<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    //
    protected $table = 'bookmark';

    protected $fillable = [
        'user_id', 'konten_id'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function konten()
    {
        return $this->hasOne('App\Konten');
    }
}
