<?php

namespace Componist\Core\Livewire\Notification;

use Livewire\Component;
use Componist\Core\Models\ComponistCoreNotification;

class NotificationShow extends Component
{
    public string $title = '';

    public ?string $message = null;

    public function mount(ComponistCoreNotification $componistCoreNotification){

        $this->title = $componistCoreNotification['title'];
        $this->message = $componistCoreNotification['message'];
        
        if($componistCoreNotification['read'] == 0){

            $componistCoreNotification['read'] = 1;
            $componistCoreNotification['read_at'] = date('Y-m-d H:i:s');
        }

        $componistCoreNotification['updated_at'] = date('Y-m-d H:i:s');

        $componistCoreNotification->save();
    }

    public function render()
    {
        return view('component::livewire.notification.componist-core-notification-show')->layout(config('core.template.dashboard'));
    }
}