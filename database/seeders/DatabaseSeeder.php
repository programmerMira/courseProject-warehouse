<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(TransportTypesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(TransportsTableSeeder::class);
        $this->call(DetailCardsTableSeeder::class);
        $this->call(DetailsDictionariesTableSeeder::class);
    }
}
