<?php

namespace App\Notifications;

use App\DTO\Feedback\FeedbackDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendFeedbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private FeedbackDTO $dto
    ) {}

    public function via( $notifiable ): array
    {
        return ['mail'];
    }

    public function toMail( $notifiable ): MailMessage
    {
        return ( new MailMessage() )
            ->subject( 'Обратная связь (заявка) от ' . $this->dto->name )
            ->greeting( 'Данные из формы обратной связи' )
            ->line( new HtmlString( '<b>Имя:</b>&nbsp;' . $this->dto->name ) )
            ->line( new HtmlString( '<b>Телефон:</b>&nbsp;' . $this->dto->phone ) )
            ->line( new HtmlString( '<b>Email:</b>&nbsp;' . $this->dto->email ) )
            ->line( new HtmlString( '<b>Сообщение:</b>&nbsp;' . $this->dto->message ) );
    }
}
