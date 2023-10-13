<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $fillable=['assetcat','description','accounts' ,'codeasset', 'codedepreciation', 'codeaccdepreciation', 'gainloss', 'codeimpairement','coderevaluation'];
    public $table='assetcatg';
    public $primaryKey='acid';
    public $timestamps=false;
}
