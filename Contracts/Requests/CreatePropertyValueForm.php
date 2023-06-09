<?php

namespace Modules\Shop\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;
use Vanilo\Properties\Contracts\PropertyValue;

interface CreatePropertyValueForm extends BaseRequest
{
    /**
     * Returns the proposed priority value for a new property value
     *
     * @param PropertyValue $propertyValue
     * @return int
     */
    public function getNextPriority(PropertyValue $propertyValue): int;
}
