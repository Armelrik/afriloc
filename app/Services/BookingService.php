<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BookingService
{
    protected CommissionService $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    public function calculateTotalCost(Property $property, int $duration, string $frequency): array
    {
        $basePrice = match($frequency) {
            'daily' => $property->price,
            'weekly' => $property->price * 7,
            'monthly' => $property->monthly_rent ?? $property->price * 30,
            'yearly' => ($property->monthly_rent ?? $property->price * 30) * 12,
            default => $property->price,
        };

        $totalRent = $basePrice * $duration;
        $deposit = $property->deposit_amount ?? 0;
        $advance = $property->advance_payment ?? 0;
        
        $commissionRate = $property->commission_rate ?? $this->commissionService->getDefaultRate();
        $commission = $this->commissionService->calculateCommission($totalRent, $commissionRate);
        
        return [
            'total_rent' => round($totalRent, 2),
            'deposit' => round($deposit, 2),
            'advance' => round($advance, 2),
            'commission' => round($commission, 2),
            'total_due' => round($totalRent + $deposit + $advance, 2),
            'promoter_amount' => round($totalRent - $commission, 2),
        ];
    }

    public function processBooking(array $bookingData): Booking
    {
        return DB::transaction(function () use ($bookingData) {
            $property = Property::findOrFail($bookingData['property_id']);
            
            $costs = $this->calculateTotalCost(
                $property,
                $bookingData['rental_duration'],
                $bookingData['rental_frequency']
            );

            $booking = Booking::create([
                'property_id' => $property->id,
                'user_id' => $bookingData['user_id'] ?? null,
                'customer_name' => $bookingData['customer_name'],
                'customer_email' => $bookingData['customer_email'],
                'customer_phone' => $bookingData['customer_phone'],
                'start_date' => $bookingData['start_date'],
                'end_date' => $bookingData['end_date'],
                'num_people' => $bookingData['num_people'] ?? 1,
                'rental_duration' => $bookingData['rental_duration'],
                'rental_frequency' => $bookingData['rental_frequency'],
                'total_rent' => $costs['total_rent'],
                'deposit_paid' => $costs['deposit'],
                'advance_paid' => $costs['advance'],
                'platform_commission' => $costs['commission'],
                'promoter_amount' => $costs['promoter_amount'],
                'total_amount' => $costs['total_due'],
                'comments' => $bookingData['comments'] ?? null,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            return $booking;
        });
    }

    public function notifyPromoter(Booking $booking): void
    {
        // Will implement with notifications
        // $booking->property->promoter->user->notify(new NewBookingReceived($booking));
    }

    public function processPayment(Booking $booking, array $paymentData): bool
    {
        // Placeholder for V2 payment integration
        $booking->update([
            'payment_status' => 'completed',
            'payment_method' => $paymentData['method'] ?? 'cash',
            'payment_provider' => $paymentData['provider'] ?? null,
            'payment_reference' => $paymentData['reference'] ?? null,
            'payment_completed_at' => now(),
        ]);

        return true;
    }
}


