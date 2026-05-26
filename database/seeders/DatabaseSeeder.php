<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Visitor User',
            'email' => 'visitor@visitor.com',
            'role' => 'visitor',
        ]);

        $this->call([
            BookSeeder::class,
        ]);
    }
}
