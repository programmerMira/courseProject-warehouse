<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Provider::factory()->count(2)->create(); 
    }
}
