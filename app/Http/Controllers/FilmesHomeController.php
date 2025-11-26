<?php

namespace App\Http\Controllers;

use App\Services\TmdbClient;

class FilmesHomeController extends Controller
{
    public function __construct(private TmdbClient $tmdb) {}

    public function index()
    {
        $ignoreGenres = ['Faroeste'];

        $genres = $this->tmdb->getGenres();
        shuffle($genres);
        $trendingMovies = $this->tmdb->popular();

        $moviesByGenre = [];

        foreach ($genres as $genre) {
            $res    = $this->tmdb->discoverByGenre($genre['id']);
            $movies = $res['results'] ?? [];

            shuffle($movies);

            foreach ($movies as &$movie) {
                $movie['main_genre'] = $this->tmdb->getMainGenre($movie['genre_ids'] ?? [], $ignoreGenres);
            }
            unset($movie);

            $moviesByGenre[$genre['name']] = $movies;
        }

        return view('filmes.index', compact('moviesByGenre', 'trendingMovies'));
    }
}