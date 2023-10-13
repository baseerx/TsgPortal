<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LeasingCompany extends Model
{
    protected $fillable=['name','description'];
    public $table='leasingcomps';
    public $primaryKey='lcid';
    public $timestamps=false;
}
