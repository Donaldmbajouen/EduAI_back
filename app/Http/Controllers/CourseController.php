<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Afficher la liste des cours.
     */
    public function index()
    {
        $courses = Course::with(['category', 'user', 'resources'])->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ], 200);
    }

    /**
     * Créer un nouveau cours.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $resources = $data['resources'] ?? [];
        unset($data['resources']);

        // Gestion de l'upload du thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->imageUploadService->uploadThumbnail($request->file('thumbnail'));
        }

        $course = Course::create($data);

        // Créer les ressources associées
        foreach ($resources as $index => $resourceData) {
            $resourceData['course_id'] = $course->id;
            $resourceData['order'] = $resourceData['order'] ?? $index + 1;

            // Gestion de l'upload de fichier pour la ressource
            if (isset($resourceData['file']) && $request->hasFile("resources.{$index}.file")) {
                $file = $request->file("resources.{$index}.file");
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/resources', $fileName);
                $resourceData['file_path'] = 'resources/' . $fileName;
            }
            unset($resourceData['file']);

            CourseResource::create($resourceData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cours créé avec succès.',
            'data' => $course->load(['category', 'user', 'resources'])
        ], 201);
    }

    /**
     * Afficher un cours spécifique.
     */
    public function show(Course $course)
    {
        // Incrémenter le compteur de vues
        $course->increment('views_count');

        return response()->json([
            'success' => true,
            'data' => $course->load(['category', 'user', 'resources'])
        ], 200);
    }

    /**
     * Mettre à jour un cours.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $resources = $data['resources'] ?? [];
        unset($data['resources']);

        // Gestion de l'upload du thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->imageUploadService->uploadThumbnail($request->file('thumbnail'), $course->thumbnail);
        }

        $course->update($data);

        // Mettre à jour les ressources
        if (!empty($resources)) {
            // Supprimer les anciennes ressources
            $course->resources()->delete();

            // Créer les nouvelles ressources
            foreach ($resources as $index => $resourceData) {
                $resourceData['course_id'] = $course->id;
                $resourceData['order'] = $resourceData['order'] ?? $index + 1;

                // Gestion de l'upload de fichier pour la ressource
                if (isset($resourceData['file']) && $request->hasFile("resources.{$index}.file")) {
                    $file = $request->file("resources.{$index}.file");
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/resources', $fileName);
                    $resourceData['file_path'] = 'resources/' . $fileName;
                }
                unset($resourceData['file']);

                CourseResource::create($resourceData);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cours mis à jour avec succès.',
            'data' => $course->load(['category', 'user', 'resources'])
        ], 200);
    }

    /**
     * Supprimer un cours.
     */
    public function destroy(Course $course)
    {
        // Supprimer le thumbnail si il existe
        if ($course->thumbnail) {
            $this->imageUploadService->deleteThumbnail($course->thumbnail);
        }

        // Supprimer les fichiers des ressources
        foreach ($course->resources as $resource) {
            if ($resource->file_path && file_exists(storage_path('app/public/' . $resource->file_path))) {
                unlink(storage_path('app/public/' . $resource->file_path));
            }
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cours supprimé avec succès.'
        ], 200);
    }

    /**
     * Obtenir les cours d'un utilisateur spécifique.
     */
    public function coursesByUser($userId)
    {
        $courses = Course::with(['category', 'user', 'resources'])
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ], 200);
    }

    /**
     * Obtenir les cours publiés d'un utilisateur.
     */
    public function publishedCoursesByUser($userId)
    {
        $courses = Course::with(['category', 'user', 'resources'])
            ->where('user_id', $userId)
            ->where('is_published', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ], 200);
    }
}
