<div id="segmen_status" style="width: 100%; height: 400px; margin: 0 auto"></div>
            
<script type="text/javascript">
     //Diagram Segmen
    var segmen          = <?= json_encode($segmen)?>;
    var segmen_total    = <?= !empty($segmen_total) ? json_encode($segmen_total) : '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]'?>;
    var segmen_sum      = <?=  !empty($segmen_sum) ? json_encode($segmen_sum) : '[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]' ?>;

    Highcharts.chart('segmen_status', {
        colors: ['#1ec100','#ef9a00','#00c2ff','#0d00de'],    
        chart: {
                type: 'column',
                backgroundColor: 'rgba(225, 225, 225, 0.8)',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                plotBorderColor: '#606063',
                style: {
                color:'#fff !important'
                },
            
        },
        title: {
            text: 'Projects',
            style: {
                 color: '#f42020',
                 textTransform: 'uppercase',
                 fontSize: '20px',
                 fontFamily: '\'Orbitron\', sans-serif',
              },
        },
        subtitle: {
            text: 'by Segmen and Category',
            style: {
                 color: '#aaa',
                 fontSize: '10px',
                 fontFamily: '\'Orbitron\', sans-serif',
              },
        },
        credits: {
                        text: 'SDV - DES',
                        href: 'https://prime.telkom.co.id/V2/projects/active',
                        style: {
                        color: '#a40000'},
        },
        xAxis: {
             categories: segmen,
             crosshair: true,
             gridLineColor: '#d0d0d0',
              labels: {
                 style: {
                    color: '#000'
                 }
              },
              lineColor: '#707073',
              minorGridLineColor: '#505053',
              tickColor: '#707073',
              title: {
                 style: {
                    color: '#f42020'

                 }
              }
            },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            labels: {
                 style: {
                    color: '#000'
                 }
              },
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px;font-family:Orbitron;padding-right:50px;">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0;font-size:10px;">{series.name}: </td>' +
                '<td style="padding:0;"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                  style: {
                     color: '#F0F0F0',
                     fontFamily: 'sans-serif !important',
                  },
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            dataLabels: {
                    color: '#B0B0B3'
                 },
        },
        series: [
        {
            name: 'Value (IDR in Billion)',
            data: segmen_sum,

        },
        {
            name: 'Total',
            data: segmen_total

        }
        ]
    });
</script>