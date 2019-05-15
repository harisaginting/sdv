<link href="<?= base_url(); ?>assets/css/timeline.css"  rel="stylesheet"/>
<div class="container-fluid container-content-no-bread">
  <div class="animated fadeIn"></div>

    <div class="card" style="margin-bottom: 0px;border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;">
      <div class="card-header" style="border-bottom: 0px !important;">
      Summary
        <div class="float-right">
          <div class="row">
          <div class="col-md-12" style="padding-right: 10px;">
            <div class="form-group input-group input-daterange">
                <input type="text" id="summary_year_start" class="form-control date-picker" placeholder="set start date range" style="color: #6f6f6f !important;">
                <div class="input-group-addon">to</div>
                <input type="text" id="summary_year_end"  class="form-control date-picker" placeholder="set end date range" style="color: #6f6f6f !important;">
            </div>
          </div>
          <!-- <div class="col-md-4" style="padding-left: 0px; padding-top: 4px;">
            <button id="addProject" type="button" class="btn btn-success btn-addon" id="summary_year">
             <span>Reload</span>
             <i class="fa fa-refresh"></i>
            </button>
          </div> -->
          </div>
        </div>

      </div>
      <div class="card-body">
        

        <div class="row" id="summary_c">
           

        </div>

        <div class="row">
          <div class="col-sm-12 col-lg-12" id="diagram1"></div>
        </div>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-lg-12" id="diagram2">
        </div>


        <!-- <div class="row" style="padding-left: 10px;padding-right: 10px;">
            <div class="col-sm-12 col-lg-12" id="diagram_regional">
                <div id="mapChart" style="height: 400px;"></div>
            </div>
        </div> -->
        
        </div>
      </div>
    </div>


      <div class="card" style="border-top-right-radius: 0px;border-top-left-radius: 0px;">
        <div class="card-header" style="background-color: #fff !important;border-top-right-radius: 0px;border-top-left-radius: 0px;">
        Quantity Projects Active by Regional
        </div>
        <div class="card-body" id="diagram_regional">
          
        </div>
      </div>



      <?php if(!empty($pm)) :  ?>
      <div class="row">
        <div class="col-md-12">
          <div class="card" >
            <div class="card-header">
            Project Manager
            </div>
            <div class="card-body row" style="max-height: 600px;">
              <div class="col-md-4">
                <div class="list-group" style="max-height: 540px;overflow-y: scroll !important;overflow-x: hidden;">
                  <?php foreach ($pm as $key => $value) : ?>
                      <span class="list-group-item list-group-item-action flex-column align-items-start list_pm" data-nik_pm="<?= $pm[$key]['NIK']; ?>" <?= ($key==0) ? "style='background-color:#6af4204a'" : ''  ?> >
                      
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><b><?= $pm[$key]['NAMA']; ?></b>
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
                  <div id="dataMonitoringPMdashboard" style="max-height: 540px; overflow-y: scroll;">
                    Select Project Manager
                  </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
        <div class="card">
        <div class="card-header">
        BAST Approved 2018          
          <div class="float-right col-sm-2">
            <select id="bast_approved_year" name="bast_approved_year" class="form-control form-control-sm Jselect2">
            <option value="">All Years</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
            </select>
          </div>

          <div class="float-right col-sm-2">
            <select id="bast_approved_month" name="bast_approved_month" class="form-control form-control-sm Jselect2">
            <option value="">All Month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
            </select>
          </div>

        </div>

          <div class="card-body" id="bast_approved">
              <div class="col-md-12"> 
                      <table class="table table-responsive-sm table-striped" style="width: 100% !important;">
                                <thead>
                                  <tr>
                                      <th style="width: 30% !important">PARTNERS</th>
                                      <?php foreach ($segmen as $key => $value) : ?>
                                        <th style="width: 5% !important"><?= $segmen[$key]['SEGMEN'] ?></th>
                                      <?php endforeach; ?>                        
                                  </tr>
                                </thead>
                        </table> 
                      </div>     
                      <div class="col-md-12" style="max-height: 540px;overflow-y: scroll !important;overflow-x: hidden;"> 
                            <table class="table table-responsive-sm table-striped" style="width: 100% !important;">
                                <tbody>
                                      <?php foreach ($partners as $key => $value) : ?>
                                        <tr>
                                        <td style="width: 30% !important"><?= $partners[$key]['NAMA_PARTNER']; ?></td>
                                          <?php foreach ($segmen as $key2 => $value2) : ?>
                                            
                                            <?= !empty($segmen_partners[$partners[$key]['KODE_PARTNER']][$segmen[$key2]['SEGMEN']]) ? "<td class='bg-success text-center' style='width: 5% !important'>".$segmen_partners[$partners[$key]['KODE_PARTNER']][$segmen[$key2]['SEGMEN']] : "<td style='width: 5% !important' class='text-center'>0"; ?>
                                              
                                            </td>
                                          <?php endforeach; ?> 
                                        </tr>
                                      <?php endforeach; ?> 
                                </tbody>
                            </table>                                                    
                            
                      </div> 
          </div>
        </div>

    <div class="card">
      <div class="card-header">
      Latest Activity
      </div>
      <div class="card-body">
          <div class="row">
            <div class="offset-sm-1 col-sm-10">
              <table id="dataAll" class="table b-t" style="width:100% !important;overflow-x:hidden;">
                  <thead class="thead-bg-blue">
                  <tr>
                      <th style="width:20%;font-size: 10px !important;">DATE TIME </th>
                      <th style="width:10%;font-size: 10px !important;">USER ID</th>                  
                      <th style="width:30%;font-size: 10px !important;">NAME</th>                  
                      <th style="width:20%;font-size: 10px !important;">ACTION</th>
                      <th style="width:20%;font-size: 10px !important;">TYPE</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php foreach($history as $key=>$value) :?>
                          <tr>
                              <td style="font-size:10px;"><?= $history[$key]['TIME']; ?></td>
                              <td><?= $history[$key]['ID_USER']; ?></td>
                              <td>
                                  <?= $history[$key]['NAME_USER'];?>
                              </td>
                              <td style="font-size:10px;"><?= $history[$key]['STATUS']; ?></td>
                              <td><?= $history[$key]['TYPE']; ?></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
            </div>  
          </div>
      </div>
    </div>


</div>

<script type="text/javascript">
  var Form = function () {    
    $(document).on('click','.list_pm',function(e){
        $('.list_pm').css('backgroundColor','#fff');
        $(this).css('backgroundColor','#6af4204a');
        e.stopImmediatePropagation();
            $('#dataMonitoringPMdashboard').empty();
            var nik_pm = $(this).data('nik_pm');
            $("#dataMonitoringPMdashboard").load( base_url+'monitoring/getProjectPM', { nik : nik_pm }, function() {
              
            });
          });

    <?php if(!empty($pm)) :  ?>
    var pmChart = function(){
                  var nik_pm = "<?= !empty($pm[0]['NIK']) ? $pm[0]['NIK'] :  '0'; ?>";
                  $("#dataMonitoringPMdashboard").load( base_url+'monitoring/getProjectPM', { nik : nik_pm }, function() {});
    }
   <?php endif; ?>
  

    var summary = function(start=null,end=null) {
                    $.ajax({  
                        type:"post",
                        async: true,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/summary",
                        success: function(data) {
                            $('#summary_c').empty();
                            $('#summary_c').append(data);
                            document.documentElement.scrollTop = 0;
                        }
                    });                                 
    };      

    var regionalChart = function(start=null,end=null) {
                    $.ajax({  
                        type:"post",
                        async: true,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/regional",
                        success: function(data) {
                            $('#diagram_regional').empty();
                            $('#diagram_regional').append(data);
                            document.documentElement.scrollTop = 0;
                        }
                    });                                 
    };    


    var ChartInitialize2 = function(start=null,end=null) {
                    $.ajax({  type:"post",
                        async: true,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/diagram2",
                        success: function(data) {
                            $('#diagram2').empty();
                            $('#diagram2').append(data);
                            regionalChart(start,end);
                        }
                    });                                 
    };

    var ChartInitialize = function(start=null,end=null) {

                    $.ajax({  type:"post",
                        async: true,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/diagram1",
                        success: function(data) {
                            $('#diagram1').empty();
                            $('#diagram1').append(data);
                            ChartInitialize2(start,end);
                        }
                    });                              
    };

    var BastInitialize = function(year = null, month = null) {
                    $.ajax({  
                        type:"post",
                        async: true,
                        data: { year : year, month : month},
                        url: base_url+"dashboard/bast",
                        success: function(data) {
                            $('#bast_approved').empty();
                            $('#bast_approved').append(data);
                        }
                    });                              
    };


    return {
        init: function() {
            summary();
            ChartInitialize();
            <?php if(!empty($pm)) :  ?>
              pmChart(); 
            <?php endif; ?>
            //BasttInitialize();
            /*<?php if(!empty($notification)):?>
            $('#notification_header').addClass('show');

            <?php endif; ?>*/

            $('#dataMonitoringPMdashboard').empty();
            var nik_pm = "<?= !empty($pm[0]['NIK']) ? $pm[0]['NIK'] :  '0'; ?>";
            
            $('body').on('change','#bast_approved_year, #bast_approved_month',function(e){
                var year    = $('#bast_approved_year').val();    
                var month   = $('#bast_approved_month').val();    
                BastInitialize(year,month);                             
            });

            $('body').on('change','#summary_year_start, #summary_year_end',function(e){
                var start   = $('#summary_year_start').val();  
                var end     = $('#summary_year_end').val();    
                ChartInitialize(start,end);       
                summary(start,end);                      
            });


        }
    };

}();

jQuery(document).ready(function() {
    Form.init();
});
</script>