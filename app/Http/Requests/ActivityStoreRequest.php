<?php

namespace App\Http\Requests;

use App\Rules\NotInWeekend;
use Illuminate\Foundation\Http\FormRequest;

class ActivityStoreRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date', new NotInWeekend],
            'end_date' => ['required', 'date', 'after_or_equal:start_date', new NotInWeekend],
            'status' => ['sometimes', 'required', 'in:aberto,concluído'],
        ];
    }
}
