<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Customer\Interfaces\CustomerInterface;

class CustomerController extends Controller
{
    public function __construct(private CustomerInterface $customer) {}

    public function get(int $customerId): ?array
    {
        return $this->customer->get($customerId);
    }
}
