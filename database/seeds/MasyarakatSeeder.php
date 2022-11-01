<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Faker\Factory as Faker;

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 0; $i < 10; $i++){
            App\Masyarakat::create([
                'nama_lengkap' => $faker->name,
                'username' => $faker->userName,
                'password' => Crypt::encryptString('customer1234!'),
                'telp' => $faker->phoneNumber
            ]);
        }
    }
}
