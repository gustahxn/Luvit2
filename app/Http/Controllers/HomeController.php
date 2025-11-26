<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListModel;
use App\Models\Review; 
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Minhas Listas (Resumo lateral)
        $myLists = ListModel::where('user_id', $user->id)
            ->withCount('items')
            ->latest()
            ->take(4)
            ->get();

        // 2. Reviews dos Amigos (Activity Feed)
        // CORREÇÃO: Usar o nome correto da tabela ou apenas 'id'
        // Assumindo que seu relacionamento following() está correto no model User
        $followingIds = $user->following()->pluck('table_users.id'); 

        $friendsReviews = Review::whereIn('user_id', $followingIds)
            ->with(['user', 'game', 'movie']) // Carrega User, Game e Movie
            ->latest()
            ->take(10)
            ->get();

        // 3. Listas da Comunidade
        $communityLists = ListModel::where('user_id', '!=', $user->id)
            ->with(['user', 'items' => function($query) {
                $query->take(3);
            }])
            ->withCount('items')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('home', compact('myLists', 'friendsReviews', 'communityLists', 'user'));
    }
}