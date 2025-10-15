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

use App\Models\allestimento;
use App\Models\carrello;
use App\Models\ordini;
use App\Models\ordini_ref;

class mainController extends AjaxController
{
//estendo AjaxController per i metodi e proprietà di quella classe
public function __construct()
	{
		parent::__construct();
		//eredito valori dalla classe originaria
		$this->middleware(function ($request, $next) {			
			if (Auth::user()) {
				$id_user = Auth::user()->id;
				$info=User::select("is_pharma","is_admin")->where('id','=',$id_user)->first();
				$is_pharma=0;$is_admin=0;
				if($info) {
					$is_pharma=$info->is_pharma;
					$is_admin=$info->is_admin;
				}	
				if ($is_pharma==1) return redirect()->away("main_pharma");
				if ($is_admin==1) return redirect()->away("main_admin_order");	
			}
			return $next($request);	
		});
		
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
			$user->is_user=1;
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

		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		


		if ($request->has('btn_reg')) {
			$post=$this->post($request);
			$save=$this->save_user($request);
			$save_user=$save['esito'];
			$save_user_err=$save['err'];
		}

		return view('all_views/main',compact('login','save_user','save_user_err','post','molecola','molecole_info'));
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
			$email_input=$request->input('txtEmail');
			$email=$email_input;
		
			
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
					$dx["txtEmail"]=$email_input;
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
		$id_user = Auth::user()->id;
		$info_mail=DB::table('users')->select('email','name')->where('id','=',$id_user)->first();


		$molecola=$this->molecola;
		$molecole_info=$this->molecole_info;		
		$packaging=$this->packaging;

		$count=carrello::select("id_articolo")->where('id_user','=',$id_user)->count();

		$new_ord=false;
		//btn order (send request)
		if ($request->has('material')) {
			$material=$request->input('material'); 
			

			$ordini_ref=new ordini_ref;
			$ordini_ref->id_user=$id_user;
			$estim=date('Y-m-d', strtotime("+14 days"));
			$ordini_ref->ship_date_estimated=$estim;
			$ordini_ref->save();
			$id_ordine = $ordini_ref->id;
				
			for ($sca=0;$sca<count($material);$sca++) {
				$new_ord=true;
				$articolo=$material[$sca];
				if (strlen($articolo)==0) continue;
				$ordini=new ordini;
				$ordini->id_ordine=$id_ordine;
				$ordini->id_articolo=$articolo;
				$ordini->id_user=$id_user;
				$ordini->save();

				//calcolo remaining (stock - 1 (sempre fisso...non ci sono quantità specifiche))
				//svuota carrello

				$info_all=allestimento::select('stock','remaining')->where('id','=',$articolo)->first();
				if($info_all) {
					$stock=$info_all->stock;
					if ($stock!=null) {
						$remaining=$info_all->remaining;
						$allestimento = allestimento::find($articolo);	
						if ($remaining==null) {
							$remaining=$stock-1;
							$allestimento->remaining=$remaining;
							$allestimento->save();
						}	
						else 
							$allestimento->decrement('remaining',1);
					}
				}

				
				$dele_carrello=DB::table('carrello')->where('id_user','=',$id_user)->delete();

				$count=0;
			}
			if ($new_ord==true) {
				$info_mail=DB::table('users')
				->select('email','name','first_name','last_name','istituto','shipping_address1','shipping_address2','state','city','postal_code')
				->where('id','=',$id_user)->first();
				if($info_mail) {
					$info_order['material']=$material;
					$info_order['name']=$info_mail->name;
					$info_order['first_name']=$info_mail->first_name;
					$info_order['last_name']=$info_mail->last_name;
					$info_order['istituto']=$info_mail->istituto;
					$info_order['shipping_address1']=$info_mail->shipping_address1;
					$info_order['shipping_address2']=$info_mail->shipping_address2;
					$info_order['state']=$info_mail->state;
					$info_order['city']=$info_mail->city;
					$info_order['postal_code']=$info_mail->postal_code;
					$info_order['delivery_date']=date("Y-m-d");
					$estim=date('Y-m-d', strtotime("+14 days"));
					$info_order['estim']=$estim;
					$art_in_order=$this->art_in_order($material);
					$info_order['art_in_order']=$art_in_order;
					$this->info_order=$info_order;

					$this->send_mail(2,$info_mail->email,"send_customer_admin");
				}
			}	 
		}
		return view('all_views/main_log',compact('id_user','count','molecola','molecole_info','molecola','molecole_info','packaging','new_ord'));

	}

	public function art_in_order($material) {
		$resp=array();
		
		for ($sca=0;$sca<count($material);$sca++) {
			$id_all=$material[$sca];
			$info_all=DB::table('allestimento')
			->select("id_molecola","id_pack","id_pack_qty")
			->where('id',"=",$id_all)
			->first();
			if($info_all) {
				$id_molecola=$info_all->id_molecola;
				$id_pack=$info_all->id_pack;
				$id_pack_qty=$info_all->id_pack_qty;

				$resp[$id_all]['id_molecola']=$id_molecola;
				if (isset($this->molecola[$id_molecola])) $resp[$id_all]['descr_molecola']=$this->molecola[$id_molecola];
				else $resp[$id_all]['descr_molecola']=$id_molecola;

				$resp[$id_all]['id_pack']=$id_pack;
				if (isset($this->packaging[$id_pack])) $resp[$id_all]['descr_pack']=$this->packaging[$id_pack];
				else $resp[$id_all]['descr_pack']=$id_pack;
				
				$resp[$id_all]['id_pack_qty']=$id_pack_qty;

			}
			
		
		}
		
		return $resp;
	}

	public function send_mail($type,$email,$to) {
		$request=Request();
		
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
					if ($sca==1) {
						$template="emails.conferma_registrazione";
						$data["title"] = "ADVANZ ASTIP Registration Confirmation";
						$name="New User";$mail_reg="";$pw_reg="";
						if ($request->has("first_name")) {
							$name=$request->input("first_name");
							$mail_reg=$request->input("email");
							$pw_reg=$request->input("password");						
						}
						$data["name"]=$name;
						$data["mail_reg"]=$mail_reg;
						$data["pw_reg"]=$pw_reg;
					}
					if ($sca==2) {
						$template="emails.conferma_registrazione_admin";
						$data["title"] = "ADVANZ ASTIP Registration Confirmation";
						$name="New User";
						if ($request->has("first_name")) 
							$name=$request->input("istituto")." (".$request->input("first_name")." ".$request->input("last_name").")";
							$data["name"]=$name;
						}

				}
				if ($type=="2")	{
					$info_order=$this->info_order;
					$data["title"] = "ADVANZ ASTIP Order Confirmation";
					$template="emails.conferma_ordine";
					$msg="";
					$data["info_order"]=$info_order;
				}
				
				


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
