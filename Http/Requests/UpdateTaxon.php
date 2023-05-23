<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\UpdateTaxon as UpdateTaxonContract;

class UpdateTaxon extends FormRequest implements UpdateTaxonContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'parent_id' => 'nullable|exists:taxons,id',
            'priority' => 'nullable|integer'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
