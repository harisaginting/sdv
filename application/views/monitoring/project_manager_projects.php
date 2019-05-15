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

  .chart-container .highcharts-grid {
   display: none;
  } 
  
</style>


<div class="container-fluid container-content">

<div class="row" >

  <?php foreach ($projects as $key => $value): ?>
    <div class="col-md-12" >
      <div style="border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;" class="card text-white <?= ($projects[$key]['STATUS'] == 'LEAD' ? 'bg-success' : ($projects[$key]['STATUS'] == 'LAG' ? 'bg-warning' : ($projects[$key]['STATUS'] == 'DELAY'? 'bg-danger' : 'hidden')))  ?> nav-link-hgn">
        <div class="card-body pb-0">
        <a href="<?= base_url();?>projects/view/<?= $projects[$key]['ID_PROJECT'] ?>"><span class="mb-0" style="font-size: 16px;font-weight: 700;color: #000;"><?= $projects[$key]['NAME']; ?></span></a><br>
        <span class="text-dark">PLAN <?= $projects[$key]['PLAN']; ?>% | ACHIEVMENT <?= $projects[$key]['ACH']; ?>%</span><br>
        <span class="text-dark">START <?= $projects[$key]['START_DATE']; ?></span><br>
        <span class="text-dark">END <?= $projects[$key]['END_DATE']; ?></span>
        </div>
        <div id="curve<?= $nik.$key; ?>" style="height: 150px;">
        </div>
    </div>
  </div>

  <script type="text/javascript">
    Highcharts.chart('curve<?= $nik.$key; ?>', {
        
            chart: {
                height: 150,
                backgroundColor : '<?= ($projects[$key]['STATUS'] == 'LEAD' ? '#4dbd74' : ($projects[$key]['STATUS'] == 'LAG' ? '#ffc107' : ($projects[$key]['STATUS'] == 'DELAY'? '#f86c6b' : 'hidden')))  ?>'
            },
            credits: {
              enabled: false
            },
                title: false,
                xAxis: {
                    categories: ['WEEK',<?php echo "'".implode("','", $projects[$key]['kurva']['WEEK'])."'"?>]
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    max: 100,
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#000'
                    }]
                },
                tooltip: {
                    // valueSuffix: '%'
                    formatter: function () {
                        var tooltipsArr = ['0',<?php echo "'".implode("','", $projects[$key]['kurva']['PERIOD'])."'"?>];
                        return tooltipsArr[this.point.index] +'<br>'+ this.series.name +' : '+ Highcharts.numberFormat(this.point.y, 2) +'%';
                    }
                },
                exporting: { enabled: false },
                legend : false,
                series: [{
                    name: 'Plan',
                    color: '#dedede',
                    data: [0,<?php echo implode(",", $projects[$key]['kurva']['PLAN'])?>]
                }, {
                    name: 'Realization',
                    color: '#0f0',
                    data: [0,<?php echo implode(",", $projects[$key]['kurva']['REAL'])?>]
                }]
    });

  </script>

  <?php endforeach; ?>

</div>

<script type="text/javascript">    
  var Page = function () {
          /*$(document).on('click','.list_pm',function(e){
            e.stopImmediatePropagation();
                $('#dataMonitoringPM').empty();
                var nik_pm = $(this).data('nik_pm');
                console.log(nik_pm);

                $("#dataMonitoringPM").load( base_url+'monitoring/getProjectPM', { nik : nik_pm }, function() {
                  
                });
              });*/
      return {
          init: function() { 
            
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>