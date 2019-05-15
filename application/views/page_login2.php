<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.png">

    <title>PRIME</title>

    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/plugin/bootstrap3/css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Courgette" rel="stylesheet">


    <script type="text/javascript">
        var base_url = "<?= base_url(); ?>";
    </script>
    <script src="<?= base_url(); ?>assets/plugin/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/plugin/bootstrap/dist/js/bootstrap.min.js"></script>

     <script src="<?= base_url(); ?>assets/js/login.js"></script>

     <style type="text/css">
       .nav-item{
        line-height: 40px;
       }

       .sdv-text{
        font-size: 14px;
        font-weight: 900;
        font-style: bold;
        color: #fff;
       }


       .form-item {
          left: 10%;
          right: 10%;
          opacity: 1;
          border-radius: 20px;
          width: 305px;
          height: 270px;
          padding-top: 20px;
          background-color: #f30d0d;
          box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.2);
          -moz-transition: all 0.5s;
          -o-transition: all 0.5s;
          -webkit-transition: all 0.5s;
          transition: all 0.5s;
        }

        .container-top{
          margin-left: 10px !important;
          margin-right: 10px !important; 
          max-width: 100% !important;
        }

        .table input {
          color:  #575757;
          padding: 10px 15px;
          margin: 0 auto 15px;
          display: block;
          width: 220px;
          border-radius : 10px;
          -moz-transition: all 0.3s;
          -o-transition: all 0.3s;
          -webkit-transition: all 0.3s;
          transition: all 0.3s;
        }


        .btn-sign-in{
          background-color: #575757;
        }

        .btn-sign-in:hover {
          background-color: #0f0 !important;
          border: #fff solid 2px;
        }

        .single-testimonial-area{
          background-image: url(<?=base_url();?>assets/img/bg_support.jpeg);
        }

        #main_title{
          font-family: 'Black Ops One', cursive;
        }

        


     </style>


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/bootstrap.min.css" >
    <!-- Font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/font-awesome.min.css">
    <!-- Slicknav -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/slicknav.css">
    <!-- Owl carousel -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/owl.theme.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/main.css">
    <!-- Extras Style -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/extras.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/template/login/css/responsive.css">

  </head>
  <body style="overflow-x: hidden;">

    <!-- Header Area wrapper Starts -->
    <header id="header-wrap">

      <!-- sliders -->
      <div id="sliders">
        <div class="full-width">
          <!-- light slider -->
          <div id="light-slider" class="carousel slide">
            <div id="carousel-area">
              <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img  src="<?= base_url();?>/assets/img/bg_login.jpg" style="min-height: 600px;" >
                    <div class="carousel-caption">
                      <h3 id="main_title" class="slide-title animated fadeInDown"><span>P R I M E</span></h3>
                      <h5 style="font-family: 'Courgette', cursive !important;" class="slide-text animated fadeIn">Project Reporting and Monitoring for Enterprise</h5>
                      <div class="form-item log-in center-block">
                          <div class="table">
                                <div class="table-cell" style="padding-top: 20px !important;vertical-align: inherit;">
                                  <?=$this->session->flashdata('alError')?>
                                  <form action="<?= base_url(); ?>login/login_proccess" method="post" accept-charset="utf-8" style="" autocomplete="off" style="margin-bottom: 10px;">
                                      <input name="nik" placeholder="ID / NIK" type="text">
                                      <input name="password" placeholder="Password" type="Password">
                                                                  <div style="text-align: center;">
                                        <button type="submit" class="btn btn-sign-in" style="">Sign In</button>  
                                      </div>
                                  </form>

                                  <!-- <span class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://prime.telkom.co.id/V2" style="color: #ffd200">Use Previous Version</a></span> -->
                                </div>
                            
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End sliders -->

    </header>
    <!-- Header Area wrapper End -->

    <!-- Footer Section -->
    <footer class="footer">
      <!-- Container Starts -->
      <div class="container">
        <!-- Row Starts -->
        <div class="row section">
          <!-- Footer Widget Starts -->
          <div class="footer-widget offset-lg-9 col-lg-3 col-md-6 col-xs-12 wow fadeIn">
            <h3 class="small-title">
              About Us
            </h3>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis veritatis eius porro modi hic. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            </p>
            <div class="social-footer">
              <a href="#"><i class="fa fa-facebook icon-round"></i></a>
              <a href="#"><i class="fa fa-twitter icon-round"></i></a>
              <a href="#"><i class="fa fa-linkedin icon-round"></i></a>
              <a href="#"><i class="fa fa-google-plus icon-round"></i></a>
            </div>
          </div>
        </div>
        <!-- Row Ends -->
      </div>
      <!-- Container Ends -->

      <!-- Copyright -->
      <div id="copyright">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
              <p class="copyright-text">All copyrights reserved ©2018 <a rel="nofollow" href="<?= base_url(); ?>">SDV - DES</a>
              </p>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
            </div>
          </div>
        </div>
      </div>
      <!-- Copyright  End-->

    </footer>
    <!-- Footer Section End-->

    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
      <i class="fa fa-arrow-up"></i>
    </a>
    
    <!-- Preloader -->
    <div id="preloader">
      <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url();?>assets/template/login/js/jquery-min.js"></script>
    <script src="<?= base_url();?>assets/template/login/js/bootstrap.min.js"></script>
    <script src="<?= base_url();?>assets/template/login/js/main.js"></script>
      
  </body>
</html>
