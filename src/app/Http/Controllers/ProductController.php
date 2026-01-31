<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\SellRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'mylist' && !Auth::check()) {
            return redirect()->guest(route('login'));
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
        ->withExists('purchasedUsers')
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


    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('categories', 'conditions'));
    }


    public function storeProduct(SellRequest $request)
    {
        $user = auth()->user();

        $sell = $request->only('product_name', 'brand', 'description', 'condition', 'price' ,'categories');

        $file = $request->file('product_image');
        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
        if ($image === false) {
            return back()->withErrors(['product_image' => '画像の読み込みに失敗しました。'])->withInput();
        }

        $product = Product::create([
            'product_name' => $sell['product_name'],
            'brand' => $sell['brand'],
            'description' => $sell['description'],
            'condition_id' => $sell['condition'],
            'price' => $sell['price'],
            'user_id' => $user['id'],
        ]);

        $dir = storage_path('app/public/images/products');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'product_' . $product['id'] . '.jpg';
        $path = $dir . '/' . $filename;
        imagejpeg($image, $path, 90);
        imagedestroy($image);

        $filepath = 'products/' . $filename;

        $product->update(['image_path' => $filepath]);
        $product->categories()->sync($sell['categories']);

        return redirect()->route('item.detail', ['item_id' => $product->id]);

    }

}
