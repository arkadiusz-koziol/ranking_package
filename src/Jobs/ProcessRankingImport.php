<?php

namespace Akoziol\RankingPackage\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Akoziol\RankingPackage\Services\RankingService;

class ProcessRankingImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private array $rows) {}

    public function handle(RankingService $service): void
    {
        foreach ($this->rows as $row) {
            $service->processImportedData([
                'email' => $row[0],
                'data' => $row[1],
            ]);
        }
    }
}
