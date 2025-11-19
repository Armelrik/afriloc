<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification
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
            ->subject(__('Booking Confirmed'))
            ->line(__('Your booking has been confirmed!'))
            ->line(__('Property: :property', ['property' => $this->booking->property->title_en]))
            ->line(__('From: :start to :end', ['start' => $this->booking->start_date->format('d/m/Y'), 'end' => $this->booking->end_date->format('d/m/Y')]))
            ->action(__('View Booking'), route('client.bookings.show', $this->booking->id))
            ->line(__('Thank you for choosing our platform!'));
    }

    public function toArray($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'property_title' => $this->booking->property->title_en,
            'start_date' => $this->booking->start_date,
            'end_date' => $this->booking->end_date,
        ];
    }
}

