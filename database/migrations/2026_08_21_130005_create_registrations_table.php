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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('registration_reference')->unique();
            $table->timestamp('registered_at')->useCurrent();
            $table->string('registration_status')->default('registered'); // registered, cancelled, completed
            $table->string('source')->nullable(); // e.g., web, csv_import, manual
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['participant_id', 'program_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
