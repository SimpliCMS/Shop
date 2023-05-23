<?php

namespace Modules\Shop\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\Menu\Facades\Menu;

class AdminMenuServiceProvider extends ServiceProvider {

    public function boot() {
        $this->app->booted(function () {
            // Add default menu items to sidebar
            if ($adminMenu = Menu::get('admin')) {
                $shop = $adminMenu->addItem('shop', __('Shop'))->data('order', 11);
                $shop->addSubItem('carriers', __('Carriers'), ['route' => 'shop.admin.carrier.index'])
                        ->data('icon', 'carrier')
                        ->activateOnUrls(route('shop.admin.carrier.index', [], false) . '*')
                        ->allowIfUserCan('list carriers');
                $shop->addSubItem('categories', __('Categorization'), ['route' => 'shop.admin.taxonomy.index'])
                        ->data('icon', 'taxonomies')
                        ->activateOnUrls(route('shop.admin.taxonomy.index', [], false) . '*')
                        ->allowIfUserCan('list taxonomies');
                $shop->addSubItem('channels', __('Channels'), ['route' => 'shop.admin.channel.index'])
                        ->data('icon', 'channel')
                        ->activateOnUrls(route('shop.admin.channel.index', [], false) . '*')
                        ->allowIfUserCan('list channels');
                $shop->addSubItem('payment-methods', __('Payment Methods'), ['route' => 'shop.admin.payment-method.index'])
                        ->data('icon', 'payment-method')
                        ->activateOnUrls(route('shop.admin.payment-method.index', [], false) . '*')
                        ->allowIfUserCan('list payment methods');
                $shop->addSubItem('products', __('Products'), ['route' => 'shop.admin.product.index'])
                        ->data('icon', 'product')
                        ->activateOnUrls(route('shop.admin.product.index', [], false) . '*')
                        ->allowIfUserCan('list products');
                $shop->addSubItem('product_properties', __('Product Properties'), ['route' => 'shop.admin.property.index'])
                        ->data('icon', 'properties')
                        ->activateOnUrls(route('shop.admin.property.index', [], false) . '*')
                        ->allowIfUserCan('list properties');
                $shop->addSubItem('orders', __('Orders'), ['route' => 'shop.admin.order.index'])
                        ->data('icon', 'bag')
                        ->activateOnUrls(route('shop.admin.order.index', [], false) . '*')
                        ->allowIfUserCan('list orders');
                $shop->addSubItem('shipping-methods', __('Shipping Methods'), ['route' => 'shop.admin.shipping-method.index'])
                        ->data('icon', 'shipping')
                        ->activateOnUrls(route('shop.admin.shipping-method.index', [], false) . '*')
                        ->allowIfUserCan('list shipping methods');
                $shop->addSubItem('zones', __('Zones'), ['route' => 'shop.admin.zone.index'])
                        ->data('icon', 'zone')
                        ->activateOnUrls(route('shop.admin.zone.index', [], false) . '*')
                        ->allowIfUserCan('list zones');
            }
        });
    }

    public function register() {
        
    }

    private function routeWildcard(string $route): string {
        if (0 === strlen($path = parse_url(route($route), PHP_URL_PATH))) {
            return '';
        }

        if ('/' === $path[0]) {
            $path = substr($path, 1);
        }

        return "$path*";
    }

}
