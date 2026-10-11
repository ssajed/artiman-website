<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the website_inquiries table for the Website module.
     * Stores inquiry/consultation requests from the public website.
     *
     * Note: No FK to CRM or other modules. Future CRM integration
     * will be handled via Events (InquirySubmitted), not database relationships.
     */
    public function up(): void
    {
        Schema::create('website_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('industry')->nullable();
            $table->string('flow_rate')->nullable();
            $table->string('inlet_temp')->nullable();
            $table->string('outlet_temp')->nullable();
            $table->string('wet_bulb')->nullable();
            $table->string('install_conditions')->nullable();
            $table->string('tower_type')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->softDeletes();

            // Index for common queries
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_inquiries');
    }
};