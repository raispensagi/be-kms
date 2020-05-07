<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    //
    protected $table = 'bookmark';

    protected $fillable = [
        'id_petani', 'id_pakar_sawit', 'id_konten'
    ];

    protected $hidden = [
        'id_petani', 'id_pakar_sawit'
    ];

    public function petani()
    {
        return $this->belongsTo('App\Petani');
    }

    public function pakar()
    {
        return $this->belongsTo('App\PakarSawit');
    }

    public function konten()
    {
        return $this->hasOne('App\Konten');
    }
}
