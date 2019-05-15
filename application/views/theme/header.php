<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.png">
  <title>PRIME <?= !empty($title) ? ' | '.$title : ''; ?></title>

  <!-- font -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:600" rel="stylesheet">

  <!-- Icons -->
  <link href="<?= base_url(); ?>assets/plugin/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/plugin/fontawesome-free-5.0.9/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/plugin/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
  <!-- Select 2-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugin/select2/css/select2.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugin/select2/css/select2-bootstrap.css">
  
  <!-- Datatable -->
  <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Bootstrap-->
  <link href="<?= base_url(); ?>assets/plugin/bootstrap3/css/bootstrap.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="<?= base_url(); ?>assets/css/style.min.css?v=29042019" rel="stylesheet">



  <!-- JAVASCRIPT -->

  <!-- Bootstrap and necessary plugins -->
  <script src="<?= base_url(); ?>assets/plugin/jquery/dist/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/popper.js/dist/umd/popper.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/pace-progress/pace.min.js"></script>

  <!-- Plugins and scripts required by all views -->
  <!-- moment.js -->
  <script src="<?= base_url(); ?>assets/plugin/moment/min/moment.min.js"  type="text/javascript"></script>
  <!-- datepicker -->
  <link href="<?= base_url(); ?>assets/plugin/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css">
  <script src="<?= base_url(); ?>assets/plugin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript" charset="utf-8"></script>  

  <!-- Selelct 2-->
  <script src="<?= base_url(); ?>assets/plugin/select2/js/select2.full.min.js" type="text/javascript" charset="utf-8"></script>

  <!-- Datatables -->
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <!-- Bootstrap File Input -->
  <link   href="<?=base_url(); ?>assets/plugin/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
  <script src="<?= base_url(); ?>assets/plugin/bootstrap-fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>assets/plugin/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>assets/plugin/bootstrap-fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
  <script src="<?= base_url(); ?>assets/plugin/bootstrap-fileinput/js/fileinput.min.js"></script>

  <!-- Awesomplete -->
  <link   href="<?= base_url(); ?>assets/plugin/awesomplete/awesomplete.css" media="all" rel="stylesheet" type="text/css" />
  <script src="<?= base_url(); ?>assets/plugin/awesomplete/awesomplete.min.js"></script>

  <!-- Bootbox -->
  <script src="<?= base_url(); ?>assets/plugin/bootbox.min.js"></script>
  <!-- Price Format -->
  <script src="<?= base_url(); ?>assets/plugin/jquery.priceformat.js" type="text/javascript" charset="utf-8"></script>

  <!-- Jquery Validation -->
  <script src="<?= base_url(); ?>assets/plugin/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="<?= base_url(); ?>assets/plugin/jquery-validation/dist/additional-methods.min.js" type="text/javascript" charset="utf-8"></script>


  <!-- JQVMAP -->
  <script src="<?= base_url(); ?>assets/plugin/jqvmap/jquery.vmap.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/jqvmap/maps/jquery.vmap.indonesia.js"></script>

  <!-- Highcharts -->
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/highcharts.js?v=05042019abc"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/modules/data.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/modules/drilldown.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/modules/exporting.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/grouped-categories.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/highcharts-more.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/highcharts-3d.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/lib/canvg.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/lib/jspdf.js"></script>
  <script src="<?= base_url(); ?>assets/plugin/highchart/code/lib/rgbcolor.js"></script>

  <script src="<?= base_url(); ?>assets/plugin/handsontable/dist/handsontable.full.js"></script>
  <link   href="<?=base_url(); ?>assets/plugin/handsontable/dist/handsontable.full.min.css" media="all" rel="stylesheet" type="text/css" />


   <script type="text/javascript">
      var base_url = "<?= base_url(); ?>";
      var priviledge = 3;
    </script>

</head> 
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
  <header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" id="toggler-header" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav ml-auto">
      
      <li>
        <span style="color: #111;font-family: sans-serif;font-weight: 900;"> <?= $this->session->userdata('nama_sess').' - '.$this->session->userdata('tipe_sess'); ?></span>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <img src="<?= !empty($this->session->userdata('photo')) ? base_url().$this->session->userdata('photo') : base_url().'assets/img/avatars/default.png';?>" class="img-avatar" alt="<?= $this->session->userdata('nama_sess')?>">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-header text-center">
            <strong>Settings</strong>
          </div>
          <a class="dropdown-item nav-link-hgn" href="<?= base_url(); ?>user/profile/<?= $this->session->userdata('nik_sess');?>"><i class="fa fa-user"></i> Profile</a>
          <a class="dropdown-item" href="<?= base_url(); ?>login/log_out"><i class="fa fa-lock"></i> Logout</a>
        </div>
      </li>
    </ul>
  </header>