<?php

namespace App\Notifications;

use App\Models\Promoter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PromoterApplicationApproved extends Notification
{
    use Queueable;

    protected $promoter;

    public function __construct(Promoter $promoter)
    {
        $this->promoter = $promoter;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Promoter Application Has Been Approved!')
                    ->line('Congratulations! Your promoter application has been approved.')
                    ->line('You can now start adding properties and managing your portfolio.')
                    ->action('Access Dashboard', url('/promoter/dashboard'))
                    ->line('Thank you for joining LocAfri!');
    }

    public function toArray($notifiable)
    {
        return [
            'promoter_id' => $this->promoter->id,
            'message' => 'Your promoter application has been approved',
        ];
    }
}
