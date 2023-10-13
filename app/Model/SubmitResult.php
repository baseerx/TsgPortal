<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubmitResult extends Model
{
    protected $fillable=['email','name','rollno','result','percentage','course','exam_id'];
    public $primaryKey='subr_id';
    public $timestamps=false;
}
