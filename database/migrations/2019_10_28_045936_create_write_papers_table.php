<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWritePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('write_papers', function (Blueprint $table) {
            $table->increments('paperid');
            $table->string('first');
            $table->string('second');
            $table->string('third');
            $table->string('fourth');
            $table->string('answer');
            $table->string('papertype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('write_papers');
    }
}
