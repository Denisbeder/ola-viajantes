<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentNotification extends Notification
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
        $greeting = sprintf('%s, %s!', $this->getGreeting(), $notifiable->name);
        return (new MailMessage)
            ->success()
            ->subject('Você fez um comentário no em ' . preg_replace('/http:\/\/|https:\/\//', '', $notifiable->commentable->present()->url))
            ->greeting($greeting)
            ->line('Veja seu comentário abaixo.')
            ->with('"' . e(nl2br($notifiable->text)) . '"')
            ->action('Ir para o site', $notifiable->commentable->present()->url)
            ->salutation('Obrigado!')
            ->line('Sua participação é muito importante para nós!');
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

    public function getGreeting()
    {
        $now = Carbon::now();
        $dawnTime = Carbon::now()->setTime(23, 59, 59);
        $dayTime = Carbon::now()->setTime(06, 00, 00);
        $afternoonTime = Carbon::now()->setTime(12, 00, 00);
        $nightTime = Carbon::now()->setTime(18, 00, 00);

        if ($now > $dayTime && $now < $afternoonTime) {
            return 'Bom dia';
        } elseif ($now > $afternoonTime && $now < $nightTime) {
            return 'Boa tarde';
        } elseif ($now > $nightTime && $now < $dawnTime) {
            return 'Boa noite';
        }

        return 'Olá';
    }
}
