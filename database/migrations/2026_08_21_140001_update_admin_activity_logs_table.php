<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_activity_logs', function (Blueprint $table) {
            $table->text('description')->nullable()->after('action');
            $table->json('metadata')->nullable()->after('description');
            // Make target_type nullable for generic log entries
            $table->string('target_type')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('admin_activity_logs', function (Blueprint $table) {
            $table->dropColumn(['description', 'metadata']);
        });
    }
};
