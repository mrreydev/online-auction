<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Petugas::create([
            'nama_petugas' => 'admin',
            'username' => 'admin123',
            'password' => Crypt::encryptString('adminpass'),
            'id_level' => 1
        ]);
    }
}
