<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexesForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['publish']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->index(['publish']);
        });

        Schema::table('adverts', function (Blueprint $table) {
            $table->index(['publish']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->index(['published_at', 'unpublished_at']);
            $table->index(['published_at', 'unpublished_at', 'publish']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->index(['publish']);
            $table->index(['published_at', 'unpublished_at']);
            $table->index(['published_at', 'unpublished_at', 'publish']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->index(['published_at', 'unpublished_at']);
            $table->index(['published_at', 'unpublished_at', 'publish']);
            $table->index(['category_id', 'published_at', 'unpublished_at', 'publish'], 'index_1');
            $table->index(['category_id', 'published_at', 'unpublished_at', 'created_at', 'publish'], 'index_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['publish']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropIndex(['publish']);
        });

        Schema::table('adverts', function (Blueprint $table) {
            $table->dropIndex(['publish']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['published_at', 'unpublished_at']);
            $table->dropIndex(['published_at', 'unpublished_at', 'publish']);
        });

        Schema::table('banners', function (Blueprint $table) {
            $table->dropIndex(['publish']);
            $table->dropIndex(['published_at', 'unpublished_at']);
            $table->dropIndex(['published_at', 'unpublished_at', 'publish']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex(['published_at', 'unpublished_at']);
            $table->dropIndex(['published_at', 'unpublished_at', 'publish']);
            $table->dropIndex('index_1');
            $table->dropIndex('index_2');
        });
    }
}
