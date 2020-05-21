<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PleaseVerifyYourEmail extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    protected $verificationUrl;

    /**
     * Create a new notification instance.
     *
     * @param string $verificationUrl
     */
    public function __construct(string $verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Please verify your email')
            ->line('We just need you to confirm your email address to prove that you\'re a human. You get it, right? Coo.')
            ->action('Verify Email', $this->verificationUrl)
            ->line('Thank you for using our application!');
    }
}
