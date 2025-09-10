<?php

namespace Componist\Core\Livewire\MenuItem;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('component::livewire.menu-item.edit')->layout(config('componist.template.dashboard'));
    }
}