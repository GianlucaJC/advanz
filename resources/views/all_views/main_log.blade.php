@extends('all_views.viewmaster.index')


@section('title', 'Advanz')

@section('extra_style') 
<!-- x button export -->

   <script async src="https://www.google.com/recaptcha/api.js"></script>
<!-- -->

@endsection



<?php if (1==2) {?>
   @section('top')
      @include('all_views.components.top')
   @endsection
<?php } ?>

@section('banner')
   @include('all_views.components.banner')
@endsection

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
    <form method='post' action="{{ route('main_log') }}" id='frm_main' name='frm_main' class="needs-validation" autocomplete="off" novalidate>
		
   <input name="_token" type="hidden" value="{{ csrf_token() }}" id='token_csrf'>


      
      <!-- start section material !-->
      <div class="appointment_section mt-3">
         <div class="container">
           
            <div class="appointment_box">
               <div class="row mb-2">
                  <div class="col-md-12">
                     <h3>Testing <span style="color: #0cb7d6;"> Material Selection</span></h3>
                  </div>
               </div>

               <div class="row mb-3">

                  <div class="alert alert-info" role="alert">
                     <i class="fas fa-cart-plus"></i> Your cart 
                     @if ($count==0) is empty! @endif
                  </div>

                  <h5 style="text-align:center">Please select the testing materials you wish to receive.</h5><hr>

                  <?php 
                  
                     $view="";
                     $id_old_mp="?";$id_old_mole="?";
                     $can_order=false;
                     foreach ($molecole_in_allestimento as $mole_in_all) {
                        $id_molecola=$mole_in_all->id_molecola;
                        $id_pack=$mole_in_all->id_pack;
                        if ($id_molecola!=$id_old_mole) {
                           if ($id_old_mole!="?") $view.="</div>";
                           $view.="<div class='row mt-4'>";
                              
                              if (isset($molecola[$id_molecola])) {
                                 $view.="<h5>Please select either ".$molecola[$id_molecola]." ";
                                 $descr_pack_in_mole=implode(" or ",$pack_in_mole[$id_molecola]);
                                 $view.=$descr_pack_in_mole;
                                 $view.="</h5><hr>";
                              } else continue;
                              
                        }
                        $id_old_mole=$id_molecola;
                        $id_mole_pack=$id_molecola.$id_pack;
                        $obj="";
                        if ($id_mole_pack!=$id_old_mp) {
                           //creazione select di scelta riferita alla molecola/packaging
                           $voci=$arr_info[$id_mole_pack]['voci_conf'];
                           
                           $render_obj=true;$no_mol="";$no_pack="";
                           $obj.="<div class='col-md-4 sm-12'>";
                              $obj.="<div class='form-floating mb-3 mb-md-0'>";
                                 $obj.="<select class='form-select mole molecola$id_molecola' name='material[]' id='material$id_mole_pack'  onchange=\"check_choice($id_molecola,'material$id_mole_pack',this.value)\">";
                                 $obj.="<option value=''>None (0 ".$molecola[$id_molecola]." ".$packaging[$id_pack].")</option>";
                                    for ($sca=0;$sca<count($voci);$sca++) {
                                       $id_allestimento=$voci[$sca]['id'];
                                       if (in_array($id_allestimento,$id_in_ordini)) {
                                          $no_mol=$voci[$sca]['molecola_descr'];
                                          $no_pack=$packaging[$id_pack];

                                          $render_obj=false;
                                          break;
                                       }
                                       $obj.="<option value='".$id_allestimento."' ";
                                       if (in_array($id_allestimento,$id_in_carrello)) $obj.=" selected ";
                                       $voce=$voci[$sca]['id_pack_qty']." ".$voci[$sca]['molecola_descr']." ".$voci[$sca]['pack_descr'];

                                       $obj.=">".$voce;
                                       $obj.="</option>";
                                    }
                                
                                 $obj.="</select>";
                                 $lbl=$arr_info[$id_mole_pack]['label'];
                                 $obj.="<label for='material$id_mole_pack'>$lbl</label>";
                              $obj.="</div>";
                           $obj.="</div>";
                           if ($render_obj==true) {
                              $can_order=true;
                              $view.=$obj;
                           }
                           else 
                              $view.="
                                 <div class='alert alert-warning' role='alert'>
                                    
                                    <h5>
                                       You can no longer request this product ($no_mol/$no_pack)!
                                    </h5>   
                                 </div>   
                              ";
                           

                        }
                        $id_old_mp=$id_mole_pack;

                        
                     }
                     $view.="</div>"; //chiusura ultimo <div class='row'>
                     if ($can_order==true)
                        echo $view;
                     else
                        echo "
                        <div class='alert alert-warning' role='alert'>
                           <h5>
                              At the moment you can no longer make requests!
                           </h5>   
                        </div>";
                   
                  ?>             

                  <div class='container-fluid'>
                     <div class="alert alert-dark mt-4" role="alert">
                        Requests for Ceftobiprole and Enmetazobactam powder may be sent to Clinicaldevelopment@advanzpharma.  com      
                     </div>
                  </div>                 
 
               </div>
               @if ($can_order==true)
                  <div class="about_bt"><a href="#" onclick="send_request()">Send Request</a></div>
               @endif   

            </div>
         </div>
      </div>       
      <!--end section material !-->

      
   </form>   
   </div> <!-- end div sign_up !-->
   

@endsection

@section('content_plugin')
   <script src="{{ URL::asset('/') }}js/main_log.js?ver=<?= time() ?>"></script>
@endsection

