<?php

namespace JobMetric\EventSystem\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use JobMetric\EventSystem\Rules\ClassExistRule;

class StoreEventSystemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'string|nullable',
            'event' => [
                'required',
                'string',
                new ClassExistRule
            ],
            'listener' => [
                'required',
                'string',
                new ClassExistRule
            ],
            'priority' => 'integer|nullable',
            'status' => 'boolean|nullable'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->status ?? true,
            'priority' => $this->priority ?? 0,
        ]);
    }
}
