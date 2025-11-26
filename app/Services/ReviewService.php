<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Game;
use App\Models\Review;

class ReviewService
{
    public function add($item, int $userId, string $reviewText, ?int $rating = null, ?int $parentId = null): Review
    {
        $data = [
            'user_id' => $userId,
            'review' => $reviewText,
            'rating' => $rating,
            'parent_id' => $parentId,
        ];

        if ($item instanceof Movie) {
            $data['movie_id'] = $item->id;
        } elseif ($item instanceof Game) {
            $data['game_id'] = $item->id;
        }

        return Review::create($data);
    }

    public function delete(int $reviewId, int $userId): bool
    {
        $review = Review::where('id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        if (!$review) {
            return false;
        }

        return (bool) $review->delete();
    }

    public function getByMovie($movieId)
    {
        return Review::where('movie_id', $movieId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function getByGame($gameId)
    {
        return Review::where('game_id', $gameId)
            ->with('user')
            ->latest()
            ->get();
    }
}