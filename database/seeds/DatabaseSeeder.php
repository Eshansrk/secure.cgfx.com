<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AdminsTableSeeder::class);
         DB::table('admins')->insert([
            'first_name' => "Sakil",
            'last_name' => "Ahmed",
            'email' => 'roifx@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
