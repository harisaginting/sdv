<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PRIME</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url(); ?>assets/css/login/app.css" rel="stylesheet"/>
    <link href="<?= base_url(); ?>assets/css/login/login.css?"  rel="stylesheet"/>
    
    <style type="text/css">
       
</style>

<script type="text/javascript">
  var base_url = "<?= base_url(); ?>"
</script>

</head>

<body style="overflow: hidden !important;">    
    <div class="header" style="padding: 2px; z-index: 10;min-height: 50px;min-width:100%; float: top;background: #f00;position: fixed;opacity: 0.9;">
        <img src="<?= base_url();?>assets/img/telkomlogo.png" class="pull-right pull top" alt="" width="60">
    </div>
    <div id="wrapper" class="background1"></div>      
    <!-- <div id="" class="background1a"></div>  -->     
    <div id="wrapper" class="background2"></div>  
    <div class="container row" style="margin: 0px !important;">
      <div class="container-forms">
        <div class="container-info">
          <div class="info-item">
            <div class="table">
              <div class="table-cell">
                <p>
                  Have an account?
                </p>
                <div class="btn">
                  Log in
                </div>
              </div>
            </div>
          </div>
          <div class="info-item">
            <div class="table">
              <div class="table-cell">
                <p>
                  Don't have an account? 
                </p>
                <div class="btn">
                  Sign up
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-form">
          <div class="form-item log-in">
            <div class="table">
              
                  <div class="table-cell">
                    <form action="<?= base_url();?>login/login_prosess" method="post" accept-charset="utf-8" style="" autocomplete="off">
                        <div style="width: 100%;padding-right: : 50px">
                        <img src="<?= base_url();?>assets/img/logo_prime2.png" style="margin-left:10%;margin-bottom:10px;width: 80%;" >
                        </div>
                        <input name="nik" placeholder="ID / NIK" type="text" />
                        <input name="password" placeholder="Password" type="Password" />
                        <button type="submit" class="btn" >Sign In</button> 
                    </form>
                    <br>
                    <?=$this->session->flashdata('alError')?> 
                  </div>
              
            </div>
          </div>
          <div class="form-item sign-up">
            <div class="table">
              <div class="table-cell">
                <form action="<?=base_url()?>login/registration_mitra" method="POST" class="form-horizontal" id="form_registration" style="padding:10px;">
                  <div style="margin-bottom: 2px;width: 100%;padding-left: 5%;" class="">
                    <select name="mitra" id="mitra" style="min-width: 89%;" required>
                                        <option></option>
                    </select>
                  </div>
                   <div class="form-group">
                   </div>
                <input name="id" id="id" value="" class="input-group" placeholder="Gunadakan ID LDAP" type="text" required />
                <input name="nama" value="" placeholder="Full Name" id="nama" type="text" required />
                <input type="number" name="telepon" value=""   placeholder="Phone Number"  required/>
                <input type="email" name="email" value="" placeholder="Email" id="emailUser" required/>

                <button type="submit" class="btn" >Sign Up</button> 
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/jquery_validation/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url(); ?>assets/vendor/jquery_validation/additional-methods.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?= base_url(); ?>assets/vendor/select2/js/select2.full.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/select2/css/select2.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/select2/css/select2-bootstrap.css">


    <script src="<?= base_url(); ?>assets/js/prime/registration_mitra.js"></script>


    <script type="text/javascript">
      $(".info-item .btn").click(function(){
      $(".container").toggleClass("log-in");
      });
      
    </script>

    <script>
      $(document).ready(function(){
      var header = $('.background1a');

      var backgrounds = new Array(
          'url(https://prime.telkom.co.id/V2/assets/img/ceo/1.jpeg)'
        , 'url(https://prime.telkom.co.id/V2/assets/img/ceo/2.jpeg)'
        , 'url(https://prime.telkom.co.id/V2/assets/img/ceo/3.jpeg)'
      );

      var current = 0;

      function nextBackground() {
          current++;
          current = current % backgrounds.length;
          header.css('background-image', backgrounds[current]);
      }
      setInterval(nextBackground, 5000);

      header.css('background-image', backgrounds[0]);
      });
  </script>

</body>
</html>
