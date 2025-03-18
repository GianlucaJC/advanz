@extends('all_views.viewmaster.index_p')


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
      border:1px solid;
      padding:4px;
      border-radius: 8px;
      text-align: center;
      font-size: 12px;
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
  
               <div id='your'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Attachments</th>
                        </tr>
                     </thead>

                     @foreach(array_keys($arr_up) as $id_ref) 
                         <tr>

                           <td>
                              <?php
                                 $id_molecola=$arr_up[$id_ref][0]->id_molecola;
                                 if (isset($molecola[$id_molecola]))
                                    echo $molecola[$id_molecola];
                              ?>
                           </td>
                           <td>
                              <?php
                                 $id_pack=$arr_up[$id_ref][0]->id_pack;
                                 if (isset($packaging[$id_pack]))
                                    echo $packaging[$id_pack];
                                 ?>                              
                           </td>  


                           <td>
                              <?php
                              for ($sca=0;$sca<count($arr_up[$id_ref]);$sca++) {
                              ?>

                                 <?php
                                    $id_up=$arr_up[$id_ref][$sca]->id;
                                    $file_ref=$arr_up[$id_ref][$sca]->filereal;
                                    $testo_ref=$arr_up[$id_ref][$sca]->testo_ref;
                                    if ($sca/3==intval($sca/5) && $sca!=0) echo "<hr>";
                                    echo "<div class='box divup$id_up' >";
                                       echo "<a class='link-underline-primary' href=".asset('storage/uploads/'.$file_ref)." target='_blank'>";
                                          echo "<i class='fas fa-paperclip'></i> $testo_ref";
                                       echo "</a>";               
                                    echo "</div>";
                               
                              }   
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
   <script src="{{ URL::asset('/') }}js/send_result_pharma.js?ver=<?= time() ?>"></script>
@endsection

