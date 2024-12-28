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
        Schema::create('agencies', function (Blueprint $table) {
            //$table->id();
            $table->string('agency_id', 17)->primary();
            $table->text('agency_name');
            $table->text('agency_url');
            $table->text('agency_timezone');
            $table->text('agency_lang');
            $table->text('agency_fare_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
