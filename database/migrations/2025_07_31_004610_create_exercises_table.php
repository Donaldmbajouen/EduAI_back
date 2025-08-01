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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['quiz_single', 'quiz_multiple']);
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('points')->default(0);
            $table->integer('time_limit')->nullable(); // en minutes
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->integer('passing_score')->default(70); // pourcentage minimum pour réussir
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['lesson_id', 'order']);
            $table->index(['lesson_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
