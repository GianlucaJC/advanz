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
		$this->middleware(function ($request, $next) {			
			$id_user = Auth::user()->id;
			$info=User::select("is_pharma")->where('id','=',$id_user)->first();
			$is_pharma=0;
			if($info) $is_pharma=$info->is_pharma;
			if ($is_pharma==0) return response()->view('all_views/viewmaster/error',compact('id_user'));
			return $next($request);	
		});
	}

	
	public function send_result_pharma(Request $request) {


		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;



		$lista_upload=DB::table('uploads as a')
		->select('id','filereal','testo_ref','culture_date','species_name','infection_source','test_method','test_result','id_molecola','id_pack')
		->orderBy('id_molecola')
		->orderBy('id_pack')
		->get();
		$arr_up=array();$indice=0;
		foreach($lista_upload as $uploads) {
			$id_up=$uploads->id;
			$id_mol=$uploads->id_molecola;
			$id_p=$uploads->id_pack;
			$filereal=$uploads->filereal;
			$testo_ref=$uploads->testo_ref;

			$culture_date=$uploads->culture_date;
			$species_name=$uploads->species_name;
			$infection_source=$uploads->infection_source;
			$test_method=$uploads->test_method;
			$test_result=$uploads->test_result;
			$id_ref=$id_mol."_".$id_p;
			if (isset($arr_up[$id_ref])) 
				$indice=count($arr_up[$id_ref]);
			else $indice=0;

			$arr_up[$id_ref][$indice]=$uploads;
		}

		return view('all_views/send_result_pharma',compact('molecola','molecole_info','packaging','pack_qty_id','arr_up'));
				
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
