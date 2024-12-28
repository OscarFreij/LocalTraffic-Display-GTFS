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
        Schema::create('routes', function (Blueprint $table) {
            //$table->id();
            $table->string('route_id', 24)->primary();
            $table->string('agency_id', 17)->index();
            //$table->foreign('agency_id')->references('agency_id')->on('agencies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('route_short_name');
            $table->text('route_long_name');
            $table->text('route_desc');
            $table->text('route_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
