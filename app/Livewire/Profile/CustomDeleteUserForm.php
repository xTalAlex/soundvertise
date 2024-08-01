<?php

namespace App\Livewire\Profile;

use Laravel\Jetstream\Http\Livewire\DeleteUserForm;

class CustomDeleteUserForm extends DeleteUserForm
{
    public $compact = false;
}
