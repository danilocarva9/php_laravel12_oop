<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Core\Providers\CoreServiceProvider::class,
    Modules\User\Providers\UserServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Order\Providers\OrderServiceProvider::class,
    Modules\Product\Providers\ProductServiceProvider::class,
    Modules\Payment\Providers\PaymentServiceProvider::class,
    Modules\Shipment\Providers\ShipmentServiceProvider::class,
    Modules\Customer\Providers\CustomerServiceProvider::class,
    Modules\Cart\Providers\CartServiceProvider::class,
];
