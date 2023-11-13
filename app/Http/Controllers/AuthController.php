<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $url = '';
        if ($request->user()->role === 'admin'){
            $url = 'admin/dashboard';
        }
        elseif($request->user()->role === 'secretary'){
            $url= 'secretary/dashboard';
        }
        elseif($request->user()->role === 'user'){
            $url = '/dashboard';
        }

        return redirect()->intended($url);
    }
}
