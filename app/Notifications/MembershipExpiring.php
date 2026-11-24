<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipExpiring extends Notification
{
    use Queueable;

    public function __construct(public $daysLeft) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Senior Citizen Membership is Expiring Soon')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your membership (ID: ' . $notifiable->membership_id . ') will expire in ' . $this->daysLeft . ' day(s).')
            ->line('Expiry Date: ' . $notifiable->expiry_date?->format('F d, Y'))
            ->action('View Membership', url('/user/dashboard'))
            ->line('Please renew your membership to continue enjoying the benefits.');
    }
}