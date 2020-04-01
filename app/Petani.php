<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Petani as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Petani extends Authenticatable implements JWTSubject
{
    // nama tabel
    protected $table = 'petani';

    // yang dapat diisi
    protected $fillable = [
        'nama', 'nomor_telefon', 'password', 'jenis_kelamin'
    ];

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }

}
