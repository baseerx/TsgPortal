<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public $primaryKey='assignment_id';
    protected $fillable=['description','filetype','file','trainingtype','course'];
    public $timestamps=false;
}
