<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;

class UpdateProfileInformationFormSimple extends UpdateProfileInformationForm
{
    public function render()
    {
        return view('profile.update-profile-information-form-simple');
    }
}
