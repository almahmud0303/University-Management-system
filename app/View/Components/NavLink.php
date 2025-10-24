<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavLink extends Component
{
    public $href;
    public $active;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $active = false)
    {
        $this->href = $href;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.nav-link');
    }
}
