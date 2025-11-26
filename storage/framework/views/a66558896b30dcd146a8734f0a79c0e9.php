<div class="luv-card rounded-xl p-6 border border-white/5 review-card">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0">
            <?php if($review->user->profile_picture): ?>
                <img src="<?php echo e(asset('storage/' . $review->user->profile_picture)); ?>" class="w-10 h-10 rounded-full object-cover">
            <?php else: ?>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                    <?php echo e(strtoupper(substr($review->user->name, 0, 1))); ?>

                </div>
            <?php endif; ?>
        </div>
        
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <a href="<?php echo e(route('profile.show', $review->user->arroba)); ?>" class="text-white font-semibold hover:underline">
                        <?php echo e($review->user->name); ?>

                    </a>
                    <p class="text-gray-400 text-sm"><?php echo e($review->created_at->diffForHumans()); ?></p>
                </div>
                
                <?php if($review->rating): ?>
                    <div class="flex items-center gap-1">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <svg class="w-4 h-4 <?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-600'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <p class="text-gray-200 leading-relaxed whitespace-pre-line"><?php echo e($review->review); ?></p>
            <?php if(auth()->guard()->check()): ?>
                <button onclick="toggleReplyForm(<?php echo e($review->id); ?>)" class="mt-3 text-sm text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Responder
                </button>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                
                <div id="reply-form-<?php echo e($review->id); ?>" class="mt-4 hidden">

                    <form method="POST" 
                        action="<?php echo e(route('filme.review.reply', ['tmdbId' => $filme['id'], 'reviewId' => $review->id])); ?>" 
                        class="space-y-3">
                        <?php echo csrf_field(); ?>
                        <textarea 
                            name="review" 
                            rows="3" 
                            class="w-full px-4 py-3 text-sm text-gray-200 focus:outline-none bg-gray-800/50 border border-gray-700 rounded-lg  placeholder-gray-400 transition-all duration-200 resize-none" 
                            placeholder="Escreva sua resposta..."
                            required
                        ></textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white text-sm font-medium rounded-lg transition-colors">
                                Enviar resposta
                            </button>
                            <button type="button" onclick="toggleReplyForm(<?php echo e($review->id); ?>)" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    

<?php if($review->replies->isNotEmpty()): ?>
    <div class="mt-4 ml-14 pl-4 border-l-2 border-purple-500/30 space-y-3">
        <?php $__currentLoopData = $review->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php echo $__env->make('components.reply-card', ['reply' => $reply], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
</div><?php /**PATH /home/gustahxn/Stuff/coding/Luvit/resources/views/components/review-card.blade.php ENDPATH**/ ?>