<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreatePropertyValue as CreatePropertyValueContract;

class CreatePropertyValue extends FormRequest implements CreatePropertyValueContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'title' => 'required|min:1|max:255',
            'value' => 'nullable|min:1|max:255',
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
