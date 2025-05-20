<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
Schema::create('forum_threads', function (Blueprint $table) {
$table->id();
$table->string('title');
$table->foreignId('author_id')
->constrained('utilisateur') // ✅ matches your custom user table
->onDelete('cascade');
$table->timestamps();
});
}

public function down(): void
{
Schema::dropIfExists('forum_threads');
}
};
