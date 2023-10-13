<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DepMethod extends Model
{
    protected $fillable=['depmethod','rate'];
    public $table='depmethod';
    public $primaryKey='dmid';
    public $timestamps=false;
}
