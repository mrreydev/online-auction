<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            [
                'level' => 'administrator'
            ],
            [
                'level' => 'petugas'
            ]
        ];

        foreach($levels as $level){
            App\Level::create($level);
        }
    }
}
