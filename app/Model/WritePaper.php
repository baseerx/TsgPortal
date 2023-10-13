<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WritePaper extends Model
{
    protected $fillable=['question','first','second','third','fourth','fifth','answer','papertype','course','exam_id'];
    protected $primaryKey='paperid';
    public $timestamps=false;
}
