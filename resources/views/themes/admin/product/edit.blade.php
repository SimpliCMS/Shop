@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $product->name }}
@stop

@section('content')
<div class="row">

    <div class="col-12 col-lg-8 col-xl-9">
        {!! Form::model($product, [
                'route'  => ['shop.admin.product.update', $product],
                'method' => 'PUT'
            ])
        !!}
        <div class="card card-accent-secondary">
            <div class="card-header">
                {{ __('Product Data') }}
            </div>
            <div class="card-body">
                @include('shop-admin::product._form')
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">{{ __('Save') }}</button>
                <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-12 col-lg-4 col-xl-3">
        @include('admin::partials.media._edit', ['model' => $product])
    </div>

</div>
@stop
