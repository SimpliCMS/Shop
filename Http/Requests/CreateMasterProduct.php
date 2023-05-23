<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\CreateMasterProduct as CreateMasterProductContract;
use Vanilo\Product\Models\ProductStateProxy;

class CreateMasterProduct extends FormRequest implements CreateMasterProductContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'price' => 'nullable|numeric',
            'original_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
