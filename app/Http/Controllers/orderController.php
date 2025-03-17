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

class orderController extends AjaxController
{
//estendo AjaxController per i metodi e proprietà di quella classe
public function __construct()
	{
		parent::__construct();
		
	}

	public function order(Request $request) {
		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;

		$id_user = Auth::user()->id;
		$id_order_view=$request->input('id_order_view');

		$lista_ordini=DB::table('ordini_ref as o')
		->select('o.id','o.stato','o.ship_date','tracker','o.ship_date_estimated','o.created_at')
		->where('id_user','=',$id_user)
		->get();	
		
		$lista_articoli=array();
		if ($id_order_view>0) {
			$lista_articoli=DB::table('ordini as o')
			->join('allestimento as a','o.id_articolo','a.id')
			->select('o.id','o.lotto','o.id_articolo','a.id_molecola','a.id_pack','a.id_pack_qty','o.created_at')
			->where('o.id_ordine','=',$id_order_view)
			->get();		
		}	


		return view('all_views/order',compact('id_user','molecola','molecole_info','lista_articoli','packaging','pack_qty_id','lista_ordini','id_order_view'));
				
	}



}
