<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TraineesModel extends Model
{
    protected $fillable=['letterid','name','address','phone','email'];
    public $table='trainees';
    public $timestamps=false;
    protected $primaryKey = 'tid';
}
