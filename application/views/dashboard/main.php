<style type="text/css">
.reg_marker{font-size:12px;font-family:sans-serif;font-weight:900;color:red}.target_text{color:#300;font-family:sans-serif;font-weight:700}.card{border-radius:0}@media (min-width:768px){#con_projectTypeData{margin-top:-20px!important}}
</style>

<div class="container-fluid container-content-no-bread" style="padding-top: 5px !important;;">
  <div class="animated fadeIn"></div>

    <div class="row">
      
      <div class="col-md-2">
          <div class="row">

            <div class="col-sm-12">
                <a href="<?= base_url(); ?>projects">
                  <div class="card" style="min-height: 95px;cursor: pointer;background: #fff;color: #1d8839;border:2px solid #1c7132;border-radius: 5%;margin-bottom: 5px;">
                    <div class="card-body align-items-center" style="padding:0px;">
                      <span class="text-center">
                        <div class="" style="font-size: 60px;margin-bottom: -15px;margin-top: -10px;font-family: monospace;"><?= $total_project; ?></div>
                        <div class="h4">Projects Active</div>
                      </span>
                    </div>
                  </div>
                </a>
            </div>

            <div class="col-sm-12">
                <a href="#">
                  <div class="card" style="min-height: 70px;cursor: pointer;background: #fff;color: #1d8839;border:2px solid #1c7132;border-radius: 5%;margin-bottom: 5px;">
                    <div class="card-body align-items-center" style="padding-top: 5px;padding-bottom: 5px;">
                      <span class="text-center">
                        <div class="" style="font-size: 40px;margin-bottom: -15px;margin-top: -10px;font-family: monospace;"><?= $total_pm; ?></div>
                        <div class="h4">Project Manager</div>
                      </span>
                    </div>
                  </div>
                </a>
            </div>

            <div class="col-sm-12">
                <a href="#">
                  <div class="card" style="min-height: 215px;cursor: pointer;background: #fff;color: #1d8839;border:2px solid #1c7132;border-radius: 2%;">
                    <div style="margin-top: 5px;" class="w-100 align-items-center text-center ">
                        <label class="h6">BAST PROGRESS</label>
                    </div>
                    <div id="chartBastProgress"></div>
                  </div>
                </a>
            </div>

        </div>
      </div>

      <div class="col-md-10">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-12">
                    <div id="" class="h-100">
                      <div class="card" style="padding: 2px;border:0px;min-height: 125px;">
                          <div class="card-body" style="padding: 0px;">
                            
                            <div class="row h5" style="margin-left: 0px;margin: 0px;background: #0fc13e;margin-bottom: 1px;border-radius:5px;">
                              <div class="col-md-12 target_text" style="color: #dae9de;font-size: 10px;margin-bottom:0.5px;">
                                TARGET ACQUISITION <?= strtoupper(date("F Y")); ?>
                              </div>
                              <div class="col-md-12 text-right" style="margin-top: 2px;">
                                <strong class="rupiah h4" style="color:#fff;font-family: inherit;">
                                  <?= $target; ?>
                                </strong>
                              </div>
                            </div>

                            <div class="row h5" style="margin-left: 0px;margin: 0px;background: #0f9e35;margin-bottom: 1px;border-radius:5px;">
                              <div class="col-md-12 target_text" style="color: #dae9de;font-size: 10px;margin-bottom:0.5px;">
                                ACQUISITED <?= strtoupper(date("F Y",strtotime('-1 months'))); ?>
                              </div>
                              <div class="col-md-12 text-right" style="margin-top: 2px;">
                                <strong class="rupiah h4" style="color:#fff;font-family: inherit;">
                                  <?= $real; ?>
                                </strong>
                              </div>
                            </div>

                            <div class="row h5" style="margin-left: 0px;margin: 0px;background: #1d8839;margin-bottom: 1px;border-radius:5px;">
                              <div class="col-md-12 target_text" style="color: #dae9de;font-size: 10px;margin-bottom:0.5px;">
                                TOTAL PROGRESS TO ACHIEVE THIS WEEK
                              </div>
                              <div class="col-md-12 text-right" style="margin-top: 2px;">
                                <strong class="rupiah h4" style="color:#fff;font-family: inherit;">
                                  <?= $scaling_week; ?>
                                </strong>
                              </div>
                            </div>

                            <div class="row h5" style="margin-left: 0px;margin: 0px;background: #1c7132;border-radius:5px;">
                              <div class="col-md-12 target_text" style="color: #dae9de;font-size: 10px;margin-bottom:0.5px;">
                                TOTAL REMAINING PROGRESS TO ACHIEVE
                              </div>
                              <div class="col-md-12 text-right" style="margin-top: 2px;">
                                <strong class="rupiah h4" style="color:#fff;font-family: inherit;">
                                  <?= $scaling; ?>
                                </strong>
                              </div>
                            </div>



                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div id="chartProjectScale" class="h-75"></div>
                  </div>
                      </div>
                  </div>
                </div>
            </div>

            <div class="col-md-8">
                <div id="chartProjectStatus">
                  
                </div>
            </div>
        </div>

      </div>
      
    </div>
    <div class="row" style="margin-top: 15px !important;" id="con_projectTypeData">
        <div class="col-md-4">
          <div id="chartBast"></div>
        </div>
        <div class="col-md-6" style="height: 200px;background: #0b8fc1;height: 320px;border:1px solid #0b8fc1;">
          <label class="h5"><strong class="text-white">Projects By Regional</strong></label>
          <div id="regionalChart" style="height: 275px;"></div>
        </div>
        <div class="col-md-2">               
              <div class="card" style="">
                  <?php $c=0; foreach ($total_project_c as $key => $value) : ?>
                      <?php //if(!empty($value)) : ?>
                      <div class="card" style="height: 30px;margin-bottom: 2px;border:2px solid #0b8fc1;">
                        <div class="card-body p-0 d-flex align-items-center" style="<?= !empty($value) ? "background: #dfdfdf;" : ""; ?>height: 26px;">
                        <span class="bg-info p-4 font-2xl mr-3" style="height: 26px; padding-top: 3px !important;padding-bottom: 7px !important; min-width: 70px;font-family: monospace;font-weight: 900;background: <?= $colorTProj[$c]; ?> !important"><?= substr($key, 0,3) ?></span>
                          <div style=""  >
                            <div class="text-value-sm"><span class="h4"><?= $value; ?></span></div>
                            <div class="text-muted text-uppercase font-weight-bold"><span class="h6" style="font-size: 8px;" ><strong><?= $key ?></strong></div>
                          </div>
                        </div>
                      </div>
                      <?php //endif; ?>
                    <?php $c++; endforeach; ?>
              </div>
        </div>
    </div>



    <!-- <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" style="padding-left: 5px;padding-top: 5px;padding-bottom: 5px;">
          <div style="width: 100%;border-bottom: 1px solid #d81011">
            <span class="h3" style="color: #d81011;font-family: sans-serif;font-weight: 900">SEGMEN</span>
          </div>
        </div>
      </div> -->


    <div class="row" style="margin-top: 20px;">
      <div class="col-md-6">
        <div id="chartSymptoms"  class="con-chart" style="margin: 0 auto;"></div>
                <table id="data_symptoms" style="display: none !important;">
                    <thead>
                        <tr>
                          <th></th>
                            <?php foreach ($chartSymptoms as $key => $value): ?>
                              <th><?=  $value['REASON_OF_DELAY'] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Total</th>
                            <?php foreach ($chartSymptoms as $key => $value) : ?>
                              <td><?= $value['TOTAL'] ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
      </div>


      <div class="col-md-6">
        <div id="chartSegmenProgress"></div>
      </div>
    </div>

    <div class="row" style="margin-top: 20px;">
      <div class="col-md-6">
        <div id="chartSegmenScale"></div>
      </div>
      <div class="col-md-6">
        <div id="chartSegmenValue"></div>
      </div>
    </div>


    <!-- <div class="row" style="margin-top: 10px;">
        <div class="col-md-12" style="padding-left: 5px;padding-top: 5px;padding-bottom: 5px;">
          <div style="width: 100%;border-bottom: 1px solid #d81011">
            <span class="h3" style="color: #d81011;font-family: sans-serif;font-weight: 900">BAST</span>
          </div>
        </div>
      </div> -->

    <div class="row" style="margin-top: 20px;">
      
    </div>

</div>


<script type="text/javascript">
  var Form = function () {    
 
    var chartProgress   = function(start=null,end=null) {
      
    };

    return {
        init: function() {
            chartProgress();
        }
    };

  }();


  var colors = ["#7cb5ec", "#434348", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1"],
      categories = [
          "DELAY",
          "LAG",
          "LEAD",
      ],
      data = <?= json_encode($chartProgress) ?>,
      browserData = [],
      versionsData = [],
      i,
      j,
      dataLen = data.length,
      drillDataLen,
      brightness;

      colorA = ['#d81011','#ffc107','#0fc13e'];
      colorB = <?= json_encode($colorTProj); ?>;



      // Build the data arrays
      for (i = 0; i < dataLen; i += 1) {

          // add browser data 
          browserData.push({
              name: categories[i],
              y: data[i].Y,
              color: colorA[i]
          });

          // add version data
          drillDataLen = data[i].drilldown.data.length;
          for (j = 0; j < drillDataLen; j += 1) {
              brightness = 0.2 - (j / drillDataLen) / 5;
              versionsData.push({
                  name: data[i].drilldown.categories[j],
                  y: data[i].drilldown.data[j],
                  color: colorB[j],
              });
          }
      }

      // Create the chart
      Highcharts.chart('chartProjectStatus', {
          chart: {
              type: 'pie',
              backgroundColor : '#ffffff',
          },
          title: {
                  style: {
                   color: '#f42020',
                   textTransform: 'uppercase',
                   fontSize: '20px'
                },
                  text: ''
              },
          credits: {
                          text: '',
                          href: 'https://prime.telkom.co.id/sdv/projects',
                          style: {
                          color: '#a40000'},
                      },
          subtitle: {
              text: ''
          },
          yAxis: {
              title: {
                  text: 'Projects Status'
              }
          },
          plotOptions: {
              pie: {
                  center: ['50%', '50%']
              }
          },
          series: [{
              name: 'Total Projects',
              data: browserData,
              size: '60%',
              innerSize: '0%',
              dataLabels: {
                  style: {
                      fontSize : '11px',
                      border : '0px',
                    },
                  formatter: function () {
                      // display only if larger than 1
                      return this.y > 0 ? '<b>' + this.point.name + ':</b> ' +
                          this.y : null;
                  },
                  color: '#fff',
                  border : '0px',
                  distance: -65 
              }
            },
            {
              name: 'Total Projects',
              data: versionsData,
              size: '60%',
              innerSize: '60%',
              dataLabels: {
                  style: {
                      fontSize : '10px',
                      border : '1px'
                    },
                  formatter: function () {
                      var a = '#d81011';
                      switch(this.point.name){
                        case 'APPLICATION' :
                            a = '#ff8201';
                          break;
                        case 'CONNECTIVITY' :
                            a = '#32f7ca';
                          break;
                        case 'CPE DEVICES' :
                            a = '#0b8fc1';
                          break;
                        case 'SMART BUILDING':
                            a = '#d60db4';
                          break;
                        default:
                          break;
                      }

                      return this.y > 0 ? "<b style='color:"+a+"'>" + this.point.name + " : <span style='font-size:14px;color:"+a+"'>"+this.y+'</b> ' : null;
                  },
                  color: '#000',
                  distance: 70
              }
            }
          ],
          responsive: {
              rules: [{
                  condition: {
                      maxWidth: 400
                  },
                  chartOptions: {
                      series: [{
                          id: 'versions',
                          dataLabels: {
                              enabled: false
                          }
                      }]
                  }
              }]
          }
      });   


      var colors = Highcharts.getOptions().colors,
          categories = [
              "BIG",
              "MEGA",
              "ORDINARY",
              "REGULAR",
          ],
          data = <?= json_encode($chartProjectScale); ?>,
          projectScale = [],
          i,
          j,
          dataLen = data.length,
          drillDataLen,
          brightness;


      // Build the data arrays
      for (i = 0; i < dataLen; i += 1) {

          // add browser data 
          projectScale.push({
              name: categories[i],
              y: data[i].Y,
              color: data[i].color,
              x: data[i].V
          });
      }

      // Create the chart
      Highcharts.chart('chartProjectScale', {
          chart: {
              type: 'pie',
              backgroundColor: '#ffffff',
              height:'280px',
          },
          title: {text: '' },
          credits: { text: ''},
          subtitle: { text: ''},
          yAxis: {
              title: {
                  text: 'Projects Scale'
              }
          },
          plotOptions: {
              pie: {
                  shadow: false,
                  center: ['50%', '35%']
              }
          },
          series: [{
              name: 'Total Projects',
              data: projectScale,
              size: '80%',
              innerSize:'0%',
              dataLabels: {
                  style: {
                      fontSize : '9px',
                      border : '0px',
                      // textOutline : false
                    },
                  formatter: function () {
                      var a = '#6f6f6f';/*
                      switch(this.point.name){
                        case 'ORDINARY' :
                            a = '#9a9a9a';
                          break;
                        case 'REGULAR' :
                            a = '#a30f7e';
                          break;
                        case 'BIG' :
                            a = '#086e94';
                          break;
                        case 'MEGA' :
                            a = '#22a144';
                          break;
                        default :
                          break;

                      }*/
                      return this.y > 1 ? "<span style='color:"+a+";borderColor:#fff'>" + this.point.name + " : <span style='color:"+a+";font-size:11px;'>"+this.y+"</> ": null;
                  },
                  border : '0px',
                  distance: -20
              }
          }],
      });


        var c_region1 = '#00aced';
            var c_region2 = '#004f6e';
            var c_region3 = '#4875b4';
            var c_region4 = '#00c204';
            var c_region5 = '#d38436';
            var c_region6 = '#f396cf';
            var c_region7 = '#96e7f3';

            $('#regionalChart').vectorMap({
              map: 'indonesia_id',
              backgroundColor: '#0b8fc1',
              borderColor: '#818181',
              borderRadius: '5px',
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

            $('#regionalChart').vectorMap('set', 'colors', { path01: c_region1, 
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
  

  // SYMPTOMP
  Highcharts.chart('chartSymptoms', {
    data: {
        table: 'data_symptoms',
    }, 
    legend: {
          layout: 'horizontal',
          backgroundColor: '#fdfdfd',
          itemStyle: {
                color: '#0a0a0a',
                fontSize : '9px'
              },
      },
    chart: {
        type: 'column',
         backgroundColor: '#fdfdfd00',
         height: '550px'
    },
    title: {text: ''},
    credits: { text: ''},
    yAxis: {
        title: {
            text: ''
        },
    },
    xAxis: {
        title: {
            text: 'Projects Symptoms'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    },
    credits: {
                    text: '',
                    href: 'https://prime.telkom.co.id/sdv/projects',
                    style: {
                    color: '#a40000'},
                },
    subtitle: {
        text: ''
    },
    dataLabels: {
            enabled: true,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y:.1f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        },
        plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
            }
        }
    },
 
  });



  Highcharts.chart('chartSegmenScale', {
      chart: {
          type: 'bar',
          backgroundColor : '#fdfdfd00',
          height: '550px'
      },
      title: {
          text: ''
      },
      xAxis: {
          categories: <?= json_encode($segmen['s_name']); ?>
      },
      subtitle: {
          text: 'Segmen with Project Scale'
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
       tooltip: {
                    valueSuffix: ' Projects'
                  },
      legend: {
          reversed: true
      },
      credits: { text: ''},
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: <?= json_encode($segmen_scale); ?>,
      plotOptions: {
          bar: {
              dataLabels: {
                  enabled: true,
                  style: {
                      fontSize : '12px',
                      border : '0px',
                    },
                  color : '#000'
              }
          }
      },
  });


  Highcharts.chart('chartSegmenValue', {
      chart: {
          type: 'bar',
          backgroundColor : '#fdfdfd00',
          height: '550px'
      },
      title: {
          text: ''
      },
      xAxis: {
          categories: <?= json_encode($segmen['s_name']); ?>
      },
      subtitle: {
        text: 'Segmen Projects Value IDR in Billion' 
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      tooltip: {
                    valueSuffix: ' Billion'
                  },

      legend: {
          reversed: true
      },
      credits: { text: ''},
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
                  name: 'Total Projects Value',
                  data: <?= json_encode($segmen_value) ?>
              }],
      plotOptions: {
          bar: {
              dataLabels: {
                  enabled: true,
                  style: {
                      fontSize : '10px',
                      border : '0px',
                    },
                  color : '#000'
              }
          }
      },
  });
      

  Highcharts.chart('chartSegmenProgress', {
      chart: {
          type: 'bar',
          backgroundColor : '#fdfdfd00',
          height: '550px'
      },
      title: {
          text: ''
      },
      subtitle: {
          text: 'Segmen Projects Progress'
      },
      xAxis: {
          categories: <?= json_encode($segmen['s_name']); ?>
      },
      yAxis: {
          min: 0,
          title: {
              text: ''
          }
      },
      tooltip: {
          valueSuffix: ' Projects'
      },
      plotOptions: {
          bar: {
              dataLabels: {
                  enabled: true
              }
          }
      },
      legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'top',
          x: -40,
          y: 80,
          floating: true,
          borderWidth: 1,
          backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
          shadow: true
      },
      credits: {
          enabled: false
      },
      series: <?= json_encode($segmen_status); ?>
  });



  // CHART BAST APPROVED
  Highcharts.chart('chartBast', {
    chart: {
        type: 'column',
        height: '335px'
    },
    title: {
        text: 'BAST Approved',
        style : {
          fontSize : '14px'
        }
    },
    subtitle: {
        text: 'Click the columns to view month',
        style : {
          fontSize : '10px'
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: ''
        },
        labels :{
            enabled : false,
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                color : '#000'
            }
        }
    },
    credits: {
          enabled: false
      },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> BAST<br/>'
    },

    series: [
        {
            "name": "Year",
            "color": '#1c7132',
            "data": <?= json_encode($bast['data']); ?>,        }
    ],
    drilldown : {series : <?= json_encode($bastDrilldown) ?>}
});


// CHART BAST APPROVED
  Highcharts.chart('chartBastProgress', {
    chart: {
        type: 'column',
        height :'200px;'
    },
    exporting: { enabled: false },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
                      categories: [ '','']
                  },
    yAxis: {
        title: {
            text: ''
        },
        labels :{
            enabled : false,
        }

    },
    legend: {
        enabled: true,
        itemStyle: {
          fontSize : '9px'
        }
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
            }
        }
    },
    credits: {
          enabled: false
      },
    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> BAST<br/>'
    },

    series: [
        {
            name        : "Revision (Out)",
            color       : '#ffc107',
            data        : [<?= $bast_r ?>]    
        },
        {
            name        : "Progress (In)",
            color       : '#0fc13e',
            data        : [<?= $bast_p ?>]    
        }
    ]

});


</script>