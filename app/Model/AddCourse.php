<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddCourse extends Model
{
    protected $fillable=['cdesc','ccode','carea_id','coursetype_id','status'];
    public $timestamps=false;
    protected $primaryKey='cid';
}
