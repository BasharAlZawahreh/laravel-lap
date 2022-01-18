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
        \App\Models\User::factory()->create([
           'email' => 'reem@reem.com',
           'password' => '123456789',
           "version" => "v1",
           "accountNumber" => "20016",
           "accountPin" => "331421",
           "accountEntity" => "AMM",
           "accountCountryCode" => "JO",
           "source" => 24
        ]);
    }
}
