<?php

namespace Componist\Core\Livewire\Notification;

use Componist\Core\Models\ComponistCoreNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Notification show')]
#[Layout(\Componist\Core\View\Components\DashboardLayout::class)]
class NotificationShow extends Component
{
    public string $title = '';

    public ?string $message = null;

    public function mount(ComponistCoreNotification $componistCoreNotification)
    {
        abort_unless((int) $componistCoreNotification->user_id === (int) Auth::id(), 403);

        $this->title = $componistCoreNotification['title'];
        $this->message = $componistCoreNotification['message'];

        if ($componistCoreNotification['read'] == 0) {

            $componistCoreNotification['read'] = 1;
            $componistCoreNotification['read_at'] = date('Y-m-d H:i:s');
        }

        $componistCoreNotification['updated_at'] = date('Y-m-d H:i:s');

        $componistCoreNotification->save();
    }

    public function render()
    {
        return view('component::livewire.notification.componist-core-notification-show');
    }
}
