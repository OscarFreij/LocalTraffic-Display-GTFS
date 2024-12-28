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
        Schema::create('calendar_dates', function (Blueprint $table) {
            //$table->id();
            $table->integer('service_id')->index();
            //$table->foreign('service_id')->references('service_id')->on('calendars')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date');
            $table->text('exception_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_dates');
    }
};
