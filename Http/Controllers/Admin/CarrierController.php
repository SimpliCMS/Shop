<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use Modules\Shop\Contracts\Requests\CreateCarrier;
use Modules\Shop\Contracts\Requests\UpdateCarrier;
use Vanilo\Shipment\Contracts\Carrier;
use Vanilo\Shipment\Models\CarrierProxy;

class CarrierController extends BaseController
{
    public function index()
    {
        return view('shop-admin::carrier.index', [
            'carriers' => CarrierProxy::all()
        ]);
    }

    public function create()
    {
        $carrier = app(Carrier::class);
        $carrier->name = ''; // Can be removed after Vanilo 4, once the interface's name() method gets renamed

        return view('shop-admin::carrier.create', [
            'carrier' => $carrier,
        ]);
    }

    public function store(CreateCarrier $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $carrier = CarrierProxy::create($attributes);
            flash()->success(__(':name has been created', ['name' => $carrier->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.carrier.index'));
    }

    public function show(Carrier $carrier)
    {
        return view('shop-admin::carrier.show', ['carrier' => $carrier]);
    }

    public function edit(Carrier $carrier)
    {
        return view('shop-admin::carrier.edit', [
            'carrier' => $carrier,
        ]);
    }

    public function update(Carrier $carrier, UpdateCarrier $request)
    {
        try {
            $attributes = $request->validated();
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $carrier->update($attributes);

            flash()->success(__(':name has been updated', ['name' => $carrier->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.carrier.index'));
    }

    public function destroy(Carrier $carrier)
    {
        try {
            $name = $carrier->name;
            $carrier->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('shop.admin.carrier.index'));
    }
}
