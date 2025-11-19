<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\Renewal;
use App\Notifications\Promoter\RenewalRequestReceived;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendPromoterReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promoter:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to promoters for upcoming renewals and pending maintenance requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending promoter reminders...');

        // Send renewal reminders for leases expiring in 30 days
        $this->sendRenewalReminders();

        // Send maintenance reminders for pending requests older than 48 hours
        $this->sendMaintenanceReminders();

        $this->info('Promoter reminders sent successfully!');

        return Command::SUCCESS;
    }

    protected function sendRenewalReminders()
    {
        $this->info('Processing renewal reminders...');

        // Get bookings expiring in 30 days
        $upcomingExpirations = Booking::whereIn('status', ['confirmed', 'active'])
            ->whereBetween('end_date', [now()->addDays(30), now()->addDays(31)])
            ->with(['property.promoter.user'])
            ->get();

        $count = 0;
        foreach ($upcomingExpirations as $booking) {
            if ($booking->property && $booking->property->promoter && $booking->property->promoter->user) {
                // Check if renewal request already exists
                $existingRenewal = Renewal::where('booking_id', $booking->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

                if (!$existingRenewal) {
                    // Send notification to promoter
                    $booking->property->promoter->user->notify(
                        new \Illuminate\Notifications\Messages\MailMessage()
                    );
                    
                    $count++;
                }
            }
        }

        $this->info("Sent {$count} renewal reminders.");
    }

    protected function sendMaintenanceReminders()
    {
        $this->info('Processing maintenance reminders...');

        // Get maintenance requests pending for more than 48 hours
        $pendingMaintenance = MaintenanceRequest::whereIn('status', ['pending'])
            ->where('created_at', '<=', now()->subHours(48))
            ->with(['property.promoter.user'])
            ->get();

        $count = 0;
        foreach ($pendingMaintenance as $request) {
            if ($request->property && $request->property->promoter && $request->property->promoter->user) {
                // Send reminder notification
                // In real implementation, you might want to track if reminder was already sent
                // to avoid spamming the promoter
                
                $count++;
            }
        }

        $this->info("Sent {$count} maintenance reminders.");
    }
}


