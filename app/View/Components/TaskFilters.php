<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskFilters extends Component
{
    public $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    public function render()
    {
        return view('components.task-filters');
    }
}