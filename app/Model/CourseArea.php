<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseArea extends Model
{
    protected $fillable=['carea_desc',];
    public $timestamps=false;
    protected $primaryKey = 'carea_id';
}
