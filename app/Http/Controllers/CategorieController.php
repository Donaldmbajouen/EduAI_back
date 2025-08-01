<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategorieRequest;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
        /**
     * Afficher la liste des catégories.
     */
    public function index()
    {
        $categories = Categorie::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }


    /**
     * Créer une nouvelle catégorie.
     */
    public function store(CategorieRequest $request)
    {
        $categorie = Categorie::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Catégorie créée avec succès.',
            'data' => $categorie
        ], 201);
    }

    /**
     * Afficher une catégorie spécifique.
     */
    public function show(Categorie $categorie)
    {
        return response()->json([
            'success' => true,
            'data' => $categorie
        ], 200);
    }
    /**
     * Mettre à jour une catégorie.
     */
    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $categorie->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Catégorie mise à jour avec succès.',
            'data' => $categorie
        ], 200);
    }

    /**
     * Supprimer une catégorie.
     */
    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie supprimée avec succès.'
        ], 200);
    }
}
