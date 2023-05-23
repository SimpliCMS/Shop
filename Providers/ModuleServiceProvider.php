<?php

namespace Modules\Shop\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Illuminate\Support\Facades\DB;
use Vanilo\Cart\Facades\Cart;
use TorMorten\Eventy\Facades\Events as Eventy;
use Modules\Shop\Http\Requests\CreateCarrier;
use Modules\Shop\Http\Requests\CreateChannel;
use Modules\Shop\Http\Requests\CreateMasterProduct;
use Modules\Shop\Http\Requests\CreateMasterProductVariant;
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
use Schema;

class ModuleServiceProvider extends BaseModuleServiceProvider {

    /**
     * The namespace for the module's models.
     *
     * @var string
     */
    protected $modelNamespace = 'Modules\Shop\Models';
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

    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot() {
        parent::boot();
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AdminMenuServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->ViewPaths();
        $this->adminViewPaths();
    }

    public function ViewPaths() {
        $moduleLower = lcfirst('Shop');
        if (Schema::hasTable('settings')) {
            $setting = DB::table('settings')->where('id', 'site.theme')->first();

            if ($setting) {
                $currentTheme = $setting->value;
            } else {
                $currentTheme = 'default';
            }
        } else {
            $currentTheme = 'default';
        }

        $views = [
            base_path("themes/$currentTheme/views/modules/Shop"),
            module_Viewpath('Shop', $currentTheme),
            base_path("themes/default/views/modules/Shop"),
            module_Viewpath('Shop', 'default'),
            base_path("resources/views/modules/Shop"),
        ];

        return $this->loadViewsFrom($views, $moduleLower);
    }

    public function adminViewPaths() {
        $moduleLower = lcfirst('Shop');
        $currentTheme = 'admin';
        $views = [
            module_Viewpath('Shop', $currentTheme),
            base_path("themes/$currentTheme/views/modules/Shop"),
        ];

        return $this->loadViewsFrom($views, $moduleLower . '-admin');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register() {
        // Your module's register logic here
        $this->app->concord->registerModule(\Vanilo\Foundation\Providers\ModuleServiceProvider::class,
                $config = [
            'image' => [
                'taxon' => [
                    'variants' => [
                        'thumbnail' => [
                            'width' => 250,
                            'height' => 188,
                            'fit' => 'contain'
                        ],
                        'header' => [
                            'width' => 1110,
                            'height' => 150,
                            'fit' => 'contain'
                        ],
                        'card' => [
                            'width' => 521,
                            'height' => 293,
                            'fit' => 'contain'
                        ]
                    ]
                ],
                'variants' => [
                    'thumbnail' => [
                        'width' => 250,
                        'height' => 188,
                        'fit' => 'fill'
                    ],
                    'medium' => [
                        'width' => 540,
                        'height' => 406,
                        'fit' => 'fill'
                    ]
                ]
            ],
                ]
        );
        $this->app->concord->registerModule(\Vanilo\Adyen\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Braintree\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Euplatesc\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Netopia\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Paypal\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Simplepay\Providers\ModuleServiceProvider::class);
        $this->app->concord->registerModule(\Vanilo\Stripe\Providers\ModuleServiceProvider::class);
    }

}
