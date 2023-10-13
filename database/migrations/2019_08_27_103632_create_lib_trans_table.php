<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('trid');
            $table->integer('library');
            $table->integer('category');
            $table->integer('scategory');
            $table->date('dop');
            $table->date('doe');
            $table->mediumInteger('price');
            $table->mediumInteger('book_code');
            $table->string('author_name');
            $table->string('publisher');
            $table->string('distributor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('lib_trans');
    }
}
