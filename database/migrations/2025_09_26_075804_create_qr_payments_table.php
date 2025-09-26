<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qr_code_id'); // foreign key to q_r_codes table
            $table->string('razorpay_payment_id')->unique();
            $table->integer('amount');
            $table->string('currency', 10)->default('INR');
            $table->string('status')->nullable();
            $table->string('method')->nullable();
            $table->string('vpa')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->json('notes')->nullable();
            $table->integer('fee')->nullable();
            $table->integer('tax')->nullable();
            $table->string('rrn')->nullable(); // acquirer_data.rrn
            $table->timestamp('paid_at')->nullable(); // from created_at (Razorpay timestamp)
            $table->timestamps();

            $table->foreign('qr_code_id')
                  ->references('id')
                  ->on('q_r_codes')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_payments');
    }
};
