<?php

namespace Akoziol\RankingPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RankingUser extends Model
{
    protected $fillable = ['ranking_id', 'user_id', 'data'];

    public function ranking(): BelongsTo
    {
        return $this->belongsTo(Ranking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
