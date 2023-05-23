<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateTaxonomy as CreateTaxonomyContract;

class CreateTaxonomy extends FormRequest implements CreateTaxonomyContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:191',
            'slug' => 'nullable|max:191',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpg,jpeg,pjpg,png,gif,webp',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
