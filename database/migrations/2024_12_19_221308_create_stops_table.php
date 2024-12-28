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
        Schema::create('stops', function (Blueprint $table) {
            //$table->id();
            $table->string('stop_id', 24)->primary();
            $table->text('stop_name');
            $table->text('stop_lat');
            $table->text('stop_lon');
            $table->text('location_type');
            $table->string('parent_station', 24);
            $table->text('platform_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
