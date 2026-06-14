<?php

namespace Database\Seeders;

use App\Models\Promoteur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PromoteurSeeder extends Seeder
{
    public function run(): void
    {
        // Create a validated promoter
        $userValide = User::create([
            'name' => 'Promoteur Valide',
            'nom' => 'Valide',
            'prenom' => 'Promoteur',
            'email' => 'promoteur.valide@barka.com',
            'telephone' => '+22670000010',
            'password' => Hash::make('password123'),
            'type_utilisateur' => 'promoteur',
            'date_inscription' => now()->subDays(60),
            'est_actif' => true,
        ]);
        $userValide->assignRole('promoter');

        $promoteurValide = Promoteur::create([
            'user_id' => $userValide->id,
            'raison_sociale' => 'Immobilier Valide SARL',
            'type_structure' => 'SARL',
            'numero_siret' => 'BF123456789',
            'adresse_professionnelle' => 'Avenue Kwame Nkrumah, Ouaga 2000',
            'ville' => 'Ouagadougou',
            'description' => 'Promoteur immobilier validé avec succès',
            'statut' => 'VALIDE',
            'date_inscription' => now()->subDays(60),
            'date_validation' => now()->subDays(55),
            'valide_par' => 1, // Admin ID
            'cnib_recto' => 'documents/cnib_recto_1.pdf',
            'cnib_verso' => 'documents/cnib_verso_1.pdf',
            'photo_promoteur' => 'documents/photo_1.jpg',
            'justificatif_domicile' => 'documents/justificatif_1.pdf',
            'registre_commerce' => 'documents/registre_1.pdf',
            'attestation_fiscale' => 'documents/attestation_1.pdf',
            'cnib_recto_verifie' => true,
            'cnib_verso_verifie' => true,
            'photo_verifiee' => true,
            'justificatif_verifie' => true,
            'registre_verifie' => true,
            'attestation_verifiee' => true,
        ]);

        // Create a pending promoter
        $userEnAttente = User::create([
            'name' => 'Promoteur En Attente',
            'nom' => 'Attente',
            'prenom' => 'Promoteur',
            'email' => 'promoteur.attente@barka.com',
            'telephone' => '+22670000011',
            'password' => Hash::make('password123'),
            'type_utilisateur' => 'promoteur',
            'date_inscription' => now()->subDays(5),
            'est_actif' => true,
        ]);
        $userEnAttente->assignRole('promoter');

        Promoteur::create([
            'user_id' => $userEnAttente->id,
            'raison_sociale' => 'Immobilier En Attente',
            'type_structure' => 'Entreprise Individuelle',
            'numero_siret' => 'BF987654321',
            'adresse_professionnelle' => 'Zone 30, Ouagadougou',
            'ville' => 'Ouagadougou',
            'description' => 'Promoteur en attente de validation',
            'statut' => 'EN_ATTENTE',
            'date_inscription' => now()->subDays(5),
            'cnib_recto' => 'documents/cnib_recto_2.pdf',
            'cnib_verso' => 'documents/cnib_verso_2.pdf',
            'photo_promoteur' => 'documents/photo_2.jpg',
            'justificatif_domicile' => 'documents/justificatif_2.pdf',
            'registre_commerce' => 'documents/registre_2.pdf',
            'attestation_fiscale' => 'documents/attestation_2.pdf',
        ]);

        // Create an incomplete promoter
        $userIncomplet = User::create([
            'name' => 'Promoteur Incomplet',
            'nom' => 'Incomplet',
            'prenom' => 'Promoteur',
            'email' => 'promoteur.incomplet@barka.com',
            'telephone' => '+22670000012',
            'password' => Hash::make('password123'),
            'type_utilisateur' => 'promoteur',
            'date_inscription' => now()->subDays(10),
            'est_actif' => true,
        ]);
        $userIncomplet->assignRole('promoter');

        Promoteur::create([
            'user_id' => $userIncomplet->id,
            'raison_sociale' => 'Immobilier Incomplet',
            'type_structure' => 'SARL',
            'numero_siret' => 'BF555555555',
            'adresse_professionnelle' => 'Zone 15, Ouagadougou',
            'ville' => 'Ouagadougou',
            'description' => 'Promoteur avec documents incomplets',
            'statut' => 'INCOMPLET',
            'date_inscription' => now()->subDays(10),
            'cnib_recto' => 'documents/cnib_recto_3.pdf',
            'cnib_verso' => null, // Missing
            'photo_promoteur' => 'documents/photo_3.jpg',
            'justificatif_domicile' => null, // Missing
            'registre_commerce' => 'documents/registre_3.pdf',
            'attestation_fiscale' => 'documents/attestation_3.pdf',
            'commentaires_validation' => 'Documents manquants: CNIB verso et justificatif de domicile',
        ]);

        $this->command->info('Created promoters with different statuses');
    }
}
