<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseInstructor extends Model
{
    protected $fillable = [
        'course_id', 'ins_id',
    ];

    public $timestamps=false;
    protected $primaryKey = 'ci_id';
}
