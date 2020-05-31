<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifikasiUser extends Model
{
    //
    protected $table = 'notifikasi_user';

    protected $fillable = [
        'notifikasi_id', 'user_id'
    ];
}
