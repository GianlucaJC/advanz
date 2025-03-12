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
               <p class="text-left">
                  <button type="button" id='btn_view_r' onclick="$('#your').toggle(200);$('#div_order').toggle();$('#btn_view_r').toggle();$('#btn_view_o').toggle();" class="btn btn-outline-success">Click for view Your request</button>
                  
                  <button type="button" style='display:none' id='btn_view_o' onclick="$('#your').toggle(200);$('#div_order').toggle();$('#btn_view_r').toggle();$('#btn_view_o').toggle();" class="btn btn-outline-info"><i class="fas fa-arrow-circle-left"></i></button>
               </p>
               <hr>
               <?php 
                  $disp="display:none";$disp_ord="";
                  if(session('success') || session('error')) {$disp="";$disp_ord="display:none";}
                ?>  
               <div id='your' style='{{$disp}}'>
                  <!--gestione degli ordini precedenti con possibilità di inviare allegati di supporto !-->
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           <th>Date Order</th>
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Attachments</th>
                        </tr>
                     </thead>  
                     @foreach($lista_ordini as $ordine)
                        
                        <tr>
                          
                           <td>
                              {{$ordine->created_at}}
                           </td>
                           <td>
                              <?php
                                 if (isset($molecola[$ordine->id_molecola]))
                                    echo $molecola[$ordine->id_molecola];
                              ?>
                           </td>
                           <td>
                           <?php
                                 if (isset($packaging[$ordine->id_pack]))
                                    echo $packaging[$ordine->id_pack];
                                ?>                              
                           </td>  

                           <td></td>
                       

                        </tr>
                           
                     @endforeach  

                  </table>
                  @if(session('success'))
                     <div class="alert alert-success mb-2 mt-2" role="alert">
                        <p>{{ session('success') }}</p>
                     </div>
                  @endif   

                  @if(session('error'))
                     <div class="alert alert-warning mb-2 mt-2" role="alert">
                        <p>{{ session('error') }}</p>
                     </div>
                  @endif

                  <button type="button" class="btn btn-info mt-2" onclick="$('#div_up').toggle(200);">Click for send attachments</button>
                  <div id='div_up' style='display:none'>    
                     <form action="upload" method="POST" enctype="multipart/form-data">
                        @csrf         

                        <hr>
                        <div class="row mb-3 g-2">
                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <select class="form-select" name='id_molecola' id='id_molecola' required>
                                    <option value="">Select...</option>
                                    @foreach($molecola as $id_mol=>$descr_mol)
                                       <option value="{{$id_mol}}"
                                       >{{$descr_mol}}</option>
                                    @endforeach
                                 </select>
                                 <label for="id_molecola">Molecule</label>
                              </div>
                           </div> 

                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <select class="form-select" name='id_pack' id='id_pack' required>
                                    <option value="">Select...</option>
                                    @foreach($packaging as $id_p=>$descr_pack)
                                       <option value="{{$id_p}}"
                                       >{{$descr_pack}}</option>
                                    @endforeach
                                 </select>
                                 <label for="id_pack">Packaging</label>
                              </div>
                           </div> 

                        </div>
                        <hr>
                        <div class="mb-3">
                           <input class="form-control form-control-sm" name="file" type="file">
                        </div>
                        <button type="submit" class='btn btn-outline-secondary'>Upload attachment for this Molecola</button>                  
                     </form>
                  </div> 


               </div>

               <div id='div_order' style="{{$disp_ord}}">     
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

