<?php

namespace App\Services\Chat;

use App\Models\Article;
use App\Models\Event;
use App\Models\Listing;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

/**
 * Drives the support chatbot. Uses OpenRouter (LLM) when configured,
 * otherwise falls back to a local rule-based knowledge engine so the
 * chatbot always works — even before any API key is set.
 */
class ChatEngine
{
    protected string $apiKey;
    protected string $model;

    public function __construct(?string $apiKey = null, ?string $model = null)
    {
        $this->apiKey = $apiKey ?? (string) env('OPENROUTER_API_KEY', '');
        $this->model = $model ?? (string) env('OPENROUTER_MODEL', 'openai/gpt-4o-mini');
    }

    /**
     * Reply to a user message.
     *
     * Returns ['reply' => string, 'source' => 'ai'|'rules', 'escalate' => bool].
     */
    public function reply(string $message, array $context = []): array
    {
        $message = trim($message);

        if ($message === '') {
            return [
                'reply' => 'Hi there! How can I help you today?',
                'source' => 'rules',
                'escalate' => false,
            ];
        }

        // Always honor an explicit request to talk to a human.
        if ($this->wantsHuman($message)) {
            return [
                'reply' => 'Sure — I\'ve connected you with a member of our team. They\'ll jump in here shortly. You can also reach us directly at ' . $this->contactEmail() . '.',
                'source' => 'rules',
                'escalate' => true,
            ];
        }

        // Try the local knowledge engine first for deterministic answers.
        $ruleReply = $this->ruleReply($message, $context);
        if ($ruleReply !== null) {
            return [
                'reply' => $ruleReply,
                'source' => 'rules',
                'escalate' => false,
            ];
        }

        // No rule matched — use OpenRouter if available.
        if ($this->apiKey !== '') {
            try {
                $aiReply = $this->askOpenRouter($message, $context);
                if (filled($aiReply)) {
                    return [
                        'reply' => $aiReply,
                        'source' => 'ai',
                        'escalate' => false,
                    ];
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Nothing resolved — fall back to a graceful message + escalation.
        return [
            'reply' => "I want to make sure you get the right answer. I've flagged this for our team to follow up with you — or you can reach us at " . $this->contactEmail() . '.',
            'source' => 'rules',
            'escalate' => true,
        ];
    }

    /**
     * Ask OpenRouter for a reply using the site's knowledge as context.
     */
    protected function askOpenRouter(string $message, array $context): ?string
    {
        $system = $this->systemPrompt($context);

        $response = Http::withToken($this->apiKey)
            ->acceptJson()
            ->timeout(30)
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $system],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
                'max_tokens' => 500,
            ]);

        if (! $response->ok()) {
            return null;
        }

        return $response->json('choices.0.message.content') ?: null;
    }

    /**
     * Build a system prompt grounded in the site's live data.
     */
    protected function systemPrompt(array $context): string
    {
        $site = Setting::group('site');
        $name = $site['site.name'] ?? config('app.name', 'the magazine');

        $knowledge = $this->knowledgeBase($context);
        $prompt = "You are the friendly support assistant for {$name}. "
            . 'Answer questions about the magazine, its articles, events, business directory, subscriptions, and contact details using ONLY the knowledge below. '
            . 'Keep answers concise (under 4 sentences) and warm. If you do not know, say so and offer to connect the visitor with a human. '
            . "Do not invent facts.\n\nKNOWLEDGE:\n" . $knowledge;

        return $prompt;
    }

    /**
     * Build a compact knowledge base from the database.
     */
    protected function knowledgeBase(array $context): string
    {
        $lines = [];

        foreach (Setting::group('site') as $key => $value) {
            if (is_string($value) && $value !== '') {
                $lines[] = ucwords(str_replace('_', ' ', $key)) . ': ' . $value;
            }
        }

        $articles = Article::published()
            ->latest('published_at')
            ->limit(6)
            ->get(['title', 'excerpt', 'category_id', 'author_id']);

        if ($articles->count()) {
            $lines[] = 'Recent articles:';
            foreach ($articles as $a) {
                $cat = $a->category?->name ? "[{$a->category->name}] " : '';
                $lines[] = '- ' . $cat . $a->title . ': ' . ($a->excerpt ?: 'See full story on the site.');
            }
        }

        $events = Event::where('status', 'published')
            ->where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->limit(4)
            ->get(['title', 'starts_at', 'venue']);

        if ($events->count()) {
            $lines[] = 'Upcoming events:';
            foreach ($events as $e) {
                $lines[] = '- ' . $e->title . ' on ' . $e->starts_at?->format('M j, Y') . ($e->venue ? ' at ' . $e->venue : '');
            }
        }

        $listings = Listing::active()->limit(5)->get(['name', 'type']);
        if ($listings->count()) {
            $lines[] = 'Directory businesses: ' . $listings->pluck('name')->implode(', ');
        }

        $contact = Setting::group('site');
        if (($email = $contact['site.contact_email'] ?? null)) {
            $lines[] = 'Support email: ' . $email;
        }
        if (($phone = $contact['site.contact_phone'] ?? null)) {
            $lines[] = 'Phone: ' . $phone;
        }
        if (($address = $contact['site.contact_address'] ?? null)) {
            $lines[] = 'Address: ' . $address;
        }

        return implode("\n", $lines);
    }

    /**
     * Deterministic local replies for common intents.
     * Returns null when no rule matches.
     */
    protected function ruleReply(string $message, array $context): ?string
    {
        $msg = strtolower($message);
        $site = Setting::group('site');
        $contact = Setting::group('site');
        $name = $site['site.name'] ?? config('app.name', 'the magazine');

        $matches = function (array $needles) use ($msg) {
            foreach ($needles as $needle) {
                if (str_contains($msg, $needle)) {
                    return true;
                }
            }
            return false;
        };

        // Greetings
        if ($matches(['hello', 'hi ', 'hey', 'good morning', 'good afternoon', 'good evening'])) {
            return "Hello! Welcome to {$name} 👋 How can I help you today?";
        }

        // How are you
        if ($matches(['how are you', 'how do you do', 'hows it going'])) {
            return "I'm great, thanks for asking! How can I help you today?";
        }

        // Thanks
        if ($matches(['thank', 'thanks', 'thx', 'grateful'])) {
            return "You're very welcome! Is there anything else I can help you with?";
        }

        // Pricing / subscription
        if ($matches(['price', 'pricing', 'subscribe', 'subscription', 'premium', 'cost', 'fee', 'pay', 'payment'])) {
            return "We offer a free tier plus a Premium subscription for full access to articles and events. You can see all the plans and prices on our Pricing page, or visit /pricing to sign up. Can I help you pick the right plan?";
        }

        // Contact
        if ($matches(['contact', 'reach you', 'get in touch', 'talk to', 'email address', 'phone number'])) {
            $email = $contact['site.contact_email'] ?? null;
            $phone = $contact['site.contact_phone'] ?? null;
            $parts = [];
            if ($email) {
                $parts[] = "email us at {$email}";
            }
            if ($phone) {
                $parts[] = "call {$phone}";
            }
            $parts[] = 'use the contact form on our site';
            return 'You can ' . implode(', or ', $parts) . '. Our team usually responds within 24 hours.';
        }

        // Location / address
        if ($matches(['where are you', 'location', 'address', 'find you', 'office'])) {
            if (($address = $contact['site.contact_address'] ?? null)) {
                return "You can find us at: {$address}. Want directions or our opening hours?";
            }
            return "We're an online publication — you can reach us through the contact form or our social channels.";
        }

        // Hours
        if ($matches(['hours', 'opening time', 'open time', 'when are you open', 'working hour'])) {
            if (($hours = $contact['hours'] ?? null)) {
                return "Our team is available {$hours}. Outside those hours you can leave a message and we'll get back to you.";
            }
            return "Our team typically responds within 24 hours.";
        }

        // Articles / news
        if ($matches(['article', 'story', 'news', 'read', 'latest', 'magazine'])) {
            $latest = Article::published()->latest('published_at')->first();
            $count = Article::published()->count();
            $reply = "We have {$count} stories in the magazine right now covering culture, business, tourism, and more. ";
            if ($latest) {
                $reply .= "The latest is \"" . $latest->title . '". ';
            }
            $reply .= 'Head to the Articles section to explore them all.';
            return $reply;
        }

        // Events
        if ($matches(['event', 'upcoming', 'happening', 'festival'])) {
            $next = Event::where('status', 'published')->where('starts_at', '>=', now())->orderBy('starts_at')->first();
            if ($next) {
                return "Our next event is \"" . $next->title . "\" on " . $next->starts_at?->format('M j, Y') . ($next->venue ? ' at ' . $next->venue : '') . '. Check the Events page for the full calendar.';
            }
            return 'Check the Events page for our latest calendar — new events are added regularly.';
        }

        // Directory
        if ($matches(['directory', 'business', 'listing', 'find a', 'recommend'])) {
            return 'Our directory lists trusted businesses across Nigeria. Visit the Listings page to browse by category.';
        }

        // About
        if ($matches(['about', 'who are you', 'what is this', 'what do you do'])) {
            $tagline = $site['site.tagline'] ?? 'a premium magazine with Nigerian soul';
            return "{$name} is {$tagline}. We tell the stories of Nigeria — its people, culture, and enterprise.";
        }

        // Goodbye
        if ($matches(['bye', 'goodbye', 'see you', 'farewell'])) {
            return 'Thanks for chatting! Feel free to come back anytime. Have a wonderful day! 👋';
        }

        // Help
        if ($matches(['help', 'what can you do', 'options', 'support'])) {
            return "I can help you with: pricing & subscriptions, events, articles, our business directory, and contact details. Just ask! If you need a human, just say \"talk to an agent\".";
        }

        return null;
    }

    protected function wantsHuman(string $message): bool
    {
        $msg = strtolower($message);

        return str_contains($msg, 'human')
            || str_contains($msg, 'agent')
            || str_contains($msg, 'real person')
            || str_contains($msg, 'talk to someone')
            || str_contains($msg, 'speak to a')
            || str_contains($msg, 'customer service')
            || str_contains($msg, 'support team')
            || str_contains($msg, 'escalate')
            || str_contains($msg, 'complaint');
    }

    protected function contactEmail(): string
    {
        $site = Setting::group('site');

        return $site['site.contact_email'] ?? (string) config('mail.from.address', 'hello@blossom.ng');
    }
}