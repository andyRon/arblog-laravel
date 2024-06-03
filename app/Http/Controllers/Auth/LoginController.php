<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use Authenticatable;
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected $redirectTo = '/admin';

    public function login(Request $request)
    {
        dd(session()->getId());
        echo 123;
        $user = Auth::user();
        dd(Auth::attempt(['email'=>$_POST['email'], 'password' => $_POST['password']]));
        return redirect('/admin/post');
    }
}
