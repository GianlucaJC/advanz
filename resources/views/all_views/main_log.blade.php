@extends('all_views.viewmaster.index')


@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->

   <script async src="https://www.google.com/recaptcha/api.js"></script>
<!-- -->
   
   <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection


<style>
   div.dataTables_wrapper {
    width: 100%;
    margin: 0 auto;
}

</style>
<?php if (1==2) {?>
   @section('top')
      @include('all_views.components.top')
   @endsection
<?php } ?>


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
   <div id='div_sign' style='' >
     
      <!-- header section end -->
      <!-- appointment section start -->

      <!-- start section material !-->
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <div id='div_order'>     
                  <form method='post' action="{{ route('main_log') }}" id='frm_main' name='frm_main' class="needs-validation" autocomplete="off" novalidate>
                  <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>                         
                     <div class="row mb-2">
                        <div class="col-md-12">
                           <h3>Testing <span style="color: #0cb7d6;"> Material Selection</span></h3>
                           <h5<i>Please select the testing materials you wish to receive.</i></h5>

                              <div class="alert alert-info" role="alert">
                                 <i class="fas fa-cart-plus"></i> Your cart 
                                 @if ($count==0) is empty! @endif
                              </div>

                        </div>
                     </div>

                     @if ($new_ord==true)
                        <div class="alert alert-success mt-2 mb-2" role="alert">
                           <i class="far fa-paper-plane"></i> <strong>Order Sent!</strong>
                        </div>              
                     @endif       
                     
                     <div class='container' id='div_setup'></div> <!--div popolato dinamicamente !-->
                     
                     <div class='container-fluid'>
                        <div class="alert alert-dark mt-4" role="alert">
                           Requests for Ceftobiprole and Enmetazobactam powder may be sent to Clinicaldevelopment@advanzpharma.com
                        </div>
                     </div>   

                     <div class="about_bt"><a href="#" onclick="send_request()">Send Request</a></div>

                  </form>   
               </div>
            </div>   
         </div>
      </div>      
      <!--end section material !-->
   </div> <!-- end div sign_up !-->
   

@endsection

@section('content_plugin')
	<!-- inclusione standard
		per personalizzare le dipendenze DataTables in funzione delle opzioni da aggiungere: https://datatables.net/download/
	!-->
	<!-- dipendenze DataTables !-->
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>
		 
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
       <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
    <!-- fine DataTables !-->
   <script src="{{ URL::asset('/') }}js/main_log.js?ver=<?= time() ?>"></script>
@endsection

