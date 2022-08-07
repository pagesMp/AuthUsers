<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(
            [
                'name'=> 'League of Legends',
                'category'=> 'rol'
            ]
        );

        DB::table('games')->insert(
            [
                'name'=> 'EuroTruck Simulator',
                'category'=> 'simulation'
            ]
        );

        DB::table('games')->insert(
            [
                'name'=> 'ARK',
                'category'=> 'survive'
            ]
        );

        DB::table('games')->insert(
            [
                'name'=> 'Beyound Good & Evil',
                'category'=> 'adventure'
            ]
        );

        DB::table('games')->insert(
            [
                'name'=> 'HITMAN',
                'category'=> 'action'
            ]
        );
    }
    
}
