<style type="text/css">
  .list-group::-webkit-scrollbar {
    width: 0.5em;
  }
   
  .list-group::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  }
   
  .list-group::-webkit-scrollbar-thumb {
    background-color: darkgrey;
    outline: 1px solid slategrey;
  }
</style>


<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>monitoring/pm"> Monitoring Project Manager</li>
<div class="col-md-10">  
  <div  class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_monitoring_project_manager" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>


<div class="container-fluid container-content">

<div class="row">
  <div class="col-md-12">
    <div class="card" >
      <div class="card-header">
      Project Manager List
      </div>
      <div class="card-body row" style="max-height: 600px;">
        <div class="col-md-4"> 
          <div class="list-group" style="max-height: 540px;overflow-y: scroll !important;overflow-x: hidden;">
            <?php foreach ($pm as $key => $value) : ?>
                <span class="list-group-item list-group-item-action flex-column align-items-start list_pm" data-nik_pm="<?= $pm[$key]['NIK']; ?>" <?= ($key==0) ? "style='background-color:#6af4204a'" : ''  ?> >
                
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1"><a class="nav-link-hgn" href="<?= base_url(); ?>user/profile/<?= $pm[$key]['NIK']; ?>"><?= $pm[$key]['NAMA']; ?></a>
                    <br><span style="font-size: 8px;width: 100%"><?= $pm[$key]['EMAIL']; ?></span></h5>
                  <small>Last Activity <?= $pm[$key]['LATEST']; ?> </small>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <img src="https://prime.telkom.co.id/dev/<?= !empty($pm[$key]['PHOTO_URL'])? $pm[$key]['PHOTO_URL'] : '../user_picture/default-profile-picture.png' ; ?>" class="img-avatar" alt="<?= $pm[$key]['NAMA']; ?>" style="max-height: 70px;">
                  </div>
                  <div class="col-md-8">
                    <table class="cursor-pointer">
                      <tbody>
                      <tr>
                        <td>
                          <span class="text-info" style="min-width: 50px;">LOAD</span>
                        </td>
                        <td>
                          &nbsp;&nbsp;: <span><?= $pm[$key]['LOAD']; ?>%</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="text-primary" style="min-width: 50px;">TOTAL PROJECT</span>
                        </td>
                        <td>
                          &nbsp;&nbsp;: <span><?= !empty($pm[$key]['TPROJECT']) ? $pm[$key]['TPROJECT'] : '00'; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <span class="text-success" style="width: 50%;"> &nbsp;&nbsp;LEAD</span>
                        </td>
                        <td>
                          &nbsp;&nbsp;: <span><?= !empty($pm[$key]['TPROJECT1']) ? $pm[$key]['TPROJECT1'] : '00'; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <span class="text-warning" style="width: 50%;"> &nbsp;&nbsp;LAG</span>
                        </td>
                        <td>
                          &nbsp;&nbsp;: <span><?= !empty($pm[$key]['TPROJECT2']) ? $pm[$key]['TPROJECT2'] : '00'; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <span class="text-danger"  style="width: 50%;"> &nbsp;&nbsp;DELAY</span>
                        </td>
                        <td>
                        &nbsp;&nbsp;: <span><?= !empty($pm[$key]['TPROJECT3']) ? $pm[$key]['TPROJECT3'] : '00'; ?></span>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                
                
                </span>
            <?php endforeach; ?>        
          </div>
        </div>

        <div class="col-md-8" >
            <div id="dataMonitoringPM" style="max-height: 580px; overflow-y: scroll;">
              Select Project Manager
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {
          $(document).on('click','.list_pm',function(e){
            $('.list_pm').css('backgroundColor','#fff');
            $(this).css('backgroundColor','#6af4204a');
            e.stopImmediatePropagation();
                $('#dataMonitoringPM').empty();
                var nik_pm = $(this).data('nik_pm');
                $("#dataMonitoringPM").load( base_url+'monitoring/getProjectPM', { nik : nik_pm }, function() {
                  
                });
              });
      return {
          init: function() { 
            $('#dataMonitoringPM').empty();
            var nik_pm = "<?= $pm[0]['NIK']; ?>";
            $("#dataMonitoringPM").load( base_url+'monitoring/getProjectPM', { nik : nik_pm }, function() {});
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>