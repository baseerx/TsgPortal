<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LetterModel extends Model
{
    protected $fillable=['ltitle','lno','ldate','course','ctitle','instructor','sdate','edate','checkparticipent'];
    public $table='create_letter';
    public $timestamps=false;
    protected $primaryKey = 'letterid';
}
