<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreateCarrier as CreateCarrierContract;

class CreateCarrier extends FormRequest implements CreateCarrierContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
