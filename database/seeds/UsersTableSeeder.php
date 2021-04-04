<?php

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
        DB::table('users')->insert([
            [
                'name' => 'テストユーザー2',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('test2'),
            ],
            [
                'name' => 'テストユーザー3',
                'email' => 'test3@gmail.com',
                'password' => bcrypt('test3'),
            ],
        ]);
    }
}
