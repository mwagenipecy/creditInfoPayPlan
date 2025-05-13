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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('network_type', ['MTN', 'VODACOM', 'AIRTEL', 'TIGO','TTCL','TPESA'])->index();
            $table->string('order_id')->unique()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->string('mobile_number', 15);
            $table->text('descriptions')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('token_number')->nullable()->index();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'expired'])
                  ->default('pending')->index();
            $table->ipAddress('device_ip')->nullable();
            $table->text('payment_response')->nullable(); // Store payment gateway response
            $table->string('payment_reference')->nullable()->index(); // External reference from payment gateway
            $table->timestamp('payment_initiated_at')->nullable();
            $table->timestamp('payment_completed_at')->nullable();
            
            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            // Add indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
            $table->index(['company_id', 'status']);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
