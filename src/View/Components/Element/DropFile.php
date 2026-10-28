<?php

namespace Componist\Core\View\Components\Element;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropFile extends Component
{
    public string $id;

    public string $name;

    public bool $multiple;

    public ?string $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name, bool $multiple = false, ?string $title = null)
    {
        $this->id = uniqid();
        $this->name = $name;
        $this->multiple = $multiple;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('component::components.element.drop-file');
    }
}
