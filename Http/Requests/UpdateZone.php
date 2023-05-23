<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\Address\Models\ZoneScopeProxy;
use Modules\Shop\Contracts\Requests\UpdateZone as UpdateZoneContract;

class UpdateZone extends FormRequest implements UpdateZoneContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:1|max:255',
            'scope' => ['required', Rule::in(ZoneScopeProxy::values())],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
