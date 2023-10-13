<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Calender extends Model
{
    protected $fillable=['year','period'];
    public $table='calenders';
    public $primaryKey='cid';
    public $timestamps=false;
}
