<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'cid', 'slibrary'
    ];

    public $timestamps=false;
    protected $primaryKey = 'sid';
}
