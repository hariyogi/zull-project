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
        Schema::table('tasks', function(Blueprint $table) {
            $table->dropForeign('tasks_user_id_foreign');
            $table->renameColumn('user_id', 'assign_to');
            $table->unsignedBigInteger('assign_by')->change();
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });

        Schema::table('tasks', function(Blueprint $table){
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assign_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop Foreign Key yang baru dibuat
            $table->dropForeign(['assign_to']);
            $table->dropForeign(['assign_by']);
            
            // Kembalikan assign_by ke varchar
            $table->string('assign_by', 100)->nullable()->change();
            
            // Kembalikan nama kolom assign_to ke user_id
            $table->renameColumn('assign_to', 'user_id');
            
            // Hapus kolom updated_at
            $table->dropColumn('updated_at');
            
            // Pasang kembali Foreign Key bawaan asli
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
