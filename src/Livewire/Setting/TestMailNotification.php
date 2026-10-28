<?php

namespace Componist\Core\Livewire\Setting;

use Componist\Core\Notifications\Setting\SendTestMailNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TestMailNotification extends Component
{
    #[Validate]
    public string $email = '';

    /**
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
        ];
    }

    public function render(): View
    {
        return view('component::livewire.setting.test-mail-notification');
    }

    public function sendTestMail(): void
    {

        $validated = $this->validate();

        if ($validated['email']) {

            Notification::route('mail', $validated['email'])->notify(new SendTestMailNotification);

            $this->email = '';
        }
    }
}
