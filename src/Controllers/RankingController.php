<?php

namespace Akoziol\RankingPackage\Controllers;

use Akoziol\RankingPackage\Models\Ranking;
use Akoziol\RankingPackage\Requests\AssignUserToRankingRequest;
use Akoziol\RankingPackage\Requests\CreateRankingRequest;
use Akoziol\RankingPackage\Requests\ImportFileRequest;
use Akoziol\RankingPackage\Requests\SetCriteriaRequest;
use Akoziol\RankingPackage\Requests\UpdateRankingRequest;
use Akoziol\RankingPackage\Services\RankingService;
use Illuminate\Http\JsonResponse;

class RankingController
{
    public function __construct(private RankingService $service) {
    }

    public function importFile(ImportFileRequest $request): JsonResponse
    {
        $this->service->importFile($request->file('file'));

        return response()->json(['message' => __('File is being imported in the background.')]);
    }

    public function setCriteria(SetCriteriaRequest $request): JsonResponse
    {
        return response()->json(
            [
                'message' => __('Criteria updated successfully.'), 'criteria' => $request->validated()
            ]
        );
    }

    public function getRankings(): JsonResponse
    {
        return response()->json(
            [
                'rankings' => $this->service->calculateRanking(config('ranking.default_criteria'))
            ]
        );
    }
    public function create(CreateRankingRequest $request): JsonResponse
    {
        return response()->json(
            [
                'ranking' => $this->service->createRanking($request->validated()),
                'message' => __('Ranking created successfully.')
            ]
        );
    }

    public function index(): JsonResponse
    {
        return response()->json(['rankings' => $this->service->getAllRankings()]);
    }

    public function show(Ranking $ranking): JsonResponse
    {
        if (!$ranking) {
            return response()->json(['message' => __('Ranking not found.')], 404);
        }

        return response()->json(['ranking' => $ranking]);
    }

    public function update(Ranking $ranking, UpdateRankingRequest $request): JsonResponse
    {
        if (!$this->service->updateRanking($ranking, $request->validated())) {
            return response()->json(
                [
                    'message' => __('Failed to update ranking.')
                ],
                404
            );
        }

        return response()->json(
            [
                'message' => __('Ranking updated successfully.')
            ]
        );
    }

    public function delete(Ranking $ranking): JsonResponse
    {

        if (!$this->service->deleteRanking($ranking)) {
            return response()->json(
                [
                    'message' => __('Failed to delete ranking.')
                ],
                404
            );
        }

        return response()->json(
            [
                'message' => __('Ranking deleted successfully.')
            ]
        );
    }

    public function assignUserToRanking(AssignUserToRankingRequest $request): JsonResponse
    {
        return response()->json(
            [
                'assignment' => $this->service->assignUserToRanking($request->validated()),
                'message' => __('User assigned to ranking successfully.')
            ]
        );
    }

    public function getRankingUsers(Ranking $ranking): JsonResponse
    {
        return response()->json(
            [
                'users' => $this->service->getRankingUsers($ranking)
            ]
        );
    }
}
