<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
//        return [
//            'title' => 'required_without:description,category_id,deadline|string',
//            'description' => 'required_without:title,category_id,deadline|string|nullable',
//            'deadline' => 'required_without:title,category_id,description|date|after_or_equal:today|nullable',
//            'category_id' => 'required_without:title,description,deadline|integer|nullable',
//        ];
        return  [
            'title' => 'required_without_all:description,category_id,deadline|string|min:30',
            'description' => 'required_without_all:title,category_id,deadline|string',
            'deadline' => 'required_without_all:title,category_id,description|date',
            'category_id' => 'required_without_all:title,description,deadline|integer'
        ];
    }
}
