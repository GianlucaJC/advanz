<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Models\carrello;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use DB;


class AjaxController extends Controller
{  
    public function __construct()
	{
		//$this->middleware('auth')->except(['index']);
		$info=DB::table('molecola as m')->select('*')->get();
		$molecola=array();$molecole_info=array();
		foreach ($info as $dato) {
			$molecola[$dato->id]=$dato->descrizione;
			$molecole_info[$dato->id]=$dato->info;
		}
		$this->molecola=$molecola;
        $this->molecole_in_allestimento=array();
		$this->molecole_info=$molecole_info;

		$info=DB::table('packaging as p')->select('*')->get();
		$packaging=array();
		foreach ($info as $dato) {
			$packaging[$dato->id]=$dato->descrizione;
		}		
		$this->packaging=$packaging;

		$info=DB::table('pack_qty as p')->select('*')->get();		
		$pack_qty_id=array();
		$pack_qty_ref=array();
		$indice=0;
		foreach ($info as $dato) {			
			$pack_qty_id[$dato->id]=$dato->descrizione;
			if (!isset($pack_qty_ref[$dato->id_pack])) $indice=0;
			else $indice++;
			$pack_qty_ref[$dato->id_pack][$indice]=$dato->descrizione;
		}		
		$this->pack_qty_id=$pack_qty_id;
		$this->pack_qty_ref=$pack_qty_ref;	

		$this->no_art=array(); //articoli già ordinati da inibire
		
	}

    public function check_allestimento(Request $request) {
        $id_country=$request->input('id_country');
		//in caso di sessione loggata:
		//recupero l'eventuale carrello precedente per precaricare dati
		$arr_cart=array();
		$no_art=array();
		if (Auth::user()) {
			$id_user = Auth::user()->id;
			//recupero il country e metto in un array tutti gli id del carrello
			//eventualmente presente per l'utente
			$info=DB::table('users')->select('country')->where('id','=',$id_user)->first();
			if($info)  {
				$id_country=$info->country;
				//calcolo delle voci di confezionamento 
				$cart=DB::table('carrello as c')
				->select('id_articolo')
				->where('id_user','=',$id_user)
				->get();
				foreach ($cart as $row_cart) {
					$arr_cart[]=$row_cart->id_articolo;
				}
			}	
			//in caso di ordini già effettuati dall'utente loggato, elimino (secondo la regola imposta),
			//gli articoli già ordinati
			$info=DB::table('ordini')->select('id_articolo')->where('id_user','=',$id_user)->get();
			foreach ($info as $ord_prec) {
				$no_art[]=$ord_prec->id_articolo;
			}
			$this->no_art=$no_art;
		}
		
		//ricavo i dati dal costruttore per l'impostazione dell'allestimento/carrello
		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$packaging=$this->packaging;

		$pack_qty_id=$this->pack_qty_id;
		$pack_qty_ref=$this->pack_qty_ref;

		$molecole_in_allestimento=DB::table('allestimento as a')
        ->join('rule_order as r','r.id_allestimento','a.id')
		->select('a.id','a.id_molecola','a.id_pack')
        ->where('r.id_country','=',$id_country)
        ->where('r.can_order','=',1)
		->groupBy('a.id_molecola','a.id_pack')
		->orderBy('a.id_molecola')
		->orderBy('a.id_pack')
		->get();

        $this->molecole_in_allestimento=$molecole_in_allestimento;
		
        $this->load_allestimento();
       
        $arr_info=$this->arr_info;
        $pack_in_mole=$this->pack_in_mole;	

        $view="";
        $id_old_mp="?";$id_old_mole="?";
        
        $view.="<div class='row mb-3'>";
        foreach ($molecole_in_allestimento as $mole_in_all) {            
           $id_a=$mole_in_all->id;
           $id_molecola=$mole_in_all->id_molecola;
           $id_pack=$mole_in_all->id_pack;
           if ($id_molecola!=$id_old_mole) {
              if ($id_old_mole!="?") $view.="</div>";
              $view.="<div class='row mt-4'>";
                 
                 if (isset($molecola[$id_molecola])) {
                    $view.="<h5>Please select either ".$molecola[$id_molecola]." ";
                    $descr_pack_in_mole=implode(" or ",$pack_in_mole[$id_molecola]);
                    $view.=$descr_pack_in_mole;
                    $view.="</h5><hr>";
                 } else {continue;}
                 
           }
           $id_old_mole=$id_molecola;
           $id_mole_pack=$id_molecola.$id_pack;
           if ($id_mole_pack!=$id_old_mp) {
              //creazione select di scelta riferita alla molecola/packaging
              $voci=$arr_info[$id_mole_pack]['voci_conf'];
			   $render_art=false;
			   $view_art="";	
               $view_art.="<div class='col-md-4 sm-12 div_allestimento' id='div_material$id_mole_pack' >";
                 $view_art.="<div class='form-floating mb-3 mb-md-0'>";
                    $view_art.="<select class='form-select molecola$id_molecola allestimento' name='material[]'  id='material$id_mole_pack'  onchange=\"check_choice($id_molecola,'material$id_mole_pack',this.value)\">";
                    $view_art.="<option value=''>None (0 ".$molecola[$id_molecola]." ".$packaging[$id_pack].")</option>";
                       for ($sca=0;$sca<count($voci);$sca++) {						
						  if (in_array($voci[$sca]['id'], $no_art)) continue;
						  $render_art=true;
                          $view_art.="<option value='".$voci[$sca]['id']."' ";
                          if (in_array($id_a, $arr_cart)) $view_art.=" selected ";
                          $voce=$voci[$sca]['id_pack_qty']." ".$voci[$sca]['molecola_descr']." ".$voci[$sca]['pack_descr'];

                          $view_art.=">".$voce;
                          $view_art.="</option>";
                       }
                   
                    $view_art.="</select>";
                    $lbl=$arr_info[$id_mole_pack]['label'];
                    $view_art.="<label for='material$id_mole_pack'>$lbl</label>";
                 $view_art.="</div>";
              $view_art.="</div>";
			  if ($render_art==true) $view.=$view_art;


           }
           $id_old_mp=$id_mole_pack;

           
        }
        $view.="</div>"; //chiusura ultimo <div class='row'>
            
       
       $risp=array();
       $risp['header']="OK";
       $risp['view']=$view;
       return json_encode($risp);	 

    }



	public function load_allestimento() {
		$molecole_in_allestimento=$this->molecole_in_allestimento;
		$no_art=$this->no_art;
		$molecola=$this->molecola;
		$pack_qty_id=$this->pack_qty_id;
		$packaging=$this->packaging;
		$arr_info=array();$pack_in_mole=array();
		foreach ($molecole_in_allestimento as $mole_in_all) {
			$id_molecola=$mole_in_all->id_molecola;
			$id_pack=$mole_in_all->id_pack;
			$id_mole_pack=$id_molecola.$id_pack;
			$lbl=DB::table('label_group as l')
			->select('label_custom')
			->where('id_mole_pack','=',$id_mole_pack)
			->first();
			
			if (isset($packaging[$id_pack])) $pack_in_mole[$id_molecola][]=$packaging[$id_pack];
			else $pack_in_mole[$id_molecola][]="";

			$molecola_descr=$id_molecola;
			if (isset($molecola[$id_molecola])) $molecola_descr=$molecola[$id_molecola];

			$pack_descr=$id_pack;
			if (isset($packaging[$id_pack])) $pack_descr=$packaging[$id_pack];

			$label="Pack of $molecola_descr $pack_descr Qty:"; //calcolo label automatica in funzione della molecola e packaging
			if($lbl) $label=$lbl->label_custom; //se è stata definita una label ad hoc la recupero

			$arr_info[$id_mole_pack]['label']=$label;
			
			//calcolo delle voci di confezionamento 
			$conf_in_all=DB::table('allestimento as a')
			->select('id','id_pack_qty')
			->where('id_molecola','=',$id_molecola)
			->where('id_pack','=',$id_pack)
			->get();
			$voci_conf=array();$indice=0;
			foreach ($conf_in_all as $conf) {
				$voci_conf[$indice]['id']=$conf->id;
				//$voci_conf[$indice]['id_pack_qty']=$conf->id_pack_qty;
				$voci_conf[$indice]['id_pack_qty']=$pack_qty_id[$conf->id_pack_qty];
				$voci_conf[$indice]['molecola_descr']=$molecola_descr;
				$voci_conf[$indice]['pack_descr']=$pack_descr;
				$indice++;
			}
			$arr_info[$id_mole_pack]['voci_conf']=$voci_conf;
		}
		
		$this->arr_info=$arr_info;
		$this->pack_in_mole=$pack_in_mole;		

	}

	

}
