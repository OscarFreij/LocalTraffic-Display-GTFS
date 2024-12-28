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
        Schema::create('transfers', function (Blueprint $table) {
            //$table->id();
            $table->string('from_stop_id', 24)->index();
            //$table->foreign('from_stop_id')->references('stop_id')->on('stops')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('to_stop_id', 24)->index();
            //$table->foreign('to_stop_id')->references('stop_id')->on('stops')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('transfer_type');
            $table->text('min_transfer_time');
            $table->string('from_trip_id', 24)->index();
            //$table->foreign('from_trip_id')->references('trip_id')->on('trips')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('to_trip_id', 24)->index();
            //$table->foreign('to_trip_id')->references('trip_id')->on('trips')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
