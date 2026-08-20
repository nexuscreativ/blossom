<?php

namespace App\Services\Chat;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;

/**
 * Orchestrates conversations across all channels: persists messages,
 * runs the ChatEngine, and manages human-in-the-loop (HITL) escalation.
 */
class ChatManager
{
    protected ChatEngine $engine;

    public function __construct(?ChatEngine $engine = null)
    {
        $this->engine = $engine ?? new ChatEngine();
    }

    /**
     * Ingest a visitor message and return the bot/agent reply.
     *
     * @param  array  $options  ['visitor_name'?, 'visitor_email'?, 'subject'?, 'metadata'?]
     * @return array ['conversation' => ChatConversation, 'message' => string, 'escalated' => bool, 'by_human' => bool]
     */
    public function handleIncoming(
        string $message,
        string $channel = 'web',
        ?string $channelIdentifier = null,
        array $options = [],
        ?ChatConversation $conversation = null,
    ): array {
        if ($conversation === null) {
            $conversation = $this->findOrCreateConversation($channel, $channelIdentifier, $options);
        }

        // Persist the visitor's message.
        $this->storeMessage($conversation, 'user', $message, $channel);

        $conversation->markLastMessage();

        // If an agent has already taken over, do not auto-reply with AI.
        if ($conversation->is_hitl) {
            return [
                'conversation' => $conversation,
                'message' => null,
                'escalated' => false,
                'by_human' => true,
            ];
        }

        $result = $this->engine->reply($message, ['conversation' => $conversation]);

        $escalated = $result['escalate'] ?? false;

        if ($escalated) {
            $this->escalate($conversation);
        }

        // Persist the bot reply (if any).
        $this->storeMessage($conversation, 'bot', $result['reply'] ?? '', $channel);

        return [
            'conversation' => $conversation,
            'message' => $result['reply'] ?? '',
            'escalated' => $escalated,
            'by_human' => false,
        ];
    }

    /**
     * Find an open conversation for a channel/identifier or create one.
     */
    public function findOrCreateConversation(
        string $channel,
        ?string $channelIdentifier,
        array $options = [],
    ): ChatConversation {
        $query = ChatConversation::where('channel', $channel)
            ->whereIn('status', [ChatConversation::STATUS_OPEN, ChatConversation::STATUS_WAITING, ChatConversation::STATUS_ESCALATED]);

        if ($channelIdentifier) {
            $query->where('channel_identifier', $channelIdentifier);
        }

        $conversation = $query->orderByDesc('updated_at')->first();

        if ($conversation) {
            // Refresh visitor details opportunistically.
            $conversation->fill(array_filter([
                'visitor_name' => $options['visitor_name'] ?? $conversation->visitor_name,
                'visitor_email' => $options['visitor_email'] ?? $conversation->visitor_email,
                'subject' => $options['subject'] ?? $conversation->subject,
            ]))->save();

            return $conversation;
        }

        $conversation = new ChatConversation([
            'channel' => $channel,
            'channel_identifier' => $channelIdentifier,
            'visitor_name' => $options['visitor_name'] ?? null,
            'visitor_email' => $options['visitor_email'] ?? null,
            'subject' => $options['subject'] ?? null,
            'status' => ChatConversation::STATUS_OPEN,
            'metadata' => $options['metadata'] ?? null,
            'last_message_at' => now(),
        ]);
        $conversation->save();

        return $conversation;
    }

    /**
     * Persist a message on a conversation.
     */
    public function storeMessage(
        ChatConversation $conversation,
        string $role,
        string $body,
        string $source = 'web',
        array $attachments = [],
    ): ChatMessage {
        return ChatMessage::create([
            'conversation_id' => $conversation->id,
            'role' => $role,
            'body' => $body,
            'source' => $source,
            'is_hitl' => $conversation->is_hitl && in_array($role, ['agent', 'user']),
            'attachments' => $attachments ?: null,
        ]);
    }

    /**
     * Escalate a conversation to a human.
     */
    public function escalate(ChatConversation $conversation, ?User $assignTo = null): void
    {
        $conversation->update([
            'status' => ChatConversation::STATUS_ESCALATED,
            'is_hitl' => true,
            'is_ai' => false,
            'escalated_at' => now(),
            'assigned_to_id' => $assignTo?->id ?? $conversation->assigned_to_id,
        ]);

        $this->storeMessage(
            $conversation,
            'system',
            'Conversation escalated to a human agent. ' . ($assignTo ? "Assigned to {$assignTo->name}." : 'Awaiting assignment.'),
            $conversation->channel
        );
    }

    /**
     * An agent replies to an escalated conversation.
     */
    public function agentReply(ChatConversation $conversation, string $body, User $agent): ChatMessage
    {
        $conversation->update([
            'status' => ChatConversation::STATUS_ESCALATED,
            'is_hitl' => true,
            'is_ai' => false,
            'assigned_to_id' => $agent->id,
        ]);

        $conversation->markLastMessage();

        return $this->storeMessage($conversation, 'agent', $body, $conversation->channel);
    }

    /**
     * Resolve / close a conversation.
     */
    public function resolve(ChatConversation $conversation, ?User $agent = null): void
    {
        $conversation->update([
            'status' => ChatConversation::STATUS_RESOLVED,
            'is_hitl' => true,
            'is_ai' => false,
            'resolved_at' => now(),
            'assigned_to_id' => $agent?->id ?? $conversation->assigned_to_id,
        ]);
    }
}