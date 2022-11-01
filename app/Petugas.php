<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    public function levels(){
        return $this->belongsTo('App\Level');
    }
}
