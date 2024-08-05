<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class AvatarUploader extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    #[Validate(['required', 'mimes:jpg,jpeg,png', 'max:1024'])]
    public $photo;

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $user = Auth::user();

        $this->state = $user->withoutRelations()->toArray();
    }

    public function updatedPhoto()
    {
        $this->updateProfilePhoto();
    }

    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function updateProfilePhoto()
    {
        $this->resetErrorBag();

        $this->validate();

        Auth::user()->updateProfilePhoto($this->photo);

        $this->dispatch('refresh-navigation-menu');
    }

    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Auth::user()->deleteProfilePhoto();

        $this->photo = null;

        $this->dispatch('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.components.avatar-uploader');
    }
}
