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
		$resp=array();
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
			$resp['esito']=1;
			$resp['err']="";
			return $resp;
		} catch (\Exception $e) {
			//dd($e);
			if (stripos($e,"dupl")>0) $e="The email has already been taken";
			$resp['esito']=2;
			$resp['err']=$e;
			return $resp;
		}		
	}	

	public function post($request) {
		$resp['istituto']=$request->input('istituto');
		$resp['prefix']=$request->input('prefix');
		$resp['name']=$request->input('name');
		$resp['first_name']=$request->input('first_name');
		$resp['last_name']=$request->input('last_name');
		$resp['position']=$request->input('position');
		$resp['department']=$request->input('department');
		$resp['shipping_address1']=$request->input('shipping_address1');
		$resp['shipping_address2']=$request->input('shipping_address2');
		$resp['country']=$request->input('country');
		$resp['state']=$request->input('state');
		$resp['city']=$request->input('city');
		$resp['postal_code']=$request->input('postal_code');
		$resp['email_ref']=$request->input('email_ref');
		$resp['phone']=$request->input('phone');
		$resp['fax']=$request->input('fax');
		$resp['email']=$request->input('email');
		$resp['password']=$request->input('password');
		$resp['password2']=$request->input('password2');
		return $resp;

	}
	public function main(Request $request) {
		$login=false;
		if (Auth::user()) $login=true;
		$save_user=0;$save_user_err="";
		$post=array();
		if ($request->has('btn_reg')) {
			$post=$this->post($request);
			$save=$this->save_user($request);
			$save_user=$save['esito'];
			$save_user_err=$save['err'];
		}
		
		
		return view('all_views/main',compact('login','save_user','save_user_err','post'));
	}
	
	

}
