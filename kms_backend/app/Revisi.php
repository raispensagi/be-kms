<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    //
    protected $table = 'revisi';

    protected $fillable = [
        'komentar', 'tanggal', 'konten_id', 'user_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function konten(){
        return $this->belongsTo('App\Konten');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
