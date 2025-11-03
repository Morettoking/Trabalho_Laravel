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
    Schema::create('vehicle_photos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
        $table->string('url');   // link da foto (sem upload)
        $table->unsignedSmallInteger('position')->default(1); // ordem de exibição
        $table->timestamps();

        $table->index(['vehicle_id','position']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_photos');
    }
};
