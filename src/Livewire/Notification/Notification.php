<?php

namespace Componist\Core\Livewire\Notification;

use Componist\Core\Models\ComponistCoreNotification;
use Componist\Core\Traits\addLivewireControlleFunctions;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Notification')]
#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class Notification extends Component
{
    use addLivewireControlleFunctions;
    use WithPagination;

    public ?string $search = null;

    public function render()
    {
        $content = ComponistCoreNotification::where('user_id', Auth::id())
            ->where('title', 'LIKE', '%'.trim($this->search).'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('component::livewire.notification.componist-core-notification', compact('content'));
    }

    public function delete(int $id): void
    {
        /** @var ComponistCoreNotification|null $notification */
        $notification = ComponistCoreNotification::query()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if ($notification && $notification->delete()) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gelöscht');
        } else {
            $this->bannerMessage('danger', 'Fehler beim löschen des Eintrags.');
        }
    }
}
