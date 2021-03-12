<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AlertErrorMessage extends Component
{

	public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Error</strong> {{ $message }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
blade;
    }
}
