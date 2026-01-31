<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($item_id);

        $shippingAddress = $user->shippingAddresses()
        ->where('product_id', $item_id)
        ->first();

        $addressData = $shippingAddress ?: $user;

        return view('purchases.purchase', compact('product', 'addressData'));
    }


    public function checkout(PurchaseRequest $request, $item_id)
    {
        $method = $request->input('payment_method');
        $user = auth()->user();

        $product = Product::findOrFail($item_id);

        Purchase::create([
            'product_id' => $item_id,
            'user_id' => $user->id,
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => [$method],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $product->product_name],
                    'unit_amount' => $product->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('index'),
            'cancel_url' => route('index'),
        ]);

        return redirect($session->url);
    }


    public function address($item_id) {
        $user = auth()->user();

        $shippingAddress = $user->shippingAddresses()
        ->where('product_id', $item_id)
        ->first();

        $addressData = $shippingAddress ?: $user;

        return view('purchases.address', compact('addressData', 'item_id'));
    }


    public function update(AddressRequest $request, $item_id) {
        $user = auth()->user();
        $address = $request->only(['postcode', 'address', 'building']);
        ShippingAddress::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $item_id,
            ],
            $address
        );


        return redirect()->route('purchase.index', ['item_id' => $item_id]);
    }
}
