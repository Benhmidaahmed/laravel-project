<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('num_tel')->nullable();
            $table->string('url_image')->nullable();

            $table->enum('roles', ['STUDENT', 'PSYCHOLOGIST', 'ADMIN'])->default('STUDENT');
            $table->boolean('enabled')->default(false);
            $table->string('provider')->nullable();

            // Student-specific fields
            $table->string('student_card_number')->nullable();
            $table->string('university')->nullable();
            $table->string('study_level')->nullable();

            // Psychologist-specific fields
            $table->string('adeli_number')->nullable();
            $table->string('specialization')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateur');
    }
};
