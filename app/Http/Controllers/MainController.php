<?php
//test
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;


class mainController extends Controller
{
public function __construct()
	{
		//$this->middleware('auth')->except(['index']);

	}

	public function main(Request $request) {
		if ($request->has("view_dele")) $view_dele=$request->input("view_dele");
		$elenco="";
		return view('all_views/main',compact('elenco'));
	}
	
	

}
