<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepButtons extends Component
{
    public $submitText;

    public function __construct($submitText = 'Yuborish')
    {
        $this->submitText = $submitText;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.step-buttons');
    }
}
