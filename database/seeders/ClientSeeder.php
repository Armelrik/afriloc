<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 test clients
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Client Test $i",
                'nom' => "Test$i",
                'prenom' => "Client$i",
                'email' => "client$i@barka.com",
                'telephone' => "+2267000000$i",
                'password' => Hash::make('password123'),
                'type_utilisateur' => 'client',
                'date_inscription' => now()->subDays(rand(1, 30)),
                'est_actif' => true,
            ]);

            $user->assignRole('client');

            Client::create([
                'user_id' => $user->id,
                'adresse' => "Zone $i, Ouagadougou",
                'ville_residence' => 'Ouagadougou',
            ]);

            $this->command->info("Created client: client$i@barka.com");
        }
    }
}
