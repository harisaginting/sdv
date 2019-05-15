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
<div class="card">

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
                  <td>GET ALL P8 FROM NUMERO</td>
                  <td><a href="<?=base_url();?>utility/get_all_spk_numero" class="btn btn-success">Execute</a> </td>
                </tr>
                <tr>
                  <td>GET ALL P7-1 FROM NUMERO</td>
                  <td><a href="<?=base_url();?>utility/get_all_p71_numero" class="btn btn-success">Execute</a> </td>
                </tr>
                <tr>
                  <td>DAILY BAST NOTIFICCATION TO PARTNER</td>
                  <td><a style="font-size:10px;"  class="btn btn-sm btn-success" href="<?= base_url();?>utility/cron_email_bastParter" ><i class='glyphicon glyphicon-new-window'></i>&nbsp;OPEN&nbsp;</a>
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