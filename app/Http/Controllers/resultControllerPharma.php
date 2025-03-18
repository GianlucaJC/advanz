<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;
use Users;


class resultControllerPharma extends AjaxController
{
//estendo AjaxController per i metodi e proprietà di quella classe
public function __construct()
	{
		parent::__construct();		
	}

	
	public function send_result_pharma(Request $request) {
		$id_user = Auth::user()->id;
		$info=User::select("is_pharma")->where('id','=',$id_user)->first();
		$is_pharma=0;
		if($info) $is_pharma=$info->is_pharma;
		if ($is_pharma==0) return redirect()->away("main_log");

		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;

		$lista_upload=DB::table('uploads as u')
		->select('id','id_user','filereal','testo_ref','id_molecola','id_pack')
		->orderBy('u.id_molecola')
		->orderBy('u.id_pack')
		->get();
		$indice=0;
		$arr_up=array();
		foreach($lista_upload as $lista) {
			$id_molecola=$lista->id_molecola;
			$id_pack=$lista->id_pack;
			$id_union=$id_molecola."_".$id_pack;

			if (!array_key_exists($id_union,$arr_up)) $indice=0;
			else $indice=count($arr_up[$id_union]);
			$arr_up[$id_union][$indice]=$lista;
		}

		return view('all_views/send_result_pharma',compact('molecola','molecole_info','lista_upload','packaging','pack_qty_id','arr_up'));
				
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
