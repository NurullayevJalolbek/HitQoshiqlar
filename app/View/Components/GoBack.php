<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GoBack extends Component
{
    public $url; // URL props uchun

    /**
     * Create a new component instance.
     *
     * @param string|null $url
     */
    public function __construct($url = null)
    {
        // Agar hech narsa kelmasa, session yoki previous URL ishlat
        $this->url = $url ?? session('back_url', url()->previous());
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.go-back');
    }
}
