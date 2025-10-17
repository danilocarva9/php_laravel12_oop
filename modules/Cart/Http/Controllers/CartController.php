<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Cart\Http\Requests\CreateRequest;
use Modules\Cart\Interfaces\CartInterface;

class CartController extends Controller
{
    public function __construct(private CartInterface $cart) {}

    public function create(CreateRequest $request): array
    {
        $data = $request->all();
        return $this->cart->create($data);
    }

    public function get(int $cartId): ?array
    {
        return $this->cart->get($cartId);
    }
}
