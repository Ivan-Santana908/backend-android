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
   Schema::create('ingrediente_receta', function (Blueprint $table) {
    $table->id();
    $table->foreignId('receta_id')->constrained('recetas')->onDelete('cascade');
    $table->foreignId('ingrediente_id')->constrained('ingredientes')->onDelete('cascade');
    $table->integer('cantidad'); // cantidad numérica
    $table->string('unidad')->nullable(); // ejemplo: gr, ml, taza
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingrediente_receta');
    }
};
