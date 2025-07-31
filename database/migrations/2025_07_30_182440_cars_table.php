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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps(6);
        });

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->unsignedTinyInteger('comfort_category');
            $table->timestamps(6);

            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
        Schema::dropIfExists('drivers');
    }
};
