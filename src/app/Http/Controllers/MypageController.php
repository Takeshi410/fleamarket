<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\MypageRequest;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $page = request('page', 'sell');

        $sellProducts = Product::where('user_id', $user->id)
            ->withExists('purchasedUsers')
            ->latest()
            ->get();

        $buyProducts = Product::whereHas('purchasedUsers', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('mypages.index', compact('user', 'page', 'sellProducts', 'buyProducts'));
    }


    public function profile()
    {
        $user = auth()->user();
        $from = request('from');

        return view('mypages.profile', compact('user', 'from'));
    }


    public function update(MypageRequest $request)
    {
        $user = auth()->user();


        $profile = $request->only(['username', 'postcode', 'address', 'building']);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
            if ($image === false) {
                return back()->withErrors(['avatar' => '画像の読み込みに失敗しました。'])->withInput();
            }

            $dir = storage_path('app/public/images/avatar');

            // 対象ディレクトリがない場合は作成
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // 画像ファイル保存名とGDによるファイル形式の設定
            $filename = 'avatar_' . $user->id . '.jpg';
            $path = $dir . '/' . $filename;
            imagejpeg($image, $path, 90);
            imagedestroy($image);

            $profile['avatar_path'] = 'avatar/' . $filename;
        }

        $user->update($profile);

        //マイページから遷移した場合はマイページにリダイレクト
        if ($request->input('from') === 'mypage') {
            return redirect()->route('mypage.index');
        }

        return redirect()->route('index');
    }
}
