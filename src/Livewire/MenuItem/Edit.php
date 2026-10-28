<?php

namespace Componist\Core\Livewire\MenuItem;

use Componist\Core\View\Components\DashboardLayout;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout(DashboardLayout::class)]
class Edit extends Component
{
    public function render(): View
    {
        return view('component::livewire.menu-item.edit');
    }
}
