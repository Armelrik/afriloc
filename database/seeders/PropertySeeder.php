<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'title_fr' => 'Belle Villa Moderne à Ouaga 2000',
                'title_en' => 'Beautiful Modern Villa in Ouaga 2000',
                'description_fr' => 'Magnifique villa moderne avec 4 chambres, piscine et jardin dans le quartier prisé de Ouaga 2000.',
                'description_en' => 'Magnificent modern villa with 4 bedrooms, swimming pool and garden in the sought-after Ouaga 2000 neighborhood.',
                'type' => 'house',
                'status' => 'available',
                'price' => 250000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 300,
                'location' => 'Ouaga 2000',
                'address' => 'Avenue Kwame Nkrumah, Ouaga 2000',
                'latitude' => 12.3333,
                'longitude' => -1.5333,
                'images' => ['house1.jpg'],
                'featured' => true,
            ],
            [
                'title_fr' => 'Appartement Spacieux Centre-Ville',
                'title_en' => 'Spacious City Center Apartment',
                'description_fr' => 'Appartement moderne de 3 chambres au cœur de Ouagadougou avec toutes les commodités.',
                'description_en' => 'Modern 3-bedroom apartment in the heart of Ouagadougou with all amenities.',
                'type' => 'apartment',
                'status' => 'available',
                'price' => 150000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 120,
                'location' => 'Centre-Ville',
                'address' => 'Avenue de la Nation, Centre-Ville',
                'latitude' => 12.3714,
                'longitude' => -1.5197,
                'images' => ['apartment1.jpg'],
                'featured' => true,
            ],
            [
                'title_fr' => 'Terrain Résidentiel à Tampouy',
                'title_en' => 'Residential Land in Tampouy',
                'description_fr' => 'Terrain de 500m² viabilisé, titre foncier disponible, idéal pour construction.',
                'description_en' => 'Serviced 500m² land plot, land title available, ideal for construction.',
                'type' => 'land',
                'status' => 'available',
                'price' => 15000000,
                'bedrooms' => null,
                'bathrooms' => null,
                'area' => 500,
                'location' => 'Tampouy',
                'address' => 'Secteur 25, Tampouy',
                'latitude' => 12.4000,
                'longitude' => -1.5000,
                'images' => ['land1.jpg'],
                'featured' => true,
            ],
            [
                'title_fr' => 'Maison Familiale à Gounghin',
                'title_en' => 'Family House in Gounghin',
                'description_fr' => 'Maison confortable de 5 chambres avec cour spacieuse, idéale pour une grande famille.',
                'description_en' => 'Comfortable 5-bedroom house with spacious courtyard, ideal for a large family.',
                'type' => 'house',
                'status' => 'available',
                'price' => 180000,
                'bedrooms' => 5,
                'bathrooms' => 2,
                'area' => 250,
                'location' => 'Gounghin',
                'address' => 'Secteur 10, Gounghin',
                'images' => ['house2.jpg'],
                'featured' => false,
            ],
            [
                'title_fr' => 'Studio Meublé à Koulouba',
                'title_en' => 'Furnished Studio in Koulouba',
                'description_fr' => 'Studio moderne entièrement meublé et équipé, proche de toutes commodités.',
                'description_en' => 'Modern fully furnished and equipped studio, close to all amenities.',
                'type' => 'apartment',
                'status' => 'available',
                'price' => 75000,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'area' => 35,
                'location' => 'Koulouba',
                'address' => 'Avenue Loudun, Koulouba',
                'images' => ['apartment2.jpg'],
                'featured' => false,
            ],
            [
                'title_fr' => 'Villa de Luxe à Somgandé',
                'title_en' => 'Luxury Villa in Somgandé',
                'description_fr' => 'Villa haut de gamme avec 6 chambres, piscine, salle de sport et système de sécurité.',
                'description_en' => 'High-end villa with 6 bedrooms, swimming pool, gym and security system.',
                'type' => 'house',
                'status' => 'available',
                'price' => 350000,
                'bedrooms' => 6,
                'bathrooms' => 4,
                'area' => 450,
                'location' => 'Somgandé',
                'address' => 'Route de Kaya, Somgandé',
                'images' => ['house3.jpg'],
                'featured' => true,
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }

        $this->command->info('Sample properties created successfully');
    }
}
