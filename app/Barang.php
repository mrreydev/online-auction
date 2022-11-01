<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama_barang', 'date', 'harga_awal', 'deskripsi_barang'
    ];

    public function fotoBarangs(){
        return $this->hasMany('App\FotoBarang');
    }
}
