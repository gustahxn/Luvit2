<div class="bg-gray-800/30 rounded-lg p-4 border border-gray-700/50">
    <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
            <?php if($reply->user->profile_picture): ?>
                <img src="<?php echo e(asset('storage/' . $reply->user->profile_picture)); ?>" class="w-10 h-10 rounded-full object-cover">
            <?php else: ?>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center text-white text-xs font-bold">
                    <?php echo e(strtoupper(substr($reply->user->name, 0, 1))); ?>

                </div>
            <?php endif; ?>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1">
                <a href="<?php echo e(route('profile.show', $reply->user->arroba)); ?>" class="text-white font-medium text-sm hover:underline">
                    <?php echo e($reply->user->name); ?>

                </a>
                <span class="text-gray-500 text-xs"><?php echo e($reply->created_at->diffForHumans()); ?></span>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-line"><?php echo e($reply->review); ?></p>
        </div>
    </div>
</div><?php /**PATH /home/gustahxn/Stuff/coding/Luvit/resources/views/components/reply-card.blade.php ENDPATH**/ ?>