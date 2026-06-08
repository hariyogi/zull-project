<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('task_evidences', function (Blueprint $table) {
            $table->dropForeign('task_evidences_task_id_foreign');
            $table->renameColumn('task_id', 'task_activity_id');
            $table->foreign('task_activity_id')
                ->references('activity_task_id')
                ->on('activity_tasks')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_evidences', function (Blueprint $table) {
           $table->dropForeign(['task_activity_id']);
           $table->renameColumn('task_activity_id', 'task_id');
           $table->foreign('task_id')->references('task_id')->on('tasks')->onDelete('cascade');
        });
    }
};
