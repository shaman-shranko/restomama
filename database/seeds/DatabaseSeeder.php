<?php

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
         // Create roles
         $this->call(RoleTableSeeder::class);
         // Create example users
         $this->call(UserTableSeeder::class);
         // Create example city
         $this->call(CitiesTableSeeder::class);
         // Create example restaurant type
         $this->call(RestaurantsTypesSeeder::class);
         // Create example restaurant
         $this->call(RestaurantsSeeder::class);
    }
}
