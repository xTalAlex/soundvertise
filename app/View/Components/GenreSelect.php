<?php

namespace App\View\Components;

use App\Models\Genre;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GenreSelect extends Component
{
    public $genres;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->genres = Genre::all()->sortBy('order', descending: false);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.genre-select');
    }
}
