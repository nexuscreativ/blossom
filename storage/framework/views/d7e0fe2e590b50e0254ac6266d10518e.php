<div class="space-y-6">
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
        <div class="bg-white rounded-xl p-6 border border-silver">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-onion flex items-center justify-center text-white font-ui font-semibold text-sm flex-shrink-0">
                    <?php echo e(substr(Auth::user()->first_name, 0, 1)); ?><?php echo e(substr(Auth::user()->last_name, 0, 1)); ?>

                </div>
                <div class="flex-1">
                    <textarea
                        wire:model="newPostBody"
                        rows="3"
                        placeholder="Share something with the community..."
                        class="w-full px-4 py-3 rounded-xl border border-silver bg-snow font-ui text-sm resize-none focus:outline-none focus:border-onion focus:ring-2 focus:ring-onion/10 transition-all"
                    ></textarea>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-xs text-ash font-ui" wire:loading.remove><?php echo e(strlen($newPostBody)); ?>/2000</span>
                        <button
                            wire:click="createPost"
                            class="btn-primary text-sm !px-6 !py-2 !min-h-0"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50"
                            <?php echo e(strlen($newPostBody) < 1 ? 'disabled' : ''); ?>

                        >
                            <span wire:loading.remove>Post</span>
                            <span wire:loading>Posting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl p-6 border border-silver text-center">
            <p class="font-ui text-sm text-graphite">
                <a href="<?php echo e(route('login')); ?>" class="text-onion font-semibold hover:underline">Sign in</a> to join the conversation.
            </p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-xl p-6 border border-silver">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-full bg-onion/10 flex items-center justify-center text-onion font-ui font-semibold text-sm flex-shrink-0">
                    <?php echo e(substr($post->user->first_name ?? '?', 0, 1)); ?><?php echo e(substr($post->user->last_name ?? '', 0, 1)); ?>

                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-ui font-semibold text-sm text-ink"><?php echo e($post->user->first_name ?? 'Unknown'); ?> <?php echo e($post->user->last_name ?? ''); ?></span>
                        <span class="text-xs text-ash font-ui"><?php echo e($post->created_at->diffForHumans()); ?></span>
                    </div>
                    <p class="font-body text-sm text-graphite leading-relaxed whitespace-pre-wrap"><?php echo e($post->body); ?></p>

                    
                    <div class="flex items-center gap-6 mt-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                            <button
                                wire:click="toggleLike(<?php echo e($post->id); ?>)"
                                class="flex items-center gap-1.5 text-xs font-ui transition-colors <?php echo e(\App\Models\Like::where('user_id', Auth::id())->where('post_id', $post->id)->exists() ? 'text-orange' : 'text-ash hover:text-orange'); ?>"
                            >
                                <svg class="w-4 h-4" fill="<?php echo e(\App\Models\Like::where('user_id', Auth::id())->where('post_id', $post->id)->exists() ? 'currentColor' : 'none'); ?>" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <?php echo e($post->likes_count); ?>

                            </button>
                            <button
                                wire:click="toggleCommentForm(<?php echo e($post->id); ?>)"
                                class="flex items-center gap-1.5 text-xs font-ui text-ash hover:text-onion transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <?php echo e($post->comments_count); ?>

                            </button>
                        <?php else: ?>
                            <span class="text-xs font-ui text-ash"><?php echo e($post->likes_count); ?> likes · <?php echo e($post->comments_count); ?> comments</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commentingOn === $post->id): ?>
                        <div class="mt-4 pl-4 border-l-2 border-onion/20">
                            <div class="flex gap-3">
                                <input
                                    wire:model="commentBody"
                                    type="text"
                                    placeholder="Write a comment..."
                                    class="flex-1 px-4 py-2 rounded-lg border border-silver bg-snow font-ui text-sm focus:outline-none focus:border-onion"
                                    wire:keydown.enter="addComment(<?php echo e($post->id); ?>)"
                                />
                                <button
                                    wire:click="addComment(<?php echo e($post->id); ?>)"
                                    class="px-4 py-2 rounded-lg bg-onion text-white text-xs font-ui font-semibold hover:bg-onion-dark transition-colors"
                                >
                                    Post
                                </button>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['commentBody'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-xs text-orange font-ui"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->comments->count()): ?>
                        <div class="mt-4 space-y-3 pl-4 border-l-2 border-silver">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $post->comments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-2">
                                    <span class="font-ui text-xs font-semibold text-onion"><?php echo e($comment->user->first_name ?? '?'); ?></span>
                                    <span class="font-ui text-xs text-graphite"><?php echo e($comment->body); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="bg-white rounded-xl p-8 border border-silver text-center">
            <p class="font-ui text-sm text-ash">No posts yet. Be the first to share something!</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php echo e($posts->links()); ?>

</div>
<?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/livewire/community-feed.blade.php ENDPATH**/ ?>