<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function SecretaryDashboard(){
        return view('secretary.secretary_dashboard');
    }//End of
}
