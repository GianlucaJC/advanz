<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Users;


class resultController extends AjaxController
{
//estendo AjaxController per i metodi e proprietà di quella classe
public function __construct()
	{
		parent::__construct();		
	}

	
	public function send_result(Request $request) {
		$id_user = Auth::user()->id;
		$info=User::select("is_pharma")->where('id','=',$id_user)->first();
		$is_pharma=0;
		if($info) $is_pharma=$info->is_pharma;
		if ($is_pharma==1) return redirect()->away("main_pharma");

		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;

		$id_user = Auth::user()->id;
		
		$lista_ordini=DB::table('ordini as o')
		->join('allestimento as a','o.id_articolo','a.id')
		->select('o.id_articolo','a.id_molecola','a.id_pack','a.id_pack_qty','o.created_at')
		->where('id_user','=',$id_user)
		->groupBy('o.id')
		->get();		


		$lista_upload=DB::table('uploads as a')
		->select('id','filereal','testo_ref','id_molecola','id_pack')
		->where('id_user','=',$id_user)
		->get();
		$arr_up=array();$indice=0;
		foreach($lista_upload as $uploads) {
			$id_up=$uploads->id;
			$id_mol=$uploads->id_molecola;
			$id_p=$uploads->id_pack;
			$filereal=$uploads->filereal;
			$testo_ref=$uploads->testo_ref;
			if (isset($arr_up[$id_mol][$id_p])) 
				$indice=count($arr_up[$id_mol][$id_p]);
			else $indice=0;
			$arr_up[$id_mol][$id_p][$indice]=$id_up."|".$filereal."|".$testo_ref;
		}

		return view('all_views/send_result',compact('id_user','molecola','molecole_info','lista_ordini','packaging','pack_qty_id','arr_up'));
				
	}

	public function delete_up(Request $request) {
		$id_up=$request->input('id_up');
		$info=DB::table('uploads')->select('filereal')->where('id','=',$id_up)->first();
		if($info) {
			$file=$info->filereal;
			@unlink('storage/uploads/'.$file);
			$delete=DB::table('uploads')->where('id','=',$id_up)->delete();
		}
		$risp=array();
		$risp['header']="OK";
		return json_encode($risp);			
	}

	
}
