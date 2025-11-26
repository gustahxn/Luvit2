<?php

namespace App\Http\Controllers;

use App\Services\RawgService;
use App\Services\GameService;
use App\Services\LikeService;
use App\Services\WatchlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\ListModel;

class GamesController extends Controller
{
    public function __construct(
        private RawgService $rawg,
        private GameService $games,
        private LikeService $likes,
        private WatchlistService $watchlists
    ) {}


    public function index()
    {
        $gamesData = $this->rawg->getPopularGames();
        return view('games.index', [
            'games' => $gamesData['results'] ?? []
        ]);
    }


    public function show($id)
    {
        $gameData = Cache::remember("game_{$id}_pt", 3600, function () use ($id) {
            $game = $this->rawg->getGameDetails($id);
            $game = $this->translateGameData($game);
            return $game;
        });


        $game = $this->games->ensureFromRawgData($gameData);


        $userId = Auth::id();
        $likeExists = $userId ? $this->likes->exists($game, $userId) : false;
        $watchlistExists = $userId ? $this->watchlists->exists($game, $userId) : false;
        $likeCount = $this->likes->count($game);


        $reviews = $game->reviews()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        $userLists = [];
        if ($userId) {
            $userLists = ListModel::where('user_id', $userId)
                                 ->select('id', 'name')
                                 ->orderBy('name')
                                 ->get();
        }

        return view('games.show', [
            'game' => $gameData,
            'likeExists' => $likeExists,
            'watchlistExists' => $watchlistExists,
            'likeCount' => $likeCount,
            'reviews' => $reviews,
            'userLists' => $userLists, 
        ]);
    }

    private function translateGameData(array $game): array
        {
            $genreTranslations = [
                'Action' => 'Ação',
                'Adventure' => 'Aventura',
                'Shooter' => 'Tiro',
                'Puzzle' => 'Quebra-cabeça',
                'Sports' => 'Esportes',
                'Racing' => 'Corrida',
                'Strategy' => 'Estratégia',
                'Simulation' => 'Simulação',
                'Fighting' => 'Luta',
                'Platformer' => 'Plataforma',
                'Casual' => 'Casual',
                'Horror' => 'Terror',
                'Indie' => 'Independente',
                'Arcade' => 'Arcade',
                'Family' => 'Família',
                'Card' => 'Cartas',
                'Board' => 'Tabuleiro',
                'Educational' => 'Educativo',
                'Music' => 'Música',
            ];

            if (!empty($game['genres'])) {
                foreach ($game['genres'] as &$genre) {
                    $genre['name'] = $genreTranslations[$genre['name']] ?? $genre['name'];
                }
            }

        return $game;
    }
    }