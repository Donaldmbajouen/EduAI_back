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
        Schema::create('suggestion_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_suggestion_id')->constrained('course_suggestions')->onDelete('cascade');
            $table->enum('vote_type', ['up', 'down'])->default('up');
            $table->timestamps();

            // Un utilisateur ne peut voter qu'une fois par suggestion
            $table->unique(['user_id', 'course_suggestion_id']);

            // Index pour optimiser les requêtes
            $table->index(['course_suggestion_id', 'vote_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestion_votes');
    }
};
