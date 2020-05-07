<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoAudio extends Model
{
    //
    protected $table = 'video_audio';

    protected $fillable = [
        'isi', 'video_audio'
    ];
}
