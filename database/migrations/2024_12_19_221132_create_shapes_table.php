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
        Schema::create('shapes', function (Blueprint $table) {
            //$table->id();
            $table->string('shape_id', 24)->index();
            $table->text('shape_pt_lat');
            $table->text('shape_pt_lon');
            $table->text('shape_pt_sequence');
            $table->text('shape_dist_traveled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shapes');
    }
};
