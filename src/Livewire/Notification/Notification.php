<?php

namespace Componist\Core\Livewire\Notification;

use Livewire\Component;
use Livewire\WithPagination;
use Componist\Core\Models\ComponistCoreNotification;
use Componist\Core\Traits\addLivewireControlleFunctions;

class Notification extends Component
{
    use addLivewireControlleFunctions;
    use WithPagination;

    public ?string $search = null;

    
    public function render()
    {
        $content = ComponistCoreNotification::where('user_id',auth()->user()->id)->where('title', 'LIKE', '%'.trim($this->search).'%')->paginate(10);

        return view('component::livewire.notification.componist-core-notification',compact('content'))->layout(config('core.template.dashboard'));
    }

    public function delete(int $id): void
    {
        if (ComponistCoreNotification::find($id)->delete()) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gelöscht');
        } else {
            $this->bannerMessage('danger', 'Fehler beim löschen des Eintrags.');
        }
    }
}