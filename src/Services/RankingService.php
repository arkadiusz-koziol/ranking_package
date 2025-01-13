<?php

namespace Akoziol\RankingPackage\Services;

use Akoziol\RankingPackage\Imports\RankingImport;
use Akoziol\RankingPackage\Jobs\ProcessRankingImport;
use Akoziol\RankingPackage\Models\Ranking;
use Akoziol\RankingPackage\Repositories\RankingRepository;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class RankingService
{
    public function __construct(private RankingRepository $repository)
    {
    }

    public function processImportedData(array $data): void
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            $this->repository->store([
                'user_id' => $user->id,
                'data' => $data['data'],
            ]);
        }
    }

    public function calculateRanking(array $criteria): array
    {
        return $this->repository->all()->map(function ($item) use ($criteria) {
            $score = $item->data * $criteria['score_weight'];
            $penalty = $item->data * $criteria['penalty_weight'];

            return [
                'user_id' => $item->user_id,
                'score' => $score - $penalty,
            ];
        })->sortByDesc('score')->values()->toArray();
    }

    public function importFile($file): void
    {
        ProcessRankingImport::dispatch(Excel::toCollection(new RankingImport, $file)->toArray());
    }

    public function createRanking(array $data): array
    {
        return $this->repository->createRanking($data)->toArray();
    }

    public function getAllRankings(): array
    {
        return $this->repository->getAllRankings()->toArray();
    }

    public function getRankingById(int $id): ?array
    {
        return $this->repository->findRankingById($id)?->toArray();
    }

    public function updateRanking(Ranking $ranking, array $data): bool
    {
        return $this->repository->updateRanking($ranking, $data);
    }

    public function deleteRanking(Ranking $ranking): bool
    {
        return $this->repository->deleteRanking($ranking);
    }

    public function assignUserToRanking(array $data): array
    {
        return $this->repository->assignUserToRanking($data)->toArray();
    }

    public function getRankingUsers(Ranking $ranking): array
    {
        return $this->repository->getRankingUsers($ranking)->toArray();
    }

    public function updateRankingUser(int $id, array $data): bool
    {
        return $this->repository->updateRankingUser($id, $data);
    }

    public function removeUserFromRanking(int $id): bool
    {
        return $this->repository->removeUserFromRanking($id);
    }
}
