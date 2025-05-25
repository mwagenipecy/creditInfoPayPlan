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
        Schema::create('payment_callback_logs', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable()->index();
            $table->enum('callback_status', ['success', 'failed', 'pending', 'cancelled', 'unknown'])->index();
            $table->enum('processing_status', ['matched', 'unmatched', 'processed', 'failed'])->default('unmatched')->index();
            $table->bigInteger('payment_id')->nullable()->index();
            $table->string('payment_reference')->nullable()->index();
            $table->string('transaction_id')->nullable()->index();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->json('callback_payload'); // Store the complete callback payload
            $table->json('request_headers')->nullable(); // Store request headers
            $table->string('source_ip', 45)->nullable();
            $table->text('error_message')->nullable(); // Store any error messages
            $table->text('processing_notes')->nullable(); // Additional notes
            $table->timestamp('callback_received_at');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['callback_status', 'processing_status'], 'idx_callback_processing_status');
            $table->index(['created_at', 'processing_status'], 'idx_created_processing_status');
            $table->index(['callback_received_at', 'processing_status'], 'idx_received_processing_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_callback_logs');
    }
};