<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SpotifyService
{
    private $driver = 'spotify';

    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = rtrim(config('services.spotify.endpoint') ?? '', '/');
    }

    public function authorize()
    {
        return Socialite::driver($this->driver)
            ->scopes(config('services.spotify.scopes'))
            ->redirect();
    }

    public function handleCallback()
    {
        return Socialite::driver($this->driver)->user();
    }

    public function createUser($spotifyData)
    {
        // return User::create([
        //     'email' => $spotifyData->email,
        //     'password' => Hash::make(Str::random(20)),
        //     'name' => $spotifyData->name,
        //     'spotify_id' => $spotifyData->id,
        //     'spotify_name' => $spotifyData->name,
        //     'spotify_avatar' => $spotifyData->user['images'][1]['url'] ?? null,
        //     'spotify_access_token' => $spotifyData->accessTokenResponseBody['access_token'],
        //     'spotify_refresh_token' => $spotifyData->accessTokenResponseBody['refresh_token'],
        //     'spotify_token_expiration' => Carbon::now()->addSeconds($spotifyData->accessTokenResponseBody['expires_in']),
        // ]);

        return User::create([
            'email' => $spotifyData['email'],
            'password' => Hash::make(Str::random(20)),
            'name' => $spotifyData['name'],
            'spotify_id' => $spotifyData['id'],
            'spotify_name' => $spotifyData['name'],
            'spotify_avatar' => $spotifyData['user']['images'][1]['url'] ?? null,
            'spotify_access_token' => $spotifyData['accessTokenResponseBody']['access_token'],
            'spotify_refresh_token' => $spotifyData['accessTokenResponseBody']['refresh_token'],
            'spotify_token_expiration' => Carbon::now()->addSeconds($spotifyData['accessTokenResponseBody']['expires_in']),
        ]);
    }

    public function updateUser(User $user, $spotifyData)
    {
        return $user->update([
            'name' => $user->name ?? $spotifyData->name,
            'spotify_id' => $spotifyData->id,
            'spotify_name' => $spotifyData->name,
            'spotify_avatar' => $spotifyData->user['images'][1]['url'] ?? null,
            'spotify_access_token' => $spotifyData->accessTokenResponseBody['access_token'],
            'spotify_refresh_token' => $spotifyData->accessTokenResponseBody['refresh_token'],
            'spotify_token_expiration' => Carbon::now()->addSeconds($spotifyData->accessTokenResponseBody['expires_in']),
        ]);
    }

    public function deleteSpotifyData(User $user)
    {
        return $user->update([
            'name' => $user->name,
            //'spotify_id' => null, Do not delete to allow user recovery
            'spotify_name' => null,
            'spotify_avatar' => null,
            'spotify_access_token' => null,
            'spotify_refresh_token' => null,
            'spotify_token_expiration' => null,
        ]);
    }

    /*
     * Update User's access token if it is going to expire within 10 seconds
     */
    public function refreshExpiringToken(User $user)
    {
        if (Carbon::now()->subSeconds(10) > $user->spotify_token_expiration) {
            $user->spotify_access_token = Socialite::driver($this->driver)->refreshToken($user->spotify_refresh_token);
            $user->save();
        }
    }

    public function getSpotifyUserPlaylist($spotifyUserId, $accessToken, $spotifyPlaylistId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
        ])->get($this->endpoint.'/playlists/'.$spotifyPlaylistId, [
        ]);

        if ($response->ok()) {
            $playlist = $response->collect()->toArray();
            if ($this->isSpotifyPlaylistImportableByUser($playlist, $spotifyUserId)) {
                return $response->collect();
            } else {
                $errors = [];
                if ($playlist['public'] != 'true') {
                    $errors['not_public'] = __('The playlist is private');
                }
                if ($playlist['owner']['id'] != $spotifyUserId) {
                    $errors['not_owned'] = __('You are not the playlist owner');
                }

                return collect(compact('errors'));
            }
        }
    }

    public function getUserPlaylist(User $user, string $playlistId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/playlists/'.$playlistId, [
        ]);

        if ($response->ok()) {
            $playlist = $response->collect()->toArray();
            if ($this->isSpotifyPlaylistImportableByUser($response->collect()->toArray(), $user->spotify_id)) {
                return $response->collect();
            } else {
                $errors = [];
                if ($playlist['public'] != 'true') {
                    $errors['not_public'] = __('The playlist is private');
                }
                if ($playlist['owner']['id'] != $user->spotify_id) {
                    $errors['not_owned'] = __('You are not the playlist owner');
                }

                return collect(compact('errors'));
            }
        }
    }

    public function getSpotifyUserPlaylists($spotifyUserId, $accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
        ])->get($this->endpoint.'/users/'.$spotifyUserId.'/playlists', [
            'limit' => 50,
        ]);

        if ($response->ok()) {
            $playlists = collect([]);

            // filtrare playlist in base a owner e collaborative

            collect($response->collect()['items'])->each(fn ($playlist) => $playlists->push($playlist));

            $playlists = $playlists->filter(fn ($playlist) => $this->isSpotifyPlaylistImportableByUser($playlist, $spotifyUserId));

            $response->collect()['next'];

            return $playlists;
        }

        if ($response->unauthorized()) {
            // prova un refresh token

        }

        if ($response->forbidden()) {
            // niente da fare

        }

        if ($response->tooManyRequests()) {
        }
    }

    public function getUserPlaylists(User $user)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/users/'.$user->spotify_id.'/playlists', [
            'limit' => 50,
        ]);

        if ($response->ok()) {
            $playlists = collect([]);

            // filtrare playlist in base a owner e collaborative

            collect($response->collect()['items'])->each(fn ($playlist) => $playlists->push($playlist));

            $playlists = $playlists->filter(fn ($playlist) => $this->isSpotifyPlaylistImportableByUser($playlist, $user->spotify_id));

            $user->update([
                'spotify_playlists_total' => $response->collect()['total'],
                'spotify_filtered_playlists_total' => $playlists->count(),
            ]);
            $response->collect()['next'];

            return $playlists;
        }

        if ($response->unauthorized()) {
            // prova un refresh token

        }

        if ($response->forbidden()) {
            // niente da fare

        }

        if ($response->tooManyRequests()) {
        }
    }

    /**
     * @param  array|Collection  $data  contains a list of track uri's and position
     */
    public function addSongsToPlaylist(User $user, Playlist $playlist, array|Collection $data)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->post($this->endpoint.'/playlists/'.$playlist->spotify_id.'/tracks', [
        ]);
    }

    /**
     * @param  array|Collection  $data  contains a list of track uri'
     */
    public function removePlaylistSongs(User $user, Playlist $playlist, array|Collection $data)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->delete($this->endpoint.'/playlists/'.$playlist->spotify_id.'/tracks', []);
    }

    public function getSong(User $user, string $songId)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/tracks/'.$songId, [
        ]);

        if ($response->ok()) {
            return $response->collect();
        }
    }

    public function getSongs(User $user, array|Collection $songIds)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/tracks', [
        ]);

        if ($response->ok()) {
            return $response->collect();
        }
    }

    public function getSongAudioFeatures(User $user, string $songId)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/audio-features/'.$songId, [
        ]);

        if ($response->ok()) {
            return $response->collect();
        }
    }

    public function getSongAudioAnalysis(User $user, string $songId)
    {
        $this->refreshExpiringToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->spotify_access_token,
        ])->get($this->endpoint.'/audio-analysis/'.$songId, [
        ]);

        if ($response->ok()) {
            return $response->collect();
        }
    }

    /*
    |------------------------------------------------
    | Utils
    |------------------------------------------------
    |
    */

    public function isSpotifyPlaylistImportableByUser(array $playlist, string $spotifyUserId): bool
    {
        return $playlist['public'] == 'true' && $playlist['owner']['id'] == $spotifyUserId;
    }

    public function getPlaylistIdFromUrl($playlistUrl): string
    {
        return Str::between($playlistUrl ?? '', 'playlist/', '?');
    }
}
