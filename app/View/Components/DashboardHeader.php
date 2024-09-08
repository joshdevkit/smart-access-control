<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardHeader extends Component
{
    public $title;
    public $homeText;
    public $breadcrumb;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $homeText, $breadcrumb)
    {
        $this->title = $title;
        $this->homeText = $homeText;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dashboard-header');
    }
}
