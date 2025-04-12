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
        Schema::create('package_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código de Estado como '001', '002'
            $table->string('name'); // Nombre del Estado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_statuses');
    }
};
