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
        Schema::create('attributions', function (Blueprint $table) {
            //$table->id();
            $table->string('trip_id', 24)->index();
            //$table->foreign('trip_id')->references('trip_id')->on('trips')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('organization_name');
            $table->boolean('is_operator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributions');
    }
};
