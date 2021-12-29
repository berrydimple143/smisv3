<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $encEmail = Crypt::encryptString($this->user->email);
        $url = url('/online/form/'.$encEmail);
        //$logo = asset('img/altus-logo.jpg');
        //$img = '<img src="'.$logo.'" style="width:30%;">';
        return (new MailMessage)
                //->line($img)
                ->greeting('Hi,')
                ->line('Thank you for creating your account.')
                ->line('Kindly verify your email to proceed with the Registration Form.')
                ->action('Verify email address', $url)
                ->line('Note: This email verification is valid for 24hrs only.');
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
}
