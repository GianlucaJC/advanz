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
  
            <div id='your' style='overflow-x:scroll'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Culture date</th>  
                           <th>Species name</th>  
                           <th>Infection source</th>  
                           <th>Test method</th>  
                           <th>Test result</th> 
                           <th>Description</th> 
                           <th>Attachments</th>
                        </tr>
                     </thead>
                     <?php
                        $fl_upload=array();
                        $keys=array_keys($arr_up);
                       
                     ?>  
                     @foreach($keys as $key)
                     <?php

                        for ($ii=0;$ii<count($arr_up[$key]);$ii++) {
                           $info_k=explode("_",$key);
                           $id_molecola=$info_k[0];
                           $id_pack=$info_k[1];
                           $file_ref=$arr_up[$key][$ii]->filereal;
                           $testo_ref=$arr_up[$key][$ii]->testo_ref;
                           $id_up=$arr_up[$key][$ii]->id;

                           $culture_date=$arr_up[$key][$ii]->culture_date;
                           $species_name=$arr_up[$key][$ii]->species_name;
                           $infection_source=$arr_up[$key][$ii]->infection_source;
                           $test_method=$arr_up[$key][$ii]->test_method;
                           $test_result=$arr_up[$key][$ii]->test_result;
                     ?>
                        <tr id='row_{{$id_up}}'>

                              

                           <td>
                              <?php
                                 if (isset($molecola[$id_molecola]))
                                    echo $molecola[$id_molecola];
                                
                              ?>
                           </td>
                           <td>
                              <?php
                                 if (isset($packaging[$id_pack]))
                                    echo $packaging[$id_pack];
                                 ?>                              
                           </td>  


                           <td>{{$culture_date}}</td>  
                           <td>{{$species_name}}</td>  
                           <td>{{$infection_source}}</td>  
                           <td>
                                 <?php
                                    $um="ug/ml";
                                    if ($test_method=="gs") echo "Gradient strips";
                                    if ($test_method=="bm") echo "Broth microdilution";
                                    if ($test_method=="ds") {echo "Disks";$um="mm";}
                                    if ($test_method=="ap") echo "Automated plates";
                                 ?>   
                           </td>  
                           <td>
                                 <?php 

                                    if (intval($test_result)!=0)
                                       echo number_format($test_result,2)." $um"; 
                                 ?>
                           </td>  
                           
                        
                           <td>
                              {{$testo_ref}}
                           </td>
   

                           <td>
                             <?php
                                 if (strlen($file_ref)>0) {
                                    echo "<div class='divup$id_up' style='display:inline;margin-left:7px;border: 1px solid;padding:4px;border-radius:6px'>";
                                       echo "<a class='link-underline-primary' href=".asset('storage/uploads/'.$file_ref)." target='_blank'>";
                                          echo "<i class='fas fa-paperclip'></i> ";
                                          echo "$testo_ref";
                                       echo "</a>";               
                                    echo "</div>";            
                                 }                 
                             ?>
                           </td>
                        </tr>
                      <?php } ?>     
                     @endforeach  
                     <tfoot>
                        <tr>
                           
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Culture date</th>  
                           <th>Species name</th>  
                           <th>Infection source</th>  
                           <th>Test method</th>  
                           <th>Test result</th>
                           <th>Description</th>
                           <th>Attachments</th>
                        </tr>
                        </tfoot>
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

