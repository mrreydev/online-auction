<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{

    public function petugas(){
        return $this->hasMany('App\Petugas');
    }
}
