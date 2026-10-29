<?php

declare(strict_types=1);

namespace Componist\Core\Livewire\Notification;

use Componist\Core\Models\ComponistCoreNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComponistCoreNotificationBell extends Component
{
    public function render(): View
    {
        $userId = Auth::id();

        $content = $userId === null
            ? 0
            : ComponistCoreNotification::query()
                ->where('user_id', $userId)
                ->where('read', 0)
                ->count();

        return view('component::livewire.notification.componist-core-notification-bell', compact('content'));
    }
}
