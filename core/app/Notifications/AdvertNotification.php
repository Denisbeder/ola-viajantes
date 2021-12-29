<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdvertNotification extends Notification
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
            ->success()
            ->subject('Você se fez um anúncio em ' . preg_replace('/http:\/\/|https:\/\//', '', $notifiable->present()->url))
            ->greeting($this->getGreeting())
            ->line('Seu anúncio está sendo analisado por nossa equipe. Segue abaixo dados do seu anúncio:')
            ->line('Título: ' . $notifiable->title)
            ->line('Telefones: ' . implode(',', $notifiable->phones ?? []))
            ->line('Cidade: ' . optional($notifiable->city)->name)
            ->line('Valor: ' . $notifiable->amount)
            ->line('Descrição: ' . nl2br($notifiable->body))
            ->action('Você pode EDITAR seu anúncio aqui após ele ser aprovado', $notifiable->present()->urlEdit)
            ->action('Você pode DELETAR seu anúncio aqui', $notifiable->present()->urlDelete)
            ->line('Sua participação é muito importante para nós!')
            ->salutation('Obrigado!');
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
