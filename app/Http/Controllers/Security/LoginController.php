<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function showLogin() {
        // Don't show log in page if user already logged in.
        if (Auth::check()) {
            return redirect()->route('app.home');
        }

        return view('security.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $validationRules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $this->validate($request, $validationRules);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('app.home'));
        } else {
            return redirect()->route('security.login')
                ->withErrors(['credentials' => trans('validation.error_credentials')]);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        
        return redirect()->route('app.home');
    }
}
