<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityDestroyRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['sometimes', 'required', 'in:aberto,concluído'],
        ];
    }
}
