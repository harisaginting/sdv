<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/planAch"> Monitoring Project BAST</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_monitoring_bast" class="btn btn-primary btn-addon "><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> 
</ol>
<div class="container-fluid container-content">

<div class="col-md-12"> 
<div class="card border-primary">
 <div class="card-header">

  
  <div class="float-right col-sm-2">
    <select id="monitoring_bast_status" name="monitoring_bast_status" class="form-control form-control-sm Jselect2">
    <option value="">All Status</option>
    <option value="LEAD">LEAD</option>
    <option value="LAG">LAG</option> 
    <option value="DELAY">DELAY</option> 
    <option value="PROJECT CANDIDATE">CANDIDATE</option> 
    <option value="CLOSED">CLOSED</option> 
    </select>
  </div> 

</div>
<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataMonitoringBastProject" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 20%;">Project Name</th>
                  <th style="width: 10%;">Value</th>
                  <th style="width: 20%;">No. BAST</th>
                  <th style="width: 12%;">BAST Value</th>
                  <th style="width: 10%;">BAST Date</th>
                  <th style="width: 10%;">BAST Type</th>
                  <th style="width: 10%;">Progress</th>
                  <th style="width: 10%;">Status</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div> 
</div>
</div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {       
          var TableInitialize = function() {                  
                $('#dataMonitoringBastProject').DataTable({
                     initComplete: function(settings, json) {
                     var input = $('.dataTables_filter input').unbind(),
                                    self = this.api(),
                                    $searchButton = $('<button>')
                                               .text('search')
                                               .addClass('btn btn btn-success mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn btn-info mb-2')
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


                      var dimension_cells = new Array();
                      var dimension_col = null;
                      var columnCount = $("#dataMonitoringBastProject tr:first th").length-3  ;
                      for (dimension_col = 0; dimension_col < columnCount; dimension_col++) {
                          // first_instance holds the first instance of identical td
                          var first_instance = null;
                          var rowspan = 1;
                          // iterate through rows
                          $("#dataMonitoringBastProject").find('tr').each(function () {

                              // find the td of the correct column (determined by the dimension_col set above)
                              var dimension_td = $(this).find('td:nth-child(' + dimension_col + ')');

                              if (first_instance == null) {
                                  // must be the first row
                                  first_instance = dimension_td;
                              } else if (dimension_td.text() == first_instance.text()) {
                                  // the current td is identical to the previous
                                  // remove the current td
                                  dimension_td.remove();
                                  ++rowspan;
                                  // increment the rowspan attribute of the first instance
                                  first_instance.attr('rowspan', rowspan);
                              } else {
                                  // this cell is different from the last
                                  first_instance = dimension_td;
                                  rowspan = 1;
                              }
                          });
                      }
                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                      'url'   :base_url+'monitoring/get_list_bast', 
                      'type'  :'POST',
                      'data'  : {
                          status  : $('#monitoring_bast_status').val()
                          } 
                    },
                    aoColumns: [
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<a class='' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"'>"+obj.NAME+"</a> ";   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<a class='' href='"+base_url+"bast/view/"+obj.ID_BAST+"'>"+obj.NO_BAST+"</a> ";   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.VALUE2+"</span> ";   
                                    }            
                                            
                                },
                                { mData: 'BAST_DATE' },
                                { mData: 'TYPE_BAST' },
                                { 
                                    'mRender': function(data, type, obj){   
                                            var progress = 0;
                                            var type = obj.TYPE_BAST;
                                            if(type=='OTC'||type == 'PROGRESS'){
                                              progress = obj.PROGRESS_LAPANGAN+"%";
                                            }else if(type == 'TERMIN'){
                                              progress = obj.NAMA_TERMIN;
                                            }else{
                                              if(obj.RECC_START_DATE!=null){
                                                 progress = obj.RECC_START_DATE + " - " + obj.RECC_END_DATE;
                                               }else{
                                                  progress = "";
                                               }
                                             
                                            }

                                            var result = "";
                                            if(obj.PLAN!= null){
                                            result = "PLAN : "+obj.PLAN+"%<br> ACH &nbsp;&nbsp;: "+obj.ACH + "%<br>BAST :" + progress;
                                              }else{
                                            result = "BAST :" + progress;
                                            }

                                            return result;   
                                    }            
                                            
                                },
                                { mData: 'STATUS' },
                               ],   
                });          
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#dataMonitoringBastProject').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>