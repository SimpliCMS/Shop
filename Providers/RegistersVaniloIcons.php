<?php

namespace Modules\Shop\Providers;

use Konekt\AppShell\Icons\FontAwesome6IconTheme;
use Konekt\AppShell\Icons\FontAwesomeIconTheme;
use Konekt\AppShell\Icons\LineIconsTheme;
use Konekt\AppShell\Icons\ZmdiIconTheme;
use Konekt\AppShell\Traits\ExtendsIconThemes;
use Konekt\AppShell\Traits\RegistersEnumIcons;
use Vanilo\Order\Models\OrderStatus;

trait RegistersVaniloIcons
{
    use ExtendsIconThemes;
    use RegistersEnumIcons;

    private array $icons = [
        'channel' => [
            ZmdiIconTheme::ID => 'portable-wifi',
            LineIconsTheme::ID => 'signal',
            FontAwesomeIconTheme::ID => 'satellite-dish'
        ],
        'zone' => [
            ZmdiIconTheme::ID => 'globe',
            LineIconsTheme::ID => 'map',
            FontAwesomeIconTheme::ID => 'map-marked-alt',
            FontAwesome6IconTheme::ID => 'map-location-dot'
        ],
        'product' => [
            ZmdiIconTheme::ID => 'layers',
            LineIconsTheme::ID => 'layers',
            FontAwesomeIconTheme::ID => 'layer-group'
        ],
        'product-off' => [
            ZmdiIconTheme::ID => 'layers-off',
            LineIconsTheme::ID => 'cross-circle',
            FontAwesomeIconTheme::ID => 'times-circle'
        ],
        'sku' => [
            ZmdiIconTheme::ID => 'code-setting',
            LineIconsTheme::ID => 'shortcode',
            FontAwesomeIconTheme::ID => 'barcode'
        ],
        'stock' => [
            ZmdiIconTheme::ID => 'chart',
            LineIconsTheme::ID => 'bar-chart',
            FontAwesomeIconTheme::ID => 'chart-bar'
        ],
        'bag' => [
            ZmdiIconTheme::ID => 'mall',
            LineIconsTheme::ID => 'shopping-basket',
            FontAwesomeIconTheme::ID => 'shopping-bag'
        ],
        'properties' => [
            ZmdiIconTheme::ID => 'collection-bookmark',
            LineIconsTheme::ID => 'bookmark-alt',
            FontAwesomeIconTheme::ID => 'list-alt'
        ],
        'property' => [
            ZmdiIconTheme::ID => 'bookmark',
            LineIconsTheme::ID => 'bookmark',
            FontAwesomeIconTheme::ID => 'bookmark'
        ],
        'property-value' => [
            ZmdiIconTheme::ID => 'format-indent-increase',
            LineIconsTheme::ID => 'indent-increase',
            FontAwesomeIconTheme::ID => 'indent'
        ],
        'taxonomies' => [
            ZmdiIconTheme::ID => 'device-hub',
            LineIconsTheme::ID => 'vector',
            FontAwesomeIconTheme::ID => 'sitemap'
        ],
        'taxonomy' => [
            ZmdiIconTheme::ID => 'folder-outline',
            LineIconsTheme::ID => 'files',
            FontAwesomeIconTheme::ID => 'folder-open'
        ],
        'taxon' => [
            ZmdiIconTheme::ID => 'file',
            LineIconsTheme::ID => 'empty-file',
            FontAwesomeIconTheme::ID => 'file'
        ],
        'pending' => [
            ZmdiIconTheme::ID => 'spinner',
            LineIconsTheme::ID => 'spinner',
            FontAwesomeIconTheme::ID => 'spinner'
        ],
        'completed' => [
            ZmdiIconTheme::ID => 'check-circle',
            LineIconsTheme::ID => 'checkmark-circle',
            FontAwesomeIconTheme::ID => 'check-circle'
        ],
        'cancelled' => [
            ZmdiIconTheme::ID => 'close-circle-o',
            LineIconsTheme::ID => 'cross-circle',
            FontAwesomeIconTheme::ID => 'times-circle'
        ],
        'payment-method' => [
            ZmdiIconTheme::ID => 'card',
            LineIconsTheme::ID => 'credit-cards',
            FontAwesomeIconTheme::ID => 'credit-card'
        ],
        'carrier' => [
            ZmdiIconTheme::ID => 'truck',
            LineIconsTheme::ID => 'delivery',
            FontAwesomeIconTheme::ID => 'truck'
        ],
        'shipping' => [
            ZmdiIconTheme::ID => 'bike',
            LineIconsTheme::ID => 'upload',
            FontAwesomeIconTheme::ID => 'truck-loading'
        ],
    ];

    private array $enumIcons = [
        OrderStatus::class => [
            OrderStatus::PENDING => 'pending',
            OrderStatus::COMPLETED => 'completed',
            OrderStatus::CANCELLED => 'cancelled'
        ],
    ];
}
