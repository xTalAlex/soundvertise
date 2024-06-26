<?php

namespace App\Socialite;

use SocialiteProviders\Spotify\Provider;

class SpotifyProvider extends Provider
{
    public function refreshToken($refreshToken)
    {
        $response = $this->getHttpClient()->post(
            $this->getTokenUrl(),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
            ]
        );

        return json_decode($response->getBody(), true)['access_token'];
    }
}
