<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_participants', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('promotion_id')->unsigned()->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->json('data')->nullable();
            $table->ipAddress('ip');
            $table->text('device');
            $table->boolean('is_mobile')->default('0');

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
        Schema::dropIfExists('promotion_participants');
    }
}
