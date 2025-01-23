<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Http\Controllers\Controller;
//use http\Env\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index',[
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
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
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit',[
            'chirp'=>$chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update',$chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
       Gate::authorize('delete', $chirp);

       $chirp->delete();

       return redirect(route('chirps.index'));
    }

    public function like(Chirp $chirp, Request $request): RedirectResponse
    {
        $userId = $request->user()->id;

        if (!$chirp->likes()->where('user_id', $userId)->exists()) {
            $chirp->likes()->create(['user_id' => $userId]);
        }

        return redirect(route('chirps.index'));
    }

    public  function unlike(Chirp $chirp, Request $request): RedirectResponse
    {

        $userId = $request->user()->id;


        $chirp->likes()->where('user_id', $userId)->delete();

        return redirect(route('chirps.index'));
    }
}
