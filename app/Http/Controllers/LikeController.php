<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Like;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Chirp $chirp)
    {
        if (!$chirp->likes()->where('user_id', auth()->id())->exists()) {
            $chirp->likes()->create([
                'user_id' => auth()->id()
            ]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like, Chirp $chirp)
    {
        $chirp->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}
