<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected $redirectTo = '/admin';

    public function login()
    {
        return redirect('/admin/post');
    }
}
