<?php

namespace App\Notifications\Promoter;

use App\Models\MaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceRequestReceived extends Notification implements ShouldQueue
{
    use Queueable;

    protected $maintenanceRequest;

    public function __construct(MaintenanceRequest $maintenanceRequest)
    {
        $this->maintenanceRequest = $maintenanceRequest;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $priorityColor = match($this->maintenanceRequest->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'normal' => 'blue',
            'low' => 'gray',
            default => 'gray',
        };

        return (new MailMessage)
                    ->subject(__('messages.notifications.maintenance_request_subject', [
                        'priority' => __('messages.maintenance.priority_' . $this->maintenanceRequest->priority)
                    ]))
                    ->greeting(__('messages.notifications.greeting', ['name' => $notifiable->name]))
                    ->line(__('messages.notifications.maintenance_request_body', [
                        'property' => $this->maintenanceRequest->property->title_fr,
                        'priority' => __('messages.maintenance.priority_' . $this->maintenanceRequest->priority),
                    ]))
                    ->line(__('messages.notifications.maintenance_title', [
                        'title' => $this->maintenanceRequest->title,
                    ]))
                    ->line(__('messages.notifications.maintenance_description', [
                        'description' => $this->maintenanceRequest->description,
                    ]))
                    ->line(__('messages.notifications.maintenance_client', [
                        'client' => $this->maintenanceRequest->user->name,
                    ]))
                    ->action(__('messages.notifications.view_maintenance'), route('promoter.maintenance'))
                    ->line(__('messages.notifications.thank_you'));
    }

    public function toArray($notifiable): array
    {
        return [
            'maintenance_request_id' => $this->maintenanceRequest->id,
            'property_id' => $this->maintenanceRequest->property_id,
            'title' => $this->maintenanceRequest->title,
            'priority' => $this->maintenanceRequest->priority,
            'user_name' => $this->maintenanceRequest->user->name,
            'type' => 'maintenance_request',
        ];
    }
}


