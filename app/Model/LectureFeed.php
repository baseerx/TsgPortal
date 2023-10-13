<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LectureFeed extends Model
{
    protected $fillable=['category','lecture','course','question','answer','userid'];
    public $timestamps=false;
    protected $primaryKey='lecfid';
}
