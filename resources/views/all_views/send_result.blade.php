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
      <div class="appointment_section mt-2">
         <div class="container">
            <div class="appointment_box">
               <h2>TEST RESULT</h2>
                  <p style='text-align:justify'>            
                     By uploading the results of the individual isolates tested with the material ordered on ADVANZ ASTIP you have the opportunity to understand the susceptibility profile at your institution and support ADVANZ PHARMA to collate surveillance information on local susceptibility
                  </p>
               </div>
         </div>
      </div>

      <div class="appointment_section mt-3">
         <div class="container">
            <div class="appointment_box">

                
                  @if(session('error'))
                     <div class="alert alert-warning mb-2 mt-2" role="alert">
                        <p>
                           <h3><b>Attention!</b> File not sent</h3><hr>
                           Check size attachents. <b>Max length is 2048 Bytes (2MB)</b><br>
                           Only this format are accepted: <b>png, jpg, pdf, doc, xls, zip</b>
                        </p>
                     </div>
                  @endif                  


                  @if(session('success'))
                     <div class="alert alert-success mb-2 mt-2" role="alert">
                        <p>{{ session('success') }}</p>
                     </div>
                  @endif  

                  <button type="button" class="btn btn-info mt-2" onclick="$('#your').toggle(200);$('#div_up').toggle(200);"><i class="fas fa-plus"></i> Add Test Result</button>
                  <div id='div_up' style='display:none'>    
                     <form action="upload" method="POST" enctype="multipart/form-data">
                        @csrf         
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>  
                        <hr>
                        <button type="button" class="btn btn-secondary mt-2 mb-2" onclick="$('#your').show(200);$('#div_up').hide(200);">Close</button>

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
                                 <label for="id_molecola">Molecule*</label>
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
                                 <label for="id_pack">Packaging*</label>
                              </div>
                           </div> 

                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control" id="testo_ref" name='testo_ref' type="text" placeholder="Custom text for attachment" required value=""  />
                                 <label for="testo_ref">Associated text*</label>
                              </div>
                           </div> 

                        </div>

                        <div class="row mb-3 g-2">
                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control" id="culture_date" name='culture_date' type="text" placeholder="Culture Date" required value=""  />
                                 <label for="culture_date">Culture Date*</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control" id="species_name" name='species_name' type="text" placeholder="Species name" required value=""  />
                                 <label for="species_name">Species name*</label>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control" id="infection_source" name='infection_source' type="text" placeholder="Infection source" required value=""  />
                                 <label for="infection_source">Infection source*</label>
                              </div>
                           </div> 
                        </div>   

                        <div class="row mb-3 g-2">
                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <select class="form-select" name='test_method' id='test_method' required onchange='set_um(this.value)'>
                                    <option value="">Select...</option>
                                    <option value='gs'>Gradient strips</option>
                                    <option value='bm'>Broth microdilution</option>
                                    <option value='ds'>Disks</option>
                                    <option value='ap'>Automated plates</option>
                                 </select>
                                 <label for="test_method">Test method user*</label>
                              </div>
                           </div> 

                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control decimal" id="test_result" name='test_result' type="text" placeholder="Test result" required value=""  />
                                 <label for="test_result">Test results (MIC ug/ml)*</label>
                              </div>
                           </div>
                        </div> 

                       
                        <hr>
                        <div class="mb-3">
                           <input class="form-control form-control-sm" name="file" type="file" id='fileup'>
                        </div>
                        <button type="submit" name='wf' class='btn btn-outline-secondary' onclick="$('#fileup').prop('required', true);">Upload and submit</button>                  
                        <button type="submit" name='nof' class='btn btn-outline-secondary' onclick="$('#fileup').prop('required', false);">Submit with no file</button>
                     </form>
                     @if (!session('error') && !session('success')) 
                        <div class="alert alert-info mb-2 mt-2" role="alert">
                           <p>
                              Check size attachents. <b>Max length is 2048 Bytes (2MB)</b><br>
                              Only this format are accepted: <b>png, jpg, pdf, doc, xls, zip</b>
                           </p>
                        </div>                  
                     @endif

 
                  </div>      
               <hr>
               <div id='your' style='overflow-x:scroll'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                           <th style='max-width:100px'><i class='fas fa-trash-alt'></i></th>
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Culture date</th>  
                           <th>Species name</th>  
                           <th>Infection source</th>  
                           <th>Test method</th>  
                           <th>Test result</th>  
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

                           <td style='max-width:100px'>
                              <div style='display:inline;' class='divup{{$id_up}}'>
                                 <span id='spin{{$id_up}}' style='display:none'>
                                    <i class='fas fa-spinner fa-spin'></i>
                                 </span>

                                 <button type='button' ><i onclick='delete_up({{$id_up}})' class='fas fa-trash-alt'></i></button>
                              </div>            
                           </td>                          

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
                              <?php
                                 /*
                                 if (isset($arr_up[$ordine->id_molecola][$ordine->id_pack])) {
                                    if (!isset($fl_upload[$ordine->id_molecola][$ordine->id_pack])) {
                                       $obj=$arr_up[$ordine->id_molecola][$ordine->id_pack];
                                       for ($sca=0;$sca<count($obj);$sca++) {
                                          $info_ref=explode("|",$obj[$sca]);
                                          $id_up=$info_ref[0];
                                          $file_ref=$info_ref[1];
                                          $testo_ref=$info_ref[2];
                                          if ($sca!=0) echo "<br>";
                                          echo "<div style='display:inline;' class='divup$id_up'>";
                                             echo "<span id='spin$id_up' style='display:none'>";
                                                echo "<i class='fas fa-spinner fa-spin'></i>";
                                             echo "</span> ";
                                             echo "<a href='#' onclick='delete_up($id_up)'>";
                                                echo "<i class='fas fa-trash-alt'></i>";
                                             echo "</a>";
                                          echo "</div>";      
                                          echo "<div class='divup$id_up' style='display:inline;margin-left:7px'>";
                                             echo "<a class='link-underline-primary' href=".asset('storage/uploads/'.$file_ref)." target='_blank'>";
                                                echo $testo_ref;
                                             echo "</a>";               
                                          echo "</div>";
                                          
                                       }
                                       
                                    } else echo "--";
                                    $fl_upload[$ordine->id_molecola][$ordine->id_pack]=true;
                                 } 
                                   */
                              ?>
                         
                       

                        </tr>
                      <?php } ?>     
                     @endforeach  
                     <tfoot>
                        <tr>
                           <th style='max-width:100px'></th>
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Culture date</th>  
                           <th>Species name</th>  
                           <th>Infection source</th>  
                           <th>Test method</th>  
                           <th>Test result</th>  
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
   <script src="{{ URL::asset('/') }}js/send_result.js?ver=<?= time() ?>"></script>
@endsection

