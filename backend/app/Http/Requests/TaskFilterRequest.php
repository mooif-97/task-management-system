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
            'page' => 'nullable|numeric|min:1',
            'page_size' => 'nullable|numeric|min:1',
            'title_search' => 'nullable|string',
            'exact_title_search' => 'nullable|boolean',
            'order_by' => 'nullable|string',
            'order' => 'nullable|string',
        ];
    }
}
