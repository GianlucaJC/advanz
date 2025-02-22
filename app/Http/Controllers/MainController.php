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
use Mail;

use App\Models\carrello;
use App\Models\ordini;

class mainController extends Controller
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

		
	
	}

	public function load_allestimento() {
		$molecole_in_allestimento=$this->molecole_in_allestimento;
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

	public function save_user($request) {
		$resp=array();
		try {
			$email=$request->input("email");
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
			$user->email=$email;
			$user->password=$pw_c;
			$user->save();
			if ($request->has('material')) {
				$id_user=$user->id;
				$material=$request->input('material'); 
				$entr=false;
				for ($sca=0;$sca<count($material);$sca++) {
					$entr=true;
					$articolo=$material[$sca];
					if (strlen($articolo)==0) continue;
					$carrello=new carrello;
					$carrello->id_articolo=$articolo;
					$carrello->id_user=$id_user;
					$carrello->save();
				}
				//if ($entr==true) $this->send_mail(2,$email,"send_customer_admin");
						
			}
			$resp['esito']=1;
			$resp['err']="";
			$this->send_mail(1,$email,"send_customer_admin");
			
			
			
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

		//ricavo i dati dal costruttore per l'impostazione dell'allestimento/carrello
		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$packaging=$this->packaging;

		$pack_qty_id=$this->pack_qty_id;
		$pack_qty_ref=$this->pack_qty_ref;


		$molecole_in_allestimento=DB::table('allestimento as a')
		->select('id_molecola','id_pack')
		->groupBy('id_molecola','id_pack')
		->orderBy('id_molecola')
		->orderBy('id_pack')
		->get();
		$this->molecole_in_allestimento=$molecole_in_allestimento;
		$this->load_allestimento();

		$arr_info=$this->arr_info;
		$pack_in_mole=$this->pack_in_mole;	
		///

		if ($request->has('btn_reg')) {
			$post=$this->post($request);
			$save=$this->save_user($request);
			$save_user=$save['esito'];
			$save_user_err=$save['err'];
		}

		return view('all_views/main',compact('login','save_user','save_user_err','post','molecola','molecole_info','packaging','pack_qty_id','pack_qty_ref','molecole_in_allestimento','arr_info','pack_in_mole'));
	}
	

	public function contact(Request $request) {
		$msg_send_mail=false; 
		if ($request->has('btn_send')) {		
			$msg_send_mail=true; 	
			$admin_ref_email = env("ADMIN_REF_EMAIL", "test@gmail.com");
			$txtInstitution=$request->input('txtInstitution');
			$txtName=$request->input('txtName');
			$txtPhone=$request->input('txtPhone');
			$ddlTopic=$request->input('ddlTopic');
			$txtMessage=$request->input('txtMessage');
			$email=$request->input('txtEmail');
		
			
			$status=array();

			for ($sca=1;$sca<=2;$sca++) {
				if ($sca==2) $email=$admin_ref_email;
				try {
					$dx['body_title']="You have made a request to the advanz-astip.com website. Below is a summary of your request";
					if ($sca==2)
						$dx['body_title']="A contact request was sent by a visitor with this data";
					$dx["txtInstitution"]=$txtInstitution;
					$dx["txtName"]=$txtName;
					$dx["txtPhone"]=$txtPhone;
					$dx["txtEmail"]=$email;
					$dx["ddlTopic"]=$ddlTopic;
					$dx["txtMessage"]=$txtMessage;
					$data['dati']=$dx;

	
					Mail::send("emails.contact", $data, function($message)use($email) {
						$message->to($email, $email)
						->subject("Request information advanz-astip.com");
					});
					
					$status['status']="OK";
					$status['message']="Mail inviata con successo";
					
					
					
				} catch (Throwable $e) {
					$status['status']="KO";
					$status['message']="Errore occorso durante l'invio! $e";
				}
			}			
			
		}
		return view('all_views/contact',compact('msg_send_mail'));
	}	


	public function main_log(Request $request) {
		if (!Auth::user()) return $this->main($request);

		$id_user = Auth::user()->id;

		//ricavo i dati dal costruttore per l'impostazione dell'allestimento/carrello
		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$packaging=$this->packaging;

		$pack_qty_id=$this->pack_qty_id;
		$pack_qty_ref=$this->pack_qty_ref;


	



		$molecole_in_allestimento=DB::table('allestimento as a')
		->select('id_molecola','id_pack')
		->groupBy('id_molecola','id_pack')
		->orderBy('id_molecola')
		->orderBy('id_pack')
		->get();
		
		$this->molecole_in_allestimento=$molecole_in_allestimento;
		$this->load_allestimento();		

		$arr_info=$this->arr_info;
		$pack_in_mole=$this->pack_in_mole;	
		///


		$count=carrello::select("id_articolo")->where('id_user','=',$id_user)->count();
		$carrello=carrello::select("id_articolo")->where('id_user','=',$id_user)->get();
		$id_in_carrello=array();
		foreach ($carrello as $cart) {
			$id_in_carrello[]=$cart->id_articolo;
		}
		
		if ($request->has('material')) {
			$material=$request->input('material'); 
			$entr=false;
			for ($sca=0;$sca<count($material);$sca++) {
				$entr=true;
				$articolo=$material[$sca];
				if (strlen($articolo)==0) continue;
				$ordini=new ordini;
				$ordini->id_articolo=$articolo;
				$ordini->id_user=$id_user;
				$ordini->save();

				//svuota carrelo
				$dele_carrello=DB::table('carrello')->where('id_user','=',$id_user)->delete();
				$id_in_carrello=array();
				$count=0;
			}
			if ($entr==true) {
				$info_mail=DB::table('users')->select('email')->where('id','=',$id_user)->first();
				if($info_mail)
					$this->send_mail(2,$info_mail->email,"send_customer_admin");
			}	 
		}


		$id_escl=DB::table('allestimento as a')
		->select('a.id')
		->join('ordini as o','a.id','o.id_articolo')
		->where('o.id_user','=',$id_user)
		->get();
		$id_in_ordini=array();
		foreach ($id_escl as $escl) {
			$id_in_ordini[]=$escl->id;
		}		
		return view('all_views/main_log',compact('packaging','id_user','count','carrello','molecola','molecole_info','packaging','pack_qty_id','pack_qty_ref','molecole_in_allestimento','arr_info','pack_in_mole','id_in_carrello','id_in_ordini'));
	}

	public function send_mail($type,$email,$to) {
		$admin_ref_email = env("ADMIN_REF_EMAIL", "test@gmail.com");
		$status=array();
		$num=1;
		if ($to=="send_customer_admin") $num=2;
		for ($sca=1;$sca<=$num;$sca++) {
			if ($sca==2) $email=$admin_ref_email;
			try {
				$msg="";$template="emails.conferma_ordine";
				$data["title"]="";$data["title"]="";
				$data["email"] = $email;			
				if ($type=="1")	{
					$data["title"] = "User registration";
					$msg = "Thank you for registering on the Advanz-Astip platform";
					$template="emails.conferma_registrazione";
				}
				if ($type=="2")	{
					$data["title"] = "Order confirmation";
					$msg = "Thank you for ordering on the platform. Below is a summary of your order...";
					$template="emails.conferma_ordine";
				}
				
				$data["body"]=$msg;


				Mail::send($template, $data, function($message)use($data) {
					$message->to($data["email"], $data["email"])
					->subject($data["title"]);
				});
				
				$status['status']="OK";
				$status['message']="Mail inviata con successo";
				
				
				
			} catch (Throwable $e) {
				$status['status']="KO";
				$status['message']="Errore occorso durante l'invio! $e";
			}
		}
	}	

}
