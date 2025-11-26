@extends('layouts.app')

@section('title', 'Dashboard - Luvit')

@section('content')
<div class="min-h-screen bg-[#09090b] text-zinc-300 font-sans selection:bg-rose-500/30">
    
    <!-- Navbar -->
    <div class="border-b border-white/5 bg-[#09090b]/80 backdrop-blur-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <h1 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="w-2 h-2 bg-rose-600 rounded-full animate-pulse"></span>
                    Feed
            </h1>
            <div class="flex gap-6 text-xs font-medium uppercase tracking-widest text-zinc-500">
                <a href="{{ route('games.index') }}" class="hover:text-white transition-colors">Games</a>
                <a href="{{ route('filmes.home') }}" class="hover:text-white transition-colors">Filmes</a>
                <a href="{{ route('lists.index') }}" class="hover:text-white transition-colors">Listas</a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- COLUNA PRINCIPAL -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Header Usuário -->
                <div class="flex items-center gap-4 pb-6 border-b border-white/5">
                    <div class="relative">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" class="w-14 h-14 rounded-full object-cover border-2 border-zinc-800">
                        @else
                            <div class="w-14 h-14 rounded-full bg-zinc-800 flex items-center justify-center text-white font-bold text-lg border-2 border-zinc-700">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-[#09090b]"></div>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-xl">Olá, {{ $user->name }}</h2>
                        <p class="text-sm text-zinc-500">Aqui está o que está rolando na sua rede.</p>
                    </div>
                </div>

                <!-- Feed de Reviews -->
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-zinc-500 uppercase tracking-wider mb-4">
                        Reviews Recentes dos Amigos
                    </h3>

                    @if($friendsReviews->isEmpty())
                        <div class="bg-zinc-900/30 border border-zinc-800/50 rounded-xl p-10 text-center">
                            <div class="w-12 h-12 bg-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <h4 class="text-white font-medium mb-1">Está meio quieto aqui...</h4>
                            <p class="text-zinc-500 text-sm">Siga mais pessoas para ver o que elas andam aprontando!</p>
                        </div>
                    @else
                        @foreach($friendsReviews as $review)
                            <div class="bg-[#101012] border border-white/5 rounded-xl p-5 hover:border-zinc-700 transition-colors group">
                                <div class="flex gap-4">
                                    <a href="{{ route('profile.show', $review->user->arroba) }}" class="flex-shrink-0">
                                        @if($review->user->profile_picture)
                                            <img src="{{ asset('storage/' . $review->user->profile_picture) }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-transparent group-hover:ring-rose-500/50 transition-all">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-xs text-white font-bold">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </a>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <div class="text-sm text-zinc-300">
                                                    <a href="{{ route('profile.show', $review->user->arroba) }}" class="font-bold text-white hover:text-rose-400 transition-colors">{{ $review->user->name }}</a>
                                                    <span class="text-zinc-500 mx-1">avaliou</span>
                                                    
                                                    @if($review->game)
                                                        <a href="{{ route('games.show', $review->game->id) }}" class="font-medium text-white hover:underline">{{ $review->game->name }}</a>
                                                    @elseif($review->movie)
                                                        <a href="{{ route('filmes.show', $review->movie->id) }}" class="font-medium text-white hover:underline">{{ $review->movie->title }}</a>
                                                    @else
                                                        <span class="text-zinc-400">um item desconhecido</span>
                                                    @endif
                                                </div>
                                                <div class="text-[10px] text-zinc-600 uppercase tracking-wide mt-0.5">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </div>
                                            </div>

                                            @if($review->rating)
                                                <div class="flex items-center gap-1 bg-zinc-900 border border-zinc-800 px-2 py-1 rounded">
                                                    <svg class="w-3 h-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <span class="text-xs font-bold text-zinc-200">{{ $review->rating }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex gap-4 mt-3">
                                            <div class="flex-1">
                                                @if($review->review)
                                                    <p class="text-sm text-zinc-400 leading-relaxed italic">
                                                        "{{ Str::limit($review->review, 180) }}"
                                                    </p>
                                                @else
                                                    <p class="text-sm text-zinc-600 italic">Sem comentário escrito.</p>
                                                @endif
                                                
                                                <div class="mt-4 flex gap-4 border-t border-white/5 pt-3">
                                                    <!-- Botão de Curtir Fictício para layout -->
                                                    <button class="text-xs text-zinc-500 hover:text-rose-400 flex items-center gap-1 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                                        Curtir
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="hidden sm:block flex-shrink-0 w-16">
                                                @php
                                                    $poster = null;
                                                    $link = '#';

                                                    if ($review->game) {
                                                        $poster = $review->game->background_image;
                                                        $link = route('games.show', $review->game->id);
                                                    } elseif ($review->movie) {
                                                        $mPoster = $review->movie->poster_path;
                                                        // Verifica se existe poster
                                                        if ($mPoster) {
                                                            // Se NÃO começa com http, adiciona o prefixo do TMDB
                                                            if (!str_starts_with($mPoster, 'http')) {
                                                                $poster = 'https://image.tmdb.org/t/p/w200' . $mPoster;
                                                            } else {
                                                                $poster = $mPoster;
                                                            }
                                                        }
                                                        $link = route('filmes.show', $review->movie->id);
                                                    }
                                                @endphp

                                                @if($poster)
                                                    <a href="{{ $link }}">
                                                        <img src="{{ $poster }}" 
                                                             class="w-16 h-24 object-cover rounded-md shadow-lg border border-zinc-800 hover:border-zinc-500 transition-colors bg-zinc-800"
                                                             onerror="this.onerror=null;this.src='https://placehold.co/200x300/27272a/52525b?text=N/A';">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Listas da Comunidade -->
                <div class="pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-zinc-500 uppercase tracking-wider">
                            Listas para você (seguindo)
                        </h3>
                        <a href="{{ route('lists.index') }}" class="text-xs text-rose-500 hover:text-rose-400">Ver todas &rarr;</a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($communityLists as $list)
                        <a href="{{ route('lists.public.show', $list->id) }}" class="block bg-[#101012] border border-white/5 rounded-lg p-4 hover:bg-zinc-900 transition-all group">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-white font-bold text-sm truncate pr-2 group-hover:text-rose-400 transition-colors">{{ $list->name }}</h4>
                                <span class="bg-zinc-800 text-[10px] text-zinc-400 px-1.5 py-0.5 rounded">{{ $list->items_count }}</span>
                            </div>
                            
                            <div class="flex gap-1 h-12 overflow-hidden opacity-50 group-hover:opacity-100 transition-opacity">
                                @foreach($list->items as $item)
                                    @php
                                        $itemPoster = $item->poster_path;
                                        if ($item->media_type === 'movie' && $itemPoster && !str_starts_with($itemPoster, 'http')) {
                                            $itemPoster = 'https://image.tmdb.org/t/p/w200' . $itemPoster;
                                        }
                                    @endphp

                                    @if($itemPoster)
                                        <img src="{{ $itemPoster }}" 
                                            class="h-full w-8 object-cover rounded-sm bg-zinc-800" 
                                            alt="{{ $item->title }}"
                                            onerror="this.onerror=null;this.src='https://placehold.co/200x300/27272a/52525b?text=+';">
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-3 text-[10px] text-zinc-500 flex items-center gap-1">
                                <span>por {{ $list->user->name }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- COLUNA LATERAL -->
            <div class="lg:col-span-4 space-y-8">
                
                <div class="bg-[#101012] border border-white/5 rounded-xl p-5">
                    <h3 class="text-xs font-bold text-zinc-500 uppercase mb-4">Menu Rápido</h3>
                    <div class="space-y-2">
                        <a href="{{ route('lists.create') }}" class="flex items-center gap-3 p-3 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm transition-all group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Nova Lista
                        </a>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('games.index') }}" class="flex items-center justify-center gap-2 p-3 rounded-lg bg-zinc-900 border border-zinc-800 hover:border-zinc-600 text-zinc-300 hover:text-white text-xs font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Jogos
                            </a>
                            <a href="{{ route('filmes.home') }}" class="flex items-center justify-center gap-2 p-3 rounded-lg bg-zinc-900 border border-zinc-800 hover:border-zinc-600 text-zinc-300 hover:text-white text-xs font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h18M3 12h18M3 16h18"/></svg>
                                Filmes
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-[#101012] border border-white/5 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-zinc-500 uppercase">Minhas Listas</h3>
                        <a href="{{ route('lists.index') }}" class="text-xs text-zinc-400 hover:text-white">Gerenciar</a>
                    </div>
                    
                    @if($myLists->isEmpty())
                        <div class="text-center py-6 text-zinc-600 text-xs">
                            Sem listas criadas.
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($myLists as $list)
                            <a href="{{ route('lists.show', $list->id) }}" class="flex items-center justify-between group p-2 rounded hover:bg-zinc-900 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center text-zinc-500 group-hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <span class="text-sm text-zinc-400 group-hover:text-white truncate font-medium">{{ $list->name }}</span>
                                </div>
                                <span class="text-xs text-zinc-600">{{ $list->items_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="text-[10px] text-zinc-700 text-center uppercase tracking-widest">
                    Luvit &copy; {{ date('Y') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection