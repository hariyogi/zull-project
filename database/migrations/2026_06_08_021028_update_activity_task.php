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
        Schema::table('activity_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('report_form')->nullable();
            $table->foreign('report_form')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_tasks', function (Blueprint $table) {
            // 1. Hapus foreign key constraint terlebih dahulu
            // Laravel menggunakan konvensi nama: {nama_tabel}_{nama_kolom}_foreign
            $table->dropForeign('task_evidences_report_form_foreign');

            // 2. Hapus kolomnya
            $table->dropColumn('report_form');
        });
    }
};
