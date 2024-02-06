<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'deadline.after_or_equal' =>'Вы запланировать завершение прошедшей датой'

        ];
    }
}
