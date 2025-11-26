@extends('layouts.app')

@section('title','Página Inicial - Luvit')

@vite(['resources/js/pages/index.js'])
@section('content')

<section class="relative min-h-[90vh] overflow-hidden hero-section">
    <div class="absolute inset-0 -z-10">
        @if(!empty($filmes[0]['backdrop_path']))
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('https://image.tmdb.org/t/p/original{{ $filmes[0]['backdrop_path'] }}')">
        </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-[#0c0d10]"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-transparent to-black/40"></div>
    </div>

    <div class="absolute top-20 left-10 w-2 h-2 bg-rose-400 rounded-full opacity-60 animate-ping"></div>
    <div class="absolute top-40 right-20 w-1 h-1 bg-purple-400 rounded-full opacity-40 animate-pulse"></div>
    <div class="absolute bottom-32 left-1/4 w-1.5 h-1.5 bg-blue-400 rounded-full opacity-50 animate-bounce"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
        <div class="grid lg:grid-cols-2 gap-12 items-center w-full py-16">
            <div class="space-y-8 animate-fade-in-up">
                <div class="space-y-4">
                    @if(!empty($filmes[0]['title']))
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20">
                        <div class="w-2 h-2 bg-rose-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-white">Em Destaque</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-black text-white leading-tight">
                        {{ $filmes[0]['title'] }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 text-white/80">
                        @if(!empty($filmes[0]['vote_average']))
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-1">
                                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-lg font-bold text-white">{{ number_format($filmes[0]['vote_average'],1) }}</span>
                            </div>
                        </div>
                        @endif
                        
                        @if(!empty($filmes[0]['release_date']))
                        <div class="flex items-center gap-2">
                            <span class="text-lg">{{ \Carbon\Carbon::parse($filmes[0]['release_date'])->format('Y') }}</span>
                        </div>
                        @endif
                        
                        @if(!empty($filmes[0]['genre_ids']))
                        <div class="flex items-center gap-2">
                            <span class="text-lg">•</span>
                            <span class="text-lg">Ação</span>
                        </div>
                        @endif
                    </div>

                    @if(!empty($filmes[0]['overview']))
                    <p class="text-xl text-white/80 leading-relaxed max-w-2xl line-clamp-3">
                        {{ $filmes[0]['overview'] }}
                    </p>
                    @endif
                    @endif
                </div>

                <div class="flex flex-wrap gap-4">
                    <a href="/filme/{{ $filmes[0]['id'] ?? '' }}" 
                       class="group relative inline-flex items-center gap-3 px-8 py-4 bg-rose-600  text-white font-bold text-lg rounded-2xl transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Ver Detalhes
                    </a>
                    
                    <a href="/register" class="group inline-flex items-center gap-3 px-8 py-4 bg-white/10  backdrop-blur-sm border border-white/20 hover:border-white/30 text-white font-bold text-lg rounded-2xl transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        Adicionar à Lista
                    </a>

                </div>
            </div>

        </div>
    </div>

</section>

<section id="trending" class="mt-12 py-2 md:py-4 relative">
    <div class="absolute top-10 right-10 w-32 h-32 bg-gradient-to-br from-rose-500/10 to-transparent rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-4">
            <h2 class="text-4xl md:text-5xl font-black text-white leading-tight">
                    Em Alta Agora!
            </h2>
            <p class="text-xl text-white/70 max-w-2xl mx-auto">
                Descubra os filmes que estão conquistando o mundo.
            </p>
            <div class="mt-6 w-24 h-1 bg-gradient-to-r from-rose-500 to-purple-600 rounded-full mx-auto"></div>
        </div>
 
</section>

<section id="movies" class="py-6 md:py-6 relative">
    <div class="absolute bottom-5 left-10 w-40 h-40 bg-gradient-to-tl from-purple-600/10 to-transparent rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8 flex-wrap gap-4">
        </div>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
            @foreach (collect($filmes)->slice(12, 6) as $filme)
            <a href="/filme/{{ $filme['id'] ?? '' }}" class="group block relative movie-card">
                <div class="relative rounded-2xl overflow-hidden glass-card-subtle hover:scale-105 transition-all duration-500 hover:shadow-2xl hover:shadow-black/40" 
                     data-tilt data-tilt-max="6" data-tilt-speed="600">
                    <div class="aspect-[2/3] overflow-hidden">
                        <img src="https://image.tmdb.org/t/p/w500{{ $filme['poster_path'] }}" 
                             alt="{{ $filme['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                             loading="lazy"/>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                        <h3 class="font-semibold text-white text-sm line-clamp-2 mb-2">{{ $filme['title'] }}</h3>
                        @if(!empty($filme['vote_average']))
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-xs font-semibold text-white">{{ number_format($filme['vote_average'],1) }}</span>
                                </div>
                                @if(!empty($filme['release_date']))
                                    <span class="text-xs text-white/70">{{ substr($filme['release_date'],0,4) }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 md:py-28 relative">
>
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-rose-500/20 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-purple-600/15 to-transparent rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="glass-card rounded-3xl p-8 md:p-16 grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="space-y-4">
                    <h3 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">
                        Crie seu perfil e 
                        <span class="bg-gradient-to-r from-rose-400 to-purple-500 bg-clip-text text-transparent">
                            personalize tudo!
                        </span>
                    </h3>
                    <p class="text-xl text-white/80 leading-relaxed">
                        Monte listas personalizadas, acompanhe lançamentos, receba recomendações feitas sob medida e salve seus trailers favoritos.
                    </p>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-white/90">
                        <div class="w-8 h-8 rounded-lg bg-rose-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="font-medium">Listas personalizadas e favoritos</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <span class="font-medium">Recomendações inteligentes</span>
                    </div>
                    <div class="flex items-center gap-3 text-white/90">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 7H4l5-5v5zm11 3.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <span class="font-medium">Notificações de lançamentos</span>
                    </div>
                </div>
                
                <div class="flex gap-4 flex-wrap">
                    <a href="/register" class="shine group inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-rose-600 to-rose-500 text-white font-semibold text-lg transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Criar Conta Grátis
                    </a>
                    <a href="/login" class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-white/10  backdrop-blur-sm border border-white/20 hover:border-white/30 text-white font-semibold text-lg transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Já Tenho Conta
                    </a>
                </div>
            </div>
            
          @php
          $games = [
              ['name' => 'Cyberpunk 2077', 'image' => 'https://upload.wikimedia.org/wikipedia/en/9/9f/Cyberpunk_2077_box_art.jpg'],
              ['name' => 'Half-Life 2', 'image' => 'https://upload.wikimedia.org/wikipedia/en/2/25/Half-Life_2_cover.jpg'],
              ['name' => 'God of War', 'image' => 'https://upload.wikimedia.org/wikipedia/en/a/a7/God_of_War_4_cover.jpg'],
              ['name' => 'The Witcher 3: Wild Hunt', 'image' => 'https://upload.wikimedia.org/wikipedia/en/0/0c/Witcher_3_cover_art.jpg'],
              ['name' => 'Super Mario Odyssey', 'image' => 'https://upload.wikimedia.org/wikipedia/en/8/8d/Super_Mario_Odyssey.jpg'],
              ['name' => 'Dead Space 2', 'image' => 'https://www.quadrorama.com.br/wp-content/uploads/2024/01/Dead-Space-2.png'],
          ];
      @endphp

          <div class="grid grid-cols-3 gap-4">
              @foreach($games as $index => $game)
                  <div class="poster-grid-item" style="animation-delay: {{ $index * 0.1 }}s">
                      <img src="{{ $game['image'] }}"
                           class="rounded-2xl aspect-[2/3] object-cover poster-shadow"
                           alt="{{ $game['name'] }}"
                           loading="lazy">
                  </div>
              @endforeach
          </div>
        </div>
    </div>
</section>

@endsection