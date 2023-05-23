<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Konekt\Address\Contracts\Zone;
use Konekt\Address\Models\ZoneProxy;
use Konekt\Address\Models\ZoneScopeProxy;
use Konekt\AppShell\Http\Controllers\BaseController;
use Modules\Shop\Contracts\Requests\CreateZone;
use Modules\Shop\Contracts\Requests\UpdateZone;

class ZoneController extends BaseController
{
    public function index()
    {
        return view('shop-admin::zone.index', [
            'zones' => ZoneProxy::all(),
        ]);
    }

    public function create()
    {
        $zone = app(Zone::class);

        return view('shop-admin::zone.create', [
            'zone' => $zone,
            'scopes' => ZoneScopeProxy::choices(),
        ]);
    }

    public function store(CreateZone $request)
    {
        try {
            $attributes = $request->validated();
            $zone = ZoneProxy::create($attributes);
            flash()->success(__(':name has been created', ['name' => $zone->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.zone.index'));
    }

    public function show(Zone $zone)
    {
        return view('shop-admin::zone.show', ['zone' => $zone]);
    }

    public function edit(Zone $zone)
    {
        return view('shop-admin::zone.edit', [
            'zone' => $zone,
            'scopes' => ZoneScopeProxy::choices(),
        ]);
    }

    public function update(Zone $zone, UpdateZone $request)
    {
        try {
            $zone->update($request->validated());

            flash()->success(__(':name has been updated', ['name' => $zone->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.zone.index'));
    }

    public function destroy(Zone $zone)
    {
        try {
            $name = $zone->name;
            $zone->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('shop.admin.zone.index'));
    }
}
