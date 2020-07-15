<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    //
    protected $table = 'notifikasi';

    protected $fillable = [
        'headline', 'isi', 'tanggal', 'user_id'
    ];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function personal()
    {
        return $this->belongsToMany('App\User');
    }
}
