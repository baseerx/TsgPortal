<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResultReport extends Model
{
    protected $fillable=['paperid','userid','selected','flag','course','exam_id'];
    public $primaryKey='rp_id';
    public $timestamps=false;
}
