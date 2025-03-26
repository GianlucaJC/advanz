<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="theme-color" content="#dc3545"/>
      <!-- bootstrap css -->
      <title>@yield('title')</title>
       
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
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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

     .active_m {
            display:inline-block;
            width:230px;
            background-color: #f2f4f4;
            padding:10px;
            border: 3px solid #aed6f1 ;
            border-radius: 20px;
            color:blue;
      }

      .normal_m {
            display:inline-block;
            width:230px;
            background-color:rgba(190, 206, 206, 0.07);
            padding:10px;
            border: 1px solid #aed6f1 ;
            border-radius: 20px;
            
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
                  <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                     <g fill="#195C68" class="advnz-letters">
                           <polyline points="306.926395 18.8413953 264.565 18.8413953 264.565 30.1105814 284.727442 30.1105814 260.490349 70.0276744 304.277791 70.0276744 304.277791 58.7584884 282.826047 58.7584884 306.926395 18.8413953"></polyline>
                           <polyline points="217.55593 70.0276744 217.55593 38.7319767 242.131628 70.0276744 255.368953 70.0276744 255.368953 18.8413953 242.131628 18.8413953 242.131628 50.137093 217.55593 18.8413953 204.250233 18.8413953 204.250233 70.0276744 217.55593 70.0276744"></polyline>
                           <polyline points="102.015233 18.8413953 123.535349 70.0276744 134.125698 70.0276744 155.713372 18.8413953 141.253488 18.8413953 128.830116 50.0011628 116.475116 18.8413953 102.015233 18.8413953"></polyline>
                           <path d="M89.5348837,50.1712791 C88.8788372,51.9139535 87.9281395,53.4181395 86.6836047,54.6854651 C85.4390698,55.9536047 83.9112791,56.9490698 82.1010465,57.6726744 C80.290814,58.397093 78.2323256,58.7584884 75.9231395,58.7584884 L72.869186,58.7584884 L72.869186,30.1105814 L75.9231395,30.1105814 C78.1859302,30.1105814 80.2232558,30.4736047 82.0334884,31.1963953 C83.842907,31.920814 85.3706977,32.917093 86.6168605,34.1836047 C87.8597674,35.4517442 88.8226744,36.9673256 89.5015116,38.7319767 C90.1803488,40.4966279 90.5189535,42.3980233 90.5189535,44.4337209 C90.5189535,46.5166279 90.1909302,48.4294186 89.5348837,50.1712791 Z M102.467791,34.6923256 C101.15407,31.5927907 99.3552326,28.8774419 97.0712791,26.5462791 C94.7840698,24.2159302 92.1151163,22.3487209 89.0603488,20.9446512 C86.0047674,19.5438372 82.7351163,18.8413953 79.2497674,18.8413953 L59.5626744,18.8413953 L59.5626744,70.0276744 L79.2497674,70.0276744 C82.7798837,70.0276744 86.0731395,69.3268605 89.127907,67.9227907 C92.1818605,66.5219767 94.8524419,64.6425581 97.1380233,62.2894186 C99.4227907,59.9354651 101.21186,57.2087209 102.501163,54.1083721 C103.791279,51.0088372 104.436744,47.7847674 104.436744,44.4337209 C104.436744,41.0403488 103.77907,37.7934884 102.467791,34.6923256 Z"></path>
                           <path d="M21.0040698,51.0194186 L26.9784884,33.9793023 L32.952093,51.0194186 L21.0040698,51.0194186 Z M34.2422093,18.8413953 L19.7139535,18.8413953 L0.230348837,70.0276744 L14.419186,70.0276744 L17.4747674,61.1344186 L36.4822093,61.1344186 L39.5377907,70.0276744 L53.725814,70.0276744 L34.2422093,18.8413953 Z"></path>
                     </g>
                     <g fill="#94C129" class="color-elements">
                           <polyline points="172.242326 0.630813953 143.632674 70.0675581 170.443488 70.0675581 175.805 57.0288372 163.93186 57.0288372 172.880465 35.6096512 200.603721 105 200.527209 72.5826744 172.242326 0.630813953"></polyline>
                           <path d="M2.36372093,89.9394186 L7.73581395,89.9394186 C8.40406977,89.9394186 9.06093023,89.862093 9.7055814,89.7066279 C10.3502326,89.5519767 10.9232558,89.3012791 11.4246512,88.9545349 C11.9260465,88.6086047 12.3313953,88.1487209 12.6423256,87.5756977 C12.9524419,87.0026744 13.107907,86.2994186 13.107907,85.4626744 C13.107907,84.6511628 12.9467442,83.9584884 12.6244186,83.3854651 C12.302093,82.8124419 11.8845349,82.3411628 11.3709302,81.970814 C10.8573256,81.6012791 10.2663953,81.3326744 9.59813953,81.165 C8.92906977,80.9981395 8.26081395,80.9143023 7.59255814,80.9143023 L2.36372093,80.9143023 L2.36372093,89.9394186 Z M0,78.7654651 L7.30604651,78.7654651 C8.18918605,78.7654651 9.11465116,78.8672093 10.0816279,79.0698837 C11.0486047,79.2733721 11.9317442,79.625 12.7318605,80.1263953 C13.5311628,80.6277907 14.1880233,81.3147674 14.7016279,82.1856977 C15.2144186,83.0574419 15.4716279,84.1497674 15.4716279,85.4626744 C15.4716279,86.6087209 15.2624419,87.5993023 14.8448837,88.4352326 C14.4273256,89.2711628 13.8656977,89.9573256 13.1616279,90.4945349 C12.4567442,91.0317442 11.6452326,91.4313953 10.7262791,91.6943023 C9.80651163,91.9572093 8.84604651,92.0882558 7.84325581,92.0882558 L2.36372093,92.0882558 L2.36372093,104.121744 L0,104.121744 L0,78.7654651 Z"></path>
                           <polyline points="25.2130233 78.7654651 27.5759302 78.7654651 27.5759302 89.9394186 41.7590698 89.9394186 41.7590698 78.7654651 44.1219767 78.7654651 44.1219767 104.121744 41.7590698 104.121744 41.7590698 92.0882558 27.5759302 92.0882558 27.5759302 104.121744 25.2130233 104.121744 25.2130233 78.7654651"></polyline>
                           <path d="M64.6075581,81.3440698 L58.6982558,95.2398837 L70.3377907,95.2398837 L64.6075581,81.3440698 Z M63.4973256,78.7654651 L65.9326744,78.7654651 L76.6052326,104.121744 L73.955,104.121744 L71.1973256,97.3887209 L57.767093,97.3887209 L54.9019767,104.121744 L52.430814,104.121744 L63.4973256,78.7654651 Z"></path>
                           <path d="M87.2419767,89.9394186 L92.2559302,89.9394186 C93.4972093,89.9394186 94.5056977,89.7847674 95.2822093,89.4738372 C96.057907,89.1637209 96.6610465,88.7811628 97.090814,88.3277907 C97.5205814,87.8744186 97.8119767,87.3852326 97.9682558,86.8594186 C98.122907,86.3344186 98.2010465,85.8566279 98.2010465,85.4268605 C98.2010465,84.997093 98.122907,84.5201163 97.9682558,83.9943023 C97.8119767,83.4693023 97.5205814,82.9793023 97.090814,82.5259302 C96.6610465,82.0725581 96.057907,81.69 95.2822093,81.3798837 C94.5056977,81.0697674 93.4972093,80.9143023 92.2559302,80.9143023 L87.2419767,80.9143023 L87.2419767,89.9394186 Z M84.8782558,78.7654651 L91.5396512,78.7654651 C91.8733721,78.7654651 92.3275581,78.7776744 92.9005814,78.8012791 C93.4736047,78.8256977 94.0938372,78.8973256 94.762907,79.0161628 C95.4311628,79.135814 96.1116279,79.3262791 96.8043023,79.589186 C97.4961628,79.852907 98.1163953,80.2338372 98.6666279,80.7352326 C99.2152326,81.2366279 99.6694186,81.8690698 100.027558,82.6333721 C100.385698,83.3976744 100.564767,84.3296512 100.564767,85.4268605 C100.564767,86.6445349 100.354767,87.6473256 99.9380233,88.4352326 C99.5196512,89.2231395 98.9946512,89.862093 98.3622093,90.3512791 C97.7289535,90.8412791 97.0305814,91.2051163 96.267093,91.4436047 C95.5027907,91.682907 94.7743023,91.8497674 94.0824419,91.945 L101.460116,104.121744 L98.7740698,104.121744 L91.647093,92.0882558 L87.2419767,92.0882558 L87.2419767,104.121744 L84.8782558,104.121744 L84.8782558,78.7654651 Z"></path>
                           <polyline points="110.520233 78.7654651 114.065814 78.7654651 123.305814 100.038953 132.545814 78.7654651 135.912326 78.7654651 135.912326 104.121744 133.548605 104.121744 133.548605 81.7738372 133.476977 81.7738372 123.807209 104.121744 122.768605 104.121744 112.955581 81.7738372 112.883953 81.7738372 112.883953 104.121744 110.520233 104.121744 110.520233 78.7654651"></polyline>
                           <path d="M156.147209,81.3440698 L150.237907,95.2398837 L161.877442,95.2398837 L156.147209,81.3440698 Z M155.036977,78.7654651 L157.472326,78.7654651 L168.144884,104.121744 L165.494651,104.121744 L162.736977,97.3887209 L149.306744,97.3887209 L146.441628,104.121744 L143.970465,104.121744 L155.036977,78.7654651 Z"></path>
                     </g>
                  </g>
               </svg>  
               </a>                 
               </center>   
               @php
                  $main_ref="main";
                  if ( Auth::user()) $main_ref="main_pharma";
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
                        @if (!Auth::user())
                        <li class="nav-item">
                           <a class="nav-link" href="javascript:void(0)" onclick="$('#div_intro').hide();$('#div_sign').show(200);">Register</a>
                        </li>
                              
                        
                        <div>
                           <li class="nav-item">
                              <a class="nav-link" href="#" onclick="$('#div_intro').hide();$('#div_reg_log').hide(100);$('#div_sign').hide();$('#div_log').show(250);"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Login</span></a>
                           </li>
                           <li class="nav-item">
                                 <a class="nav-link" href="#" onclick="$('#div_intro').hide();$('#div_reg_log').hide(100);$('#div_sign').show(250);$('#div_log').hide();"><i class="fa fa-user" aria-hidden="true"></i><span class="signup_text">Sign Up</span></a>
                           </li>
                        </div>
                        @endif                         
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
                        <li><a href="https://www.advanzpharma.com/privacy-policy" target='_blank'>Privacy Policies</a></li>

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

       @if ( Auth::user()) 
      
         <div class="appointment_section">
            <div class="container">
               <div class="appointment_box">
                  <h3>
                  <div class="row g-4">
                    
                     <div class="col-md-3">
                        <div class='custom_lnk'>
                           <?php   
                              $act="normal_m";
                              if ($route=="main_pharma") $act="active_m";
                           ?>
                           <span class='{{$act}}''>
                              <a href="main_pharma">Customer requests <i class="fas fa-clipboard-list"></i></a>
                           </span>   
                        </div>   
                     </div>
                     <div class="col-md-3">
                        <div class='custom_lnk'>
                           <?php   
                              $act="normal_m";
                              if ($route=="send_result_pharma") $act="active_m";
                           ?>
                           <span class='{{$act}}'>
                              <a href="send_result_pharma">Customer Test <i class="fas fa-flask"></i></i></a>
                           </span>
                        </div>   
                     </div>       
                     
                     <div class="col-md-3">
                        <div class='custom_lnk'>
                           <span class='normal_m'>
                              <a href="#" onclick="$('#div_stat').toggle(150)">Statistics <i class="fa-solid fa-chart-pie"></i></a>
                           </span>
                        </div>   
                     </div>                     
                  
                  </div> 
               </div>  
               </h3>
            </div>   
         </div> 
       
      @endif 


      @yield('content_main')


      @if ( !Auth::user())
      <div class="about_section layout_padding mb-3">
         <div class="container">


            <div class="row">
               <div class="col-md-6">
                  <h1 class="about_taital">About Advanz Pharma</h1>
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
                              <span class="padding_15">11-15 Seaton Place St Helier Jersey JE4 0QH</span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>
                              <span class="padding_15">Direct: +44 (0) 208 588 9100</span></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>
                              <span class="padding_15">Email : enquiries@advanzpharma.com</span></a>
                           </li>
                        </ul>
                     </div>
                     <div class="footer_social_icon">
                        <ul>
                           <li>
                              <a href="#"><i class="fa-brands fa-facebook" aria-hidden="true"></i></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa-brands fa-linkedin" aria-hidden="true"></i></a>
                           </li>
                           <li>
                              <a href="#"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
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
                           <a href="https://www.advanzpharma.com/privacy-policy" target='_blank'>Privacy Policies</a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-lg-3 col-sm-6">
                     <h3 class="footer_taital">Help & Support</h3>
                     <p class="ipsum_text">To obtain support on using the services, contact enquiries@advanzpharma.com</p>
                  </div>

               </div>
            </div>
         </div>
      </div>

      




      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text"><?php echo date("Y"); ?> All Rights Reserved. </p>
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