<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
    protected $fillable=['name','validity'];
    public $table='insurance_companies';
    public $primaryKey='icid';
    public $timestamps=false;
}
