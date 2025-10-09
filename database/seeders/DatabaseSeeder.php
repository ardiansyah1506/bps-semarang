<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin BPS',
            'email' => 'admin@bps.go.id',
            'password' => Hash::make('password123'),
        ]);

        // Call BPS data seeder
        $this->call([
            BpsDataSeeder::class,
        ]);
    }
}
