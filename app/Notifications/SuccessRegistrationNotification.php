<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SuccessRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via( $notifiable ) : array
    {
        return [ 'mail' ];
    }

    public function toMail( $notifiable ): MailMessage
    {
        return ( new MailMessage() )
            ->subject( 'Завершение регистрации на сайте ' . config( 'contact.site' ) )
            ->greeting( 'Поздравляем с завершением регистрации' )
            ->line( 'Рады сообщить, что вы были зарегистрированы в системе. Для доступа в личный кабинет используйте ссылку.' )
            ->action( 'Личный кабинет', route('account.profile.index') )
            ->line( 'Появились вопросы? Нужна консультация? Можете связаться с нами используя следующие контакты' )
            ->line( new HtmlString( '<a href="mailto:info@tatuguru.com"><img alt="email" src="' . asset( '/images/icons/mail.svg' ) . '"> info@tatuguru.com</a>' ) )
            ->line( new HtmlString( '<a href="https://t.me/+79052782835" target="_blank"><img alt="telegram" src="' . asset( '/images/icons/telegram-light.svg' ) . '"> Telegram</a>' ) );
    }
}
