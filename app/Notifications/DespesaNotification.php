<?php

namespace App\Notifications;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DespesaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Despesa $despesa;
    public User $userWhoCreate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Despesa $despesa, User $userWhoCreate)
    {
        $this->despesa = $despesa;
        $this->userWhoCreate = $userWhoCreate;
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
            ->subject('despesa cadastrada.')
            ->greeting('Olá, ' . $notifiable->name)
            ->line('Uma nova despesa foi cadastrada. Confira detalhes abaixo: ')
            ->line('Valor: R$' . $this->despesa->valor)
            ->line('Descrição: ' . $this->despesa->descricao)
            ->line('Data: ' . $this->formatDate($this->despesa->datadespesa))
            ->line('Criado Por: ' . $this->userWhoCreate->name);
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
    public function formatDate(String $date)
    {
        $date = explode("-", $date);

        return $date[2]."/".$date[1]."/".$date[0];
    }
}
