<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    protected $fillable=['course','schedules','instructor','center','date','stime','etime','marks','examtitle','exam_status'];
    public $timestamps=false;
    protected $primaryKey='exam_id';
}
