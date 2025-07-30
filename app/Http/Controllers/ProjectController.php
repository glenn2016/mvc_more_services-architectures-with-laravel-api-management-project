<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\ProjectService;


class ProjectController extends Controller
{

    protected ProjectService $ProjectService;
    /**
     * Liste les projets de l'utilisateur connecté.
     *
     * Cette route retourne la liste paginée des projets créés par l'utilisateur connecté.
     *
     * @group Projets
     * @authenticated
     *
     * @queryParam per_page int Nombre de projets par page. Exemple: 10
     *
     * @response 200 scenario="Succès" {
     *   "status": "success",
     *   "data": {
     *     "current_page": 1,
     *     "data": [
     *       {
     *         "id": 1,
     *         "name": "Mon projet",
     *         "description": "Une super idée",
     *         "chef_id": 4,
     *         "created_by": 1,
     *         "created_at": "2025-07-30T10:00:00.000000Z",
     *         "updated_at": "2025-07-30T10:00:00.000000Z"
     *       }
     *     ],
     *     "total": 3,
     *     "last_page": 1
     *   }
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $userId = Auth::id(); // ID de l'utilisateur connecté

        $projets = $this->ProjectService->getByUserPaginated($userId, $perPage);

        return response()->json([
            'status' => 'success',
            'data' => $projets
        ]);
    }

    /**
     * Créer un nouveau projet.
     *
     * Cette route permet à un utilisateur authentifié de créer un nouveau projet,
     * à condition qu’il n’ait pas déjà dépassé la limite de 5 projets pour la journée.
     *
     * @group Projets
     * @authenticated
     *
     * @bodyParam name string required Nom du projet. Exemple: Application mobile
     * @bodyParam description string Description du projet. Exemple: Une appli pour suivre ses dépenses
     * @bodyParam chef_id int required ID de l'utilisateur chef du projet. Doit exister dans la table `users`. Exemple: 4
     *
     * @response 201 scenario="Projet créé" {
     *   "status": "success",
     *   "data": {
     *     "id": 10,
     *     "name": "Application mobile",
     *     "description": "Une appli pour suivre ses dépenses",
     *     "chef_id": 4,
     *     "created_by": 2,
     *     "created_at": "2025-07-30T11:22:33.000000Z",
     *     "updated_at": "2025-07-30T11:22:33.000000Z"
     *   }
     * }
     *
     * @response 429 scenario="Limite atteinte" {
     *   "status": "error",
     *   "message": "Vous avez atteint la limite de 5 projets pour aujourd'hui."
     * }
     */
    public function store(Request $request):JsonResponse
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'chef_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();

        $projet = $this->ProjectService->createWithLimit($validated, $userId);

        return response()->json([
            'status' => 'success',
            'data' => $projet
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        //
    }
}
