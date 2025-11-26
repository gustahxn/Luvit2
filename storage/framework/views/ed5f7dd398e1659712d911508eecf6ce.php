<?php $__env->startSection('title', 'Seguindo - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="<?php echo e(route('profile.show', $user->arroba)); ?>" class="text-gray-400 hover:text-white flex items-center gap-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar ao perfil
        </a>
        <h1 class="text-3xl font-bold text-white"><?php echo e($user->name); ?> está seguindo</h1>
        <p class="text-gray-400 mt-2"><?php echo e($following->total()); ?> <?php echo e($following->total() == 1 ? 'pessoa' : 'pessoas'); ?></p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $following; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followedUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('profile.show', $followedUser->arroba)); ?>">
                        <?php if($followedUser->profile_picture): ?>
                            <img src="<?php echo e(asset('storage/' . $followedUser->profile_picture)); ?>" 
                                 class="w-12 h-12 rounded-full object-cover"
                                 alt="<?php echo e($followedUser->name); ?>">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                <?php echo e(strtoupper(substr($followedUser->name, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                    </a>
                    <div>
                        <a href="<?php echo e(route('profile.show', $followedUser->arroba)); ?>" class="text-white font-semibold hover:underline">
                            <?php echo e($followedUser->name); ?>

                        </a>
                        <p class="text-sm text-gray-400"><?php echo e('@' . $followedUser->arroba); ?></p>
                    </div>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->id() !== $followedUser->id): ?>
                        <button 
                            class="mini-follow-btn px-4 py-2 cursor-pointer rounded-lg text-sm font-medium transition-colors <?php echo e(auth()->user()->isFollowing($followedUser->id) ? 'bg-gray-700 hover:bg-gray-600 text-white' : 'bg-rose-600 hover:bg-rose-700 text-white'); ?>"
                            data-arroba="<?php echo e($followedUser->arroba); ?>"
                            data-following="<?php echo e(auth()->user()->isFollowing($followedUser->id) ? 'true' : 'false'); ?>">
                            <?php echo e(auth()->user()->isFollowing($followedUser->id) ? 'Seguindo' : 'Seguir'); ?>

                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-gray-400">Ainda não segue ninguém.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-8">
        <?php echo e($following->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/pages/profile/follow.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/gustahxn/Stuff/coding/Luvit/resources/views/profile/following.blade.php ENDPATH**/ ?>