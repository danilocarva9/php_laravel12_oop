<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Order\Providers\OrderServiceProvider::class,
    Modules\Product\Providers\ProductServiceProvider::class,
    Modules\Payment\Providers\PaymentServiceProvider::class,
    Modules\Shipment\Providers\ShipmentServiceProvider::class,
    Modules\Customer\Providers\CustomerServiceProvider::class,
    Modules\Cart\Providers\CartServiceProvider::class,
];
