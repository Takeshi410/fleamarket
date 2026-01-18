<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request, $item_id)
    {
        $product = Product::find($item_id);
        return view('purchases.purchase', compact('product'));
    }
}
