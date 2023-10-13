<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    protected $fillable=['course','ctitle','instructor','sdate','edate'];
    public $table='course_schedules';
    public $timestamps=false;
    protected $primaryKey = 'sch_id';
}
