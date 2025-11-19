<?php

namespace App\Console\Commands;

use App\Services\RenewalService;
use Illuminate\Console\Command;

class SendRenewalReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'renewals:send-reminders {--days=30 : Days before expiry to send reminders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send renewal reminders for bookings expiring soon';

    /**
     * Execute the console command.
     */
    public function handle(RenewalService $renewalService)
    {
        $days = (int) $this->option('days');
        
        $this->info("Sending renewal reminders for bookings expiring in {$days} days...");
        
        $result = $renewalService->sendRenewalReminders($days);
        
        $this->info("Reminders sent: {$result['reminders_sent']}");
        $this->info("Bookings notified: {$result['bookings_notified']}");
        
        return Command::SUCCESS;
    }
}
