@extends('all_views.viewmaster.index_a')


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
   <form method='post' action="{{ route('main_admin_order') }}" id='frm_order' name='frm_order' class="needs-validation" autocomplete="off" novalidate>
   <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'> 

   <div id='div_sign' style='' >

   <input type='hidden' name='id_order_view' id='id_order_view' value='{{$id_order_view}}'>
      @if ($id_order_view>0)
      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">
               <h3>Order detail #{{$id_order_view}}</h3></hr>
               <div id='order_detail' style='max-width:auto;overflow-x: scroll'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           <th>HCP Name</th>
                           <th>Institution</th>
                           <th>Address</th>
                           <th>City</th>
                           <th>Country</th>
                           <th>Postal Code</th>
                           <th>Email</th>
                           <th>Phone</th>                           
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Quantity</th>
                           <th>Batch Num</th>
                           <th>Remaining Advanz stock</th>
                           <th>Expiration date</th>
                           <th>Shipping date</th>
                           <th>Shipping AWB</th>
                           <th>Receipt date at site</th>
                           <th>Comments</th>
                           <th>Operation</th>
                        </tr>
                     </thead>
                     <?php
                        $fl_upload=array();
                     ?>  
                     <tbody>
                     @foreach($lista_articoli as $articolo)
                        <?php
                            $id_ordine_ref=$articolo->id_ordine;
                            $id_user_ref=$articolo->id_user;
                            $name="";$istituto="";$shipping_address1="";$shipping_address2="";
                            $data_ordine=$articolo->created_at;
                            $city="";$country_view="";$postal_code="";$email_ref="";$phone="";
                            if (isset($arr_user[$id_user_ref])) {
                              $name=$arr_user[$id_user_ref]->name;
                              $istituto=$arr_user[$id_user_ref]->istituto;
                              $shipping_address1=$arr_user[$id_user_ref]->shipping_address1;
                              $shipping_address2=$arr_user[$id_user_ref]->shipping_address2;
                              $city=$arr_user[$id_user_ref]->city;
                              $country_code=$arr_user[$id_user_ref]->country;
                              $country_view=$country_code;
                              if (isset($country[$country_code])) $country_view=$country[$country_code];
                              $postal_code=$arr_user[$id_user_ref]->postal_code;
                              $email_ref=$arr_user[$id_user_ref]->email_ref;
                              $phone=$arr_user[$id_user_ref]->phone;

                           }

                        ?>
                        <tr>
                        
                           <td>
                              {{$name}}
                           </td>
                           <td>
                              {{$istituto}}
                           </td>
                           <td>
                              {{$shipping_address1}} 
                              <?php
                               if (strlen($shipping_address2)!=0) echo " - $shipping_address2";
                              ?>
                           </td>
                           <td>
                              {{$city}}
                           </td>
                           <td>{{$country_view}}</td>
                           <td>{{$postal_code}}</td>
                           <td>{{$email_ref}}</td>
                           <td>{{$phone}}</td>
                          <td>
                              <?php
                                 if (isset($molecola[$articolo->id_molecola]))
                                    echo $molecola[$articolo->id_molecola];
                              ?>
                           </td>

                           <td>
                           <?php
                                 if (isset($packaging[$articolo->id_pack]))
                                    echo $packaging[$articolo->id_pack];
                              ?>
                             
                             
                           <td>
                                 <?php
                                  if (isset($pack_qty_id[$articolo->id_pack_qty]))
                                      echo $pack_qty_id[$articolo->id_pack_qty];
                                 ?>                              
                           </td>    

                           <td>
                              
                              <input type='text' placeholder='Batch Num.' class='form-control' id='lotto{{$articolo->id}}' style='width:auto' value="{{$articolo->lotto}}"> 
                                                        
                           </td>  


                           <td>Remaining Advanz stock</td>
                           <td>

                           <input type='date' class='form-control' id='exp_date{{$articolo->id}}' style='width:auto' value="{{$articolo->expiration_date}}"> 

                           </td>
                           <td>
                              <?php 
                              if (count($info_ordine)>0 && $info_ordine[0]->ship_date) {
                                    $ship=$info_ordine[0]->ship_date;
                                    echo  $ship;
                              }
                              ?>                               
                           </td>
                           <td>
                              <?php 
                              if (count($info_ordine)>0 && $info_ordine[0]->tracker) {
                                    $track=$info_ordine[0]->tracker;
                                    if (substr($track,0,4)=="http") echo "<a href='$track' target='_blank'>";
                                    echo  $track;
                                    if (substr($track,0,4)=="http") echo "</a>";
                              }
                              ?>                                 
                           </td>
                           <td>{{$data_ordine}}</td>
                           <td></td>                          
                           <td>
                              <span id='spin_art{{$articolo->id}}' style='display:inline;' hidden>
                              <i class='fas fa-spinner fa-spin'></i>
                              </span>

                              <button type="button" onclick="save_art({{$articolo->id}})" class="btn btn-success">Save</button>                              
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
                  <div id='orders' style='max-width:auto;overflow-x: scroll'>
                  <table id='tbl_order' class="display nowrap">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Status</th>
                           <th>ID user</th>
                           <th>name</th>                           
                           <th>Date Order</th>
                           <th>FedEx Tracker Shipping</th>
                           <th>Date Shipping</th> 
                           <th>Estimated Shipping</th>
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
                              ?>
                              <select class="form-select" style='width:auto' id='stato{{$ordine->id}}'>
                                  <option value="0"
                                  <?php if ($stato=="0") echo " selected ";?>
                                  >New</option>
                                 <option value="1"
                                 <?php if ($stato=="1") echo " selected ";?>
                                 >Ready</option>
                                 <option value="2" 
                                 <?php if ($stato=="2") echo " selected ";?>
                                 >Shipped</option>
                              </select>
                           </td>    
                           <td>
                              <?php
                                 $id_user_ref=$ordine->id_user;
                                 echo $id_user_ref;
                              ?>
                           </td>                        
                           <td>
                              <?php
                                 if (isset($arr_user[$id_user_ref])) {
                                    echo $arr_user[$id_user_ref]->name;
                                 }
                              ?>
                           </td>
                           <td>
                              <?php
                                $d_o=$ordine->created_at;
                                $dx=substr($d_o,0,10);
                                echo $dx;
                               ?> 
                           </td> 
                           <td>
                                <input type='text' placeholder='Tracker code or link' class='form-control' id='tracker{{$ordine->id}}' style='width:180px' value="{{$ordine->tracker}}">    
                           </td>
                           <td>
                              
                              <input type='date' class='form-control' id='ship_date{{$ordine->id}}' style='width:auto' value="{{$ordine->ship_date}}"> 

                           </td> 
                           <td>
                              
                               <small>

                                 <input type='date' class='form-control' id='ship_date_estimated{{$ordine->id}}' style='width:auto' value="{{$ordine->ship_date_estimated}}">                                
                               </small>

                           </td> 
                           <td style='text-align:center'>

                              
                              
                              <span id='spin{{$ordine->id}}' style='display:inline;' hidden>
                                 <i class='fas fa-spinner fa-spin'></i>
                              </span>
                              
                                <button type="button" onclick="save_info({{$ordine->id}})" class="btn btn-success">Save</button>

                                <button type="submit" onclick="$('#id_order_view').val({{$ordine->id}})" class="btn btn-info">View</button>
                           </td> 
                        </tr>
                           
                     @endforeach 
                     </tbody> 
                     <tfoot>
                        <tr>
                           <th>ID</th>
                           <th>Status</th>
                           <th>ID user</th>
                           <th>name</th>                           
                           <th>Date Order</th>
                           <th>FedEx Tracker Shipping</th>
                           <th>Date Shipping</th> 
                           <th>Estimated Date Shipping</th>
                           <th>Operation</th>
                        </tr>
                     </tfoot>
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
   <script src="{{ URL::asset('/') }}js/order_admin.js?ver=<?= time() ?>"></script>
@endsection

