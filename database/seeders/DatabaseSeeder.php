<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamamos al seeder correcto
        $this->call(\Database\Seeders\UsersMain::class);
        $this->call(\Database\Seeders\CupSeeder::class);
    }
}
