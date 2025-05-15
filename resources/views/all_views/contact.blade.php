@extends('all_views.viewmaster.index1')



@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->

   <script async src="https://www.google.com/recaptcha/api.js"></script>
<!-- -->

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

<form method='post' action="{{ route('contact') }}" id='frm_contact' name='frm_contact' class="needs-validation" autocomplete="off" novalidate>
    <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>
    <div id='div_intro'>

    <div class="appointment_section">
            <div class='container'>    
               <div class="appointment_box"> 

                    <a href="main">
                      <button type="button" class="btn btn-info">Back to home</button>
                    </a>
                  
               </div>
            </div> 
      </div>          
      <div class="appointment_section mt-2">
            <div class='container'>
               <div class="appointment_box">
                  <div class="jumbotron">
                     <p style='text-align:justify'>
                       <h3>Welcome to the ADVANZ PHARMA AST Investigational Programme</h3>
                     </p>
                     <h1>(ADVANZ PHARMA ASTIP)</h1>
                        coordinated by
                     <hr class="my-2">
                     ADVANZ PHARMA
                  

                    <h1>Contact Form</h1>

                    @if ($msg_send_mail==true)
                      <div class="alert alert-success mb-2 mt-2" role="alert">
                      Your request has been sent successfully.<hr>
                      You will shortly receive a confirmation email with a summary of the information sent
                      </div>                      
                    @endif
                    <div class="col-md-8 col-xs-12">
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Send us a message</legend>
                                
                                <div class="form-group">
                                        
                                    <label for="inputInstitution" class="col-lg-3 control-label">Institution Name</label>
                                    <div class="col-lg-9">
                                        <input name="txtInstitution" type="text" id="txtInstitution" class="form-control" placeholder="Institution Name" required />
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                <label for="inputInstitution" class="col-lg-3 control-label">Full Name</label>
                                <div class="col-lg-5">
                                    <input name="txtName" type="text" id="txtName" class="form-control" placeholder="Full Name" required />
                                    
                                </div>
                                </div>

                                <div class="form-group">
                                <label for="inputInstitution" class="col-lg-3 control-label">Phone Number</label>
                                <div class="col-lg-5">
                                    <input name="txtPhone" type="tel" id="txtPhone" class="form-control" placeholder="Phone Number" required />
                                    
                                </div>
                                </div>

                                <div id="pEmail" class="form-group">
                    
                                
                                <label for="inputEmail" class="col-lg-3 control-label">Email</label>
                                <div class="col-lg-9">
                                    <input name="txtEmail" type="email" id="txtEmail" class="form-control" placeholder="Email" required />
                                </div>
                                
                                    
                                </div>
                                <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">Topic</label>
                                <div class="col-lg-5">
                                    <select name="ddlTopic" id="ddlTopic" class="selectpicker form-control" style="font-weight:bold;" required>
                                    <option value="">Please select...</option>
                                    <option value="Enrollment Registration">Enrollment Registration</option>
                                    <option value="Order Acknowledgement">Order Acknowledgement</option>
                                    <option value="Test Result Entry">Test Result Entry</option>
                                    <option value="Ceftobiprole">Ceftobiprole</option>
                                    <option value="Cefepime/Enmetazobactam">Cefepime/Enmetazobactam</option>
                                    <option value="Dalbavancin">Dalbavancin</option>
                                    <option value="Website">Website Issue</option>
                                    <option value="Other Topic">Other</option>

                                    </select>
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="textArea" class="col-lg-3 control-label">Message</label>
                                <div class="col-lg-8">
                                    <textarea name="txtMessage" rows="2" cols="20" id="txtMessage" class="form-control" placeholder="Message" required>
                                    </textarea>
                                    <span class="help-block">Please allow up to 48 hours for a reply where possible.</span>
                                </div>
                                </div>
                                
                        </div>		
                    </div>                     
                  </div>
                  <button type="submit" class="btn btn-success mt-3" id="btn_send" name="btn_send"><i class="fas fa-paper-plane"></i> Send message</button>                  
            </div> 
          </div> 
      </div>  
      
   </div>           
  </form>

   



<!-- Modal -->
<div class="modal fade bd-example-modal-xl"" role="dialog" id='div_modal'>
	  <div class="modal-dialog modal-xl" style='max-width:4000px' role="document">
		<div class="modal-content">
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

@section('content_plugin')
   <script src="{{ URL::asset('/') }}js/contact.js?ver=<?= time() ?>"></script>
@endsection

