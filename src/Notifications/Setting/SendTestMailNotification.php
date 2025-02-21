<?php

namespace Componist\Core\Notifications\Setting;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTestMailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Test-E-Mail erfolgreich versendet – Einstellungen sind in Ordnung')
            ->greeting('Hallo,')
            ->line('wir freuen uns, dir mitteilen zu können, dass die Test-E-Mail erfolgreich versendet wurde und alle Einstellungen korrekt konfiguriert sind. Deine E-Mail-Konfiguration ist somit vollständig in Ordnung und funktionsfähig.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
