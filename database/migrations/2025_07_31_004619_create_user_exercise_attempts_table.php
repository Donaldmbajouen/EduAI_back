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
        Schema::create('user_exercise_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->integer('max_score')->default(0);
            $table->decimal('percentage', 5, 2)->default(0.00);
            $table->integer('time_spent')->nullable(); // en minutes
            $table->enum('status', ['started', 'completed', 'abandoned'])->default('started');
            $table->boolean('is_passed')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['user_id', 'exercise_id']);
            $table->index(['user_id', 'status']);
            $table->index(['exercise_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exercise_attempts');
    }
};
