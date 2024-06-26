<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SpotifyService;
use Illuminate\Support\Facades\Auth;

class SpotifyController extends Controller
{
    private SpotifyService $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    /*
     * Auth redirect route
     */
    public function redirect()
    {
        return $this->spotifyService->authorize();
    }

    /**
     * Spotify callback
     *
     * @spotifyUser contains id, name, email, avatar
     *
     * @tokenResponse contains access_token, expires_in, refresh_token
     */
    public function callback()
    {
        $spotifyUser = $this->spotifyService->handleCallback();
        $tokenResponse = $spotifyUser->accessTokenResponseBody;
        $user = User::where('spotify_id', $spotifyUser->id)->first();

        //validare dati es. spotify_id unique

        if (Auth::check()) {
            if (! $user || $user->id == Auth::user()->id) {
                $this->spotifyService->updateUser(Auth::user(), $spotifyUser);

                return redirect('/dashboard')->banner('Spotify connected successfully.');
            } else {
                return redirect('dashboard')->dangerBanner('Spotify ID is already associated to another email.');
            }
        } else {
            if ($user) {
                $this->spotifyService->updateUser($user, $spotifyUser);
            } else {
                $user = $this->spotifyService->createUser($spotifyUser);
            }
            Auth::login($user);
        }

        return redirect('/dashboard');
    }
}
