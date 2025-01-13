<?php

namespace Akoziol\RankingPackage\Repositories;

use Akoziol\RankingPackage\Models\Ranking;
use Akoziol\RankingPackage\Models\RankingUser;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class RankingRepository
{
    public function __construct(private DatabaseManager $db) {}

    public function store(array $data): void
    {
        $this->db->table('rankings')->insert($data);
    }

    public function all(): Collection
    {
        return $this->db->table('rankings')->get();
    }
    public function createRanking(array $data): Ranking
    {
        return Ranking::create($data);
    }

    public function getAllRankings(): \Illuminate\Support\Collection
    {
        return Ranking::all();
    }

    public function findRankingById(int $id): ?Ranking
    {
        return Ranking::find($id);
    }

    public function updateRanking(Ranking $ranking, array $data): bool
    {
        return $ranking->update($data);
    }

    public function deleteRanking(Ranking $ranking): bool
    {
        return $ranking->delete();
    }

    public function assignUserToRanking(array $data): RankingUser
    {
        return RankingUser::create($data);
    }

    public function getRankingUsers(Ranking $ranking): Collection
    {
        return RankingUser::where('ranking_id', $ranking->id)->get();
    }

    public function updateRankingUser(int $id, array $data): bool
    {
        $rankingUser = RankingUser::find($id);

        return $rankingUser ? $rankingUser->update($data) : false;
    }

    public function removeUserFromRanking(int $id): bool
    {
        $rankingUser = RankingUser::find($id);

        return $rankingUser ? $rankingUser->delete() : false;
    }
}