<?php

namespace App\Services;

use App\Models\project;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
class ProjectService
{
    //

    public function getByUserPaginated(int $userId, int $perPage = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return project::where('created_by', $userId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function createWithLimit(array $data, int $userId): project
    {
        // Vérifie combien de projets ont été créés aujourd’hui par cet utilisateur
        $todayCount = project::where('created_by', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($todayCount >= 5) {
            throw ValidationException::withMessages([
                'limit' => 'Vous avez atteint la limite de 5 projets par jour.'
            ]);
        }

        $data['created_by'] = $userId;

        return project::create($data);
    }

}