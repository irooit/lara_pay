<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createFounderUser();
    }

    /**
     * Insert the founder information.
     *
     * @return void
     */
    protected function createFounderUser()
    {
        User::create(['username' => 'root', 'password' => bcrypt('root'), 'email' => '85825770@qq.com']);
    }
}
