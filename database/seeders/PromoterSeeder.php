<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Promoter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PromoterSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 promoters for testing
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Promoteur Test $i",
                'email' => "promoteur$i@afriloc.com",
                'password' => Hash::make('password123'),
            ]);
            
            $user->assignRole('promoter');
            
            Promoter::create([
                'user_id' => $user->id,
                'company_name' => "Société Immobilière $i",
                'phone' => "+22670000000$i",
                'whatsapp' => "+22670000000$i",
                'address' => "Zone $i, Ouagadougou, Burkina Faso",
                'identification_number' => "BF12345678$i",
                'status' => 'approved',
                'verified_at' => now(),
            ]);
            
            $this->command->info("Created promoter: promoteur$i@afriloc.com");
        }
    }
}


