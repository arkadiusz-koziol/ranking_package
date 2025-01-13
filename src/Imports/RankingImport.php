<?php

namespace Akoziol\RankingPackage\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Akoziol\RankingPackage\Jobs\ProcessRankingImport;

class RankingImport implements ToCollection
{
    public function collection(Collection $collection): void
    {
        ProcessRankingImport::dispatch($collection->toArray());
    }
}
