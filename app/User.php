<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'nama', 'email', 'password', 'peran', 'nomor_telefon'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at'
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

    public function bookmark(){
        return $this->hasMany('App\Bookmark');
    }

    public function riwayat(){
        return $this->hasMany('App\Riwayat');
    }

    public function konten(){
        return $this->hasMany('App\Konten');
    }

    public function revisi(){
        return $this->hasMany('App\Revisi');
    }
}
