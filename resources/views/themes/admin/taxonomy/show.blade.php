@extends('appshell::layouts.private')

@section('title')
    {{ $taxonomy->name }}
@stop

@section('content')

    <style>
        .card-actionbar-show-on-hover {
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
        }

        .card-body:hover > .card-actionbar-show-on-hover {
            opacity: 1;
        }
    </style>

<div class="row">

    <div class="col-12 col-md-6 col-lg-8 col-xl-9">
    <div class="card mb-4">
        <div class="card-body">
            <div class="card">
                @include('shop-admin::taxon._tree', ['taxons' => $taxonomy->rootLevelTaxons()])

                @can('create taxons')
                    <div class="card-footer">
                        <a href="{{ route('shop.admin.taxon.create', $taxonomy) }}"
                           class="btn btn-outline-success btn-sm">{{ __('Add :category', ['category' => \Illuminate\Support\Str::singular($taxonomy->name)]) }}</a>
                    </div>
                @endcan
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            @can('edit taxonomies')
                <a href="{{ route('shop.admin.taxonomy.edit', $taxonomy) }}" class="btn btn-outline-primary">{{ __('Edit Category Tree') }}</a>
            @endcan

            @can('delete taxonomies')
                {!! Form::open([
                        'route' => ['shop.admin.taxonomy.destroy', $taxonomy],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('Delete this categorization: ":name"?', ['name' => $taxonomy->name])
                    ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('Delete Category Tree') }}
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
    </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        @include('admin::partials.media._index', ['model' => $taxonomy])
    </div>

</div>

@stop
