<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Validator as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Validator extends Authenticatable implements JWTSubject
{
    // nama tabel
    protected $table = 'validator';

    // yang dapat diisi
    protected $fillable = [
        'nama', 'email', 'password', 'foto'
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