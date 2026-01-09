<?php

namespace Database\Seeders;

use App\Models\Commission;
use App\Models\Paiement;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    public function run(): void
    {
        $paiementsValides = Paiement::where('statut', 'VALIDE')->get();

        if ($paiementsValides->isEmpty()) {
            $this->command->warn('No validated payments found. Run PaiementSeeder first.');
            return;
        }

        foreach ($paiementsValides as $paiement) {
            // Calculate commission (10% platform fee)
            Commission::calculer($paiement, 10.0);
        }

        $this->command->info('Created commissions for validated payments');
    }
}
