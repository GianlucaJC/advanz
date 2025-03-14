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

   .box {
         display:inline-block;
         width:70px;
         padding:4px;
         border-radius: 8px;
         text-align: center;
         font-size: 12px;
   }
   
   .box_new {
         background-color:rgba(251, 255, 5, 0.61);
         border: 2px solid;
         border-color: rgba(245, 186, 57, 0.93);
         color:#CD7F32;
   }
   .box_ready {
         background-color:rgba(57, 226, 245, 0.93);
         border: 2px solid;
         border-color: rgba(57, 73, 245, 0.93);
         color:blue;
   }
   .box_shipped {
         background-color:rgba(82, 245, 57, 0.93);
         border: 2px solid;
         border-color: rgb(121, 190, 98);
         color:green;
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
   <form method='post' action="{{ route('order') }}" id='frm_order' name='frm_order' class="needs-validation" autocomplete="off" novalidate>
   <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'> 

   <div id='div_sign' style='' >

   <input type='hidden' name='id_order_view' id='id_order_view' value='{{$id_order_view}}'>
      @if ($id_order_view>0)
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <h3>Order detail #{{$id_order_view}}</h3></hr>
               <div id='your'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           <th>Molecule</th>
                           <th>Batch</th>
                           <th>Packaging</th>  
                           <th>Quantity</th>
                        </tr>
                     </thead>
                     <?php
                        $fl_upload=array();
                     ?>  
                     <tbody>
                     @foreach($lista_articoli as $articolo)
                        
                        <tr>
                        
                          <td>
                              <?php
                                 if (isset($molecola[$articolo->id_molecola]))
                                    echo $molecola[$articolo->id_molecola];
                              ?>
                           </td>
                           <td>
                              {{$articolo->lotto}}                            
                           </td>  

                           <td>
                           <?php
                                 if (isset($packaging[$articolo->id_pack]))
                                    echo $packaging[$articolo->id_pack];
                              ?>
                             
                           </td>                           
                           <td>
                                 <?php
                                  if (isset($pack_qty_id[$articolo->id_pack_qty]))
                                      echo $pack_qty_id[$articolo->id_pack_qty];
                                 ?>                              
                           </td>

                       

                        </tr>
                           
                     @endforeach  
                     </tbody>

                  </table>



               </div>

            </div>   
         </div>
      </div> 
      @endif     
      <div class="appointment_section mt-3">
            <div class="container">
               <div class="appointment_box">
                  <div id='your_order'>
                  <table id='tbl_order' class="display nowrap">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Status</th>
                           <th>Date Order</th>
                           <th>Date Shipping</th>  
                           <th>Estimated Date Shipping</th>
                           <th>Operation</th>
                        </tr>
                     </thead>
                     <?php
                        $fl_upload=array();
                     ?>  
                     <tbody>
                     @foreach($lista_ordini as $ordine)
                        
                        <tr>
                           <td>
                              {{$ordine->id}}
                           </td> 
                           <td>
                              <?php
                                 $stato=$ordine->stato;
                                 if ($stato==0)
                                     echo "<div class='box box_new'>New</div>";
                                 if ($stato==1)
                                     echo "<div class='box box_ready'>Ready</div>";
                                 if ($stato==2)
                                     echo "<div class='box box_shipped'>Shipped</div>";                                    
                              ?>
                           </td>                            
                           <td>
                              {{$ordine->created_at}}
                           </td> 
                           <td>
                              {{$ordine->ship_date}}
                           </td> 
                           <td>
                              <!-- {{$ordine->ship_date_estimated}} !-->
                               <small>+14 days from order date</small>

                           </td> 
                           <td style='text-align:center'>
                              <button type="submit" onclick="$('#id_order_view').val({{$ordine->id}})" class="btn btn-info">View</button>
                           </td> 
                        </tr>
                           
                     @endforeach 
                     </tbody> 

                  </table>

                  </div>
               </div>
            </div>
      </div>
      


    
      <!--end section material !-->

      
   
   </div> <!-- end div sign_up !-->
   </form>

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

