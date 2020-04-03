<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\SuperAdmin as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SuperAdmin extends Authenticatable implements JWTSubject
{
    // nama tabel
    protected $table = 'validator';

    // yang dapat diisi
    protected $fillable = [
        'nama', 'email', 'password'
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