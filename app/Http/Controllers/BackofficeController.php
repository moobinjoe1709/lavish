<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;

class BackofficeController extends Controller
{
	public function dashboard()
	{
		return view('dashboard/index');
	}
	
	public function logout(){
		Auth::logout();
		return redirect('/');
	}
}
