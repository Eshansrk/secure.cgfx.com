<?php

use Illuminate\Database\Seeder;
// use Hash;
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name' => "Sakil",
            'last_name' => "Ahmed",
            'email' => 'roifx@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
