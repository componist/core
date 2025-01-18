<?php

namespace Componist\Core\View\Components;

use Illuminate\View\Component;

class DashboardLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view(config('core.template.dashboard'));
    }
}
