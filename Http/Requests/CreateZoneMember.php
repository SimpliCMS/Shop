<?php

namespace Modules\Shop\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Konekt\Address\Models\ZoneMemberType;
use Konekt\Address\Models\ZoneMemberTypeProxy;
use Modules\Shop\Contracts\Requests\CreateZoneMember as CreateZoneMemberContract;

class CreateZoneMember extends FormRequest implements CreateZoneMemberContract
{
    public function rules(): array
    {
        return [
            'member_type' => ['required', Rule::in(ZoneMemberTypeProxy::values())],
            'member_id' => $this->getMemberIdRule(),
        ];
    }

    public function authorize()
    {
        return true;
    }

    private function getMemberIdRule(): string
    {
        return match ($this->input('member_type')) {
            ZoneMemberType::COUNTRY => 'required|exists:countries,id',
            ZoneMemberType::PROVINCE => 'required|exists:provinces,id',
            default => 'required',
        };
    }
}
