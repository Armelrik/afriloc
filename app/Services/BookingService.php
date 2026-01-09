<?php

namespace App\Services;

use App\Models\Bien;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService
{
    protected CommissionService $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }

    public function calculateTotalCost(Bien $bien, int $duration, string $frequency): array
    {
        $basePrice = $bien->prix_location ?? 0;

        $totalRent = $basePrice * $duration;
        $deposit = $bien->depot_garantie ?? 0;
        $advance = $bien->avance ?? 0;
        
        $commissionRate = $this->commissionService->getDefaultRate();
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

    public function processBooking(array $bookingData): Reservation
    {
        return DB::transaction(function () use ($bookingData) {
            $bien = Bien::publie()->findOrFail($bookingData['bien_id']);
            
            $costs = $this->calculateTotalCost(
                $bien,
                $bookingData['rental_duration'],
                $bookingData['rental_frequency']
            );

            $reservation = Reservation::create([
                'bien_id' => $bien->id,
                'client_id' => optional(Auth::user())->client->id ?? null,
                'date_debut' => $bookingData['start_date'],
                'date_fin' => $bookingData['end_date'],
                'statut' => 'EN_ATTENTE',
                'montant_total' => $costs['total_due'],
                'note' => $bookingData['comments'] ?? null,
                'conditions_specifiques' => null,
            ]);

            return $reservation;
        });
    }
}

