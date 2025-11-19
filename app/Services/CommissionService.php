<?php

namespace App\Services;

use App\Models\Promoter;

class CommissionService
{
    public function getDefaultRate(): float
    {
        return config('locafri.commission.default_rate', 10);
    }

    public function getPromoterRate(int $promoterId): float
    {
        $promoter = Promoter::find($promoterId);
        return $promoter ? $promoter->commission_rate : $this->getDefaultRate();
    }

    public function calculateCommission(float $amount, float $rate): float
    {
        return round($amount * ($rate / 100), 2);
    }

    public function calculatePromoterAmount(float $totalAmount, float $commissionRate): float
    {
        $commission = $this->calculateCommission($totalAmount, $commissionRate);
        return round($totalAmount - $commission, 2);
    }

    public function recordCommission($booking): void
    {
        $property = $booking->property;
        $commissionRate = $property->commission_rate ?? $this->getDefaultRate();
        $platformCommission = $this->calculateCommission($booking->total_amount, $commissionRate);
        $promoterAmount = $this->calculatePromoterAmount($booking->total_amount, $commissionRate);

        $booking->update([
            'platform_commission' => $platformCommission,
            'promoter_amount' => $promoterAmount,
        ]);
    }
}


