<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App as AppFac;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function home()
    {
        return view('app.home');
    }

    public function secret()
    {
        return view('app.secret');
    }

    public function session(Request $request)
    {
        $allowedSessionKeys = ['sidebar_locked'];

        if (request()->ajax()) {
            $jsonData = json_decode($request->getContent(), true);
            if (array_key_exists ('session_data', $jsonData)) {
                foreach ($jsonData['session_data'] as $key => $value) {
                    if (in_array($key, $allowedSessionKeys)) {
                        Session::put([$key => $value]);
                    }
                }
            }
            return response()->json(); 
        }
        else {
            AppFac::abort(404, 'Page not found.');
        }
    }
}
