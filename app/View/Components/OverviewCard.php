<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OverviewCard extends Component
{
    public $title;
    public $amount;
    public $icon;
    public $trend;
    
    public function __construct($title, $amount, $icon = null, $trend = null)
    {
        $this->title = $title;
        $this->amount = $amount;
        $this->icon = $icon;
        $this->trend = $trend;
    }
    
    public function render()
    {
        return view('components.overview-card');
    }
}