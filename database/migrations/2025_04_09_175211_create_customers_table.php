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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Persona física', 'Persona jurídica'])->default('Persona física');
            $table->string('document_type')->nullable(); // CI / RUC / etc.
            $table->string('document_number')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_alt')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_gov_supplier')->default(false);
            $table->string('operation_type')->nullable(); // B2B / B2C
            $table->foreignId('agent_id')->nullable()->constrained('users'); // O tabla agentes
            $table->string('group')->nullable();
            $table->string('series')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_days')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
