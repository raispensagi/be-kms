<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    //
    protected $table = 'konten';

    protected $fillable = [
        'kategori', 'sub_kategori', 'tipe', 'id_tipe', 'judul', 'tanggal', 'is_draft',
        'is_valid', 'is_hidden', 'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function bookmark(){
        return $this->belongsTo('App\Bookmark');
    }

    public function riwayat(){
        return $this->belongsTo('App\Riwayat');
    }

    public function revisi(){
        return $this->hasMany('App\Revisi');
    }
}
