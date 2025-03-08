<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as AuthResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends AuthResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    /**
     * @param string $url
     * @return MailMessage
     */
    protected function buildMailMessage( $url ): MailMessage
    {
        return (new MailMessage)
            ->subject( 'Запрос на восстановление пароля на сайте ' . config( 'contact.site' ) )
            ->greeting( 'Здравствуйте!' )
            ->line( 'Вы получили это электронное письмо, потому что был выполнен запрос на сброс пароля для вашей учетной записи.' )
            ->action( 'Сбросить пароль', $url )
            ->line( 'Срок действия этой ссылки для сброса пароля истечет через ' . config( 'auth.passwords.' . config( 'auth.defaults.passwords' ) . '.expire' ) . ' минут.' )
            ->line( 'Если вы не запрашивали сброс пароля, проигнорируйте это сообщение.' );
    }
}
