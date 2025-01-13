<?php

use Illuminate\Support\Facades\Route;
use Akoziol\RankingPackage\Controllers\RankingController;

Route::group(['prefix' => 'ranking', 'middleware' => 'auth:api'], function () {
    Route::post('/import', [RankingController::class, 'importFile'])
        ->name('ranking.import');
    Route::post('/criteria', [RankingController::class, 'setCriteria'])
        ->name('ranking.criteria');
    Route::get('/', [RankingController::class, 'getRankings'])
        ->name('ranking.index');
    Route::post('/', [RankingController::class, 'create'])
        ->name('ranking.create');
    Route::get('/', [RankingController::class, 'index'])
        ->name('ranking.index');
    Route::get('/{ranking}', [RankingController::class, 'show'])
        ->name('ranking.show');
    Route::put('/{ranking}', [RankingController::class, 'update'])
        ->name('ranking.update');
    Route::delete('/{ranking}', [RankingController::class, 'delete'])
        ->name('ranking.delete');
    Route::post('/assign-user', [RankingController::class, 'assignUserToRanking'])
        ->name('ranking.assign-user');
    Route::get('/{ranking}/users', [RankingController::class, 'getRankingUsers'])
        ->name('ranking.users');
});
