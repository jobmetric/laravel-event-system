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
     * Normalize raw input when validating outside Laravel's FormRequest pipeline.
     *
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    public static function normalize(array $data): array
    {
        $data['status'] = $data['status'] ?? true;
        $data['priority'] = $data['priority'] ?? 0;

        if (($data['description'] ?? null) === '') {
            $data['description'] = null;
        }

        return $data;
    }

    /**
     * Laravel's native pipeline will still call this when using the FormRequest normally.
     */
    protected function prepareForValidation(): void
    {
        $this->merge(static::normalize($this->all()));
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => trans('event-system::base.fields.name'),
            'description' => trans('event-system::base.fields.description'),
            'event' => trans('event-system::base.fields.event'),
            'listener' => trans('event-system::base.fields.listener'),
            'priority' => trans('event-system::base.fields.priority'),
            'status' => trans('event-system::base.fields.status'),
        ];
    }
}
