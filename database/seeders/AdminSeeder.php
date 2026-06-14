<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@barka.com'],
            [
                'name' => 'Admin User',
                'nom' => 'Admin',
                'prenom' => 'User',
                'password' => Hash::make('password123'),
                'type_utilisateur' => 'administrateur',
                'date_inscription' => now(),
                'est_actif' => true,
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Admin user created: admin@barka.com / password123');
    }
}
