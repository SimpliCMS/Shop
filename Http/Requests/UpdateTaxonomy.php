<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\UpdateTaxonomy as UpdateTaxonomyContract;

class UpdateTaxonomy extends FormRequest implements UpdateTaxonomyContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:191',
            'slug' => 'nullable|max:191'
        ];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }
}
