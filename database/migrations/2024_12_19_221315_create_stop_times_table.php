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
        Schema::create('stop_times', function (Blueprint $table) {
            //$table->id();
            $table->string('trip_id', 24)->index();
            //$table->foreign('trip_id')->references('trip_id')->on('trips')->cascadeOnDelete()->cascadeOnUpdate();
            $table->time('arrival_time');
            $table->time('departure_time');
            $table->string('stop_id', 24)->index();
            //$table->foreign('stop_id')->references('stop_id')->on('stops')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('stop_sequence');
            $table->text('stop_headsign');
            $table->integer('pickup_type');
            $table->integer('drop_off_type');
            $table->text('shape_dist_traveled');
            $table->integer('timepoint');
            $table->timestamp('rt_arrival_time')->nullable();
            $table->timestamp('rt_departure_time')->nullable();
            $table->integer('schedule_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stop_times');
    }
};
