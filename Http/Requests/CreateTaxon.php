<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateTaxon as CreateTaxonContract;

class CreateTaxon extends FormRequest implements CreateTaxonContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'parent_id' => 'nullable|exists:taxons,id',
            'priority' => 'nullable|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
