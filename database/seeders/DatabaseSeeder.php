<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'first_name' => 'faizan',
            'last_name' => 'farooq',
            'email' => 'faizanfarooq@gmail.com',
            'password' => 'realmadrid@141'
        ]);
       
        \App\Models\User::factory()->create([
            'first_name' => 'test',
            'last_name' => 'best',
            'email' => 'test@gmail.com',
            'password' => 'test123'
        ]);

        Meal::factory(256)->create();
    }
}
