<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GameService
{
    public function __construct(private RawgService $rawgClient) {}

    public function createOrUpdateGame(int $rawgId): Game
    {
        return Cache::remember("game_local:{$rawgId}", now()->addDay(), function () use ($rawgId) {
            $gameData = $this->rawgClient->getGameDetails($rawgId);

            return DB::transaction(fn () =>
                Game::updateOrCreate(
                    ['rawg_id' => $rawgId],
                    $this->mapToGameColumns($gameData)
                )
            );
        });
    }

    public function ensureFromRawgData(array $data): Game
    {
        $rawgId = $data['id'] ?? null;
        if (!$rawgId) {
            throw new \InvalidArgumentException('Dados RAWG inválidos: id ausente.');
        }

        return Game::updateOrCreate(
            ['rawg_id' => $rawgId],
            $this->mapToGameColumns($data)
        );
    }

    private function mapToGameColumns(array $gd): array
    {
        return [
            'name' => $gd['name'] ?? 'Game sem nome',
            'slug' => $gd['slug'] ?? null,
            'released' => $gd['released'] ?? null,
            'background_image' => $gd['background_image'] ?? null,
            'rating' => isset($gd['rating']) ? round((float)$gd['rating'], 2) : null,
            'metacritic' => $gd['metacritic'] ?? null,
            'playtime' => $gd['playtime'] ?? null,
            'description' => $gd['description_raw'] ?? null,
        ];
    }
}