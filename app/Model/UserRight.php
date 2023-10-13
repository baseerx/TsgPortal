<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRight extends Model
{
    protected $fillable = [
        'uId', 'mmenuId', 'smenuId','cAdd','cEdit','cDelete','cPrint'
    ];
    public $timestamps=false;
    protected $primaryKey = 'uId';

}
