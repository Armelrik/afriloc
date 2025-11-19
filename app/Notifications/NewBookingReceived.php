<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewBookingReceived extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Booking for Your Property')
                    ->line('You have received a new booking request.')
                    ->line('Property: ' . $this->booking->property->title_fr)
                    ->line('Customer: ' . $this->booking->customer_name)
                    ->line('Amount: ' . number_format($this->booking->promoter_amount, 0) . ' FCFA')
                    ->action('View Booking', url('/promoter/bookings'))
                    ->line('Please review and confirm the booking.');
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'property_title' => $this->booking->property->title_fr,
            'customer_name' => $this->booking->customer_name,
            'amount' => $this->booking->promoter_amount,
        ];
    }
}
