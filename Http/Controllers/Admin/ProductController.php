<?php

namespace Modules\Shop\Http\Controllers\Admin;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\LazyCollection;
use Konekt\AppShell\Http\Controllers\BaseController;
use Modules\Shop\Contracts\Requests\CreateProduct;
use Modules\Shop\Contracts\Requests\UpdateProduct;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\MasterProduct\Models\MasterProductProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Properties\Models\PropertyProxy;

class ProductController extends BaseController
{
    public function index()
    {
        LazyCollection::macro('paginate', function ($perPage = 100, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        /** @todo this solution requires significant improvement. It loads all the records in the memory! */
        $products = ProductProxy::query()->with(['taxons', 'media'])->get();
        $masterProducts = MasterProductProxy::query()->with(['taxons', 'media'])->get();

        $items = collect()->push($products, $masterProducts)->lazy()->flatten()->sortByDesc('created_at');

        return view('shop-admin::product.index', [
                'products' => $items->paginate(100)->withPath(route('shop.admin.product.index')),
        ]);
    }

    public function create()
    {
        return view('shop-admin::product.create', [
            'product' => app(Product::class),
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function store(CreateProduct $request)
    {
        try {
            $product = ProductProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $product->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection();
                    });
                }
            } catch (\Exception $e) { // Here we already have the product created
                flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

                return redirect()->route('shop.admin.product.edit', ['product' => $product]);
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.product.index'));
    }

    public function show(Product $product)
    {
        return view('shop-admin::product.show', [
            'product' => $product,
            'taxonomies' => TaxonomyProxy::all(),
            'properties' => PropertyProxy::all()
        ]);
    }

    public function edit(Product $product)
    {
        return view('shop-admin::product.edit', [
            'product' => $product,
            'states' => ProductStateProxy::choices()
        ]);
    }

    public function update(Product $product, UpdateProduct $request)
    {
        try {
            $product->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $product->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('shop.admin.product.show', $product));
    }

    public function destroy(Product $product)
    {
        try {
            $name = $product->name;
            $product->propertyValues()->detach();
            $product->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('shop.admin.product.index'));
    }
}
