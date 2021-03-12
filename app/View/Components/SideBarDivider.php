<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideBarDivider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
		<hr class="sidebar-divider my-1">
blade;
    }
}
