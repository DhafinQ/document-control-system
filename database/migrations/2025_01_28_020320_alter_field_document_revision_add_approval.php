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
        Schema::table('document_revisions', function (Blueprint $table) {
            $table->boolean('acc_format')->default(false);
            $table->boolean('acc_content')->default(false);
            $table->dropColumn('status');
            $table->enum('status', ['Draft', 'Disetujui', 'Ditolak','Pengajuan Revisi'])->default('Draft');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_revisions', function (Blueprint $table) {
            $table->dropColumn('acc_format');
            $table->dropColumn('acc_content');
            $table->dropColumn('status');
            $table->enum('status', ['Draft', 'Disetujui', 'Ditolak'])->default('Draft');
        });
    }
};
