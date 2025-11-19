<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RenewalReminder extends Notification
{
    use Queueable;

    protected $booking;
    protected $daysUntilExpiry;

    public function __construct(Booking $booking, int $daysUntilExpiry)
    {
        $this->booking = $booking;
        $this->daysUntilExpiry = $daysUntilExpiry;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Rental Renewal Reminder'))
            ->line(__('Your rental is expiring soon!'))
            ->line(__('Property: :property', ['property' => $this->booking->property->title_en]))
            ->line(__('Expires in: :days days', ['days' => $this->daysUntilExpiry]))
            ->line(__('End date: :date', ['date' => $this->booking->end_date->format('d/m/Y')]))
            ->action(__('Request Renewal'), route('client.renewals'))
            ->line(__('Please contact us if you wish to renew your rental.'));
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'property_title' => $this->booking->property->title_en,
            'end_date' => $this->booking->end_date,
            'days_until_expiry' => $this->daysUntilExpiry,
        ];
    }
}

