<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\PakarSawit as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class PakarSawit extends Authenticatable implements JWTSubject
{
    //
    protected $table = 'pakar_sawit';

    protected $fillable = [
      'nama', 'foto', 'email', 'password'
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

    public function bookmark(){
        return $this->hasMany('App\Bookmark');
    }

}
