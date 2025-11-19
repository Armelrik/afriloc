<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Renewal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RenewalService
{
    /**
     * Create a renewal request
     */
    public function createRenewalRequest(Booking $booking, array $renewalData): Renewal
    {
        return Renewal::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
            'property_id' => $booking->property_id,
            'current_end_date' => $booking->end_date,
            'new_start_date' => $renewalData['new_start_date'],
            'new_end_date' => $renewalData['new_end_date'],
            'renewal_duration' => $renewalData['renewal_duration'],
            'renewal_frequency' => $renewalData['renewal_frequency'] ?? 'monthly',
            'renewal_amount' => $renewalData['renewal_amount'],
            'renewal_type' => $renewalData['renewal_type'] ?? 'manual',
            'notes' => $renewalData['notes'] ?? null,
            'requested_at' => now(),
            'status' => 'pending',
        ]);
    }

    /**
     * Approve a renewal request
     */
    public function approveRenewal(Renewal $renewal, int $approvedBy): bool
    {
        return DB::transaction(function () use ($renewal, $approvedBy) {
            // Approve the renewal
            $renewal->approve($approvedBy);
            
            // Update the booking's end date
            $renewal->booking->update([
                'end_date' => $renewal->new_end_date,
            ]);
            
            return true;
        });
    }

    /**
     * Reject a renewal request
     */
    public function rejectRenewal(Renewal $renewal, int $rejectedBy, string $reason = ''): bool
    {
        return $renewal->reject($rejectedBy, $reason);
    }

    /**
     * Get renewals expiring soon (for reminders)
     */
    public function getBookingsNeedingRenewalReminders(int $daysBeforeExpiry = 30): array
    {
        $targetDate = Carbon::now()->addDays($daysBeforeExpiry)->toDateString();
        
        $bookings = Booking::query()
            ->where('status', 'confirmed')
            ->where('payment_status', 'completed')
            ->whereDate('end_date', '=', $targetDate)
            ->whereDoesntHave('renewals', function ($query) {
                $query->whereIn('status', ['pending', 'approved']);
            })
            ->with(['user', 'property'])
            ->get();
        
        return $bookings->toArray();
    }

    /**
     * Get all pending renewal requests for a property owner
     */
    public function getPendingRenewalsForPromoter(int $promoterId): \Illuminate\Database\Eloquent\Collection
    {
        return Renewal::query()
            ->whereHas('property', function ($query) use ($promoterId) {
                $query->where('promoter_id', $promoterId);
            })
            ->where('status', 'pending')
            ->with(['booking', 'user', 'property'])
            ->latest()
            ->get();
    }

    /**
     * Get renewal requests for a client
     */
    public function getRenewalsForClient(int $userId): \Illuminate\Database\Eloquent\Collection
    {
        return Renewal::query()
            ->where('user_id', $userId)
            ->with(['booking', 'property', 'approver'])
            ->latest()
            ->get();
    }

    /**
     * Calculate renewal amount based on property and duration
     */
    public function calculateRenewalAmount(Booking $booking, int $duration, string $frequency): float
    {
        $property = $booking->property;
        
        // Get the base rent based on frequency
        $baseRent = match($frequency) {
            'monthly' => $property->monthly_rent ?? $property->price,
            'yearly' => ($property->monthly_rent ?? $property->price) * 12,
            'weekly' => ($property->monthly_rent ?? $property->price) / 4,
            'daily' => ($property->monthly_rent ?? $property->price) / 30,
            default => $property->monthly_rent ?? $property->price,
        };
        
        return round($baseRent * $duration, 2);
    }

    /**
     * Auto-create renewal reminders for expiring bookings
     */
    public function sendRenewalReminders(int $daysBeforeExpiry): array
    {
        $bookings = $this->getBookingsNeedingRenewalReminders($daysBeforeExpiry);
        $remindersSent = 0;
        
        foreach ($bookings as $bookingData) {
            // In production, this would send actual notifications
            // For now, we'll just log it
            \Log::info("Renewal reminder for booking #{$bookingData['id']} - expires in {$daysBeforeExpiry} days");
            
            // Here you would:
            // - Send email notification
            // - Send SMS notification
            // - Create in-app notification
            
            $remindersSent++;
        }
        
        return [
            'reminders_sent' => $remindersSent,
            'bookings_notified' => count($bookings),
        ];
    }

    /**
     * Get renewal statistics for admin dashboard
     */
    public function getRenewalStatistics(): array
    {
        return [
            'pending_renewals' => Renewal::pending()->count(),
            'approved_this_month' => Renewal::approved()
                ->whereMonth('approved_at', Carbon::now()->month)
                ->count(),
            'rejected_this_month' => Renewal::rejected()
                ->whereMonth('rejected_at', Carbon::now()->month)
                ->count(),
            'expiring_soon' => Booking::where('status', 'confirmed')
                ->whereBetween('end_date', [
                    Carbon::now(),
                    Carbon::now()->addDays(30)
                ])
                ->count(),
        ];
    }

    /**
     * Check if a booking is eligible for renewal
     */
    public function isEligibleForRenewal(Booking $booking): array
    {
        $eligible = true;
        $reasons = [];
        
        // Check if booking is confirmed
        if ($booking->status !== 'confirmed') {
            $eligible = false;
            $reasons[] = 'Booking must be confirmed';
        }
        
        // Check if payment is completed
        if ($booking->payment_status !== 'completed') {
            $eligible = false;
            $reasons[] = 'Payment must be completed';
        }
        
        // Check if already has pending renewal
        $hasPendingRenewal = $booking->renewals()
            ->whereIn('status', ['pending', 'approved'])
            ->exists();
        
        if ($hasPendingRenewal) {
            $eligible = false;
            $reasons[] = 'Already has a pending or approved renewal request';
        }
        
        // Check if booking is not expired
        if ($booking->end_date < Carbon::now()) {
            $eligible = false;
            $reasons[] = 'Booking has already expired';
        }
        
        return [
            'eligible' => $eligible,
            'reasons' => $reasons,
        ];
    }
}

