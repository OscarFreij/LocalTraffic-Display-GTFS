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
        Schema::create('worker_schedules', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->tinyInteger('start_week_day');
            $table->tinyInteger('end_week_day');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('minimum_time_between_calls')->default(300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_schedules');
    }
};
