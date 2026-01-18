<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Like;
use App\Http\Requests\ProductRequest;
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

    public function detail ($item_id){
        $product = Product::with(['categories', 'condition', 'likedUsers', 'comments' => function ($query) {
                $query->with('user')->orderBy('sequence');
            },
        ])->withCount(['likedUsers as likes_count', 'comments as comments_count'])
        ->findOrFail($item_id);
        return view('detail', compact('product'));
    }

    public function storeComment(ProductRequest $request, $item_id)
    {
        if (!Auth::check()) {
            return redirect()->route('item.detail', ['item_id' => $item_id]);
        }


        $nextSequence = Comment::where('product_id', $item_id)->max('sequence');
        $nextSequence = $nextSequence ? $nextSequence + 1 : 1;

        $comment = $request->input('comment');

        Comment::create([
            'product_id' => $item_id,
            'sequence' => $nextSequence,
            'user_id' => Auth::id(),
            'comment' => $comment,
        ]);

        return redirect()->route('item.detail', ['item_id' => $item_id]);
    }

    public function toggleLike(Request $request, $item_id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $like = Like::where('user_id', Auth::id())
            ->where('product_id', $item_id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'product_id' => $item_id,
            ]);
        }

        return redirect()->route('item.detail', ['item_id' => $item_id]);
    }

}
