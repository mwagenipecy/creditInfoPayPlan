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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });


        if (!Schema::hasTable('role_permission')) {
            Schema::create('role_permission', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id');
                $table->unsignedBigInteger('permission_id');
                $table->primary(['role_id', 'permission_id']);
                
              //  $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
              //  $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            });
        }
        
        // Create user_permissions table (for custom permission overrides) if it doesn't exist
        if (!Schema::hasTable('user_permissions')) {
            Schema::create('user_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('permission_id');
                $table->boolean('value')->default(true); // true = grant, false = deny
                $table->primary(['user_id', 'permission_id']);
                
              //  $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
              //  $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            });
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
