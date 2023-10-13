<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class feedbackText extends Model
{
    protected $fillable=['hris_id','feedbk','course'];
    public $table='feedbacktxt';
    public $timestamps=false;
    protected $primaryKey = 'ftxt_id';
}
