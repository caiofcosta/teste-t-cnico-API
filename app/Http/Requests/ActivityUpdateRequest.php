<?php

namespace App\Http\Requests;

use App\Rules\NotInWeekend;
use Illuminate\Foundation\Http\FormRequest;

class ActivityUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'type' => ['sometimes', 'required', 'string', 'max:100'],
            'description' => ['sometimes', 'nullable', 'string'],
            'start_date' => ['sometimes', 'required', 'date', new NotInWeekend],
            'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date', new NotInWeekend],
            'status' => ['sometimes', 'required', 'in:aberto,concluído'],
        ];
    }
}
