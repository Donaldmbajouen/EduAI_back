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
        Schema::create('exercise_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['text', 'image'])->default('text');
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['exercise_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_questions');
    }
};
