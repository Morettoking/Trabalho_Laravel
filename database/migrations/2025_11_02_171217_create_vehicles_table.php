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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();

        $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
        $table->foreignId('car_model_id')->constrained('car_models')->cascadeOnDelete();
        $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();

        $table->string('title')->nullable(); // ex: “Civic EXL 2.0 AT”
        $table->year('year');                // ano de fabricação (obrigatório)
        $table->unsignedInteger('mileage_km'); // quilometragem (obrigatório)
        $table->decimal('price', 12, 2);       // valor (obrigatório)

        $table->string('main_photo_url')->nullable(); // foto principal (URL)
        $table->text('description')->nullable();      // detalhes

        $table->timestamps();

        $table->index(['brand_id','car_model_id','color_id']);
        $table->index(['year','price']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
