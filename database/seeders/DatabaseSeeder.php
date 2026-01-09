<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // First: Roles and permissions
            RoleSeeder::class,
            
            // Second: Admin user
            AdminSeeder::class,
            
            // Third: Clients
            ClientSeeder::class,
            
            // Fourth: Promoters (with different statuses)
            PromoteurSeeder::class,
            
            // Fifth: Validation requests
            DemandeValidationSeeder::class,
            
            // Sixth: Properties (only for validated promoters)
            BienSeeder::class,
            
            // Seventh: Reservations
            ReservationSeeder::class,
            
            // Eighth: Payments
            PaiementSeeder::class,
            
            // Ninth: Commissions
            CommissionSeeder::class,
            
            // Tenth: Notifications
            NotificationSeeder::class,
        ]);
    }
}
