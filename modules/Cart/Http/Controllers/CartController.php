<?php

namespace Modules\Cart\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Cart\Http\Requests\AddRequest;
use Modules\Cart\Interfaces\CartInterface;

class CartController extends Controller
{
    public function __construct(private CartInterface $cart) {}

    public function add(AddRequest $request): array
    {
        $data = $request->all();
        return $this->cart->add($data['product_id'], $data['quantity']);
    }

    public function list(): ?array
    {
        return $this->cart->list();
    }
}
