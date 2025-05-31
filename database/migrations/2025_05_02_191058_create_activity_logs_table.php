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
       


        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
                $table->string('action')->nullable(); // created, updated, deleted, etc.
                $table->string('model_type')->nullable(); // User::class, Company::class, etc.
                $table->unsignedBigInteger('model_id')->nullable(); // ID of the model
                $table->text('description')->nullable();
                $table->json('properties')->nullable(); // Additional data
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
                
                $table->index(['model_type', 'model_id']);
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');



                $table->string('subject_type')->nullable(); // Polymorphic type
                $table->unsignedBigInteger('subject_id')->nullable(); // Polymorphic id
                $table->string('activity')->nullable(); // Type of activity (user_updated, user_created, etc.)
                $table->json('old_values')->nullable(); // Old values before change
                $table->json('new_values')->nullable(); // New values after change
                $table->json('changes')->nullable(); // Specific changes made
                $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
    
                // Indexes for better performance
                $table->index(['subject_type', 'subject_id']);
                $table->index(['activity']);
                $table->index(['user_id', 'created_at']);
                $table->index(['company_id', 'created_at']);



            });

        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
