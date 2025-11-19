<?php

namespace App\Notifications\Promoter;

use App\Models\Renewal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RenewalRequestReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $renewal;

    public function __construct(Renewal $renewal)
    {
        $this->renewal = $renewal;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('messages.notifications.renewal_request_subject'))
                    ->greeting(__('messages.notifications.greeting', ['name' => $notifiable->name]))
                    ->line(__('messages.notifications.renewal_request_body', [
                        'property' => $this->renewal->property->title_fr,
                        'client' => $this->renewal->user->name,
                    ]))
                    ->line(__('messages.notifications.renewal_dates', [
                        'current_end' => $this->renewal->current_end_date->format('d/m/Y'),
                        'new_end' => $this->renewal->new_end_date->format('d/m/Y'),
                    ]))
                    ->line(__('messages.notifications.renewal_amount', [
                        'amount' => number_format($this->renewal->renewal_amount, 0, ',', ' '),
                    ]))
                    ->action(__('messages.notifications.review_renewal'), route('promoter.renewals'))
                    ->line(__('messages.notifications.thank_you'));
    }

    public function toArray($notifiable): array
    {
        return [
            'renewal_id' => $this->renewal->id,
            'property_id' => $this->renewal->property_id,
            'user_name' => $this->renewal->user->name,
            'amount' => $this->renewal->renewal_amount,
            'type' => 'renewal_request',
        ];
    }
}


