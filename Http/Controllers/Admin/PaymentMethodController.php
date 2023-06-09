<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use Modules\Shop\Contracts\Requests\CreatePaymentMethod;
use Modules\Shop\Contracts\Requests\UpdatePaymentMethod;
use Vanilo\Payment\Contracts\PaymentMethod;
use Vanilo\Payment\Models\PaymentMethodProxy;
use Vanilo\Payment\PaymentGateways;

class PaymentMethodController extends BaseController
{
    public function index()
    {
        return view('shop-admin::payment-method.index', [
            'paymentMethods' => PaymentMethodProxy::all()
        ]);
    }

    public function create()
    {
        return view('shop-admin::payment-method.create', [
            'paymentMethod' => app(PaymentMethod::class),
            'gateways' => PaymentGateways::choices(),
        ]);
    }

    public function store(CreatePaymentMethod $request)
    {
        try {
            $guardedAttributes = app(PaymentMethodProxy::modelClass())->getGuarded();
            $attributes = $request->except($guardedAttributes);
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $paymentMethod = PaymentMethodProxy::create($attributes);
            flash()->success(__(':name has been created', ['name' => $paymentMethod->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.payment-method.index'));
    }

    public function show(PaymentMethod $paymentMethod)
    {
        return view('shop-admin::payment-method.show', ['paymentMethod' => $paymentMethod]);
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('shop-admin::payment-method.edit', [
            'paymentMethod' => $paymentMethod,
            'gateways' => PaymentGateways::choices(),
        ]);
    }

    public function update(PaymentMethod $paymentMethod, UpdatePaymentMethod $request)
    {
        try {
            $guardedAttributes = $paymentMethod->getGuarded();
            $attributes = $request->except($guardedAttributes);
            $attributes['configuration'] = json_decode($attributes['configuration']);
            $paymentMethod->update($attributes);

            flash()->success(__(':name has been updated', ['name' => $paymentMethod->getName()]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.payment-method.index'));
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            $name = $paymentMethod->getName();
            $paymentMethod->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('shop.admin.payment-method.index'));
    }
}
