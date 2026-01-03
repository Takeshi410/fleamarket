<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'mylist' && !Auth::check()) {
            return view('index', ['products' => collect(), 'tab' => $tab]);
        }

        $query = Product::with('likedUsers')->withExists('purchasedUsers');

        if (Auth::check()) {
            $query->where('products.user_id', '!=', Auth::id());

            if ($tab === 'mylist') {
                $query->whereHas('likedUsers', function ($q) {
                    $q->where('users.id', Auth::id());
                });
            }
        }

        $products = $query->get();

        return view('index', compact('products', 'tab'));
    }


public function search(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'mylist' && !Auth::check()) {
            return view('index', ['products' => collect(), 'tab' => $tab]);
        }

        $query = Product::with('likedUsers')->withExists('purchasedUsers')->keywordSearch($request->keyword);

        if (Auth::check()) {
            $query->where('products.user_id', '!=', Auth::id());

            if ($tab === 'mylist') {
                $query->whereHas('likedUsers', function ($q) {
                    $q->where('users.id', Auth::id());
                });
            }
        }

        $products = $query->get();

        return view('index', compact('products', 'tab'));
    }
}
