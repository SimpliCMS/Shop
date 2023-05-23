<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Shop\Contracts\Requests\UpdateOrder as UpdateOrderContract;
use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Models\OrderStatusProxy;

class UpdateOrder extends FormRequest implements UpdateOrderContract
{
    public function rules()
    {
        return [
            'status' => ['required', Rule::in(OrderStatusProxy::values())]
        ];
    }

    public function wantsToChangeOrderStatus(Order $order): bool
    {
        return $this->getStatus() !== $order->getStatus()->value();
    }

    public function getStatus(): string
    {
        return $this->get('status');
    }

    public function authorize()
    {
        return true;
    }
}
