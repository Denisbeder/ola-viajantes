<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['published_at', 'unpublished_at', 'publish']);
            $table->index(['published_at', 'publish']);
            $table->index(['publish']);
            //$table->unique(['slug']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->index(['created_at', 'publish']);
            $table->index(['publish']);
            //$table->unique(['slug']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->index(['created_at', 'publish']);
            $table->index(['publish']);
            //$table->unique(['slug']);
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->index(['published_at', 'unpublished_at', 'publish']);
            $table->index(['published_at', 'publish']);
            $table->index(['publish']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published_at', 'unpublished_at', 'publish']);
            $table->dropIndex(['published_at', 'publish']);
            $table->dropIndex(['publish']);
            //$table->dropUnique(['slug']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex(['created_at', 'publish']);
            $table->dropIndex(['publish']);
            //$table->dropUnique(['slug']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['created_at', 'publish']);
            $table->dropIndex(['publish']);
            //$table->dropUnique(['slug']);
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->dropIndex(['published_at', 'unpublished_at', 'publish']);
            $table->dropIndex(['published_at', 'publish']);
            $table->dropIndex(['publish']);
        });
    }
}
