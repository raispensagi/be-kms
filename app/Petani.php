<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Petani as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Petani extends Authenticatable
{
    use HasApiTokens, Notifiable;
    // nama tabel
    protected $table = 'petani';

    // yang dapat diisi
    protected $fillable = [
        'nama', 'nomor_telefon', 'password', 'jenis_kelamin'
    ];

    protected $hidden = [
        'password'
    ];

    public function OauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }
}
