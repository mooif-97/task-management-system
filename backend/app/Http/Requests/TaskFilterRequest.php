<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function prepareForValidation(){
        // convert string into boolean
        $this->merge([
            'excact_title_search' => filter_var($this->excact_title_search, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return  [
            'page' => 'nullable|numeric',
            'page_size' => 'nullable|numeric',
            'title_search' => 'nullable|string',
            'excact_title_search' => 'nullable|boolean'
            // 'description_search' => 'nullable|string'
        ];
    }
}
