<?php

/*
 * This file is part of the Laravel framework.
 *
 * (c) Laravel <https://laravel.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
public $token;

public function __construct($token)
{
$this->token = $token;
}

public function via($notifiable)
{
return ['mail'];
}

public function toMail($notifiable)
{
$url = url(route('password.reset', [
'token' => $this->token,
'email' => $notifiable->getEmailForPasswordReset(),
], false));

return (new MailMessage)
->subject(Lang::get('Reset Password Notification'))
->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
->action(Lang::get('Reset Password'), $url)
->line(Lang::get('This password reset link will expire in :count minutes.', ['count' =>
config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
->line(Lang::get('If you did not request a password reset, no further action is required.'));
}
}