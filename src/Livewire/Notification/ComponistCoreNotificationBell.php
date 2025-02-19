<?php

namespace Componist\Core\Livewire\Notification;

use Livewire\Component;
use Componist\Core\Models\ComponistCoreNotification;

class ComponistCoreNotificationBell extends Component
{
    public function render()
    {
        $content = ComponistCoreNotification::where('user_id',auth()->user()->id)->where('read',0)->count();

        return view('component::livewire.notification.componist-core-notification-bell',compact('content'));
    }
}