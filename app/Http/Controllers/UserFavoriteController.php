<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function store(Request $request, $micropost)
    {
        \Auth::user()->favorite($micropost);
        return redirect()->back();
    }

    public function destroy($micropost)
    {
        \Auth::user()->unfavorite($micropost);
        return redirect()->back();
    }
    
    public function index(Request $request, $id)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->favoritings()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
            $data += $this->counts($user);
            return view('users.favoritings', $data);
        }
            return view('welcome');
    }    
}
