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

      <div class="appointment_section mt-3">
            <div class="container">
               <div class="appointment_box">
                  <div id='your_order'>
                     <table id='tbl_order' class="display nowrap">
                     </table>
                  </div>
               </div>
            </div>
      </div>

      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <h3>Order detail</h3></hr>
               <div id='your'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>

                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Quantity</th>

                        </tr>
                     </thead>
                     <?php
                        $fl_upload=array();
                     ?>  
                     @foreach($lista_ordini as $ordine)
                        
                        <tr>
                        
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
                           <td>
                                 <?php
                                  if (isset($pack_qty_id[$ordine->id_pack_qty]))
                                      echo $pack_qty_id[$ordine->id_pack_qty];
                                 ?>                              
                           </td>

                       

                        </tr>
                           
                     @endforeach  

                  </table>



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
   <script src="{{ URL::asset('/') }}js/order.js?ver=<?= time() ?>"></script>
@endsection

