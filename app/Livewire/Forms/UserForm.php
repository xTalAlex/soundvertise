<?php

namespace App\Livewire\Forms;

use App\Actions\Fortify\PasswordValidationRules;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    use PasswordValidationRules;

    #[Validate]
    public $name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $country = '';

    #[Validate]
    public $password = '';

    #[Validate]
    public $password_confirmation = '';

    #[Validate]
    public $spotify_id;

    #[Validate]
    public $spotify_name;

    #[Validate]
    public $spotify_avatar;

    #[Validate]
    public $spotify_access_token;

    #[Validate]
    public $spotify_refresh_token;

    #[Validate]
    public $spotify_token_expiration;

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|min:5',
            'country' => 'required|min:2|max:3',
            'password' => $this->passwordRules(),
            'password_confirmation' => 'required_with:password',
            'spotify_id' => 'required|string',
            'spotify_name' => 'required|string',
            'spotify_avatar' => 'nullable|string',
            'spotify_access_token' => 'required|string',
            'spotify_refresh_token' => 'required|string',
            'spotify_token_expiration' => 'required|date',
        ];
    }

    public function setUser($spotifyUser)
    {
        $this->name = $spotifyUser['name'];

        $this->email = $spotifyUser['email'];

        $this->spotify_id = $spotifyUser['id'];

        $this->spotify_name = $spotifyUser['name'];

        $this->spotify_avatar = $spotifyUser['user']['images'][1]['url'] ?? null;

        $this->spotify_access_token = $spotifyUser['accessTokenResponseBody']['access_token'];

        $this->spotify_refresh_token = $spotifyUser['accessTokenResponseBody']['refresh_token'];

        $this->spotify_token_expiration = $spotifyUser['accessTokenResponseBody']['expiration_date'];
    }
}
