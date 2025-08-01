<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseSuggestionRequest;
use App\Models\CourseSuggestion;
use App\Models\SuggestionVote;
use Illuminate\Http\Request;

class CourseSuggestionController extends Controller
{
    /**
     * Afficher toutes les suggestions de cours.
     */
    public function index()
    {
        $suggestions = CourseSuggestion::with(['user', 'category', 'votes'])
            ->popular()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggestions
        ], 200);
    }

    /**
     * Créer une nouvelle suggestion de cours.
     */
    public function store(CourseSuggestionRequest $request)
    {
        $suggestion = CourseSuggestion::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Suggestion de cours créée avec succès.',
            'data' => $suggestion->load(['user', 'category'])
        ], 201);
    }

    /**
     * Afficher une suggestion spécifique.
     */
    public function show(CourseSuggestion $courseSuggestion)
    {
        return response()->json([
            'success' => true,
            'data' => $courseSuggestion->load(['user', 'category', 'votes'])
        ], 200);
    }

    /**
     * Mettre à jour une suggestion (admin seulement).
     */
    public function update(Request $request, CourseSuggestion $courseSuggestion)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,implemented',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $courseSuggestion->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'approved_at' => $request->status === 'approved' ? now() : null,
            'implemented_at' => $request->status === 'implemented' ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Suggestion mise à jour avec succès.',
            'data' => $courseSuggestion->load(['user', 'category'])
        ], 200);
    }

    /**
     * Supprimer une suggestion.
     */
    public function destroy(CourseSuggestion $courseSuggestion)
    {
        $courseSuggestion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Suggestion supprimée avec succès.'
        ], 200);
    }

    /**
     * Voter pour une suggestion.
     */
    public function vote(Request $request, CourseSuggestion $courseSuggestion)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vote_type' => 'required|in:up,down',
        ]);

        // Vérifier si l'utilisateur a déjà voté
        $existingVote = $courseSuggestion->getUserVote($request->user_id);

        if ($existingVote) {
            // Mettre à jour le vote existant
            if ($existingVote->vote_type === $request->vote_type) {
                // Même vote, le supprimer (annuler le vote)
                $existingVote->delete();
                $courseSuggestion->decrementVotes();

                return response()->json([
                    'success' => true,
                    'message' => 'Vote annulé.',
                    'data' => $courseSuggestion->load(['user', 'category'])
                ], 200);
            } else {
                // Vote différent, le mettre à jour
                $existingVote->update(['vote_type' => $request->vote_type]);

                return response()->json([
                    'success' => true,
                    'message' => 'Vote mis à jour.',
                    'data' => $courseSuggestion->load(['user', 'category'])
                ], 200);
            }
        } else {
            // Nouveau vote
            SuggestionVote::create([
                'user_id' => $request->user_id,
                'course_suggestion_id' => $courseSuggestion->id,
                'vote_type' => $request->vote_type,
            ]);

            $courseSuggestion->incrementVotes();

            return response()->json([
                'success' => true,
                'message' => 'Vote enregistré avec succès.',
                'data' => $courseSuggestion->load(['user', 'category'])
            ], 201);
        }
    }

    /**
     * Obtenir les suggestions populaires.
     */
    public function popular()
    {
        $suggestions = CourseSuggestion::with(['user', 'category'])
            ->where('status', 'pending')
            ->popular()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggestions
        ], 200);
    }

    /**
     * Obtenir les suggestions d'un utilisateur.
     */
    public function userSuggestions($userId)
    {
        $suggestions = CourseSuggestion::with(['category'])
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggestions
        ], 200);
    }

    /**
     * Obtenir les suggestions par statut (admin).
     */
    public function byStatus($status)
    {
        $suggestions = CourseSuggestion::with(['user', 'category'])
            ->where('status', $status)
            ->popular()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suggestions
        ], 200);
    }
}
