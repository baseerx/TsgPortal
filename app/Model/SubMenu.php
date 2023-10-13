<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{

    protected $fillable = [
        'smenuDesc', 'smenuURL', 'sOrder','mmenuId','mmenuDesc'
    ];

    public $timestamps=false;
    protected $primaryKey = 'smenuId';
}
