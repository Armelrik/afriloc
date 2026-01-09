<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found.');
            return;
        }

        // Create notifications for different types
        $types = ['VALIDATION', 'RESERVATION', 'PAIEMENT', 'CONFIRMATION'];
        $canaux = ['EMAIL', 'SMS', 'IN_APP'];
        $priorites = ['BASSE', 'NORMALE', 'HAUTE', 'URGENTE'];

        foreach ($users as $user) {
            // Create 2-3 notifications per user
            $nombreNotifications = rand(2, 3);

            for ($i = 0; $i < $nombreNotifications; $i++) {
                Notification::create([
                    'utilisateur_id' => $user->id,
                    'type' => $types[array_rand($types)],
                    'canal' => $canaux[array_rand($canaux)],
                    'contenu' => "Notification de test pour {$user->name}",
                    'priorite' => $priorites[array_rand($priorites)],
                    'date_envoi' => now()->subDays(rand(0, 7)),
                    'est_lue' => rand(0, 1) === 1,
                    'date_lecture' => rand(0, 1) === 1 ? now()->subDays(rand(0, 5)) : null,
                ]);
            }
        }

        $this->command->info('Created test notifications for all users');
    }
}
