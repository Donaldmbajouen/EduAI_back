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
        Schema::create('user_exercise_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('user_exercise_attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('exercise_questions')->onDelete('cascade');
            $table->json('selected_answers')->nullable(); // Pour les réponses multiples
            $table->boolean('is_correct')->default(false);
            $table->integer('points_earned')->default(0);
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['attempt_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exercise_answers');
    }
};
