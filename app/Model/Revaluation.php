<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Revaluation extends Model
{
    protected $fillable=['assetcode','bookvalue','revaluated'];
    public $table='revaluations';
    public $primaryKey='rid';
    public $timestamps=false;
}
