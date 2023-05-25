<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Scheduler;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SchedulerUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Scheduler $scheduler, Carbon $schedulerOldFrom)
    {
        $this->scheduler = $scheduler;
        $this->schedulerOldFrom = $schedulerOldFrom;
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
            ->subject('Actualización de Cita')
            ->greeting("Hola {$this->scheduler->staffUser->name}")
            ->line("El cliente: {$this->scheduler->clientUser->name}. Reagendó la cita del día: {$this->schedulerOldFrom->isoFormat('dddd Do MMMM YYYY')} a las {$this->schedulerOldFrom->format('H:i')}.
                    Para el día: {$this->scheduler->from->isoFormat('dddd Do MMMM YYYY')} a las {$this->scheduler->from->format('H:i')}.")
            ->action('Revisar Agenda', url('/dashboard'))
            ->line('¡No olvides revisar con frecuencia tu agenda!');
    }
  // 
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
