<?php

use App\Masyarakat;
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
        $this->call([
            MasyarakatSeeder::class,
            LevelSeeder::class,
            PetugasSeeder::class,
        ]);
    }
}
