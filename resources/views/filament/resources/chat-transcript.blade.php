<div>
    @php
        /** @var \App\Models\ChatConversation|null $conversation */
        $conversation = $this->getRecord();
        $messages = $conversation?->messages()->get() ?? collect();
    @endphp

    <x-filament::section heading="Transcript">
        <div class="flex flex-col gap-2">
            @forelse ($messages as $message)
                @php
                    $isVisitor = in_array($message->role, ['user', 'agent']);
                    $bubble = match ($message->role) {
                        'user' => 'bg-gray-100 text-gray-800',
                        'agent' => 'bg-primary-500 text-white',
                        'bot' => 'bg-gray-50 text-gray-700 border border-gray-200',
                        default => 'bg-transparent text-gray-500 italic text-xs',
                    };
                    $align = in_array($message->role, ['user', 'agent']) ? 'justify-end' : 'justify-start';
                @endphp
                <div class="flex {{ $align }}">
                    <div class="max-w-[80%] rounded-lg px-3 py-2 {{ $bubble }}">
                        <div class="text-xs">
                            @if ($message->role === 'user')
                                Visitor
                            @elseif ($message->role === 'agent')
                                Agent
                            @elseif ($message->role === 'bot')
                                Bot
                            @else
                                System
                            @endif
                            &middot; {{ $message->created_at->format('M j, g:i A') }}
                        </div>
                        <div class="text-sm break-words">{!! nl2br(e($message->body)) !!}</div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">No messages yet.</p>
            @endforelse
        </div>
    </x-filament::section>
</div>