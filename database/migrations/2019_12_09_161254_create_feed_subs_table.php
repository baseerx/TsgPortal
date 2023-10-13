<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_subs', function (Blueprint $table) {
            $table->increments('fsub_id');
            $table->string('lectureid');
            $table->string('questionone');
            $table->string('questiontwo');
            $table->string('questionthree');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_subs');
    }
}
