<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    //
    protected $table = 'penulis';

    protected $fillable = [
        'nama', 'peran'
    ];

    public function konten(){
        return $this->hasMany('App\Konten');
    }

}
