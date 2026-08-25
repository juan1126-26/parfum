<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

abstract class CategoryFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', $this->slugRule()],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
        ];
    }

    abstract protected function slugRule(): mixed;
}
