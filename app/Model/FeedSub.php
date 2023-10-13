<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FeedSub extends Model
{
    protected $fillable=['lectureid','questionone','questiontwo','questionthree'];
    public $timestamps=false;
}
