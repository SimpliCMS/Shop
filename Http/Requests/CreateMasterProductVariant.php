<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateMasterProductVariant as CreateMasterProductVariantContract;

class CreateMasterProductVariant extends FormRequest implements CreateMasterProductVariantContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'sku' => 'required|unique:products',
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
            'excerpt' => 'sometimes|nullable|max:8192',
            'description' => 'sometimes|nullable|max:32768',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp'
        ];
    }

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'stock' => $this->stock ?? 0,
        ]);
    }
}
