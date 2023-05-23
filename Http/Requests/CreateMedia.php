<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Konekt\AppShell\Http\Requests\HasFor;
use Modules\Shop\Contracts\Requests\CreateMedia as CreateMediaContract;

class CreateMedia extends FormRequest implements CreateMediaContract
{
    use HasFor;

    protected $allowedFor = ['product', 'property', 'taxonomy', 'taxon', 'property_value', 'master_product', 'master_product_variant'];

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge($this->getForRules(), [
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
