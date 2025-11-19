<?php

namespace App\Notifications\Promoter;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('messages.notifications.new_booking_subject'))
                    ->greeting(__('messages.notifications.greeting', ['name' => $notifiable->name]))
                    ->line(__('messages.notifications.new_booking_body', [
                        'property' => $this->booking->property->title_fr,
                        'customer' => $this->booking->customer_name,
                    ]))
                    ->line(__('messages.notifications.booking_dates', [
                        'start' => $this->booking->start_date->format('d/m/Y'),
                        'end' => $this->booking->end_date->format('d/m/Y'),
                    ]))
                    ->line(__('messages.notifications.booking_amount', [
                        'amount' => number_format($this->booking->promoter_amount, 0, ',', ' '),
                    ]))
                    ->action(__('messages.notifications.view_booking'), route('promoter.bookings'))
                    ->line(__('messages.notifications.thank_you'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'property_id' => $this->booking->property_id,
            'customer_name' => $this->booking->customer_name,
            'amount' => $this->booking->promoter_amount,
            'type' => 'new_booking',
        ];
    }
}


