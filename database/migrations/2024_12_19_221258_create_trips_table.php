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
        Schema::create('trips', function (Blueprint $table) {
            //$table->id();
            $table->string('route_id', 24)->index();
            //$table->foreign('route_id')->references('route_id')->on('routes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('service_id')->index();
            //$table->foreign('service_id')->references('service_id')->on('calendars')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('trip_id', 24)->primary();
            $table->text('trip_headsign');
            $table->integer('direction_id');
            $table->string('shape_id', 24)->index();
            //$table->foreign('shape_id')->references('shape_id')->on('shapes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('schedule_relationship')->nullable();
            $table->boolean('service_alert_cancled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
