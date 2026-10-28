<?php

namespace Componist\Core\Livewire\Menu;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Edit extends Component
{
    public function render(): View
    {
        return view('component::livewire.menu.edit');
    }
}
