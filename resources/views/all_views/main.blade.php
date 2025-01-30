@extends('all_views.viewmaster.index')


@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->

   <script async src="https://www.google.com/recaptcha/api.js"></script>
<!-- -->

@endsection



<?php if (1==2) {?>
   @section('top')
      @include('all_views.components.top')
   @endsection
<?php } ?>

@section('banner')
   @include('all_views.components.banner')
@endsection

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
      $disp="";
      if ($login==true || $save_user==1) $disp="display:none";
      if (isset($errors) && count($errors)>0) {$disp="display:none";}
   ?>
   @if ($save_user==1 || $save_user==2)
      <div class="appointment_section" id='div_reg_log'>
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

               <div class="row mb-3">
                  <div class="col-md-4">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='prefix' id='prefix'>
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
               

               <div class="row mb-3">
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

               <div class="row mb-3">
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
               <div class="row mb-3">
                  <div class="col-md-3">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='country' id='country' required>
                           <option value=""
                           <?php if (strlen($country)==0) echo " selected "; ?>
                           >Select...</option>
                           <option value="1"
                           <?php if ($country==1) echo " selected "; ?>
                           >Italy</option>
                           <?php if ($country==2) echo " selected "; ?><option value="2"
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
               
               <div class="row mb-3">

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

               <div class="row mb-2">
                  <div class="col-md-12">
                     <center>
                        <a href='doc/france.pdf' target='_blank'> 
                           <button type="button" class="btn btn-info" onclick="$('#read_terms').prop('disabled',false);$('#btn_reg').prop('disabled',false);">Click to view Terms & Conditions</button>
                        </a>   
                     </center>   
                  </div>
               </div>

               <div class="row mb-1">
                  <div class="col-md-12">
                     <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="read_terms" name="read_terms" required disabled>
                        <label class="form-check-label" for="read_terms">
                              I have read and agree to the Terms & Conditions
                        </label>
                     </div>
                  </div>
               </div>   
               <div class="row mb-3">
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
                  </div>
               </div>
              



               <div class="row mb-3">

                  <h5 style="text-align:center">Please select either ceftobiprole disks or strips. </h5><hr>
               
                  <div class="col-md-4">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='material1' id='material1'>
                           <option selected="selected" value="4">None (0 Ceftobiprole Strips)</option>
                           <option value="8">10 Ceftobiprole Strips</option>
                           <option value="21">30 Ceftobiprole Strips</option>
                        </select>
                        <label for="material1">Pack of Ceftobiprole Strips Qty:</label>
                     </div>
                  </div>     

                  <div class="col-md-4">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='material2' id='material2'>
                           <option selected="selected" value="30">None (0 cefepime/Enmetazobactam disks)</option>
                           <option value="31">250 cefepime/Enmetazobactam disks</option>
                        </select>
                        <label for="material2">Pack of Cefepime/Enmetazobactam Disks (not-CE marked) Qty:</label>
                     </div>
                  </div>                   

                  <div class="col-md-4">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='material3' id='material3'>
                        <option selected="selected" value="32">None (0 Cefepime/Enmetazobactam Dry Panel)</option>
                        <option value="33">10 Cefepime/Enmetazobactam plates</option>
                        </select>
                        <label for="material3">Pack of Cefepime/Enmetazobactam SENSITITRE® Dry Panel (CMP1ADV) Qty:</label>
                     </div>
                  </div> 
               </div>

            </div>
         </div>
      </div>       
      <!--end section material !-->

      <!-- start section account !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <h3>My ADVANZ® PHARMA AVEP <span style="color: #0cb7d6;"> Account Creation Details</span></h3>
                  </div>
               </div>
              
               <div class="row mb-3">
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
                        <button class="btn btn-primary" type="submit" id='btn_reg' name='btn_reg' disabled>Submit Registration</button>                        
                     </center>   
                  </div>
               </div>               

               <!-- Google Recaptcha Widget-->
               <div class="g-recaptcha" data-sitekey={{config('services.recaptcha.key')}}          

               <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
               <input type="hidden" name="action" value="validate_captcha">

                </div>
         </div>
      </div>
      </div> 
      <!-- end section account !-->



      
   </form>   
   </div> <!-- end div sign_up !-->
   
   <?php
      $disp1="display:none";
      if (isset($errors) && count($errors)>0) {$disp1="";}
   ?>

   <div id='div_log' style='{{$disp1}}'>
   

    <form method='post' action="{{ route('login') }}" id='frm_lo1' name='frm_log1' class="needs-validation2" autocomplete="off" novalidate>
		
    @csrf     

      <!-- start section login !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <h3>My ADVANZ® PHARMA AVEP <span style="color: #0cb7d6;"> Access with account</span></h3>
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


               <div class="row mb-3">
                  <div class="col-md-6">
                     <div class="form-floating">
                           <input class="form-control" id="email" name='email' type="email" placeholder="Email User" required  maxlength="200" value="" onkeyup="this.value = this.value.toLowerCase();"  />
                           <span class="mt-2"></span>
                           <label for="email">User Email*</label>
                     </div>
                     <font color='red'><x-input-error :messages="$errors->get('email')" class="mt-2" /></font>

                  </div>
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="password" name='password' type="password" placeholder="Password" required  maxlength="20" value="" />
                        <label for="password">Password*</label>
                     </div>
                     <font color='red'><x-input-error :messages="$errors->get('password')" class="mt-2" /></font>
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

<?php if (1==2) {?>
   @section('content5')
      @include('all_views.components.contact')
   @endsection
<?php } ?>   

@section('content_plugin')
   <script src="{{ URL::asset('/') }}js/main.js?ver=<?= time() ?>"></script>
@endsection

