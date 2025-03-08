<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail as AuthVerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends AuthVerifyEmailNotification implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $url
     * @return MailMessage
     */
    protected function buildMailMessage( $url ): MailMessage
    {
        return (new MailMessage)
            ->subject( 'Подтверждение регистрациим на сайте ' . config( 'contact.site' ) )
            ->greeting( 'Здравствуйте!' )
            ->line( 'Пожалуйста, нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты.' )
            ->action( 'Подтвердить электронную почту', $url )
            ->line( 'Если вы не создавали учетную запись, проигнорируйте это сообщение.' );
    }
}
