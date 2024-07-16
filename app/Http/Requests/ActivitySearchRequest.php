<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivitySearchRequest extends FormRequest
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
            'user_id' => ['sometimes', 'required', 'exists:users,id'],
            'title' => ['sometimes', 'required'],
            'type' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'completion_date' => ['sometimes', 'nullable', 'date'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after:start_date'],
            'status' => ['sometimes', 'required', 'in:aberto,concluído'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $start_date = $this->input('start_date');
            $end_date = $this->input('end_date');

            if ((! empty($start_date) && empty($end_date)) || (empty($start_date) && ! empty($end_date))) {
                $validator->errors()->add('start_date', 'Tanto a data de início quanto a data de término devem ser fornecidas.');
                $validator->errors()->add('end_date', 'Tanto a data de início quanto a data de término devem ser fornecidas.');
            }
        });
    }
}
