<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feed_infos', function (Blueprint $table) {
            //$table->id();
            $table->string('feed_id', 24)->primary();
            $table->text('feed_publisher_name');
            $table->text('feed_publisher_url');
            $table->text('feed_lang');
            $table->text('feed_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_infos');
    }
};
