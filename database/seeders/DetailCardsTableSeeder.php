<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DetailCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\DetailsCard::factory()->count(6)->create();
    }
}
