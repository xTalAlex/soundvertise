<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Services\SpotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaylistController extends Controller
{
    private SpotifyService $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = $this->spotifyService->getUserPlaylists(auth()->user());

        return view('playlists', compact('playlists'));
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
    public function store(Request $request)
    {
        $request->merge([
            'playlist_id' => Str::between($request->playlist_id ?? '', 'playlist/', '?'),
        ]);

        $validated = $request->validate([
            'playlist_id' => 'required|alpha_num',
        ]);

        $playlist = $this->spotifyService->getPlaylist(auth()->user(), $validated['playlist_id']);
        auth()->user()->playlists()->updateOrCreate([
            'spotify_id' => $playlist['id'],
        ], [
            'user_id' => auth()->user()->id,
            'url' => $playlist['external_urls']['spotify'],
            'name' => $playlist['name'],
            'description' => $playlist['description'],
            'collaborative' => $playlist['collaborative'],
            'tracks_total' => $playlist['tracks']['total'],
            'followers_total' => $playlist['followers']['total'],
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
