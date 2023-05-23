<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\UpdatePropertyValue as UpdatePropertyValueContract;

class UpdatePropertyValue extends FormRequest implements UpdatePropertyValueContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'title' => 'required|min:1|max:255',
            'value' => 'nullable|min:1|max:255',
            'property_id' => 'required|exists:properties,id',
            'priority' => 'nullable|integer'
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
