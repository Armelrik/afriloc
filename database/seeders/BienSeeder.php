<?php

namespace Database\Seeders;

use App\Models\Bien;
use App\Models\MediaBien;
use App\Models\Promoteur;
use Illuminate\Database\Seeder;

class BienSeeder extends Seeder
{
    public function run(): void
    {
        $promoteursValides = Promoteur::valide()->get();

        if ($promoteursValides->isEmpty()) {
            $this->command->warn('No validated promoters found. Run PromoteurSeeder first.');
            return;
        }

        $biens = [
            [
                'titre' => 'Belle Villa Moderne à Ouaga 2000',
                'description' => 'Magnifique villa moderne avec 4 chambres, piscine et jardin dans le quartier prisé de Ouaga 2000.',
                'type_bien' => 'maison',
                'adresse' => 'Avenue Kwame Nkrumah, Ouaga 2000',
                'ville' => 'Ouagadougou',
                'quartier' => 'Ouaga 2000',
                'superficie' => 300.00,
                'nombre_pieces' => 6,
                'nombre_chambres' => 4,
                'nombre_salles_bain' => 3,
                'prix_location' => 350000.00,
                'frequence_location' => 'mensuel',
                'depot_garantie' => 350000.00,
                'avance' => 100000.00,
                'disponibilite' => 'disponible',
                'statut' => 'publie',
                'est_publie' => true,
                'date_ajout' => now()->subDays(30),
                'date_publication' => now()->subDays(25),
            ],
            [
                'titre' => 'Appartement 3 pièces Centre-Ville',
                'description' => 'Appartement moderne et bien situé au centre-ville, proche de tous les services.',
                'type_bien' => 'appartement',
                'adresse' => 'Avenue de la Nation',
                'ville' => 'Ouagadougou',
                'quartier' => 'Centre-Ville',
                'superficie' => 80.00,
                'nombre_pieces' => 3,
                'nombre_chambres' => 2,
                'nombre_salles_bain' => 1,
                'prix_location' => 150000.00,
                'frequence_location' => 'mensuel',
                'depot_garantie' => 150000.00,
                'avance' => 50000.00,
                'disponibilite' => 'disponible',
                'statut' => 'publie',
                'est_publie' => true,
                'date_ajout' => now()->subDays(20),
                'date_publication' => now()->subDays(18),
            ],
            [
                'titre' => 'Terrain constructible Zone 30',
                'description' => 'Terrain viabilisé de 500m², idéal pour construction de villa.',
                'type_bien' => 'terrain',
                'adresse' => 'Zone 30, Ouagadougou',
                'ville' => 'Ouagadougou',
                'quartier' => 'Zone 30',
                'superficie' => 500.00,
                'nombre_pieces' => null,
                'nombre_chambres' => null,
                'nombre_salles_bain' => null,
                'prix_location' => 50000.00,
                'frequence_location' => 'mensuel',
                'depot_garantie' => 100000.00,
                'avance' => 50000.00,
                'disponibilite' => 'disponible',
                'statut' => 'publie',
                'est_publie' => true,
                'date_ajout' => now()->subDays(15),
                'date_publication' => now()->subDays(12),
            ],
        ];

        foreach ($biens as $bienData) {
            $bien = Bien::create(array_merge($bienData, [
                'promoteur_id' => $promoteursValides->random()->id,
            ]));

            // Add media for each property
            MediaBien::create([
                'bien_id' => $bien->id,
                'type_media' => 'IMAGE',
                'url_media' => 'images/biens/bien_' . $bien->id . '_1.jpg',
                'description' => 'Photo principale',
                'ordre' => 1,
                'date_ajout' => $bien->date_ajout,
            ]);

            MediaBien::create([
                'bien_id' => $bien->id,
                'type_media' => 'IMAGE',
                'url_media' => 'images/biens/bien_' . $bien->id . '_2.jpg',
                'description' => 'Photo secondaire',
                'ordre' => 2,
                'date_ajout' => $bien->date_ajout,
            ]);
        }

        $this->command->info('Created properties with media');
    }
}
