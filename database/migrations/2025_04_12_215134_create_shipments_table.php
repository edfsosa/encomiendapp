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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->date('shipment_date');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('itinerary_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_status_id')->constrained()->onDelete('cascade');
            $table->string('addressee_name');
            $table->string('addressee_address');
            $table->string('addressee_phone');
            $table->string('addressee_email')->nullable();
            $table->string('payment_method');
            $table->string('payment_status');
            $table->integer('total_items')->default(0);
            $table->integer('total_cost')->default(0);
            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
