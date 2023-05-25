<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class BodegasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::factory()->create([
                'role_id' => 2,
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@catenazapata.com',
            ]);
        User::factory()->create([
                'role_id' => 1,
                'first_name' => 'Gaston',
                'last_name' => 'Perez Izquierdo',
                'email' => 'g.izquierdo@catenazapata.com',
            ]);
        User::factory()->create([
                'role_id' => 0,
                'first_name' => 'Jowan',
                'last_name' => 'Mushyan',
                'email' => 'j.mushyan@catenazapata.com',
            ]);
    }
}
