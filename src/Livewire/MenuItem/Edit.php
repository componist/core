<?php

namespace Reinholdjesse\Core\Livewire\MenuItem;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('component::livewire.menu-item.edit')->layout(config('core.template.dashboard'));
    }
}
