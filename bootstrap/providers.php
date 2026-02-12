<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    Modules\Cart\Providers\CartServiceProvider::class,
    Modules\Core\Providers\CoreServiceProvider::class,
    Modules\Customer\Providers\CustomerServiceProvider::class,
    Modules\Order\Providers\OrderServiceProvider::class,
    Modules\Payment\Providers\PaymentServiceProvider::class,
    Modules\Product\Providers\ProductServiceProvider::class,
    Modules\Shipment\Providers\ShipmentServiceProvider::class,
    Modules\User\Providers\UserServiceProvider::class,
];
