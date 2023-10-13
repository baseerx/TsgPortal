<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLectureFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecture_feeds', function (Blueprint $table) {
            $table->increments('lecfid');
            $table->string('category');
            $table->integer('lecture');
            $table->integer('course');
            $table->string('question');
            $table->string('answer');
            $table->integer('userid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecture_feeds');
    }
}
