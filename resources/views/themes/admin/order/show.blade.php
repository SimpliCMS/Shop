@extends('appshell::layouts.private')

@section('title')
    {{ __('Order :no', ['no' => $order->number]) }}
@stop

@section('content')

    <div class="card-deck mb-3">
        @include('shop-admin::order.show._cards')
    </div>

    <div class="card-deck mb-3">
        @include('shop-admin::order.show._addresses')
        @include('shop-admin::order.show._details')
    </div>

    <div class="row">

        <div class="col-12 col-md-8">
            @include('shop-admin::order.show._items')
        </div>

        <div class="col-12 col-md-4">
            @include('shop-admin::order.show._payment')
            @if(null !== $order->shipping_address_id)
                @include('shop-admin::order.show._shipment')
            @endif
        </div>
    </div>

    @include('shop-admin::order.show._actions')

@stop
