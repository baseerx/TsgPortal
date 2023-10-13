<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable=([
       'name','title','dob','phone','mobile','email'
    ]);
    public $timestamps=false;
    public $primaryKey='ins_id';
}
