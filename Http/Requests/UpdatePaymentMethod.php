<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\UpdatePaymentMethod as UpdatePaymentMethodContract;
use Vanilo\Payment\PaymentGateways;

class UpdatePaymentMethod extends FormRequest implements UpdatePaymentMethodContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'gateway' => ['required', Rule::in(PaymentGateways::ids())],
            'configuration' => 'sometimes|json',
            'is_enabled' => 'sometimes|boolean',
            'description' => 'sometimes|nullable|string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
