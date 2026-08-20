<div>
    <?php
        /** @var \App\Models\ChatConversation|null $conversation */
        $conversation = $this->getRecord();
        $messages = $conversation?->messages()->get() ?? collect();
    ?>

    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => ['heading' => 'Transcript']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['heading' => 'Transcript']); ?>
        <div class="flex flex-col gap-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isVisitor = in_array($message->role, ['user', 'agent']);
                    $bubble = match ($message->role) {
                        'user' => 'bg-gray-100 text-gray-800',
                        'agent' => 'bg-primary-500 text-white',
                        'bot' => 'bg-gray-50 text-gray-700 border border-gray-200',
                        default => 'bg-transparent text-gray-500 italic text-xs',
                    };
                    $align = in_array($message->role, ['user', 'agent']) ? 'justify-end' : 'justify-start';
                ?>
                <div class="flex <?php echo e($align); ?>">
                    <div class="max-w-[80%] rounded-lg px-3 py-2 <?php echo e($bubble); ?>">
                        <div class="text-xs">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->role === 'user'): ?>
                                Visitor
                            <?php elseif($message->role === 'agent'): ?>
                                Agent
                            <?php elseif($message->role === 'bot'): ?>
                                Bot
                            <?php else: ?>
                                System
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            &middot; <?php echo e($message->created_at->format('M j, g:i A')); ?>

                        </div>
                        <div class="text-sm break-words"><?php echo nl2br(e($message->body)); ?></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">No messages yet.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
</div><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/filament/resources/chat-transcript.blade.php ENDPATH**/ ?>