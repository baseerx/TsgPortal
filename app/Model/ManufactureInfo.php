<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManufactureInfo extends Model
{
    protected $fillable=['mname','description'];
    public $table='manufacture_infos';
    public $primaryKey='mfid';
    public $timestamps=false;
}
