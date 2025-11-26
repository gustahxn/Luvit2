<?php $__env->startSection('title', 'Perfil de ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="profile-header">
        <div class="h-48 md:h-64 rounded-t-2xl bg-gradient-to-br from-gray-800 to-gray-900 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-ink to-transparent"></div>
        </div>

        <div class="px-4 md:px-8 pb-6 bg-ink/80 backdrop-blur-sm rounded-b-2xl">
            <div class="flex flex-col sm:flex-row justify-between items-start -mt-16 md:-mt-20">
                <div class="flex items-end gap-4">
                    <div class="relative">
                        <?php if($user->profile_picture): ?>
                            <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>" 
                                class="w-24 h-24 md:w-32 md:h-32 rounded-full object-cover border-4 border-ink"
                                alt="<?php echo e($user->name); ?>">
                        <?php else: ?>
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-4xl border-4 border-ink">
                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-white"><?php echo e($user->name); ?></h1>
                        <p class="text-sm text-gray-400"><?php echo e('@' . $user->arroba); ?></p>
                    </div>
                </div>

                <div class="mt-4 sm:mt-0">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->id() === $user->id): ?>
                            <a href="<?php echo e(route('profile.edit', $user->arroba)); ?>" 
                               class="shine enhanced-btn bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/30 text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 backdrop-blur-sm hover:-translate-y-0.5">
                                Editar Perfil
                            </a>
                        <?php else: ?>
                            <button 
                                id="followBtn"
                                data-arroba="<?php echo e($user->arroba); ?>"
                                data-following="<?php echo e($isFollowing ? 'true' : 'false'); ?>"
                                class="follow-button enhanced-btn <?php echo e($isFollowing ? 'bg-gray-700 hover:bg-gray-600 border-gray-600' : 'bg-rose-600 hover:bg-rose-700'); ?> text-white font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 hover:-translate-y-0.5">
                                <span class="follow-text"><?php echo e($isFollowing ? 'Seguindo' : 'Seguir'); ?></span>
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <p class="mt-4 text-gray-300 max-w-2xl"><?php echo e($user->bio ?? 'Ainda sem biografia.'); ?></p>

            <div class="mt-4 flex items-center gap-6 text-sm text-gray-400">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Ingressou em <?php echo e($user->created_at->translatedFormat('F \d\e Y')); ?></span>
                </div>
                <a href="<?php echo e(route('profile.following', $user->arroba)); ?>" class="flex items-center gap-1 hover:text-white transition-colors">
                    <span class="font-bold text-white" id="followingCount"><?php echo e($user->following_count); ?></span> Seguindo
                </a>
                <a href="<?php echo e(route('profile.followers', $user->arroba)); ?>" class="flex items-center gap-1 hover:text-white transition-colors">
                    <span class="font-bold text-white" id="followersCount"><?php echo e($user->followers_count); ?></span> Seguidores
                </a>
            </div>
        </div>
    </div>

    <div class="mt-8" x-data="{ activeTab: 'liked' }">
        <div class="border-b border-white/10">
            <nav class="-mb-px flex space-x-8 px-4 md:px-8" aria-label="Tabs">
                <button @click="activeTab = 'liked'" :class="{ 'text-rose-400 border-rose-400': activeTab === 'liked', 'text-gray-400 border-transparent hover:text-white hover:border-gray-500': activeTab !== 'liked' }" class="cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 outline-none">
                    Curtidas
                </button>
                <button @click="activeTab = 'watchlist'" :class="{ 'text-rose-400 border-rose-400': activeTab === 'watchlist', 'text-gray-400 border-transparent hover:text-white hover:border-gray-500': activeTab !== 'watchlist' }" class="cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 outline-none">
                    Salvos
                </button>
                <button @click="activeTab = 'comments'" :class="{ 'text-rose-400 border-rose-400': activeTab === 'comments', 'text-gray-400 border-transparent hover:text-white hover:border-gray-500': activeTab !== 'comments' }" class="cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 outline-none">
                    Comentários
                </button>
                <button @click="activeTab = 'lists'" :class="{ 'text-rose-400 border-rose-400': activeTab === 'lists', 'text-gray-400 border-transparent hover:text-white hover:border-gray-500': activeTab !== 'lists' }" class="cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 outline-none">
                    Listas
                </button>
            </nav>
        </div>

        <div class="mt-6">
            <div x-show="activeTab === 'liked'" x-transition x-cloak>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
                    <?php
                        $allLiked = array_merge(
                            array_map(fn($m) => array_merge($m, ['type' => 'movie']), $likedMovies ?? []),
                            array_map(fn($g) => array_merge($g, ['type' => 'game']), $likedGames ?? [])
                        );
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $allLiked; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="movie-poster-card group">
                            <?php if($item['type'] === 'game'): ?>
                                <a href="/games/<?php echo e($item['id'] ?? $item['rawg_id']); ?>" class="block relative">
                                    <div class="aspect-[2/3] rounded-lg shadow-lg poster-shadow overflow-hidden bg-gray-800">
                                        <img src="<?php echo e($item['background_image_additional'] ?? $item['background_image']); ?>" 
                                             alt="<?php echo e($item['name']); ?>" 
                                             class="w-full h-full object-cover transition-all duration-300 group-hover:brightness-75">
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold text-sm truncate"><?php echo e($item['name']); ?></h3>
                                        <p class="text-xs text-gray-300"><?php echo e($item['released'] ? substr($item['released'], 0, 4) : 'N/A'); ?></p>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a href="/filme/<?php echo e($item['id'] ?? $item['tmdb_id']); ?>" class="block relative">
                                    <img src="https://image.tmdb.org/t/p/w500<?php echo e($item['poster_path'] ?? $item['poster']); ?>" alt="Pôster de <?php echo e($item['title']); ?>" class="rounded-lg shadow-lg poster-shadow transition-all duration-300 group-hover:brightness-75 aspect-[2/3] object-cover bg-gray-800">
                                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold text-sm truncate"><?php echo e($item['title']); ?></h3>
                                        <p class="text-xs text-gray-300"><?php echo e(substr($item['release_date'], 0, 4 )); ?></p>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12 bg-white/5 rounded-lg flex flex-col items-center justify-center gap-4">
                            <p class="text-gray-400">Nenhum item curtido ainda.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div x-show="activeTab === 'watchlist'" x-transition x-cloak>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
                    <?php
                        $allWatchlist = array_merge(
                            array_map(fn($m) => array_merge($m, ['type' => 'movie']), $watchlistMovies ?? []),
                            array_map(fn($g) => array_merge($g, ['type' => 'game']), $watchlistGames ?? [])
                        );
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $allWatchlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="movie-poster-card group">
                            <?php if($item['type'] === 'game'): ?>
                                <a href="/games/<?php echo e($item['id'] ?? $item['rawg_id']); ?>" class="block relative">
                                    <div class="aspect-[2/3] rounded-lg shadow-lg poster-shadow overflow-hidden bg-gray-800">
                                        <img src="<?php echo e($item['background_image_additional'] ?? $item['background_image']); ?>" 
                                             alt="<?php echo e($item['name']); ?>" 
                                             class="w-full h-full object-cover transition-all duration-300 group-hover:brightness-75">
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold text-sm truncate"><?php echo e($item['name']); ?></h3>
                                        <p class="text-xs text-gray-300"><?php echo e($item['released'] ? substr($item['released'], 0, 4) : 'N/A'); ?></p>
                                    </div>
                                </a>
                            <?php else: ?>
                                <a href="/filme/<?php echo e($item['id'] ?? $item['tmdb_id']); ?>" class="block relative">
                                    <img src="https://image.tmdb.org/t/p/w500<?php echo e($item['poster_path'] ?? $item['poster']); ?>" alt="Pôster de <?php echo e($item['title']); ?>" class="rounded-lg shadow-lg poster-shadow transition-all duration-300 group-hover:brightness-75 aspect-[2/3] object-cover bg-gray-800">
                                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent rounded-b-lg">
                                        <h3 class="text-white font-semibold text-sm truncate"><?php echo e($item['title']); ?></h3>
                                        <p class="text-xs text-gray-300"><?php echo e(substr($item['release_date'], 0, 4 )); ?></p>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12 bg-white/5 rounded-lg flex flex-col items-center justify-center gap-4">
                            <p class="text-gray-400">Nenhum item salvo ainda.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div x-show="activeTab === 'comments'" x-transition x-cloak>
                <?php echo $__env->make('profile.partials._comments', ['comments' => $reviews], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div x-show="activeTab === 'lists'" x-transition x-cloak>
                <?php if($lists->isEmpty()): ?>
                    <div class="col-span-full text-center py-12 bg-white/5 rounded-lg flex flex-col items-center justify-center gap-4">
                            <p class="text-gray-400">Nenhuma lista criada ainda.</p>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4 flex flex-col">
                                <a href="<?php echo e(route('lists.public.show', $list->id)); ?>">
                                    <h3 class="text-white font-semibold mb-4"><?php echo e($list->name); ?></h3>
                                    </a>
                                <div class="text-gray-400 text-xs mt-2 flex justify-between">
                                    <span><?php echo e($list->items->count()); ?> itens</span>
                                    <span><?php echo e($list->created_at->locale('pt_BR')->diffForHumans()); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
     
document.addEventListener("DOMContentLoaded", function () {
    const followButtons = document.querySelectorAll(
        "#followBtn, .mini-follow-btn"
    );

    followButtons.forEach((followBtn) => {
        followBtn.addEventListener("click", async function () {
            const arroba = this.dataset.arroba;

            this.disabled = true; 

            try {
                const response = await fetch(`/profile/${arroba}/follow`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        Accept: "application/json",
                    },
                });

                const data = await response.json();

                if (data.success) {
                    const isFollowing = data.isFollowing;

                    this.dataset.following = isFollowing ? "true" : "false";

                    if (this.classList.contains("mini-follow-btn")) {
                        this.textContent = isFollowing ? "Seguindo" : "Seguir";

                        if (isFollowing) {
                            this.classList.remove(
                                "bg-rose-600",
                                "hover:bg-rose-700"
                            );
                            this.classList.add(
                                "bg-gray-700",
                                "hover:bg-gray-600"
                            );
                        } else {
                            this.classList.remove(
                                "bg-gray-700",
                                "hover:bg-gray-600"
                            );
                            this.classList.add(
                                "bg-rose-600",
                                "hover:bg-rose-700"
                            );
                        }
                    } else {
                        const followText = this.querySelector(".follow-text");
                        if (followText) {
                            followText.textContent = isFollowing
                                ? "Seguindo"
                                : "Seguir";
                        }

                        if (isFollowing) {
                            this.classList.remove(
                                "bg-rose-600",
                                "hover:bg-rose-700"
                            );
                            this.classList.add(
                                "bg-gray-700",
                                "hover:bg-gray-600",
                                "border-gray-600"
                            );
                        } else {
                            this.classList.remove(
                                "bg-gray-700",
                                "hover:bg-gray-600",
                                "border-gray-600"
                            );
                            this.classList.add(
                                "bg-rose-600",
                                "hover:bg-rose-700"
                            );
                        }

                        const followersCount =
                            document.getElementById("followersCount");
                        if (followersCount) {
                            followersCount.textContent = data.followersCount;
                        }
                    }
                }
            } catch (error) {
                console.error("Erro:", error);
                alert("Ocorreu um erro. Tente novamente.");
            } finally {
                this.disabled = false;
            }
        });
    });
});
</script> 
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/gustahxn/Stuff/coding/Luvit/resources/views/profile/show.blade.php ENDPATH**/ ?>