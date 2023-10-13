<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    protected $fillable=['run','rollback','calender'];
    public $table='depreciations';
    public $primaryKey='depid';
    public $timestamps=false;
}
