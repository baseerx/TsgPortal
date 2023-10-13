<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GainLoss extends Model
{
    protected $fillable=['salevalue','bookvalue','gainloss'];
    public $table='gain_losses';
    public $primaryKey='glid';
    public $timestamps=false;
}
