<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('Payment Received'))
            ->line(__('A payment has been received for your property.'))
            ->line(__('Amount: :amount FCFA', ['amount' => number_format($this->payment->amount, 0, ',', ' ')]))
            ->line(__('Property: :property', ['property' => $this->payment->booking->property->title_en]))
            ->action(__('View Details'), route('promoter.bookings'))
            ->line(__('Thank you for using our platform!'));
    }

    public function toArray($notifiable)
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount,
            'booking_id' => $this->payment->booking_id,
            'property_title' => $this->payment->booking->property->title_en,
        ];
    }
}

