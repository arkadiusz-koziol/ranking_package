<?php

namespace Akoziol\RankingPackage\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetCriteriaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'score_weight' => ['required', 'numeric'],
            'penalty_weight' => ['required', 'numeric'],
        ];
    }
}
