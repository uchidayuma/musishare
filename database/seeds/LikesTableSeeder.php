<?php

use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('likes')->insert([
            [
                'music_id' => 1,
                'user_id' => 1,
            ],
            [
                'music_id' => 1,
                'user_id' => 2,
            ],
            [
                'music_id' => 1,
                'user_id' => 3,
            ],
            [
                'music_id' => 2,
                'user_id' => 1,
            ],
            [
                'music_id' => 2,
                'user_id' => 2,
            ],
            [
                'music_id' => 3,
                'user_id' => 1,
            ],
        ]);

    }
}
