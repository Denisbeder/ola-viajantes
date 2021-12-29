<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;

class AuthController extends LoginController
{
	protected $redirectTo = '/admin/dashboard';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function loggedOut(Request $request)
    {
        return redirect('/admin/login');
    }

}