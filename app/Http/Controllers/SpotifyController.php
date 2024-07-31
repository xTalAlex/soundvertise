<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SpotifyService;
use Illuminate\Support\Carbon;
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
                $this->spotifyService->updateUser(Auth::user(), $spotifyUser);

                return ! $user ?
                    redirect()->route('profile.show')->banner('Spotify connected successfully.')
                    :
                    redirect()->route('profile.show');
            }
            // If spotify_id is registered but is associated with another user
            else {
                return redirect()->route('profile.show')->dangerBanner('Spotify ID is already associated to another email.');
            }
        } else {
            if ($user) {
                $this->spotifyService->updateUser($user, $spotifyUser);
                Auth::login($user);

                return redirect()->route('profile.show');
            } else {
                $spotifyUser->accessTokenResponseBody['expiration_date'] = Carbon::now()->addSeconds($spotifyUser->accessTokenResponseBody['expires_in']);
                session()->put('spotifyUser', $spotifyUser);

                return redirect()->route('register.user');
            }
        }

        return redirect()->route('login')->dangerBanner('Unexpected error. Please, try again later.');
    }
}
