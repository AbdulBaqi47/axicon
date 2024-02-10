<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailymotionChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailymotion_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_id');
            $table->string('channel_url');
            $table->string('dailymotion_access')->nullable();
            $table->string('dailymotion_refresh')->nullable();
            $table->string('dailymotion_expires')->nullable();
            $table->integer('subscriber_count')->nullable();
            $table->integer('view_count')->nullable();
            $table->integer('video_count')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailymotion_channels');
    }
}
