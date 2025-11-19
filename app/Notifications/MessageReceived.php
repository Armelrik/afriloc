<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageReceived extends Notification
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('New Message'))
            ->line(__('You have received a new message.'))
            ->line(__('From: :sender', ['sender' => $this->message->sender->name]))
            ->line(__('Subject: :subject', ['subject' => $this->message->subject ?? 'No subject']))
            ->action(__('View Message'), route('client.messages'))
            ->line(__('Please log in to read and respond to the message.'));
    }

    public function toArray($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'sender_name' => $this->message->sender->name,
            'subject' => $this->message->subject,
            'preview' => substr($this->message->message, 0, 100),
        ];
    }
}

