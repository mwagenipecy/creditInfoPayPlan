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
       

        if (!Schema::hasTable('permission_logs')) {
            Schema::create('permission_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id'); // User whose permissions were changed
                $table->unsignedBigInteger('admin_id')->nullable(); // Admin who made the change
                $table->unsignedBigInteger('permission_id')->nullable();
                $table->string('action'); // updated, reset, etc.
                $table->string('type')->nullable(); // grant, deny, reset
                $table->text('note')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('set null');
            });
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_logs');
    }
};
