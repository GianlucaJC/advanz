<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Users;
use Mail;

use App\Models\carrello;
use App\Models\ordini;
use App\Models\ordini_ref;

class mainAdminController extends AjaxController
{
//estendo AjaxController per i metodi e proprietà di quella classe
public function __construct()
	{
		parent::__construct();
		//eredito questi valori dalla classe originaria

		$this->country=$this->paesi();

		$this->middleware(function ($request, $next) {			
			if (Auth::user()) {
				$id_user = Auth::user()->id;
				$info=User::select("is_admin")->where('id','=',$id_user)->first();
				$is_admin=0;
				if($info) $is_admin=$info->is_admin;
                if ($is_admin==0) return response()->view('all_views/viewmaster/error',compact('id_user'));
                   
			}
			return $next($request);	
		});
	}

	public function paesi() {	
		$paesi=array();    
		$paesi['2']="France";
		$paesi['3']="Austria";
		$paesi['4']="Denmark";
		$paesi['5']="Germany";
		$paesi['6']="Ireland";
		$paesi['7']="Spain";
		$paesi['8']="United Kingdom";
		return $paesi;

	}
	
	public function update_order(Request $request) {
		$id_ordine=$request->input('id_ordine');
		$stato=$request->input('stato');
		$tracker=$request->input('tracker');
		$ship_date=$request->input('ship_date');
		$ship_date_estimated=$request->input('ship_date_estimated');
		
		$ordini_ref = ordini_ref::find($id_ordine);
		$ordini_ref->stato = $request->input('stato');
		$ordini_ref->tracker = $request->input('tracker');
		$ordini_ref->ship_date = $request->input('ship_date');
		$ordini_ref->ship_date_estimated = $request->input('ship_date_estimated');
		$ordini_ref->save();

		$risp=array();
		$risp['header']="OK";
		return json_encode($risp);					
	}
    public function main_admin_order(Request $request) {
		$country=$this->country;


		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;

		$id_user = Auth::user()->id;
		$id_order_view=$request->input('id_order_view');
		
		$lista_user=User::select("*")->get();
		$arr_user=array();
		foreach($lista_user as $lu) {
			$arr_user[$lu->id]=$lu;
		}

		$lista_ordini=DB::table('ordini_ref as o')
		->select('o.id','o.stato','o.id_user','o.ship_date','tracker','o.ship_date_estimated','o.created_at')
		->orderBy('id_user')
		->get();	
		

		$lista_articoli=array();
		if ($id_order_view>0) {
			$lista_articoli=DB::table('ordini as o')
			->join('allestimento as a','o.id_articolo','a.id')
			->select('o.id','o.id_ordine','o.id_user','o.lotto','o.id_articolo','a.id_molecola','a.id_pack','a.id_pack_qty','o.created_at')
			->where('o.id_ordine','=',$id_order_view)
			->get();		
		}	


		return view('all_views/main_admin_order',compact('id_user','molecola','molecole_info','lista_articoli','packaging','pack_qty_id','lista_ordini','id_order_view','arr_user','country'));
        
    }



	public function main_pharma(Request $request) {
		$country=$this->country;


		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;

		$id_user = Auth::user()->id;
		$id_order_view=$request->input('id_order_view');
		
		$lista_user=User::select("*")->get();
		$arr_user=array();
		foreach($lista_user as $lu) {
			$arr_user[$lu->id]=$lu;
		}

		$lista_ordini=DB::table('ordini_ref as o')
		->select('o.id','o.stato','o.id_user','o.ship_date','tracker','o.ship_date_estimated','o.created_at')
		->orderBy('id_user')
		->get();	
		

		$lista_articoli=array();
		if ($id_order_view>0) {
			$lista_articoli=DB::table('ordini as o')
			->join('allestimento as a','o.id_articolo','a.id')
			->select('o.id','o.id_ordine','o.id_user','o.lotto','o.id_articolo','a.id_molecola','a.id_pack','a.id_pack_qty','o.created_at')
			->where('o.id_ordine','=',$id_order_view)
			->get();		
		}	


		return view('all_views/main_pharma',compact('id_user','molecola','molecole_info','lista_articoli','packaging','pack_qty_id','lista_ordini','id_order_view','arr_user','country'));

	}


}
