<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        private TmdbClient $tmdb,
        private RawgService $rawg
    ) {}

    public function getProfileData(User $user): array
    {
        $likedMovieIds = $user->likedMovies()->pluck('tmdb_id')->toArray();
        $watchlistMovieIds = $user->watchlistMovies()->pluck('tmdb_id')->toArray();
        
        $likedGameIds = $user->likedGames()->pluck('rawg_id')->toArray();
        $watchlistGameIds = $user->watchlistGames()->pluck('rawg_id')->toArray();

        $likedMovies = $this->fetchMoviesByTmdbIds($likedMovieIds);
        $watchlistMovies = $this->fetchMoviesByTmdbIds($watchlistMovieIds);
        
        $likedGames = $this->fetchGamesByRawgIds($likedGameIds);
        $watchlistGames = $this->fetchGamesByRawgIds($watchlistGameIds);

        $reviews = $this->getCommentsForUser($user);

        $lists = $user->lists()->with('items')->get();

        return [
            'likedMovies' => $likedMovies,
            'watchlistMovies' => $watchlistMovies,
            'likedGames' => $likedGames,
            'watchlistGames' => $watchlistGames,
            'reviews' => $reviews,
            'lists' => $lists,
        ];
    }

    public function getCommentsForUser(User $user): Collection
    {
        $reviews = $user->reviews()->with('movie')->latest()->get();

        if ($reviews->isEmpty()) {
            return $reviews;
        }

        $movieTmdbIds = $reviews->pluck('movie.tmdb_id')->filter()->unique()->toArray();
        $movieDetails = $this->fetchMoviesByTmdbIds($movieTmdbIds);
        $movieDetailsMap = collect($movieDetails)->keyBy('id');

        $reviews->each(function ($review) use ($movieDetailsMap) {
            if ($review->movie && isset($movieDetailsMap[$review->movie->tmdb_id])) {
                $review->movieDetails = $movieDetailsMap[$review->movie->tmdb_id];
            } else {
                $review->movieDetails = null;
            }
        });

        return $reviews;
    }

    private function fetchMoviesByTmdbIds(array $tmdbIds): array
    {
        if (empty($tmdbIds)) {
            return [];
        }

        return collect($tmdbIds)
            ->map(fn ($id) => $this->tmdb->movieDetails($id))
            ->filter()
            ->all();
    }

    private function fetchGamesByRawgIds(array $rawgIds): array
    {
        if (empty($rawgIds)) {
            return [];
        }

        return collect($rawgIds)
            ->map(fn ($id) => $this->rawg->getGameDetails($id))
            ->filter()
            ->all();
    }
}
