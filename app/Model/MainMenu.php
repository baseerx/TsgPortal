<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $fillable = [
         'mmenuDesc', 'mmenuURL',
    ];

    public $timestamps=false;
    protected $primaryKey = 'mmenuId';
}
