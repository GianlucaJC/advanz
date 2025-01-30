<?php
//test
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Users;

class mainController extends Controller
{
public function __construct()
	{
		//$this->middleware('auth')->except(['index']);

	}

	public function save_user($request) {
		try {
			$pw_c=bcrypt($request->input("password"));
			$user=new user;
			$user->istituto=$request->input("istituto");
			$user->prefix=$request->input("prefix");
			$user->name=$request->input("first_name");
			$user->first_name=$request->input("first_name");
			$user->last_name=$request->input("last_name");
			$user->position=$request->input("position");
			$user->department=$request->input("department");
			$user->shipping_address1=$request->input("shipping_address1");
			$user->shipping_address2=$request->input("shipping_address2");
			$user->country=$request->input("country");
			$user->state=$request->input("state");
			$user->city=$request->input("city");
			$user->postal_code=$request->input("postal_code");
			$user->email_ref=$request->input("email_ref");
			$user->phone=$request->input("phone");
			$user->fax=$request->input("fax");
			$user->email=$request->input("email");
			$user->password=$pw_c;
			$user->save();
			return 1;	
		} catch (\Exception $e) {
			//dd($e);
			return 2;
		}		
	}	

	public function main(Request $request) {
		$login=false;
		if (Auth::user()) $login=true;
		$save_user=0;
		if ($request->has('btn_reg')) {
			 $save_user=$this->save_user($request);
		}
		
		return view('all_views/main',compact('login','save_user'));
	}
	
	

}
