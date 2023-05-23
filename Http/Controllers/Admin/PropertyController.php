<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use Modules\Shop\Contracts\Requests\CreateProperty;
use Modules\Shop\Contracts\Requests\UpdateProperty;
use Modules\Shop\Traits\CreatesMediaFromRequestImages;
use Vanilo\Properties\Contracts\Property;
use Vanilo\Properties\Models\PropertyProxy;
use Vanilo\Properties\PropertyTypes;

class PropertyController extends BaseController
{
    use CreatesMediaFromRequestImages;

    public function index()
    {
        return view('shop-admin::property.index', [
            'properties' => PropertyProxy::paginate(100)
        ]);
    }

    public function create()
    {
        return view('shop-admin::property.create', [
            'property' => app(Property::class),
            'types' => PropertyTypes::choices()
        ]);
    }

    public function store(CreateProperty $request)
    {
        try {
            $property = PropertyProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $property->name]));
            $this->createMedia($property, $request);
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.property.index'));
    }

    public function show(Property $property)
    {
        return view('shop-admin::property.show', ['property' => $property]);
    }

    public function edit(Property $property)
    {
        return view('shop-admin::property.edit', [
            'property' => $property,
            'types' => PropertyTypes::choices()
        ]);
    }

    public function update(Property $property, UpdateProperty $request)
    {
        try {
            $property->update($request->except('images'));

            flash()->success(__(':name has been updated', ['name' => $property->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.property.index'));
    }

    public function destroy(Property $property)
    {
        try {
            $name = $property->name;
            $property->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('shop.admin.property.index'));
    }
}
