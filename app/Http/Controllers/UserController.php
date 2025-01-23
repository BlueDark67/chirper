<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chirp;
use App\Models\Follow;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        $chirps = Chirp::with('user', 'likes')->get();
        $user = auth()->user(); // ou como você obtém o usuário

        return view('chirps.index', compact('chirps', 'user'));
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function follow(User $user, Request $request): RedirectResponse
    {
        $followerId = $request->user()->id;

        if (!$user->followers()->where('follower_id', $followerId)->exists()) {
            $user->followers()->create(['follower_id' => $followerId]);
        }

        return redirect()->back();
    }

    public function unfollow(User $user, Request $request): RedirectResponse
    {
        $followerId = $request->user()->id;

        $user->followers()->where('follower_id', $followerId)->delete();

        return redirect()->back();
    }
}
