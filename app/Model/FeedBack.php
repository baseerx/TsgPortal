<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable=['course','question','option','userid'];
    protected $table='feedback';
    public $timestamps=false;
    public $primaryKey='fid';
}
