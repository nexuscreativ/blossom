<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Services\Chat\ChatManager;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Widget bootstrap — returns the current session and recent messages.
     */
    public function session(Request $request)
    {
        $manager = new ChatManager();

        $sessionId = $request->cookie('blossom_chat_session')
            ?? $request->header('X-Chat-Session')
            ?? Str::uuid()->toString();

        $conversation = ChatConversation::where('channel', 'web')
            ->where('channel_identifier', $sessionId)
            ->whereIn('status', [
                ChatConversation::STATUS_OPEN,
                ChatConversation::STATUS_WAITING,
                ChatConversation::STATUS_ESCALATED,
            ])
            ->orderByDesc('updated_at')
            ->first();

        $messages = [];

        if ($conversation) {
            $messages = $conversation->messages()
                ->orderBy('created_at')
                ->limit(50)
                ->get(['role', 'body', 'created_at'])
                ->map(fn ($m) => [
                    'role' => $m->role,
                    'body' => $m->body,
                    'at' => $m->created_at->toIso8601String(),
                ])
                ->values();
        }

        return response()->json([
            'session' => $sessionId,
            'conversation_id' => $conversation?->id,
            'escalated' => $conversation?->is_hitl ?? false,
            'messages' => $messages,
            'welcome' => 'Hi there! 👋 Welcome to ' . (setting('site.name', 'the magazine')) . '. How can I help you today?',
        ]);
    }

    /**
     * Widget send — accepts a visitor message and returns the reply.
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session' => ['nullable', 'string', 'max:191'],
            'name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email'],
        ]);

        $manager = new ChatManager();

        $sessionId = $request->input('session')
            ?? $request->cookie('blossom_chat_session')
            ?? Str::uuid()->toString();

        $conversation = null;
        if ($request->input('conversation_id')) {
            $conversation = ChatConversation::find((int) $request->input('conversation_id'));
        }

        $result = $manager->handleIncoming(
            $request->input('message'),
            'web',
            $sessionId,
            [
                'visitor_name' => $request->input('name'),
                'visitor_email' => $request->input('email'),
            ],
            $conversation,
        );

        $conversation = $result['conversation'];

        $response = [
            'session' => $sessionId,
            'conversation_id' => $conversation->id,
            'escalated' => $conversation->is_hitl,
            'reply' => $result['message'],
            'by_human' => $result['by_human'],
            'source' => $result['message'] ? null : 'agent',
        ];

        $response = response()->json($response);
        $response->cookie('blossom_chat_session', $sessionId, 60 * 24 * 30);

        return $response;
    }

    /**
     * Agent (or visitor) sends a message to an escalated conversation.
     */
    public function followUp(Request $request)
    {
        $request->validate([
            'conversation_id' => ['required', 'integer'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $conversation = ChatConversation::findOrFail((int) $request->input('conversation_id'));

        if ($conversation->channel !== 'web' || ! $conversation->is_hitl) {
            abort(403, 'This conversation is not open for direct follow-up.');
        }

        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'body' => $request->input('message'),
            'source' => 'web',
        ]);

        $conversation->markLastMessage();

        return response()->json(['ok' => true]);
    }
}