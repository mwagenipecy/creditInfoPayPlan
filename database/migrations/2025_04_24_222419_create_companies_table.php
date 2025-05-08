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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('company_name')->nullable();
            $table->string('trading_name')->nullable();
            $table->string('registration_number')->unique();
            $table->date('date_of_incorporation')->nullable();
            $table->string('business_type')->nullable();
            $table->string('industry')->nullable();
            
            // Contact Information
            $table->string('primary_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_address')->nullable();
            
            // Primary Contact Person
            $table->string('contact_name')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            
            // Verification status and terms acceptance
            $table->string('verification_status')->default('draft');
            $table->boolean('terms_accepted')->default(false);


            $table->text('address')->nullable();
            $table->string('logo_path')->nullable();
            $table->boolean('is_blocked')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
