<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Shop\Contracts\Requests\CreatePropertyValueForm as CreatePropertyValueFormContract;
use Vanilo\Properties\Contracts\PropertyValue;
use Vanilo\Properties\Models\PropertyValueProxy;

class CreatePropertyValueForm extends FormRequest implements CreatePropertyValueFormContract
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getNextPriority(PropertyValue $propertyValue): int
    {
        $lastNeighbour = PropertyValueProxy::byProperty($propertyValue->property_id)->sortReverse()->first();

        return $lastNeighbour ? $lastNeighbour->priority + 10 : 10;
    }
}
