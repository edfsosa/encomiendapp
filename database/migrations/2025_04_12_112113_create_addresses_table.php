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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nombre de la dirección (casa, oficina, etc.)
            $table->string('house_number'); // Número de casa
            $table->string('address'); // Dirección
            $table->string('city'); // Ciudad
            $table->string('department'); // Departamento
            $table->string('postal_code')->nullable(); // Código postal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
