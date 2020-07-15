<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDokumen extends Model
{
    //
    protected $table = 'edokumen';

    protected $fillable = [
        'penulis', 'tahun', 'penerbit', 'halaman', 'bahasa', 'deskripsi', 'file'
    ];
}
