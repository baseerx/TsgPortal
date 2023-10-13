<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordData extends Model
{
    protected $fillable=['description','filetype','file','trainingtype','training'];
    public $table='record_data';
    public $primaryKey='recid';
    public $timestamps=false;
}
