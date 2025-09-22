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
        Schema::create('q_r_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('razorpay_qr_id');
            $table->string('image_url')->nullable();
            $table->enum('usage', ['single_use', 'multiple_use']);
            $table->boolean('fixed_amount')->default(false);
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('description')->nullable();
            $table->json('notes')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r_codes');
    }
};
