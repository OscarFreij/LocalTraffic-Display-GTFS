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
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 36);
            $table->string('long_name');
            $table->string('description')->nullable();
            $table->text('stop_queue')->nullable();
            $table->integer('time_per_stop')->default(5);
            $table->string('longitude', 16)->nullable();
            $table->string('latitude', 16)->nullable();
            $table->string('timezone', 64);
            $table->foreignIdFor(App\Models\User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};
