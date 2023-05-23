<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\UpdateProduct as UpdateProductContract;
use Vanilo\Product\Models\ProductStateProxy;

class UpdateProduct extends FormRequest implements UpdateProductContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($this->route('product')->id),
                ],
            'state' => ['required', Rule::in(ProductStateProxy::values())],
            'price' => 'nullable|numeric',
            'original_price' => 'sometimes|nullable|numeric',
            'stock' => 'nullable|numeric',
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
