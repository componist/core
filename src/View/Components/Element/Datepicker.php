<?php

namespace Reinholdjesse\Core\View\Components\Element;

use Closure;
use Illuminate\View\Component;

class Datepicker extends Component
{
    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $model = null)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render()
    {
        return view('component::components.element.datepicker');
    }
}
