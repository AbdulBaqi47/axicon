<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYoutubeChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youtube_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_url');
            $table->string('youtube_access')->nullable();
            $table->string('youtube_refresh')->nullable();
            $table->string('youtube_expires')->nullable();
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
        Schema::dropIfExists('youtube_channels');
    }
}
