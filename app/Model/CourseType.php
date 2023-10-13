<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    protected $fillable = ['coursetype_desc',];

    public $timestamps=false;
    protected $primaryKey = 'coursetype_id';

}
