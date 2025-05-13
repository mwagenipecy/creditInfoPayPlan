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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number', 20)->unique()->index();
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('payment_id')->unique()->index(); // Link to specific payment
            $table->unsignedInteger('total_reports')->default(0);
            $table->unsignedInteger('remaining_reports')->default(0);
            $table->enum('status', ['active', 'inactive', 'suspended', 'expired'])->default('active')->index();
            $table->timestamp('last_used')->nullable();
            $table->timestamp('valid_from')->nullable(); // When account becomes valid
            $table->timestamp('valid_until')->nullable(); // When account expires (30 days)
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->string('package_type', 100)->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['company_id', 'status', 'valid_until']);
            $table->index(['user_id', 'status', 'valid_until']);
            $table->index(['status', 'valid_until']);
            $table->index(['valid_from', 'valid_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
