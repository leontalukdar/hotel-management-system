<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'room_number' => "#01",
            'price' => 1500,
            'locked' => false,
            'max_persons' => 3,
            'room_type' => "King"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#02",
            'price' => 800,
            'locked' => false,
            'max_persons' => 2,
            'room_type' => "Single"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#03",
            'price' => 800,
            'locked' => false,
            'max_persons' => 2,
            'room_type' => "Single"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#04",
            'price' => 800,
            'locked' => false,
            'max_persons' => 2,
            'room_type' => "Single"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#05",
            'price' => 800,
            'locked' => false,
            'max_persons' => 2,
            'room_type' => "Single"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#06",
            'price' => 800,
            'locked' => false,
            'max_persons' => 2,
            'room_type' => "Single"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#07",
            'price' => 1200,
            'locked' => false,
            'max_persons' => 4,
            'room_type' => "Double"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#08",
            'price' => 1800,
            'locked' => false,
            'max_persons' => 3,
            'room_type' => "Triple"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#09",
            'price' => 2000,
            'locked' => false,
            'max_persons' => 3,
            'room_type' => "Triple"
        ]);
        DB::table('rooms')->insert([
            'room_number' => "#10",
            'price' => 1000,
            'locked' => false,
            'max_persons' => 3,
            'room_type' => "Queen"
        ]);
    }
}
