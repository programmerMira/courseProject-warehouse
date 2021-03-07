<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransportTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\TransportType::factory()->count(3)->create(); 
    }
}
