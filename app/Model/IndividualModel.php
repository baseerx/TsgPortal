<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class IndividualModel extends Model
{
    protected $fillable=['traineetype','description','file','trainingtype'];
    public $timestamps=false;
    public $primaryKey='ind_id';
    protected $table='indschedual';
}
