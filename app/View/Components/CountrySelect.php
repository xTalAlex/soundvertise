<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CountrySelect extends Component
{
    public $countries;

    public bool $detectLang;

    /**
     * Create a new component instance.
     */
    public function __construct(?bool $detectLang = false)
    {
        $this->countries = collect([
            'it' => 'Italy',
            'fr' => 'France',
            'es' => 'Spain',
            'ch' => 'Switzerland',
        ])->sort();

        $this->detectLang = $detectLang;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.country-select');
    }
}
