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
  
               <div id='your'>
                  <table id='tbl_articoli' class="display nowrap">
                     <thead>
                        <tr>
                          
                           <th>Molecule</th>
                           <th>Packaging</th>  
                           <th>Attachments</th>
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
                              ?>
                           </td>
                       

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
                        <p>
                           <h3><b>Attention!</b> File not sent</h3><hr>
                           Check size attachents. <b>Max length is 2048 Bytes (2MB)</b><br>
                           Only this format are accepted: <b>png, jpg, pdf</b>
                        </p>
                     </div>
                  @endif
                  @if (!session('error') && !session('success')) 
                       <div class="alert alert-info mb-2 mt-2" role="alert">
                        <p>
                           Check size attachents. <b>Max length is 2048 Bytes (2MB)</b><br>
                           Only this format are accepted: <b>png, jpg, pdf</b>
                        </p>
                     </div>                  
                  @endif


                  <button type="button" class="btn btn-info mt-2" onclick="$('#div_up').toggle(200);"><i class="fas fa-plus"></i> Add Test Result</button>
                  <div id='div_up' style='display:none'>    
                     <form action="upload" method="POST" enctype="multipart/form-data">
                        @csrf         
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>  
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

                           <div class="col-md-4">
                              <div class="form-floating mb-3 mb-md-0">
                                 <input class="form-control" id="testo_ref" name='testo_ref' type="text" placeholder="Custom text for attachment" required value=""  />
                                 <label for="testo_ref">Associated text*</label>
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

