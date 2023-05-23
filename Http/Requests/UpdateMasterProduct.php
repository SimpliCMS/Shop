<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\UpdateMasterProduct as UpdateMasterProductContract;
use Vanilo\Product\Models\ProductStateProxy;

class UpdateMasterProduct extends FormRequest implements UpdateMasterProductContract
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
