<?php

namespace Database\Seeders;

use App\Models\Paiement;
use App\Models\PaiementCarte;
use App\Models\PaiementMobileMoney;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    public function run(): void
    {
        $reservations = Reservation::all();

        if ($reservations->isEmpty()) {
            $this->command->warn('No reservations found. Run ReservationSeeder first.');
            return;
        }

        foreach ($reservations as $index => $reservation) {
            $paiement = Paiement::create([
                'reservation_id' => $reservation->id,
                'montant' => $reservation->montant_total,
                'methode_paiement' => $index % 2 === 0 ? 'MOBILE_MONEY' : 'CARTE',
                'statut' => $reservation->statut === 'CONFIRME' ? 'VALIDE' : 'EN_ATTENTE',
                'date_paiement' => $reservation->statut === 'CONFIRME' ? $reservation->date_confirmation : null,
                'reference_transaction' => 'TXN-' . strtoupper(uniqid()),
                'numero_recu' => $reservation->statut === 'CONFIRME' ? 'REC-' . strtoupper(uniqid()) : null,
            ]);

            // Create payment method details
            if ($paiement->methode_paiement === 'MOBILE_MONEY') {
                PaiementMobileMoney::create([
                    'paiement_id' => $paiement->id,
                    'operateur' => ['MOOV', 'ORANGE', 'MTN'][rand(0, 2)],
                    'numero_telephone' => '+226' . rand(70000000, 79999999),
                    'code_transaction' => 'MM-' . strtoupper(uniqid()),
                ]);
            } else {
                PaiementCarte::create([
                    'paiement_id' => $paiement->id,
                    'numero_carte_masque' => '1234****' . rand(1000, 9999),
                    'type_carte' => ['VISA', 'MASTERCARD'][rand(0, 1)],
                    'token_paiement' => 'token_' . bin2hex(random_bytes(16)),
                ]);
            }
        }

        $this->command->info('Created payments with payment method details');
    }
}
