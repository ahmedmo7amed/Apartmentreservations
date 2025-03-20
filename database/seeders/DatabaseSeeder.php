<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        Customer::factory()->create([
//            'name' => 'Ahmed User',
//            'email' => 'Ahmed@admin.com',
//            'password' => bcrypt('password'),
//        ]);
        //CountrySeeder
        $this->call([
           RoleSeeder::class,
            CountrySeeder::class,
            CustomerSeeder::class
            ]);
    }
}
