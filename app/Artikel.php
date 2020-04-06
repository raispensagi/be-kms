<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    //
    protected $table = 'artikel';

    protected $fillable = [
        'judul', 'konten', 'valid', 'draft', 'posted', 'hidden', 'tanggal', 'pakar_sawit_id'
    ];

    public function pakar_sawit(){
        return $this->belongsTo('App\PakarSawit');
    }
}
