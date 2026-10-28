<?php

namespace Componist\Core\View\Components\Element;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datepicker extends Component
{
    public ?string $model;

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
     * @return View|Closure|string
     */
    public function render()
    {
        return view('component::components.element.datepicker');
    }
}
