<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_progress_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phase_id')
                ->constrained('project_progress_phases')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('reference_key')->nullable()->unique();
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 20)->default('not_started');
            $table->string('priority', 20)->default('medium');
            $table->timestamps();

            $table->index(['end_date', 'status']);
            $table->index(['phase_id', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_progress_activities');
    }
};
