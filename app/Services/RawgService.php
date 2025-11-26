<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.rawg.base_url');
        $this->apiKey = config('services.rawg.key');
    }

    protected function request($endpoint, $params = [])
    {
        $params['key'] = $this->apiKey;

        $response = Http::get($this->baseUrl . $endpoint, $params);

        if ($response->failed()) {
            throw new \Exception('Erro na requisição à API RAWG');
        }

        return $response->json();
    }

    public function getPopularGames($page = 1)
    {
        return $this->request('games', [
            'page' => $page,
            'ordering' => '-rating',
        ]);
    }

    public function searchGames($query)
    {
        return $this->request('games', [
            'search' => $query,
        ]);
    }

    public function getGameDetails($id)
    {
        return $this->request("games/{$id}");
    }
}