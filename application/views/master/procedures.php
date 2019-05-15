<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>master/api"> Database Procedures</li>
  <div class="col-md-10">  
  </div>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>        
        <label>Proedure Database</label>                                                          
          <table id="dataApi" class="table table-stripped table-responsive-sm" style="width: 100%;border:2px solid #e4e5e6">
              <thead>
                <tr style="background: #e4e5e6;">
                  <th style="width:85%">NAME</th>
                  <th style="width:15%">ACTION</th>
                </tr> 
              </thead>
              <tbody>
                <tr>
                  <td>UPDATE STATUS PROCEDURE</td>
                  <td><a href="<?=base_url();?>utility/execute_procedure_updateStatus" class="btn btn-success">Execute</a> </td>
                </tr>
                <tr>
                  <td>UPDATE MONITORING PROCEDURE</td>
                  <td><a href="<?=base_url();?>utility/execute_procedure_updateMonitoring" class="btn btn-success">Execute</a> </td>
                </tr>
                <tr>
                  <td>UPDATE S CURVE</td>
                  <td><a href="<?=base_url();?>utility/execute_procedure_updateSCurve" class="btn btn-success">Execute</a> </td>
                </tr>
                <tr>
                  <td>DAILY BAST NOTIFICCATION TO PARTNER</td>
                  <td></td>
                </tr>
              </tbody>
          </table>

          <label>Cron Tab</label> 
          <table id="dataEmail" class="table table-stripped table-responsive-sm" style="width: 100%;border:2px solid #e4e5e6">
              <thead>
                <tr style="background: #e4e5e6;">
                  <th style="width:85%">NAME</th>
                  <th style="width:15%">ACTION</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>DAILY BAST NOTIFICCATION TO PARTNER</td>
                  <td><a style="font-size:10px;"  class="btn  b  tn-xs btn-success circle2 nav-link-hgn" href="<?= base_url();?>/master/cron_email_bastParter"  target='_blank'><i class='glyphicon glyphicon-new-window'></i></a>
                  </td>
                </tr>
              </tbody>
          </table>
        </div> 
</div>
</div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {
      return {
          init: function() { 
          }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });      

           
</script>