<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    public $fillable=['assettype','description','cwip','tangible','stores','others'];
    protected $primaryKey='asstype_id';
    public $timestamps=false;
}
