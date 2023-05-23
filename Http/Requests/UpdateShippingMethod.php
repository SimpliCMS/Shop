<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\UpdateShippingMethod as UpdateShippingMethodContract;
use Vanilo\Shipment\ShippingFeeCalculators;

class UpdateShippingMethod extends FormRequest implements UpdateShippingMethodContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'carrier_id' => 'required|exists:carriers,id',
            'zone_id' => 'sometimes|nullable|exists:zones,id',
            'calculator' => ['sometimes', 'nullable', Rule::in(ShippingFeeCalculators::ids())],
            'configuration' => 'sometimes|json',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
