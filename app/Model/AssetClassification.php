<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssetClassification extends Model
{
    protected $fillable=['assetcls','description'];
    public $primaryKey='aclid';
    public $timestamps=false;
    public $table='asset_classifications';
}
