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
        Schema::create('task_evidences', function (Blueprint $table) {
            $table->id('task_evidence_id');
            $table->foreignId('task_id')->constrained('tasks', 'task_id')->cascadeOnDelete();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_type', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_evidences');
    }
};
