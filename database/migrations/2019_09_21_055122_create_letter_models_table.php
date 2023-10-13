<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_letter', function (Blueprint $table) {
            $table->increments('letterid');
            $table->integer('course');
            $table->string('ctitle');
            $table->integer('instructor');
            $table->date('sdate');
            $table->date('edate');
            $table->string('ltitle');
            $table->string('lno');
            $table->date('ldate');
            $table->string('checkparticipent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('create_letter');
    }
}
