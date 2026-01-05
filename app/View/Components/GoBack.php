<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GoBack extends Component
{
    public $url; // URL props uchun

    /**
     * Create a new component instance.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.go-back');
    }
}
