<?php

namespace Componist\Core\Livewire\Notification;

use Componist\Core\Models\ComponistCoreNotification;
use Livewire\Component;

class ComponistCoreNotificationBell extends Component
{
    public function render()
    {
        $content = ComponistCoreNotification::where('user_id', auth()->user()->id)->where('read', 0)->count();

        return view('component::livewire.notification.componist-core-notification-bell', compact('content'));
    }
}
