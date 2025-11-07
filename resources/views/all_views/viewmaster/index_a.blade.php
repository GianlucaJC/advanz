<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="theme-color" content="#dc3545"/>
      <title>@yield('title')</title>
      <!-- bootstrap css -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ URL::asset('/') }}css/style.css?ver=3007">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ URL::asset('/') }}css/responsive.css">


      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ URL::asset('/') }}css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Poppins:400,700&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="{{ URL::asset('/') }}css/owl.carousel.m.css">

      <!-- <link rel="stylesheet" href="css/owl.theme.default.min.css">!-->
      <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">!-->
      @yield('extra_style')  
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

   </head>
   
   <style>
      .custom_lnk a:link {
         color: gray;
         }

         /* visited link */
      .custom_lnk a:visited {
         color: gray;
         }

         /* mouse over link */
      .custom_lnk a:hover {
         color: blue;
         }

         /* selected link */
      .custom_lnk a:active {
         color: blue;
         }      

     .admin-nav-item {
            display: block;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #6c757d; /* Bootstrap secondary color for subtle look */
            transition: all 0.3s ease;
      }
     .admin-nav-item:hover {
            background-color: #e9ecef; /* Light gray background on hover */
            color: #0056b3; /* Darker blue on hover */
      }      
     .admin-nav-item.active {
            background-color: #007bff6c; /* Bootstrap primary color */
            color: white;
            font-weight: bold;
            border: 1px solid #007bff;
      }
     .admin-nav-item.active i {
            color: white;
     }
     .admin-nav-item i {
            margin-left: 5px;
      }

   </style>
   <body>
      <!-- header top section start -->
      @yield('top')
      <!-- header top section end -->
      <!-- header section start -->
      <div class="header_section">
         <div class="container">

              <center>
                <a class="navbar-brand"href="#">
                     <img src="images/logo_p.png" style='width:30%'>
               </a>
               </center>
               @php
                  $main_ref="main_admin_order";
                  if ( Auth::user()) $main_ref="main_admin_order";
               @endphp
               <nav class="navbar navbar-expand-lg navbar-light bg-light">

                  <button class="navbar-toggler" onclick="$('#menuItems').collapse('toggle');" type="button"  aria-controls="menuItems" aria-expanded="false"  aria-label="Toggle Navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="menuItems">
                     <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                           <a class="nav-link" href="{{$main_ref}}">Home</a>
                        </li>

                     </ul>

                  </div>
               </nav>



               <div class="custom_bg">
               <div class="custom_menu">
                  @if (!Auth::user())
                     <ul>
                        <li class="active"><a href="{{$main_ref}}">Home</a></li>

                        <li><a href="javascript:void(0)" onclick="$('#div_intro').hide();$('#div_sign').show(200);">Register</a></li>

                        <li><a href="contact">Contact Us</a></li>
                        <li><a onclick="if (!confirm('Dear user, you are leaving the ASTIP website, are you sure?')) event.preventDefault();" href="https://www.advanzpharma.com/privacy-policy" target='_blank'>Privacy Policies</a></li>

                     </ul>
                     @endif
                  </div>
                  <?php
                     $disp="";
                     if ( Auth::user()) $disp="display:none";
                  ?>

                  <div id='div_sign_log' style='{{$disp}}' >
                        <div class="search_btn">
                           <li><a href="#" onclick="$('#div_intro').hide();$('#div_reg_log').hide(100);$('#div_sign').hide();$('#div_log').show(250);"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Login</span></a></li>
                           <li><a href="#" onclick="$('#div_intro').hide();$('#div_reg_log').hide(100);$('#div_sign').show(250);$('#div_log').hide();"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Sign Up</span></a></li>
                        </div>
                  </div>


                  @if ( Auth::user())
                        <div class="search_btn1">
                           <li>
                              <a href="profile">
                                 <i class="fas fa-university"></i>
                                 <span class="signup_text">Profile</span>
                              </a>
                           </li>

                           <div><span style='color:rgba(225, 217, 96, 0.97);'>{{ Auth::user()->name }}</div>
                        </div>

                        <div class="search_btn1">
                          <!-- Authentication -->
                           <form method="POST" action="{{ route('logout') }}">
                           @csrf
                              <li>
                                 <a href="#" onclick="event.preventDefault();this.closest('form').submit();">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="signup_text">Logout</span>
                                 </a>
                              </li>
                           </form>
                        </div>
               @endif

               </div>
         </div>



         <div class="banner_section layout_padding"></div>

      </div>

 <input type="hidden" value="{{url('/')}}" id="url" name="url">
      <?php
         $route=Route::currentRouteName();
      ?>

      @section('navigation_admin')
         @if ( Auth::user())

           <div class="appointment_section">
              <div class="container">
                 <div class="appointment_box">
                    <h3>
                    <div class="row g-4 justify-content-center"> {{-- Added justify-content-center for better spacing --}}

                       <div class="col-md-4"> {{-- Changed to col-md-4 for 3 items --}}
                          <div class='custom_lnk text-center'> {{-- Added text-center for alignment --}}
                             <a href="main_admin_order" class="admin-nav-item {{ $route == 'main_admin_order' ? 'active' : '' }}">
                                Customer requests <i class="fas fa-clipboard-list"></i>
                             </a>
                          </div>
                       </div>

                       <div class="col-md-4"> {{-- Changed to col-md-4 for 3 items --}}
                          <div class='custom_lnk text-center'> {{-- Added text-center for alignment --}}
                             <a href="main_admin_articoli" class="admin-nav-item {{ $route == 'main_admin_articoli' ? 'active' : '' }}">
                                Liofilchem Products <i class="fas fa-cog"></i>
                             </a>
                          </div>
                       </div>

                       <div class="col-md-4"> {{-- Changed to col-md-4 for 3 items --}}
                          <div class='custom_lnk text-center'> {{-- Added text-center for alignment --}}
                             <a href="{{ route('categories.manage') }}" class="admin-nav-item {{ $route == 'categories.manage' ? 'active' : '' }}">
                                Gestione Categorie <i class="fas fa-boxes"></i>
                             </a>
                          </div>
                       </div>

                    </div>
                 </div>
                 </h3>
              </div>
           </div>

        @endif
      @show

      @yield('content_main')


      @if ( !Auth::user())
      <div class="about_section layout_padding mb-3">
         <div class="container">


            <div class="row">
               <div class="col-md-6">
                  <h1 class="about_taital">About ADVANZ PHARMA</h1>
                  <p class="about_text"  style="text-align: justify;text-justify: inter-word;">

                     ADVANZ PHARMA is a global pharmaceutical company with the purpose to improve patients’ lives by providing the specialty, hospital, and rare disease medicines they depend on.

                     Our ambition is to be a partner of choice for the commercialisation of specialty, hospital, and rare disease medicines in Europe, Canada, and Australia. In line with our ambition, we are partnering with innovative biopharma and pharmaceutical development companies to bring medicines to patients.

                     Headquartered in London, UK, we have commercial sales in more than 90 countries globally and have a direct commercial presence in more than 20 countries, including key countries in Europe, the US, Canada, and Australia. </p>
                     <div class="about_bt"><a href="https://www.advanzpharma.com" target='_blank'>Read More</a></div>
               </div>
               <div class="col-md-6">
                  <div class="about_img"><img src="{{ URL::asset('/') }}images/piastre.jpg"></div>
               </div>
            </div>
         </div>
    </div>
    @endif

      <!-- treatment section start -->
      @yield('content2')
      <!-- treatment section end -->

      <!-- doctores section start -->
       @yield('content3')
      <!-- doctores section end -->

      <!-- testimonial section start -->
       @yield('content4')
      <!-- testimonial section end -->

      <!-- contact section start -->
       @yield('content5')
      <!-- contact section end -->
      <!-- footer section start -->
      <div class="footer_section">
         <div class="container">
            <div class="footer_section_2">
               <div class="row">
                  <div class="col-lg-3 col-sm-6">
                     <h3 class="footer_taital">Address</h3>
                     <div class="location_main">
                        <ul>
                          <li>
                              <a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>
                              <span class="padding_15">
                                 <b>Corporate Headquarters</b>,<br>
                                 Dashwood House, 2nd Floor, 69 Old Broad Street, London, EC2M 1QS
                              </span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>
                              <span class="padding_15">Direct: +39 (085) 8930745</span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>
                              <span class="padding_15">Email : enquiries@advanz-astip.com</span></a>
                           </li>
                        </ul>
                     </div>
                     <div class="footer_social_icon">
                        <ul>
                           <!--
                           <li>
                              <a href="#"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                           </li>
                           !-->
                           <li>
                              <a onclick="if (!confirm('Dear user, you are leaving the ASTIP website, are you sure?')) event.preventDefault();" href="https://www.linkedin.com/company/advanz-pharma/about/"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h3 class="footer_taital">Useful Link</h3>
                     <div class="footer_menu">
                        <ul>
                           <li class="active">
                              <a href="main_pharma">Home</a>
                           </li>
                           <li>
                              <a href="contact">Contact Us</a>
                           </li>
                           <li>
                           <a onclick="if (!confirm('Dear user, you are leaving the ASTIP website, are you sure?')) event.preventDefault();" href="https://www.advanzpharma.com/privacy-policy" target='_blank'>Privacy Policies</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h3 class="footer_taital">Help & Support</h3>
                     <p class="ipsum_text">
                     Healthcare professionals are asked to report any suspected adverse reactions via the national reporting system. Adverse events and product quality complaints should also be reported to Advanz Pharma at <a style='color:#0cb6d5' href="mailto:medicalinformation@advanzpharma.com">medicalinformation@advanzpharma.com</a><br><br>
                        To obtain support on using the services, contact

                        <a style='color:#0cb6d5' href="mailto:enquiries@advanz-astip.com">
                           enquiries@advanz-astip.com
                        </a>
                        </font>
                     </p>

                  </div>

               </div>
            </div>
         </div>
      </div>






      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">Copyright 2025 Liofilchem®. All Rights Reserved.</p>
         </div>
      </div>
      <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="{{ URL::asset('/') }}js/jquery.min.js"></script>
      <script src="{{ URL::asset('/') }}js/popper.min.js"></script>


      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



      <script src="{{ URL::asset('/') }}js/jquery-3.0.0.min.js"></script>
      <script src="{{ URL::asset('/') }}js/plugin.js"></script>
      <!-- sidebar -->
      <script src="{{ URL::asset('/') }}js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="{{ URL::asset('/') }}js/custom.js?ver=1.14"></script>
      <!-- javascript -->
      <!-- <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  !-->

      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

      @yield('content_plugin')

      <script>
         $('#datepicker').datepicker({
             uiLibrary: 'bootstrap'
         });
      </script>
      <script>
         $('#timepicker').timepicker({
             uiLibrary: 'bootstrap'
         });
      </script>
   </body>
</html>