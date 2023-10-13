<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DefineLibrary extends Model
{
    protected $fillable=['author','description','filename','category'];
    public $table='define_library';

    public $timestamps=false;
    protected $primaryKey = 'libraryid';
}
