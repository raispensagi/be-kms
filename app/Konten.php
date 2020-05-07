<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    //
    protected $table = 'konten';

    protected $fillable = [
        'kategori', 'sub_kategori', 'tipe', 'id_tipe', 'judul', 'tanggal', 'is_draft',
        'is_valid', 'is_hidden', 'id_penulis',
    ];

    public function penulis(){
        return $this->belongsTo('App\Penulis');
    }

    public function bookmark(){
        return $this->belongsTo('App\Bookmark');
    }
}
