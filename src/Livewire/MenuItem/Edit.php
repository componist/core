<?php

namespace Componist\Core\Livewire\MenuItem;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class Edit extends Component
{
    public function render()
    {
        return view('component::livewire.menu-item.edit');
    }
}
