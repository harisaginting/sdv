<style type="text/css">
  .card{
    border-radius: 0px;
  }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item col-md-2"> User Profile</li>
</ol>

<div class="container-fluid container-content"> 

  <div class="col-md-12">
    <div class="card border-primary">
      <div class="card-body">
      
        <div class="row">
          <div class="col-md-4">
              <h2><?= $user['NAMA']; ?></h2>
              <h4><?= $user['NIK']; ?></h4>
              <img src="https://prime.telkom.co.id/V2/../user_picture/default-profile-picture.png" style="max-width: 100%;" class="img-circle">
              
            </div>
                    
            
            <div class="col-md-8">
                <h3>Projects</h3>
                <div class="row">

                  <div class="col-sm-12">

                    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                   </div> 
                  
                  <table id="datatableProjectProfile" hidden>
                      <thead>
                          <tr>
                              <th></th>
                              <th>LEAD</th>
                              <th>LAG</th>
                              <th>DELAY</th>
                              <th>CLOSED</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <th>APPLICATION</th>
                              <td><?= $type_project['APPLICATION']['LEAD']->TOTAL ?></td>
                              <td><?= $type_project['APPLICATION']['LAG']->TOTAL ?></td>
                              <td><?= $type_project['APPLICATION']['DELAY']->TOTAL ?></td>
                              <td><?= $type_project['APPLICATION']['CLOSED']->TOTAL ?></td>
                          </tr>
                          <tr>
                              <th>CONNECTIVITY</th>
                              <td><?= $type_project['CONNECTIVITY']['LEAD']->TOTAL ?></td>
                              <td><?= $type_project['CONNECTIVITY']['LAG']->TOTAL ?></td>
                              <td><?= $type_project['CONNECTIVITY']['DELAY']->TOTAL ?></td>
                              <td><?= $type_project['CONNECTIVITY']['CLOSED']->TOTAL ?></td>
                          </tr>
                          <tr>
                              <th>CPE & OTHERS</th>
                              <td><?= $type_project['CPE & OTHERS']['LEAD']->TOTAL ?></td>
                              <td><?= $type_project['CPE & OTHERS']['LAG']->TOTAL ?></td>
                              <td><?= $type_project['CPE & OTHERS']['DELAY']->TOTAL ?></td>
                              <td><?= $type_project['CPE & OTHERS']['CLOSED']->TOTAL ?></td>
                          </tr>
                          <tr>
                              <th>SMART BUILDING</th>
                              <td><?= $type_project['SMART BUILDING']['LEAD']->TOTAL ?></td>
                              <td><?= $type_project['SMART BUILDING']['LAG']->TOTAL ?></td>
                              <td><?= $type_project['SMART BUILDING']['DELAY']->TOTAL ?></td>
                              <td><?= $type_project['SMART BUILDING']['CLOSED']->TOTAL ?></td>
                          </tr>
                      </tbody>
                  </table>
                </div> 
                </div>
            </div>
        </div>
      
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">    
  var Page = function () {
    var tableInit = function(){                     
        var table = $('#dataku').DataTable({
                  initComplete: function(settings, json) {
                     var input = $('.dataTables_filter input').unbind(),
                                    self = this.api(),
                                    $searchButton = $('<button>')
                                               .text('search')
                                               .addClass('btn btn-md btn-success mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn-md btn-info mb-2')
                                               .click(function() {
                                                  input.val('');
                                                  $searchButton.click(); 
                                               }) 
                                $('.dataTables_filter').append($searchButton,$clearButton);
                                $('.rupiah').priceFormat({
                                    prefix: '',
                                    centsSeparator: ',',
                                    thousandsSeparator: '.',
                                    centsLimit: 0
                                });
                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                        'url'  :base_url+'projects/get_list_project_active', 
                        'type' :'POST',
                        'data' : {
                                  status  : $('#status').val(),
                                  pm      : $('#pm').val(),
                                  customer: $('#customer').val(),
                                  regional: $('#regional').val(),
                                  type    : $('#type').val(),
                                  mitra   : $('#mitra').val(),
                                  segmen  : $('#segmen').val()
                                  }   
                        },
                    aoColumns: [
                        { mData: 'ID_PROJECT'}, 
                        { mData: 'NAME'}, 
                        { mData: 'SEGMEN'}, 
                        { mData: 'TYPE'}, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return obj.WEIGHT + ' %';   
                            }            
                                    
                        },  
                        { 
                            'mRender': function(data, type, obj){   
                                    return obj.ACH + ' %';   
                            }            
                                    
                        },
                        
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<span style='font-size:10px;width:48%;margin-right:1px;' class=\'circle nav-link-hgn btn btn-xs btn-success \' data-url='"+base_url+"projects/view/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></span>"+
                                            "<span style='font-size:10px;width:48%;margin-right:1px;' class=\'circle btn btn-xs nav-link-hgn btn-warning \' data-url='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-pencil'/></i></span>";       
                                    return a;
                            }

                        }, 
                       ],      
                });  
    };    
      return {
          init: function() { 
            tableInit();
            $(document).on('change','.Jselect2Active', function (e) {
              e.stopImmediatePropagation();
              $('#dataku').dataTable().fnDestroy();

              tableInit();
              });

            var nik = "<?= $user['NIK'] ?>";  
            var lLead = [];


            Highcharts.chart('container', {
              colors: ['#1ec100', '#ce8500', '#ffc107','#d34836'],
                chart: {
                    type: 'bar',
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Application', 'Connectivity', 'CPE & Others', 'Smart Building']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Project'
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    }
                },
                data: {
                    table: 'datatableProjectProfile'
                },
                credits:''
            });


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>