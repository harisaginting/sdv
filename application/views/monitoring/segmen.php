<style type="text/css">
  #summary_year_start, #summary_year_end{
    background-color: #00ff4e;
  }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/subsidiary">Monitoring Segmen</li>
<!-- <div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_monitoring_subsidiary" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> --> 
</ol>
<div class="container-fluid container-content">
  <div class="card">
  <div class="card-header" style="border-bottom: 0px !important;padding-bottom: 0px;">
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
          <div class="row">
            <div class="col-md-2">
              <div id="segmen1" ></div>
            </div>

          </div> 
      </div>
      </div>


</div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {       
          var Initialize = function() {                  
                        
                          };

          

            

var colors = Highcharts.getOptions().colors,
    categories = [
        "Chrome",
        "Firefox",
        "Internet Explorer",
        "Safari",
        "Edge",
        "Opera",
        "Other"
    ],
    data = [
        {
            "y": 62.74,
            "color": colors[2],
            "drilldown": {
                "name": "Chrome",
                "categories": [
                    "Chrome v65.0",
                    "Chrome v64.0",
                    "Chrome v63.0",
                    "Chrome v62.0",
                    "Chrome v61.0",
                    "Chrome v60.0",
                    "Chrome v59.0",
                    "Chrome v58.0",
                    "Chrome v57.0",
                    "Chrome v56.0",
                    "Chrome v55.0",
                    "Chrome v54.0",
                    "Chrome v51.0",
                    "Chrome v49.0",
                    "Chrome v48.0",
                    "Chrome v47.0",
                    "Chrome v43.0",
                    "Chrome v29.0"
                ],
                "data": [
                    0.1,
                    1.3,
                    53.02,
                    1.4,
                    0.88,
                    0.56,
                    0.45,
                    0.49,
                    0.32,
                    0.29,
                    0.79,
                    0.18,
                    0.13,
                    2.16,
                    0.13,
                    0.11,
                    0.17,
                    0.26
                ]
            }
        },
        {
            "y": 10.57,
            "color": colors[1],
            "drilldown": {
                "name": "Firefox",
                "categories": [
                    "Firefox v58.0",
                    "Firefox v57.0",
                    "Firefox v56.0",
                    "Firefox v55.0",
                    "Firefox v54.0",
                    "Firefox v52.0",
                    "Firefox v51.0",
                    "Firefox v50.0",
                    "Firefox v48.0",
                    "Firefox v47.0"
                ],
                "data": [
                    1.02,
                    7.36,
                    0.35,
                    0.11,
                    0.1,
                    0.95,
                    0.15,
                    0.1,
                    0.31,
                    0.12
                ]
            }
        },
        {
            "y": 7.23,
            "color": colors[0],
            "drilldown": {
                "name": "Internet Explorer",
                "categories": [
                    "Internet Explorer v11.0",
                    "Internet Explorer v10.0",
                    "Internet Explorer v9.0",
                    "Internet Explorer v8.0"
                ],
                "data": [
                    6.2,
                    0.29,
                    0.27,
                    0.47
                ]
            }
        },
        {
            "y": 5.58,
            "color": colors[3],
            "drilldown": {
                "name": "Safari",
                "categories": [
                    "Safari v11.0",
                    "Safari v10.1",
                    "Safari v10.0",
                    "Safari v9.1",
                    "Safari v9.0",
                    "Safari v5.1"
                ],
                "data": [
                    3.39,
                    0.96,
                    0.36,
                    0.54,
                    0.13,
                    0.2
                ]
            }
        },
        {
            "y": 4.02,
            "color": colors[5],
            "drilldown": {
                "name": "Edge",
                "categories": [
                    "Edge v16",
                    "Edge v15",
                    "Edge v14",
                    "Edge v13"
                ],
                "data": [
                    2.6,
                    0.92,
                    0.4,
                    0.1
                ]
            }
        },
        {
            "y": 1.92,
            "color": colors[4],
            "drilldown": {
                "name": "Opera",
                "categories": [
                    "Opera v50.0",
                    "Opera v49.0",
                    "Opera v12.1"
                ],
                "data": [
                    0.96,
                    0.82,
                    0.14
                ]
            }
        },
        {
            "y": 7.62,
            "color": colors[6],
            "drilldown": {
                "name": 'Other',
                "categories": [
                    'Other'
                ],
                "data": [
                    7.62
                ]
            }
        }
    ],
    browserData = [],
    versionsData = [],
    i,
    j,
    dataLen = data.length,
    drillDataLen,
    brightness;


// Build the data arrays
for (i = 0; i < dataLen; i += 1) {

    // add browser data
    browserData.push({
        name: categories[i],
        y: data[i].y,
        color: data[i].color
    });

    // add version data
    drillDataLen = data[i].drilldown.data.length;
    for (j = 0; j < drillDataLen; j += 1) {
        brightness = 0.2 - (j / drillDataLen) / 5;
        versionsData.push({
            name: data[i].drilldown.categories[j],
            y: data[i].drilldown.data[j],
            color: Highcharts.Color(data[i].color).brighten(brightness).get()
        });
    }
}

// Create the chart
Highcharts.chart('segmen1', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Browser market share, January, 2018'
    },
    subtitle: {
        text: 'Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    },
    yAxis: {
        title: {
            text: 'Total percent market share'
        }
    },
    plotOptions: {
        pie: {
            shadow: false,
            center: ['50%', '50%']
        }
    },
    tooltip: {
        valueSuffix: '%'
    },
    series: [{
        name: 'Browsers',
        data: browserData,
        size: '60%',
        dataLabels: {
            formatter: function () {
                return this.y > 5 ? this.point.name : null;
            },
            color: '#ffffff',
            distance: -30
        }
    }, {
        name: 'Versions',
        data: versionsData,
        size: '80%',
        innerSize: '60%',
        dataLabels: {
            formatter: function () {
                // display only if larger than 1
                return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                    this.y + '%' : null;
            }
        },
        id: 'versions'
    }],
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




      return {
          init: function() { 
            Initialize();
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>