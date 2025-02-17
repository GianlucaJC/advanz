@extends('all_views.viewmaster.index')


@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->

   <script async src="https://www.google.com/recaptcha/api.js"></script>
<!-- -->

@endsection



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


   <div id='div_intro'>
      <div class="appointment_section">
            <div class='container'>
               <div class="appointment_box">
                  <div class="jumbotron">
                     <p style='text-align:justify'>
                       <h3>Welcome to the ADVANZ® PHARMA AST Investigational Programme</h3>
                     </p>
                     <h1>(ADVANZ® PHARMA ASTIP)</h1>
                        coordinated by
                     <hr class="my-2">
                     ADVANZ® PHARMA
                  

                    <h1>Contact Form</h1>

                    <div class="col-md-8 col-xs-12">
                        <div class="form-horizontal">
                            <fieldset>
                                <legend>Send us a message</legend>
                                
                                <div class="form-group">
                                        
                                    <label for="inputInstitution" class="col-lg-3 control-label">Institution Name</label>
                                    <div class="col-lg-9">
                                        <input name="ctl00$MainContent$txtInstitution" type="text" id="MainContent_txtInstitution" class="form-control" placeholder="Institution Name" />
                                        <span data-val-controltovalidate="MainContent_txtInstitution" data-val-errormessage="Please enter the name of your institution." data-val-display="Dynamic" data-val-validationGroup="ContactForm" id="MainContent_ctl00" class="text-danger" data-val="true" data-val-evaluationfunction="RequiredFieldValidatorEvaluateIsValid" data-val-initialvalue="" style="display:none;">Please enter the name of your institution.</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                <label for="inputInstitution" class="col-lg-3 control-label">Full Name</label>
                                <div class="col-lg-5">
                                    <input name="ctl00$MainContent$txtName" type="text" id="MainContent_txtName" class="form-control" placeholder="Full Name" />
                                    <span data-val-controltovalidate="MainContent_txtName" data-val-errormessage="Please enter your name." data-val-display="Dynamic" data-val-validationGroup="ContactForm" id="MainContent_ctl01" class="text-danger" data-val="true" data-val-evaluationfunction="RequiredFieldValidatorEvaluateIsValid" data-val-initialvalue="" style="display:none;">Please enter your name.</span>
                                </div>
                                </div>

                                <div class="form-group">
                                <label for="inputInstitution" class="col-lg-3 control-label">Phone Number</label>
                                <div class="col-lg-5">
                                    <input name="ctl00$MainContent$txtPhone" type="tel" id="MainContent_txtPhone" class="form-control" placeholder="Phone Number" />
                                    
                                </div>
                                </div>

                                <div id="MainContent_pEmail" class="form-group">
                    
                                
                                <label for="inputEmail" class="col-lg-3 control-label">Email</label>
                                <div class="col-lg-9">
                                    <input name="ctl00$MainContent$txtEmail" type="email" id="MainContent_txtEmail" class="form-control" placeholder="Email" />
                                    <span data-val-controltovalidate="MainContent_txtEmail" data-val-errormessage="Please enter your email address." data-val-display="Dynamic" data-val-validationGroup="ContactForm" id="MainContent_ctl02" class="text-danger" data-val="true" data-val-evaluationfunction="RequiredFieldValidatorEvaluateIsValid" data-val-initialvalue="" style="display:none;">Please enter your email address.</span>
                                </div>
                                
                                    
                                </div>
                                <div class="form-group">
                                <label for="select" class="col-lg-3 control-label">Topic</label>
                                <div class="col-lg-5">
                                    <select name="ctl00$MainContent$ddlTopic" id="MainContent_ddlTopic" class="selectpicker form-control" style="font-weight:bold;">
                                    <option value="Not Specified">--</option>
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
                                    <textarea name="ctl00$MainContent$txtMessage" rows="2" cols="20" id="MainContent_txtMessage" class="form-control" placeholder="Message">
                                    </textarea>
                                    <span class="help-block">Please allow up to 48 hours for a reply.</span>
                                </div>
                                </div>
                                <!-- Validation Summary -->
                                <div class="form group">
                                    <div class="row">
                                        <div class="col-xs-offset-3 col-xs-6">
                                            <div data-val-headertext="Contact form error summary:" data-val-showmessagebox="True" data-val-validationGroup="ContactForm" id="MainContent_ValidationSummary1" class="alert alert-dismissable alert-danger" data-valsummary="true" style="border-color:OrangeRed;border-width:1px;border-style:Solid;display:none;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>		
                    </div>                     
                  </div>
                  <button type="button" class="btn btn-success mt-3"><i class="fas fa-paper-plane"></i> Send message</button>                  
            </div> 
          </div> 
      </div>  
      
   </div>           


   



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
   <script src="{{ URL::asset('/') }}js/main.js?ver=<?= time() ?>"></script>
@endsection

