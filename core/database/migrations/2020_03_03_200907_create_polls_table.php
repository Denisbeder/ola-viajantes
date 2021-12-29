<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->boolean('publish')->default('0');
            $table->string('title');

            $table->timestamp('published_at')->nullable();
            $table->timestamp('unpublished_at')->nullable();

            $table->timestamps();
        });

        Schema::create('poll_options', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('poll_id')->unsigned()->nullable();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');

            $table->string('title');
        });

        Schema::create('poll_votes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('poll_option_id')->unsigned()->nullable();
            $table->foreign('poll_option_id')->references('id')->on('poll_options')->onDelete('cascade');

            $table->bigInteger('poll_id')->unsigned()->nullable();
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');

            $table->ipAddress('ip');
            $table->text('device');
            $table->boolean('is_mobile')->default('0');
	
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_votes');
        Schema::dropIfExists('poll_options');
        Schema::dropIfExists('polls');
    }
}
