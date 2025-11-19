<?php

namespace App\Notifications;

use App\Models\Promoter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PromoterApplicationSubmitted extends Notification
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
                    ->subject('New Promoter Application')
                    ->line('A new promoter application has been submitted.')
                    ->line('Name: ' . $this->promoter->user->name)
                    ->line('Email: ' . $this->promoter->user->email)
                    ->action('Review Application', url('/admin/promoters'))
                    ->line('Please review and approve the application.');
    }

    public function toArray($notifiable)
    {
        return [
            'promoter_id' => $this->promoter->id,
            'promoter_name' => $this->promoter->user->name,
            'message' => 'New promoter application submitted',
        ];
    }
}
