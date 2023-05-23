<?php

namespace Modules\Shop\Contracts\Requests;

use Illuminate\Database\Eloquent\Model;
use Konekt\Concord\Contracts\BaseRequest;

interface SyncModelPropertyValues extends BaseRequest
{
    /**
     * Returns the model for which the property values have to be updated
     *
     * @return null|Model
     */
    public function getFor();

    public function getPropertyValueIds(): array;
}
