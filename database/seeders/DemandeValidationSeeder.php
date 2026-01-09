<?php

namespace Database\Seeders;

use App\Models\DemandeValidation;
use App\Models\Promoteur;
use Illuminate\Database\Seeder;

class DemandeValidationSeeder extends Seeder
{
    public function run(): void
    {
        $promoteurs = Promoteur::all();

        foreach ($promoteurs as $promoteur) {
            $statut = match($promoteur->statut) {
                'VALIDE' => 'VALIDE',
                'INCOMPLET' => 'INCOMPLET',
                'REJETE' => 'REJETE',
                default => 'EN_ATTENTE',
            };

            DemandeValidation::create([
                'promoteur_id' => $promoteur->id,
                'statut' => $statut,
                'date_demande' => $promoteur->date_inscription,
                'date_traitement' => $promoteur->date_validation,
                'traite_par_admin_id' => $promoteur->valide_par,
                'score_completude' => $promoteur->calculerScoreCompletude(),
                'commentaires' => $promoteur->commentaires_validation,
                'motif_rejet' => $promoteur->motif_rejet,
            ]);
        }

        $this->command->info('Created validation requests for all promoters');
    }
}
