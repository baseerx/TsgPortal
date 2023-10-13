<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $table = 'category';

    protected $fillable = [
        'category',
    ];
    public $timestamps=false;
    protected $primaryKey = 'cid';
}
