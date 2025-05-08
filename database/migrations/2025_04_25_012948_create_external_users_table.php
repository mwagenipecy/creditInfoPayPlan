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
        Schema::create('external_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('organization')->nullable();
            $table->boolean('has_access')->default(false);
            $table->string('access_level')->nullable(); // read, write, admin
            $table->timestamp('access_expires_at')->nullable();
            $table->timestamp('access_revoked_at')->nullable();
            $table->foreignId('access_revoked_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_users');
    }
};
