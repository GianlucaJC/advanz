@extends('all_views.viewmaster.index')


@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->
   <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">


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

@section('content_main')

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
                           <input class="form-control" id="istituto" name='istituto' type="text" placeholder="Institution Name" required  maxlength="100" value="" onkeyup="this.value = this.value.toUpperCase();"  />
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
                           <input class="form-control" id="first_name" name='first_name' type="text" placeholder="First name" required value=""  />
                           <label for="first_name">First Name *</label>
                        </div>
                        <div class="invalid-feedback">
                          First name is required.
                        </div>                        
                  </div>
                  
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="last_name" name='last_name' type="text" placeholder="First name" required value=""  />
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
                        <input class="form-control" id="position" name='position' type="text" placeholder="Position/Title" required value=""  />
                        <label for="position">Position *</label>
                     </div>
                     <div class="invalid-feedback">
                        Position is required.
                     </div>     
                  </div>
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="department" name='pdepartmentosition' type="text" placeholder="Department" required value=""  />
                        <label for="departmentposition">Department *</label>
                     </div>
                     <div class="invalid-feedback">
                           Department is required.
                     </div>     
                  </div>                  
               </div>

               <div class="row mb-3">
                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="shipping_address1" name='shipping_address1' type="text" placeholder="Shipping Address1" required value=""  />
                        <label for="shipping_address1">Shipping Address1 *</label>
                     </div>
                     <div class="invalid-feedback">
                        Shipping Address1 is required.
                     </div>     
                  </div>

                  <div class="col-md-6">
                     <div class="form-floating">
                        <input class="form-control" id="shipping_address2" name='shipping_address2' type="text" placeholder="Shipping Address2"  value=""  />
                        <label for="shipping_address2">Shipping Address2 </label>
                     </div>
                     <div class="invalid-feedback">
                        Shipping Address1 is required.
                     </div>     
                  </div>                  
               </div>           

               <div class="row mb-3">
                  <div class="col-md-3">
                     <div class="form-floating mb-3 mb-md-0">
                        <select class="form-select" name='country' id='country'>
                           <option value="">Select...</option>
                           <option value="1">France</option>
                           <option value="2">Austria</option>
                           <option value="3">Denmark</option>
                           <option value="4">Germany</option>
                           <option value="5">Ireland</option>
                           <option value="6">Spain</option>
                           <option value="7">United Kingdom</option>
                        </select>
                        <label for="countru">Country</label>
                     </div>
                  </div>
                 
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="state" name='state' type="text" placeholder="State" required value=""  />
                           <label for="state">State *</label>
                        </div>
                        <div class="invalid-feedback">
                           State/Region is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="city" name='city' type="text" placeholder="City" required value=""  />
                           <label for="state">City *</label>
                        </div>
                        <div class="invalid-feedback">
                           City is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-3">
                        <div class="form-floating">
                           <input class="form-control" id="postal_code" name='postal_code' type="text" placeholder="Postal Code" required value=""  />
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
                           <input class="form-control" id="email_ref" name='email_ref' type="email" placeholder="Your Email" required value=""  />
                           <label for="email_ref">Your Email *</label>
                        </div>
                        <div class="invalid-feedback">
                           Your Email is required.
                        </div>                        
                  </div> 
                 
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="phone" name='phone' type="text" placeholder="Phone" required value=""  />
                           <label for="state">Phone *</label>
                        </div>
                        <div class="invalid-feedback">
                           Phone is required.
                        </div>                        
                  </div> 
                  
                  <div class="col-md-4">
                        <div class="form-floating">
                           <input class="form-control" id="fax" name='fax' type="text" placeholder="Fax"  value=""  />
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
                        <input class="form-control" id="email_user" name='email_user' type="email" placeholder="Email User" required  maxlength="200" value="" onkeyup="this.value = this.value.toLowerCase();"  />
                        <label for="istituto">User Email*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input class="form-control" id="password" name='password' type="password" placeholder="Password" required  maxlength="20" value="" />
                        <label for="istituto">Password*</label>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-floating">
                        <input class="form-control" id="password2" name='password2' type="password" placeholder="Confirm Password" required  maxlength="20" value="" />
                        <label for="istituto">Confirm Password*</label>
                     </div>
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

   </form>   
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