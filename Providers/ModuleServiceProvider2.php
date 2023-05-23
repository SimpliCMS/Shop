<?php

declare(strict_types=1);

/**
 * Contains the ModuleServiceProvider class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-10-09
 *
 */

namespace Vanilo\Admin\Providers;

use Konekt\Address\Models\ZoneScope;
use Konekt\Address\Models\ZoneScopeProxy;
use Konekt\AppShell\Acl\ResourcePermissionMapper;
use Konekt\AppShell\Breadcrumbs\HasBreadcrumbs;
use Konekt\AppShell\EnumColors;
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\Concord\BaseBoxServiceProvider;
use Menu;
use Modules\Shop\Http\Requests\CreateCarrier;
use Modules\Shop\Http\Requests\CreateChannel;
use Modules\Shop\Http\Requests\CreateMasterProduct;
use Modules\Shop\Http\Requests\CreateMasterProductVariant;
use Modules\Shop\Http\Requests\CreateMedia;
use Modules\Shop\Http\Requests\CreatePaymentMethod;
use Modules\Shop\Http\Requests\CreateProduct;
use Modules\Shop\Http\Requests\CreateProperty;
use Modules\Shop\Http\Requests\CreatePropertyValue;
use Modules\Shop\Http\Requests\CreatePropertyValueForm;
use Modules\Shop\Http\Requests\CreateShippingMethod;
use Modules\Shop\Http\Requests\CreateTaxon;
use Modules\Shop\Http\Requests\CreateTaxonForm;
use Modules\Shop\Http\Requests\CreateTaxonomy;
use Modules\Shop\Http\Requests\CreateZone;
use Modules\Shop\Http\Requests\CreateZoneMember;
use Modules\Shop\Http\Requests\SyncModelPropertyValues;
use Modules\Shop\Http\Requests\SyncModelTaxons;
use Modules\Shop\Http\Requests\UpdateCarrier;
use Modules\Shop\Http\Requests\UpdateChannel;
use Modules\Shop\Http\Requests\UpdateMasterProduct;
use Modules\Shop\Http\Requests\UpdateMasterProductVariant;
use Modules\Shop\Http\Requests\UpdateOrder;
use Modules\Shop\Http\Requests\UpdatePaymentMethod;
use Modules\Shop\Http\Requests\UpdateProduct;
use Modules\Shop\Http\Requests\UpdateProperty;
use Modules\Shop\Http\Requests\UpdatePropertyValue;
use Modules\Shop\Http\Requests\UpdateShippingMethod;
use Modules\Shop\Http\Requests\UpdateTaxon;
use Modules\Shop\Http\Requests\UpdateTaxonomy;
use Modules\Shop\Http\Requests\UpdateZone;

class ModuleServiceProvider extends BaseBoxServiceProvider
{
    use HasBreadcrumbs;
    use RegistersVaniloIcons;

    protected $requests = [
        CreateProduct::class,
        UpdateProduct::class,
        CreateMasterProduct::class,
        UpdateMasterProduct::class,
        CreateMasterProductVariant::class,
        UpdateMasterProductVariant::class,
        UpdateOrder::class,
        CreateTaxonomy::class,
        UpdateTaxonomy::class,
        CreateTaxon::class,
        UpdateTaxon::class,
        CreateTaxonForm::class,
        SyncModelTaxons::class,
        CreateMedia::class,
        CreateProperty::class,
        UpdateProperty::class,
        CreatePropertyValueForm::class,
        CreatePropertyValue::class,
        UpdatePropertyValue::class,
        SyncModelPropertyValues::class,
        CreateChannel::class,
        UpdateChannel::class,
        CreatePaymentMethod::class,
        UpdatePaymentMethod::class,
        CreateShippingMethod::class,
        UpdateShippingMethod::class,
        CreateCarrier::class,
        UpdateCarrier::class,
        CreateZone::class,
        UpdateZone::class,
        CreateZoneMember::class,
    ];

    public function boot()
    {
        parent::boot();

        /** @var ResourcePermissionMapper $aclResourceMapper */
        $aclResourceMapper = $this->app->get(ResourcePermissionMapper::class);
        $aclResourceMapper->overrideResourcePlural('taxon', 'taxons');
        $aclResourceMapper->addAlias('master product', 'product');
        $aclResourceMapper->addAlias('master product variant', 'product');
        $aclResourceMapper->addAlias('zone member', 'zone');

        $this->registerIconExtensions();
        $this->registerEnumIcons();
        $this->registerEnumColors();
        $this->loadBreadcrumbs();
        $this->addMenuItems();
    }

    protected function addMenuItems()
    {
        if ($menu = Menu::get('appshell')) {
            $shop = $menu->addItem('shop', __('Shop'));
            $shop->addSubItem('products', __('Products'), ['route' => 'vanilo.admin.product.index'])
                ->data('icon', 'product')
                ->activateOnUrls(route('vanilo.admin.product.index', [], false) . '*')
                ->allowIfUserCan('list products');
            $shop->addSubItem('product_properties', __('Product Properties'), ['route' => 'vanilo.admin.property.index'])
                ->data('icon', 'properties')
                ->activateOnUrls(route('vanilo.admin.property.index', [], false) . '*')
                ->allowIfUserCan('list properties');
            $shop->addSubItem('categories', __('Categorization'), ['route' => 'vanilo.admin.taxonomy.index'])
                ->data('icon', 'taxonomies')
                ->activateOnUrls(route('vanilo.admin.taxonomy.index', [], false) . '*')
                ->allowIfUserCan('list taxonomies');
            $shop->addSubItem('orders', __('Orders'), ['route' => 'vanilo.admin.order.index'])
                ->data('icon', 'bag')
                ->activateOnUrls(route('vanilo.admin.order.index', [], false) . '*')
                ->allowIfUserCan('list orders');

            $settings = $menu->getItem('settings_group');
            $settings->addSubItem('channels', __('Channels'), ['route' => 'vanilo.admin.channel.index'])
                ->data('icon', 'channel')
                ->activateOnUrls(route('vanilo.admin.channel.index', [], false) . '*')
                ->allowIfUserCan('list channels');
            $settings->addSubItem('zones', __('Zones'), ['route' => 'vanilo.admin.zone.index'])
                ->data('icon', 'zone')
                ->activateOnUrls(route('vanilo.admin.zone.index', [], false) . '*')
                ->allowIfUserCan('list zones');
            $settings->addSubItem('payment-methods', __('Payment Methods'), ['route' => 'vanilo.admin.payment-method.index'])
                     ->data('icon', 'payment-method')
                     ->activateOnUrls(route('vanilo.admin.payment-method.index', [], false) . '*')
                     ->allowIfUserCan('list payment methods');
            $settings->addSubItem('shipping-methods', __('Shipping Methods'), ['route' => 'vanilo.admin.shipping-method.index'])
                ->data('icon', 'shipping')
                ->activateOnUrls(route('vanilo.admin.shipping-method.index', [], false) . '*')
                ->allowIfUserCan('list shipping methods');
            $settings->addSubItem('carriers', __('Carriers'), ['route' => 'vanilo.admin.carrier.index'])
                ->data('icon', 'carrier')
                ->activateOnUrls(route('vanilo.admin.carrier.index', [], false) . '*')
                ->allowIfUserCan('list carriers');
        }
    }

    private function registerEnumColors(): void
    {
        EnumColors::registerEnumColor(
            ZoneScopeProxy::enumClass(),
            [
                ZoneScope::SHIPPING => ThemeColor::SUCCESS(),
                ZoneScope::BILLING => ThemeColor::INFO(),
                ZoneScope::TAXATION => ThemeColor::WARNING(),
                ZoneScope::PRICING => ThemeColor::PRIMARY(),
                ZoneScope::CONTENT => ThemeColor::SECONDARY(),
            ]
        );
    }
}
