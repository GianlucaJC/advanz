@extends('all_views.viewmaster.index')


@section('title', 'ADVANZ PHARMA')

@section('extra_style') 

   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   

@endsection

<script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LcItusqAAAAABgAVnGu_eZQS51dCR0TTyVEgVsA'
        });
      };
</script>

<?php if (1==2) {?>
   @section('top')
      @include('all_views.components.top')
   @endsection
<?php } ?>

<style>

.modal-backdrop
{
    opacity:1 !important;
}
</style>


<div class="modal" id="modal_main" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Attention!</h5>
      </div>
      <div class="modal-body">
        <p>Check the fields highlighted in red</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@section('content_main')

   <?php
      $disp_intro="";
      if ($login==true || $save_user==1 || $save_user==2) $disp_intro="display:none";
      if (isset($errors) && count($errors)>0) {$disp_intro="display:none";}
      
   ?>
   <div id='div_all'>
   <div id='div_intro' style='{{$disp_intro}}'>
      <div class="appointment_section">
            <div class='container'>
               <div class="appointment_box">
                  <div class="jumbotron">
                     <p style='text-align:justify'>
                       <h3>Welcome to the ADVANZ PHARMA <b>A</b>ntimicrobial <b>S</b>usceptibility <b>Investigational</b> Program</h3>
                     </p>
                     <h1>(ADVANZ PHARMA ASTIP)</h1>
                        coordinated by
                     <hr class="my-2">
                     ADVANZ PHARMA
                  
                  </div>
            </div> 
          </div> 
      </div>   
	
      <div class="appointment_section mt-2">
         <div class="container">
            <div class="appointment_box">
               <h2>Goal of ASTIP</h2>
                  <p style='text-align:justify'>            
                     ADVANZ PHARMA offers you the opportunity to join the antimicrobial susceptibility Investigational Program (ASTIP). The ASTIP provides In Vitro Diagnostics (IVD) materials for susceptibility testing at no cost. The goal is to help healthcare institutions to better understand the susceptibility of pathogens, the appropriate use of antibiotics and the prevention of antimicrobial resistances in your healthcare institution. By registering to ASTIP you can order a limited quantity of in vitro testing material for research use only and upload anonymised results. Disks and Strips are manufactured by Liofilchem® s.r.l. (<a href='https://www.liofilchem.com' class='link-info'>https://www.liofilchem.com</a>) and automated testing plates by Thermo Fisher Scientific (<a href='https://www.thermofisher.com' class='link-info'>https://www.thermofisher.com</a>)
                  </p>
               </div>
         </div>
      </div>

      <div class="appointment_section mt-2">
            <div class='container'>
               <div class="appointment_box">
                  <div class="jumbotron">
                     <p style='text-align:justify'>
                     All the information and personal data you share with us will be protected and kept confidential in line with our company policy on data protection accessible here <a href='https://www.advanzpharma.com/privacy-policy' target='blank'>https://www.advanzpharma.com/privacy-policy</a>. By clicking on the button “Register for Enrollment” or contacting us by phone or at the <a href='mailto:info@advanz.com'>info@advanz.com</a> address and submitting your personal information as requested in particular in the concerned form you consent to the processing of your personal data in accordance with our privacy policy. The collected information will be used only for the management of your request and will be stored for a limited period, proportionate to the aims pursued. You have a right of access to the personal data which we may hold about you as well as various other rights as outlined in our privacy policy. To exercise any of those rights, or if you have any comments or questions about our privacy policy, you can address your request to the following email address: <a href='mailto:enquiries@advanz-astip.com'>enquiries@advanz-astip.com</a>.
                     </p>

                     <hr class="my-2">
                    
                    <div class="about_bt" style='width:auto'><a href="#" onclick="$('#about').hide();$('#div_intro').hide();$('#div_sign').show(200);">Register for Enrollment</a></div>
                  
                  </div>
            </div> 
          </div> 
      </div>

      <div class="appointment_section mt-3">
            <div class='container'>
            <div class="appointment_box">
               @foreach($molecole_info as $k=>$v)
                  <div class="card mt-2">
                     <div class="card-header">
                        <h2>{{$molecola[$k]}}</h2>
                     </div>
                     <div class="card-body">
                        <p class="card-text"><?php echo $v;?></p>
                     </div>
                  </div> 
               @endforeach 
            </div>     
          </div> 
      </div>  
      
      
   </div>           


   @if ($save_user==1 || $save_user==2)
      <div class="appointment_section mb-2" id='div_reg_log'>
         <div class='container'>
            <div class="appointment_box">
               @if ($save_user==1)
               <div class="alert alert-success" role="alert">
                     <h4><b>Good! </b></h4>
                     <h5>Your account has been created successfully. To log in <a href='#' onclick="$('#div_reg_log').hide(100);$('#div_sign').hide();$('#div_log').show(250);">click here</a></h5>
               </div>     
               @endif
               @if ($save_user==2)
               <div class="alert alert-warning" role="alert">
                     <h4><b>Attention!</b></h4>
                     <h5>An error occurred while creating your account. Repeat the operation or contact an Administrator</h5>
                     <small><font color='red'>{{$save_user_err}}</font></small>
               </div>     
               @endif

            </div>   
         </div>
      </div>
   @endif


   <?php
      $disp="display:none";
      if (strlen($disp_intro)!=0) $disp="";
      if ($login==true || $save_user==1) $disp="display:none";
      if (isset($errors) && count($errors)>0) {$disp="display:none";}
      
   ?>   
   <div id='div_sign' style='{{$disp}}' >
     
      <!-- header section end -->
      <!-- appointment section start -->
   <form method='post' action="{{ route('main') }}" id='frm_main' name='frm_main' class="needs-validation" autocomplete="off" novalidate>
		
      <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>
	 


	  <div class="appointment_section">

         <div class="container">
            <div class="appointment_box">
               <div class="row">
                  <div class="col-md-12">
                     <h1 class="appointment_taital">User <span style="color: #0cb7d6;">Information</span></h1>
                  </div>
               </div>
               <div class="row mb-3">
                     <div class="col-md-12">
                        <div class="form-floating">
                           <input class="form-control" id="istituto" name='istituto' type="text" placeholder="Institution Name" required  maxlength="100" value="{{$post['istituto'] ?? ''}}" onkeyup="this.value = this.value.toUpperCase();"  />
                           <label for="istituto">Institution Name*</label>
                						
                        </div>
                     </div>
                     <!--
                     <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="liofsite" name='liofsite' type="text" placeholder="(if know)"  value=""  />
                           <label for="liofsite">IHMA Site ID</label>
                        </div>
                     </div>
                     
                     <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="eori" name='eori' type="text" placeholder="EROI/CIF #" required value=""  />
                           <label for="eori">EORI/CIF Number *</label>
                        </div>
                        <div id="eoriFeedback"  class="invalid-feedback">
                          EORI/CIF Number is required.
                        </div>                        
                     </div>
                     !-->
            	</div>

               <div class="row mb-3 g-2">
                  <div class="col-md-4">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select nice" name='prefix' id='prefix'>
                           <option value="">Select...</option>
                           <option value="1">Dr.</option>
                           <option value="2">Mrs.</option>
                           <option value="3">Mr.</option>
                           <option value="4">Miss.</option>
                           <option value="5">Ms.</option>
                           <option value="6">Rev.</option>
                        </select>
                        <label for="prefix">Prefix</label>
                     </div>
                  </div>
  

                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="first_name" value="{{$post['first_name'] ?? ''}}" name='first_name' type="text" placeholder="First name" required value=""  />
                           <label for="first_name">First Name *</label>
                        </div>
                        <div class="invalid-feedback">
                          First name is required.
                        </div>                        
                  </div>
                  
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="last_name" value="{{$post['last_name'] ?? ''}}" name='last_name' type="text" placeholder="First name" required value=""  />
                           <label for="last_name">Last Name *</label>
                        </div>
                        <div class="invalid-feedback">
                          Last name is required.
                        </div>                        
                  </div>

               </div>
               

               <div class="row mb-3 g-2">
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="position" value="{{$post['position'] ?? ''}}" name='position' type="text" placeholder="Position/Title" required value=""  />
                        <label for="position">Position *</label>
                     </div>
                     <div class="invalid-feedback">
                        Position is required.
                     </div>     
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="department" value="{{$post['department'] ?? ''}}" name='department' type="text" placeholder="Department" required value=""  />
                        <label for="department">Department *</label>
                     </div>
                     <div class="invalid-feedback">
                           Department is required.
                     </div>     
                  </div>                  
               </div>

               <div class="row mb-3 g-2">
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="shipping_address1" value="{{$post['shipping_address1'] ?? ''}}" name='shipping_address1' type="text" placeholder="Shipping Address1" required value=""  />
                        <label for="shipping_address1">Shipping Address1 *</label>
                     </div>
                     <div class="invalid-feedback">
                        Shipping Address1 is required.
                     </div>     
                  </div>

                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="shipping_address2" value="{{$post['shipping_address2'] ?? ''}}" name='shipping_address2' type="text" placeholder="Shipping Address2"  value=""  />
                        <label for="shipping_address2">Shipping Address2 </label>
                     </div>
                     <div class="invalid-feedback">
                        Shipping Address1 is required.
                     </div>     
                  </div>                  
               </div>           
               <?php 
                  $country="";
                  if (isset($post['country'])) $country=$post['country'];
               ?>
               <div class="row mb-3 g-2">
                  <div class="col-md-3">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select nice" name='country' id='country' required onchange="select_terms(this.value)">
                           <option value=""
                           <?php if (strlen($country)==0) echo " selected "; ?>
                           >Select...</option>
                           
                           <?php if ($country==2) echo " selected "; ?>
                           <option value="2"
                           >France</option>
                           <option value="3"
                           <?php if ($country==3) echo " selected "; ?>
                           >Austria</option>
                           <option value="4"
                           <?php if ($country==4) echo " selected "; ?>
                           >Denmark</option>
                           <option value="5"
                           <?php if ($country==5) echo " selected "; ?>
                           >Germany</option>
                           <option value="6"
                           <?php if ($country==6) echo " selected "; ?>
                           >Ireland</option>
                           <option value="7"
                           <?php if ($country==7) echo " selected "; ?>
                           >Spain</option>
                           <option value="8"
                           <?php if ($country==8) echo " selected "; ?>
                           >United Kingdom</option>
                        </select>
                        <label for="country">Country</label>
                     
                     <div class="invalid-feedback">
                           Country is required.
                     </div>                       
                     </div> 
                  </div>

                 

                  
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="state" name='state' value="{{$post['state'] ?? ''}}" type="text" placeholder="State" required value=""  />
                           <label for="state">State *</label>
                        </div>
                        <div class="invalid-feedback">
                           State/Region is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="city" name='city' value="{{$post['city'] ?? ''}}" type="text" placeholder="City" required value=""  />
                           <label for="state">City *</label>
                        </div>
                        <div class="invalid-feedback">
                           City is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="postal_code" value="{{$post['postal_code'] ?? ''}}" name='postal_code' type="text" placeholder="Postal Code" required value=""  />
                           <label for="state">Postal Code *</label>
                        </div>
                        <div class="invalid-feedback">
                           Postal Code is required.
                        </div>                        
                  </div>                   
               </div>         
               
               <div class="row mb-3 g-2">

               <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="email_ref" value="{{$post['email_ref'] ?? ''}}" name='email_ref' type="email" placeholder="Your Email" required value=""  />
                           <label for="email_ref">Your Email *</label>
                        </div>
                        <div class="invalid-feedback">
                           Your Email is required.
                        </div>                        
                  </div> 
                 
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="phone" value="{{$post['phone'] ?? ''}}" name='phone' type="text" placeholder="Phone" required value=""  />
                           <label for="state">Phone *</label>
                        </div>
                        <div class="invalid-feedback">
                           Phone is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="fax" value="{{$post['fax'] ?? ''}}" name='fax' type="text" placeholder="Fax"  value=""  />
                           <label for="state">Fax</label>
                        </div>
                  </div>                   
               </div>  

               <div class="row mb-2 g-2">
                  <div class="col-md-12">
                     <center>
                        <a href='javascript:void(0)' id='a_terms'> 
                           <button type="button" class="btn btn-info" onclick="$('#read_terms').prop('disabled',false);$('#btn_reg').prop('disabled',false);">Click to view Terms & Conditions</button>
                        </a>   
                     </center>   
                  </div>
               </div>

               <div class="row mb-1 g-2">
                  <div class="col-md-12">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="read_terms" name="read_terms" required disabled>
                        <label class="form-check-label" for="read_terms">
                              I have read and agree to the Terms & Conditions
                        </label>
                     </div>
                  </div>
               </div>   
               <div class="row mb-3 g-2">
                  <div class="col-md-12">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="purpose" name="purpose" required>
                        <label class="form-check-label" for="purpose">
                        I hereby confirm that the ordered materials will only be used for the purpose of general epidemiological research.
                        </label>
                     </div> 
                  </div>               
               </div>

            </div>
         </div>
      </div>
      
      <!-- start section material !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <h3>Testing <span style="color: #0cb7d6;"> Material Selection</span></h3>
                     <h5<i>Please select the testing materials you wish to receive.</i></h5>
                  </div>
               </div>
              
                  <div class='container' id='div_setup'></div> <!--div popolato dinamicamente !-->
                  
                  <div class='container-fluid'>
                     <div class="alert alert-dark mt-4" role="alert">
                        Requests for Ceftobiprole and Enmetazobactam powder may be sent to clinicaldevelopment@advanzpharma.com
                     </div>
                  </div>   


               </div>

         </div>
      </div>

        

      <!-- start section account !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div class="row mb-2 g-2">
                  <div class="col-md-12">
                     <h3>My ADVANZ PHARMA ASTIP <span style="color: #0cb7d6;"> Account Creation Details</span></h3>
                  </div>
               </div>
              
               <div class="row mb-3 g-2">
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input class="form-control" id="email_" name='email' type="email" placeholder="Email User" required  maxlength="200" value="{{$post['email'] ?? ''}}" onkeyup="this.value = this.value.toLowerCase();"  />
                        <label for="email">User Email*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input class="form-control" id="password" value="{{$post['password'] ?? ''}}" name='password' type="password" placeholder="Password" required  maxlength="20" value="" />
                        <label for="password">Password*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input class="form-control" id="password2" value="{{$post['password2'] ?? ''}}" name='password2' type="password" placeholder="Confirm Password" required  maxlength="20" value="" />
                        <label for="password2">Confirm Password*</label>
                     </div>
                  </div> 
               </div>

               <div class="row mb-2 g-2" style='display:none' id='err_pw' >
                  <div class="col-md-4"></div>
                  <div class="col-md-8" style='border-style: dotted;border-color:red'>
                        <small>
                           - Ensures at least one lowercase letter.<br>
                           - Ensures at least one uppercase letter.<br>
                           - Ensures at least one digit.<br>
                           - Ensures at least one special character.<br>
                           - Ensures the password is at least 8 characters long.
                        </small>
                  </div>
               </div>
               

               <div class="row mb-2 g-2">
                  <div class="col-md-12">
                     <center>
                        <div id="html_element" class='mb-2'></div>
                        <button 
                           class="btn btn-primary" type="submit" id='btn_reg' name='btn_reg' 
                           disabled
                           >Submit Registration</button>                        
                     </center>   
                  </div>
                  
               </div>               

     


                </div>
         </div>
      </div>
      </div> 
      <!-- end section account !-->      
   </form>   
   <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
    </script>   
   </div> <!-- end div sign_up !-->
   
   <?php
      $disp1="display:none";
      if (isset($errors) && count($errors)>0) {$disp1="";}
   ?>


   <div id='div_log' class='init'style='{{$disp1}}'>
   

    <form method='post' action="{{ route('login') }}" id='frm_log1' name='frm_log1' class="needs-validation2" autocomplete="off" novalidate>
		
    @csrf     

      <!-- start section login !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <h3>My ADVANZ PHARMA ASTIP <span style="color: #0cb7d6;"> Access with account</span></h3>
                  </div>
               </div>

               <!-- Remember Me -->
               <!--
               <div class="block mt-4">
                     <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                     </label>
               </div>
               !-->


               <!--
               <div class="flex items-center justify-end mt-4">
                     @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                           {{ __('Forgot your password?') }}
                        </a>
                     @endif

                     <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                     </x-primary-button>
               </div> 
               !-->


               <div class="row mb-3 g-2">
                  <div class="col-md-6">
                     <div class="form-floating">
                           <input class="form-control" id="email" name='email' type="email" placeholder="Email User" required  maxlength="200" value="" onkeyup="this.value = this.value.toLowerCase();"  />
                           <span class="mt-2"></span>
                           <label for="email">User Email*</label>
                     </div>
                     <font color='red'><x-input-error :messages="$errors->get('email')" class="mt-2" /></font>
                     <div style='text-align: left;'><a href='forgot-password'   class='link-underline-primary'><font color='gray'>Forgot password</font></a></div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control pw" id="password" name='password' type="password" placeholder="Password" required  maxlength="20" value="" />
                        <label for="password">Password*</label>
                     </div>
                     <font color='red'><x-input-error :messages="$errors->get('password')" class="mt-2" /></font>
                     
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="view_pw">
                        <label class="form-check-label" for="view_pw">
                           View Password
                        </label>
                     </div>                  

                  </div>
                                     
               </div>

               <div class="row mb-2" style='display:none' id='err_pw' >
                  <div class="col-md-4"></div>
                  <div class="col-md-8" style='border-style: dotted;border-color:red'>
                        <small>
                           - Ensures at least one lowercase letter.<br>
                           - Ensures at least one uppercase letter.<br>
                           - Ensures at least one digit.<br>
                           - Ensures at least one special character.<br>
                           - Ensures the password is at least 8 characters long.
                        </small>
                  </div>
               </div>
               

               <div class="row mb-2">
                  <div class="col-md-12">
                     <center>
                        <button class="btn btn-primary" type="submit" id='btn_log' name='btn_log'>Login</button>                        
                     </center>   
                  </div>
               </div>               
         </div>
      </div>
      </div> 
      
     </form> 
      <!-- end section login !-->
       
   </div> <!-- div_log !-->    

</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl"" role="dialog" id='div_modal'>
	  <div class="modal-dialog modal-xl" style='max-width:4000px;min-height:200px' role="document">
		<div class="modal-content " style='max-width:4000px;min-height:400px'>
		  <div class="modal-header">
       
			  <div id='modal-title'>Access Restricted</div>
        
			  <!--
			  
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				!-->	
		  </div>
		  
		  
		  <div class="modal-body" id='modal_body'>
            <center>
            <p>
               <h1>Are you a Healthcare Professional?</h1>
            </p>
            <h2>This website is intended for healthcare professionals only.</h2>
            <small>Please confirm you are a Healthcare Professional.</small>
            
            <div class='mt-5'>
               <button type="button" class="btn btn-success btn-lg btn-block" onclick="set_c(1)">YES, I am a Healthcare Professional.</button>
               <button type="button" style='margin-left:10px' class="btn btn-danger btn-lg btn-block" onclick="set_c(2)">NO, I am not a Healthcare Professional.</button>
            </div>
            </center>

         </div>


		  <div class="modal-footer" id='div_foot'>
		  </div>
		</div>
	  </div>
	</div>  

@endsection

<?php if (1==2) {?>
   @section('content2')
      @include('all_views.components.treatment')
   @endsection
<?php } ?>   
<?php if (1==2) {?>
   @section('content3')
      @include('all_views.components.doc')
   @endsection
<?php } ?>   
<?php if (1==2) {?>
   @section('content4')
      @include('all_views.components.testimonial')
   @endsection
<?php } ?>   



@section('content_plugin')
   <script src="{{ URL::asset('/') }}js/main.js?ver=<?= time() ?>"></script>
@endsection

