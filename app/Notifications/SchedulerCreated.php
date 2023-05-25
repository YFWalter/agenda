<?php

namespace App\Notifications;

use App\Models\Scheduler;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SchedulerCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Scheduler $scheduler)
    {
        $this->scheduler = $scheduler;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Nueva Cita')
                    ->greeting("Hola {$this->scheduler->staffUser->name}")
                    ->line("{$this->scheduler->clientUser->name} ha realizado una nueva reservacion que debes atender el día {$this->scheduler->from->isoFormat('dddd Do MMMM YYYY')} a las {$this->scheduler->from->format('H:i')}.")
                    ->action('Revisar Agenda', url('/dashboard'))
                    ->line('¡No olvides revisar con frecuencia tu agenda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
