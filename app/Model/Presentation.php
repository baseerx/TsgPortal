<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $fillable=['user','description','filetype','file','trainingtype','course'];
    public $primaryKey='pid';
    public $timestamps=false;
}
