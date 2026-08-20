<div class="space-y-6">
    {{-- Post Composer --}}
    @auth
        <div class="bg-white rounded-xl p-6 border border-silver">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-onion flex items-center justify-center text-white font-ui font-semibold text-sm flex-shrink-0">
                    {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                </div>
                <div class="flex-1">
                    <textarea
                        wire:model="newPostBody"
                        rows="3"
                        placeholder="Share something with the community..."
                        class="w-full px-4 py-3 rounded-xl border border-silver bg-snow font-ui text-sm resize-none focus:outline-none focus:border-onion focus:ring-2 focus:ring-onion/10 transition-all"
                    ></textarea>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-xs text-ash font-ui" wire:loading.remove>{{ strlen($newPostBody) }}/2000</span>
                        <button
                            wire:click="createPost"
                            class="btn-primary text-sm !px-6 !py-2 !min-h-0"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50"
                            {{ strlen($newPostBody) < 1 ? 'disabled' : '' }}
                        >
                            <span wire:loading.remove>Post</span>
                            <span wire:loading>Posting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl p-6 border border-silver text-center">
            <p class="font-ui text-sm text-graphite">
                <a href="{{ route('login') }}" class="text-onion font-semibold hover:underline">Sign in</a> to join the conversation.
            </p>
        </div>
    @endauth

    {{-- Feed --}}
    @forelse($posts as $post)
        <div class="bg-white rounded-xl p-6 border border-silver">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-onion/10 flex items-center justify-center text-onion font-ui font-semibold text-sm flex-shrink-0">
                    {{ substr($post->user->first_name ?? '?', 0, 1) }}{{ substr($post->user->last_name ?? '', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-ui font-semibold text-sm text-ink">{{ $post->user->first_name ?? 'Unknown' }} {{ $post->user->last_name ?? '' }}</span>
                        <span class="text-xs text-ash font-ui">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="font-body text-sm text-graphite leading-relaxed whitespace-pre-wrap">{{ $post->body }}</p>

                    {{-- Actions --}}
                    <div class="flex items-center gap-6 mt-4">
                        @auth
                            <button
                                wire:click="toggleLike({{ $post->id }})"
                                class="flex items-center gap-1.5 text-xs font-ui transition-colors {{ \App\Models\Like::where('user_id', Auth::id())->where('post_id', $post->id)->exists() ? 'text-orange' : 'text-ash hover:text-orange' }}"
                            >
                                <svg class="w-4 h-4" fill="{{ \App\Models\Like::where('user_id', Auth::id())->where('post_id', $post->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                {{ $post->likes_count }}
                            </button>
                            <button
                                wire:click="toggleCommentForm({{ $post->id }})"
                                class="flex items-center gap-1.5 text-xs font-ui text-ash hover:text-onion transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                {{ $post->comments_count }}
                            </button>
                        @else
                            <span class="text-xs font-ui text-ash">{{ $post->likes_count }} likes · {{ $post->comments_count }} comments</span>
                        @endauth
                    </div>

                    {{-- Comment Form --}}
                    @if($commentingOn === $post->id)
                        <div class="mt-4 pl-4 border-l-2 border-onion/20">
                            <div class="flex gap-3">
                                <input
                                    wire:model="commentBody"
                                    type="text"
                                    placeholder="Write a comment..."
                                    class="flex-1 px-4 py-2 rounded-lg border border-silver bg-snow font-ui text-sm focus:outline-none focus:border-onion"
                                    wire:keydown.enter="addComment({{ $post->id }})"
                                />
                                <button
                                    wire:click="addComment({{ $post->id }})"
                                    class="px-4 py-2 rounded-lg bg-onion text-white text-xs font-ui font-semibold hover:bg-onion-dark transition-colors"
                                >
                                    Post
                                </button>
                            </div>
                            @error('commentBody')
                                <p class="mt-1 text-xs text-orange font-ui">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    {{-- Existing Comments --}}
                    @if($post->comments->count())
                        <div class="mt-4 space-y-3 pl-4 border-l-2 border-silver">
                            @foreach($post->comments->take(5) as $comment)
                                <div class="flex gap-2">
                                    <span class="font-ui text-xs font-semibold text-onion">{{ $comment->user->first_name ?? '?' }}</span>
                                    <span class="font-ui text-xs text-graphite">{{ $comment->body }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl p-8 border border-silver text-center">
            <p class="font-ui text-sm text-ash">No posts yet. Be the first to share something!</p>
        </div>
    @endforelse

    {{ $posts->links() }}
</div>
