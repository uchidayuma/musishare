<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => '邦楽',
                'url' => 'jpop',
            ],
            [
                'id' => 2,
                'name' => 'ジャズ',
                'url' => 'jaz',
            ],
            [
                'id' => 3,
                'name' => 'ロック',
                'url' => 'rock',
            ],
            [
                'id' => 4,
                'name' => 'クラシック',
                'url' => 'classic',
            ]
        ]);
    }
}
