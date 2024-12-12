<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            // due_date validated as ISO 8601 format to streamline input from FE and to DB
            'due_date' => 'nullable|regex:/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{3}Z$/',
            'created_by' => 'nullable|string|max:255'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Throw the validation exception and return a JSON response
        throw new ValidationException(
            $validator,
            response()->json(['errors' => $validator->errors()], 422)
        );
    }
}
