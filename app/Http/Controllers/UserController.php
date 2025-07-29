<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ImageUploadService;

class UserController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

        public function store(UserRequest $request)
    {
        $data = $request->validated();

        // Gestion de l'upload d'image
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->imageUploadService->uploadAvatar($request->file('avatar'));
        }

        // Hashage du mot de passe
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé avec succès.',
            'data' => $user
        ], 201);
    }

        public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        // Gestion de l'upload d'image
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->imageUploadService->uploadAvatar($request->file('avatar'), $user->avatar);
        }

        // Hashage du mot de passe si fourni
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour avec succès.',
            'data' => $user
        ], 200);
    }

    public function destroy(User $user)
    {
        // Supprimer l'avatar si il existe
        if ($user->avatar) {
            $this->imageUploadService->deleteAvatar($user->avatar);
        }

        $user->active = false;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur désactivé avec succès.'
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé.'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

}
