<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Spinner extends Component
{

	public $color, $size, $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($color = 'text-white', $size = 'spinner-border-sm', $id='')
    {
        $this->color = $color;
		$this->size = $size;
		$this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
		<div id='{{$id}}' class="spinner-border {{ $size }} {{ $color }}" role="status"></div>
blade;
    }
}
