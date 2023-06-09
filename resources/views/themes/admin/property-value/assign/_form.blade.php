<div id="properties-assign-component" x-data="vaniloPropertyValues">
<div id="properties-assign-to-model-modal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="properties-assign-to-model-modal-title" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'url'  => route('shop.admin.property_value.sync', [$for, $forId]),
                    'method' => 'PUT'
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title" id="properties-assign-to-model-modal">{{ __('Assign Properties') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-condensed table-striped">
                    <tbody>
                    <template x-for="(assignedProperty, id) in assignedProperties">
                        <tr :id="id">
                        <th class="align-middle" x-text="assignedProperty.property.name"></th>
                        <td>
                            <select name="propertyValues[]" x-model="assignedProperty.value" @change="onPropertyValueChange($event, id)" class="form-control form-control-sm">
                                <option value=""></option>
                                <template x-for="value in assignedProperty.values">
                                    <option :value="value.id" x-html="value.title" :selected="assignedProperty.value == value.id"></option>
                                </template>
                                <optgroup label="{{ __('Missing value?') }}"></optgroup>
                                <option value="+">[+] {{ __('Add value') }}</option>
                            </select>
                        </td>
                        <td class="align-middle">
                            {!! icon('delete', 'danger', ['style' => 'cursor: pointer', '@click' => 'removePropertyValue(id)']) !!}
                        </td>
                    </tr>
                    </template>
                    </tbody>
                    <tfoot>
                        <tr class="bg-success">
                            <th class="align-middle">{{ __('Unused properties') }}:</th>
                            <td>
                                <select x-model="selected" class="form-control form-control-sm">
                                    <option value="">--</option>
                                    <template x-for="(unassignedProperty, id) in unassignedProperties">
                                        <option :value="id" x-text="unassignedProperty.property.name"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-light btn-sm" type="button" :disabled="selected == ''"
                                        @click="addSelectedPropertyValue()">
                                    {{ __('Use property') }}
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary">{{ __('Save properties') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@include('shop-admin::property-value.assign._create_property_value')

</div>

@push('scripts')

<script>
    document.addEventListener('alpine:init', function() {
        Alpine.data('vaniloPropertyValues', () => ({
            selected: '',
            adding: {
                name: '',
                property_id: ''
            },
            assignedProperties: {
                @foreach($assignments as $propertyValue)
                "{{ $propertyValue->property->id }}": {
                    "value": "{{ $propertyValue->id }}",
                    "property": {
                        "id":  "{{ $propertyValue->property->id }}",
                        "name": "{{ $propertyValue->property->name }}"
                    },
                    "values": [
                        @foreach($propertyValue->property->values() as $value)
                        {
                            "id": "{{ $value->id }}",
                            "title": "{{ $value->title }}"
                        },
                        @endforeach
                    ]
                },
                @endforeach
            },
            unassignedProperties: {
                @foreach($properties->keyBy('id')->except($assignments->map(function ($propertyValue) {
                        return $propertyValue->property->id;
                })->all()) as $unassignedProperty)
                "{{ $unassignedProperty->id }}": {
                    "value": "",
                    "property": {
                        "id": "{{ $unassignedProperty->id }}",
                        "name": "{{ $unassignedProperty->name }}"
                    },
                    "values": [
                            @foreach($unassignedProperty->values() as $value)
                        {
                            "id": "{{ $value->id }}",
                            "title": "{{ $value->title }}"
                        },
                        @endforeach
                    ]
                },
                @endforeach
            },
            addSelectedPropertyValue() {
                if (this.selected && '' !== this.selected) {
                    var property = this.unassignedProperties[this.selected];
                    if (property) {
                        this.assignedProperties[property.property.id] = property;
                        delete this.unassignedProperties[property.property.id];
                    }
                }
            },
            removePropertyValue(propertyId) {
                var property = this.assignedProperties[propertyId];
                if (property) {
                    this.unassignedProperties[propertyId] = property;
                    delete this.assignedProperties[propertyId];
                }
            },
            onPropertyValueChange(event, propertyId) {
                var selected = this.assignedProperties[propertyId].value;
                if ('+' !== selected) {
                    return;
                }

                this.adding.name = this.assignedProperties[propertyId].property.name;
                this.adding.property_id = propertyId;

                var url = "{{ route('shop.admin.property_value.create', '@@@') }}";
                window.open(url.replace('@@@', propertyId), '_blank');
            }
        }))
    })
</script>
@endpush
