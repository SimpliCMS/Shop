@extends('appshell::layouts.private')

@section('title')
    {{ __('Editing') }} {{ $channel->name }}
@stop

@section('content')
{!! Form::model($channel, [
        'route'  => ['shop.admin.channel.update', $channel],
        'method' => 'PUT'
    ])
!!}

    <div class="card card-accent-secondary">
        <div class="card-header">
            {{ __('Channel Details') }}
        </div>

        <div class="card-body">
            @include('shop-admin::channel._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('Save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('Cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
