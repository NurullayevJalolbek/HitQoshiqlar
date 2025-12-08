<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SvgIcon extends Component
{
    public $name;
    public $class;
    public $width;
    public $height;
    public $svgContent;

    public function __construct($name, $class = '', $width = 16, $height = 16)
    {
        $this->name = $name;
        $this->class = $class;
        $this->width = $width;
        $this->height = $height;

        $path = public_path("svg/{$name}.svg");
        if (file_exists($path)) {
            $this->svgContent = file_get_contents($path);
            $this->svgContent = str_replace(
                ['width="16"', 'height="16"', '<svg'],
                ['width="'.$width.'"', 'height="'.$height.'"', '<svg class="'.$class.'"'],
                $this->svgContent
            );
        } else {
            $this->svgContent = '';
        }
    }

    public function render()
    {
        return view('components.svg-icon');
    }
}
