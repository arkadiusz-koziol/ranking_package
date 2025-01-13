<?php

namespace Akoziol\RankingPackage\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignUserToRankingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ranking_id' => ['required', 'exists:rankings,id'],
            'user_id' => ['required', 'exists:users,id'],
            'data' => ['nullable', 'numeric'],
        ];
    }
}
