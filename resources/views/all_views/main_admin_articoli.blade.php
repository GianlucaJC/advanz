@extends('all_views.viewmaster.index_a')


@section('title', 'Advanz')

@section('extra_style') 
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

      <div class="appointment_section mt-3">
            <div class="container">
               <div class="appointment_box" style='overflow-x:scroll'>
                    <table id='tbl_art_liof' class="display nowrap">
                        <thead>
                            <tr>
                                <th>Molecola</th>
                                <th>Packaging</th>
                                <th>Pack Quantity</th>    
                                <th>Liofilchem Code</th>
                                <th>Description</th>
                                <th>Stock</th>
                                <th>Remaining</th>
                                <th>Operation</th>
                            </tr>   
                        </thead> 
                        <tbody>
                            @foreach ($allestimento as $art)
                              <tr>  
                                 <td>
                                 <?php
                                    if (isset($molecola[$art->id_molecola]))
                                       echo $molecola[$art->id_molecola];
                                    else
                                       echo $art->id_molecola;
                                 ?>                              
                                 </td>
                                 <td>
                                 <?php
                                  if (isset($packaging[$art->id_pack]))
                                    echo $packaging[$art->id_pack];
                                  else  
                                    echo $art->id_pack;
                                  ?>                                
                                 </td>
                                 <td>
                                 <?php
                                    if (isset($pack_qty_id[$art->id_pack_qty]))
                                      echo $pack_qty_id[$art->id_pack_qty];
                                    else
                                       echo $art->id_pack_qty;
                                 ?>                                  
                                 </td>
                                 <td>
                                    <input type='text' placeholder='Code Liofilchem' class='form-control' id='cod_liof{{$art->id}}' style='width:150px' maxlength=20 value="{{$art->cod_liof}}"> 

                                 </td>
                                 <td>
                                    <input type='text' placeholder='Description' class='form-control' id='description{{$art->id}}' style='width:150px' value="{{$art->descrizione}}"
                                 </td>

                                 </td>
                                 <td>
                                    <input type='text' placeholder='Stock' class='form-control' id='stock{{$art->id}}' style='width:100px' maxlength=20 value="{{$art->stock}}"> 

                                 </td>
                                 <td>
                                    {{$art->remaining}}
                                 </td>                                 
                                 <td>
                                    <span id='spin_art{{$art->id}}' style='display:inline;' hidden>
                                    <i class='fas fa-spinner fa-spin'></i>
                                    </span>

                                    <button type="button" onclick="save_art_liof({{$art->id}})" class="btn btn-success">Save</button>                              
                                 </td>                                 
                              </tr>  
                            @endforeach 
                        </tbody>
                    </table>
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
   <script src="{{ URL::asset('/') }}js/art_admin.js?ver=<?= time() ?>"></script>
@endsection

