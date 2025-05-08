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
                $table->string('action'); // created, updated, deleted, etc.
                $table->string('model_type'); // User::class, Company::class, etc.
                $table->unsignedBigInteger('model_id'); // ID of the model
                $table->text('description')->nullable();
                $table->json('properties')->nullable(); // Additional data
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
                
                $table->index(['model_type', 'model_id']);
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
