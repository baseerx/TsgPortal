<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LibTrans extends Model
{

    protected $fillable = [
        'library','category', 'scategory','description', 'dop', 'doe','price','book_code','author_name','publisher','distributor','type','file','filedesc'
    ];
    public $table = 'transactions';
    public $timestamps = false;
    protected $primaryKey = 'trid';
}
