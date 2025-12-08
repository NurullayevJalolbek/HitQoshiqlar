<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterButtons extends Component
{
    public $searchText;
    public $clearText;

    public function __construct($searchText = null, $clearText = null)
    {
        $this->searchText = $searchText ?? __('admin.search');
        $this->clearText = $clearText ?? __('admin.clear');
    }


    public function render()
    {
        return view('components.filter-buttons');
    }
}
