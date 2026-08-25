<?php

namespace App\Http\Requests\Admin;

use App\Models\Brand;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends BrandFormRequest
{
    protected function slugRule(): mixed
    {
        /** @var Brand $brand */
        $brand = $this->route('brand');

        return Rule::unique('brands', 'slug')->ignore($brand);
    }
}
