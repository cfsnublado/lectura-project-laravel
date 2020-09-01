<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_audios', function (Blueprint $table) {
            $table->id();
            $table->uuid('creator_id');
            $table->foreign('creator_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')
            ->references('id')->on('posts')
            ->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('audio_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_audios');
    }
}
