<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $clients = User::where('type_utilisateur', 'client')->get();
        $biens = Bien::publie()->disponible()->get();

        if ($clients->isEmpty() || $biens->isEmpty()) {
            $this->command->warn('No clients or properties found. Run ClientSeeder and BienSeeder first.');
            return;
        }

        // Create 3 reservations
        for ($i = 0; $i < 3; $i++) {
            $client = $clients->random();
            $bien = $biens->random();

            $dateDebut = now()->addDays(rand(10, 30));
            $dateFin = $dateDebut->copy()->addDays(rand(7, 30));
            $duree = $dateDebut->diffInDays($dateFin);
            $montantTotal = $bien->prix_location * ($duree / 30); // Approximate monthly calculation

            Reservation::create([
                'client_id' => $client->id,
                'bien_id' => $bien->id,
                'date_debut' => $dateDebut,
                'date_fin' => $dateFin,
                'nombre_personnes' => rand(1, 4),
                'montant_total' => $montantTotal,
                'statut' => $i === 0 ? 'CONFIRME' : 'EN_ATTENTE',
                'commentaires' => "Réservation de test #$i",
                'date_reservation' => now()->subDays(rand(1, 5)),
                'date_confirmation' => $i === 0 ? now()->subDays(rand(1, 3)) : null,
            ]);
        }

        $this->command->info('Created test reservations');
    }
}
