<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTaskRequest extends FormRequest
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

        return  [
            'title' => 'required_without_all:description,deadline,project_id,task_status_id,length|string',
            'description' => 'required_without_all:title,deadline,project_id,task_status_id,length|string',
            'deadline' => 'required_without_all:title,description,project_id,task_status_id,length|date',
            'project_id' => 'required_without_all:title,description,deadline,task_status_id,length|integer',
            'task_status_id' => 'required_without_all:title,description,deadline,project_id,length|integer',
            'length' => 'required_without_all:title,description,deadline,project_id,task_status_id|integer'
        ];
    }

}
