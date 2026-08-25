<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends CategoryFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Category $category */
        $category = $this->route('category');

        return Rule::unique('categories', 'slug')->ignore($category);
    }
}
