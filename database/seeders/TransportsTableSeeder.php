<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Transport::factory()->count(5)->create(); 
    }
}
