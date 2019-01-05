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
        $this->call(BanWordSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PassportSeeder::class);
    }
}
