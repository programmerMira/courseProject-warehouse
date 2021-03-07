<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DetailsDictionariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\DetailsDictionary::factory()->count(7)->create();
    }
}
