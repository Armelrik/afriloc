<?php

namespace App\Notifications;

use App\Models\MaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceRequestReceived extends Notification
{
    use Queueable;

    protected $maintenanceRequest;

    public function __construct(MaintenanceRequest $maintenanceRequest)
    {
        $this->maintenanceRequest = $maintenanceRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('New Maintenance Request'))
            ->line(__('A new maintenance request has been submitted.'))
            ->line(__('Property: :property', ['property' => $this->maintenanceRequest->property->title_en]))
            ->line(__('Title: :title', ['title' => $this->maintenanceRequest->title]))
            ->line(__('Priority: :priority', ['priority' => ucfirst($this->maintenanceRequest->priority)]))
            ->action(__('View Request'), route('promoter.maintenance'))
            ->line(__('Please review and respond as soon as possible.'));
    }

    public function toArray($notifiable)
    {
        return [
            'maintenance_request_id' => $this->maintenanceRequest->id,
            'property_title' => $this->maintenanceRequest->property->title_en,
            'title' => $this->maintenanceRequest->title,
            'priority' => $this->maintenanceRequest->priority,
        ];
    }
}

