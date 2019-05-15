<link href="<?= base_url(); ?>assets/css/timeline.css"  rel="stylesheet"/>
<div class="container-fluid container-content-no-bread">
  <div class="animated fadeIn">

    <div class="row">
           <div class="col-md-6 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>projects" >
              <div class="social-box social-box-4 linkedin">
              <i class="icon-rocket"> Project Active</i>
                <ul>
                  <li>
                    <strong><?= $project['LEAD'] ?></strong>
                    <span>Lead</span>
                  </li>
                  <li>
                    <strong><?= $project['LAG'] ?></strong>
                    <span>Lag</span>
                  </li>
                  <li>
                    <strong><?= $project['DELAY'] ?></strong>
                    <span>Delay</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6  nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate">
              <div class="social-box twitter">
              <i class="icon-vector"> Candidate</i>
                <ul>
                  <li>
                    <strong><?= $project['PROJECT CANDIDATE'] ?></strong>
                    <span>Epic</span>
                    </li>
                    <li>
                    <strong><?= !empty($project['REQUEST'])? $project['REQUEST'] : '0' ?></strong>
                    <span>Prime</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>bast">
              <div class="social-box google-plus">
              <i class="fa fa-handshake-o"> BAST</i>
                <ul>
                  <li>
                    <strong><?= $bast['progress'] ?></strong>
                    <span>In Progress</span>
                    </li>
                    <li>
                    <strong><?= $bast['approved'] ?></strong>
                    <span>Approved</span>
                  </li>
                </ul>
              </div>
            </div>

            </div>
  </div>

    <div class="card">
      <div class="card-header">
      Projects Summary
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-lg-12" id="diagram1"></div>
        </div>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-lg-12" id="diagram2">
        </div>

        
        </div>
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

          
          <!-- <div class="float-right col-sm-2">
            <select id="source_project" name="source_project" class="form-control form-control-sm Jselect2">
            <option value="2018">2018</option>
            </select>
          </div> -->

        </div>

        <div class="card-body">
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
        Quantity Projects Active by Regional
        </div>
        <div class="card-body">
          <div class="row" style="padding-left: 10px;padding-right: 10px;">
            <div class="col-sm-12 col-lg-12" id="mapChart" style="height: 400px;"></div>
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
    

    var ChartInitialize2 = function(start=null,end=null) {


                    $.ajax({  type:"post",
                        async: true,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/diagram2",
                        success: function(data) {
                            $('#diagram2').empty();
                            $('#diagram2').append(data);
                             <?php if(!empty($pm)) :  ?>
                              pmChart(); 
                            <?php endif; ?>
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
                            ChartInitialize2();
                        }
                    });                              
    };


    return {
        init: function() {
            ChartInitialize();

            /*<?php if(!empty($notification)):?>
            $('#notification_header').addClass('show');

            <?php endif; ?>*/

            $('#dataMonitoringPMdashboard').empty();
            var nik_pm = "<?= !empty($pm[0]['NIK']) ? $pm[0]['NIK'] :  '0'; ?>";
            
            $('body').on('click','#diagram_refresh',function(e){
                var start   = $('#d_start').val();  
                var end     = $('#d_end').val();    
                ChartInitialize(start,end);                             
            });

            var c_region1 = '#00aced';
            var c_region2 = '#004f6e';
            var c_region3 = '#4875b4';
            var c_region4 = '#00c204';
            var c_region5 = '#d38436';
            var c_region6 = '#f396cf';
            var c_region7 = '#96e7f3';

            $('#mapChart').vectorMap({
              map: 'indonesia_id',
              backgroundColor: '#a5bfdd',
              borderColor: '#818181',
              borderOpacity: 0.25,
              borderWidth: 1,
              color: '#f4f3f0',
              enableZoom: true,
              hoverColor: '#c9dfaf',
              hoverOpacity: null,
              normalizeFunction: 'linear',
              scaleColors: ['#b6d6ff', '#005ace'],
              selectedColor: '#c9dfaf',
              selectedRegions: null,
              showTooltip: true,
              onRegionClick: function(element, code, region)
              {

                console.log(this);
                  var message = region;

                  console.log(message);
              },
              pins: <?= json_encode($regional); ?>,
            });

            $('#mapChart').vectorMap('set', 'colors', { path01: c_region1, 
                                                        path02: c_region1,
                                                        path03: c_region1,
                                                        path04: c_region1,
                                                        path05: c_region1,
                                                        path06: c_region1,
                                                        path07: c_region1,
                                                        path08: c_region1,
                                                        path09: c_region1,
                                                        path10: c_region1,
                                                        
                                                        path11: c_region2,
                                                        path14: c_region2,

                                                        path12: c_region3,

                                                        path13: c_region4,
                                                        path16: c_region4,

                                                        path15: c_region5,
                                                        path17: c_region5,
                                                        path18: c_region5,
                                                        path19: c_region5,

                                                        path20: c_region6,
                                                        path21: c_region6,
                                                        path22: c_region6,
                                                        path23: c_region6,
                                                        path24: c_region6,

                                                        path25: c_region7,
                                                        path26: c_region7,
                                                        path27: c_region7,
                                                        path28: c_region7,
                                                        path29: c_region7,
                                                        path30: c_region7,
                                                        path31: c_region7,
                                                        path32: c_region7,
                                                        path33: c_region7,
                                                        path34: c_region7,
                                               

                                                      });


        }
    };

}();

jQuery(document).ready(function() {
    Form.init();
});
</script>