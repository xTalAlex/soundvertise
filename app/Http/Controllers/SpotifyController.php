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

        if (Auth::check()) {
            // If spotify_id is not registered or it is associated with the current user
            if (! $user || $user->id == Auth::user()->id) {
                if ($user) {
                    $this->spotifyService->updateUser($user, $spotifyUser);
                }

                return ! $user ?
                    redirect()->route('register')->with(
                        'spotifyUser', $spotifyUser,
                    ) :
                    redirect()->route('galaxy')->banner('Spotify connected successfully.');
            }
            // If spotify_id is registered but is associated with another user
            else {
                return redirect()->route('galaxy')->dangerBanner('Spotify ID is already associated to another email.');
            }
        } else {
            if ($user) {
                $this->spotifyService->updateUser($user, $spotifyUser);
                Auth::login($user);

                return redirect()->route('galaxy')->banner('Logged in successfully.');
            } else {
                //$user = $this->spotifyService->createUser($spotifyUser);
                return redirect()->route('register')->with('spotifyUser', $spotifyUser);
            }
        }

        return redirect()->route('login')->dangerBanner('Unexpected error. Please, try again later.');
    }
}
