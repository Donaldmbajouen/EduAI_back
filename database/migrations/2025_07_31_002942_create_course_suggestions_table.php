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
        Schema::create('course_suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->foreignId('category_id')->constrained('categories');
            $table->text('justification')->nullable(); // Pourquoi ce cours est nécessaire
            $table->enum('status', ['pending', 'approved', 'rejected', 'implemented'])->default('pending');
            $table->integer('votes_count')->default(0);
            $table->text('admin_notes')->nullable(); // Notes de l'admin
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('implemented_at')->nullable();
            $table->timestamps();

            // Index pour optimiser les requêtes
            $table->index(['status', 'votes_count']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_suggestions');
    }
};
