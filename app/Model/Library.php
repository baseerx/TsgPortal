<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'library',
    ];

    public $timestamps=false;
    protected $primaryKey = 'lid';
}
