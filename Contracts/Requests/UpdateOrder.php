<?php

namespace Modules\Shop\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;
use Vanilo\Order\Contracts\Order;

interface UpdateOrder extends BaseRequest
{
    public function wantsToChangeOrderStatus(Order $order): bool;

    public function getStatus(): string;
}
