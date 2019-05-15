<div id="project_status" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
    var data_status     = <?= json_encode($by_status) ?>;
    var data_status_lead   = <?= !empty($sub_by_status['LEAD'])? json_encode($sub_by_status['LEAD']) : '' ?>;
    var data_status_lag   = <?= !empty($sub_by_status['LAG'])?json_encode($sub_by_status['LAG']) : ''?>;
    var data_status_delay   = <?= !empty($sub_by_status['DELAY'])?json_encode($sub_by_status['DELAY']): ''?>;

    Highcharts.chart('project_status', {
        
        chart: {
            //backgroundColor : null,   
            backgroundColor: 'rgba(225, 225, 225, 0.8)',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            style: {
            fontFamily: '\'Orbitron\', sans-serif'
            },
        }, 
        colors: ['#00c2ff','#ef9a00', '#1ec100','#0d00de'],
        credits: {
                    text: 'SDV - DES',
                    href: 'https://prime.telkom.co.id/V2/projects/active',
                    style: {
                    color: '#a40000'},
                },
        title: {
            style: {
             color: '#f42020',
             textTransform: 'uppercase',
             fontSize: '20px'
          },
            text: 'Projects Status'
        },
        subtitle: {
            text: 'Click the slices to view type project',
            style: {
             color: '#aaa',
             fontSize: '10px'
          },
        },
        plotOptions: {
            dataLabels: {
                color: '#B0B0B3'
             },
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}:<br>{point.y:f} Project'
                }
            },
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<b>{point.y:f} Project <span style="color:{point.color}">{point.name}</span></b><br>Value : Rp. <b class="rupiah">{point.s}</b>',
            backgroundColor: 'rgba(0, 0, 0, 0.85)',
              style: {
                 color: '#F0F0F0',
                 fontFamily: 'sans-serif !important',
              }
        },
        series: [{
            name: 'Status',
            colorByPoint: true,
            data: data_status

            
        }],
        drilldown: {
            series: [
            {
                name: 'LEAD',
                id: 'LEAD',
                data: data_status_lead
            }, 
            {
                name: ':LAG',
                id: 'LAG',
                data: data_status_lag
            }, 
            {
                name: 'DELAY',
                id: 'DELAY',
                data: data_status_delay
            },
            ],
        }
    });   
</script>