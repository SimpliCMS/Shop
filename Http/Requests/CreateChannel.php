<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateChannel as CreateChannelContract;

class CreateChannel extends FormRequest implements CreateChannelContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'slug' => 'nullable|max:255',
            'configuration' => 'nullable|array',
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
