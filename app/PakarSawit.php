<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\PakarSawit as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class PakarSawit extends Authenticatable
{
    use HasApiTokens, Notifiable;
    //
    protected $table = 'pakar_sawit';

    protected $fillable = [
      'nama', 'nomor_telefon', 'email', 'password', 'jenis_kelamin'
    ];

    protected $hidden = [
        'password'
    ];

    public function OauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }

}
