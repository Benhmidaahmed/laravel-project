<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('client');
            $table->dateTimeTz('date'); // for ZonedDateTime
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->string('email')->nullable()->comment('E-mail column from Java');
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
