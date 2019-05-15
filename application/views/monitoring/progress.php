<style type="text/css">
  #dataProg th {
    border : 1px solid #a4b7c1;
  }

  .table > tbody > tr > td{
    font-size: 14px;  
  }

  .table>tbody>tr.danger>td{
    background: #fd180033 !important;
  }
  .table>tbody>tr.info>td{
    background: #dfdfdf !important;
  }

  .table>tbody>tr.warning>td{
    background: #ffcc0033 !important;
  }

  .table>tbody>tr.success>td{ 
    background: #00ff5933 !important;
  }

  .table>tbody>tr.disabled>td{
    background: #dadada !important;
  } 
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/planAch"> Monitoring Project Progress</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <!-- <a href="<?= base_url(); ?>monitoring/download_list_monitoring_planAch" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a> -->
  </div>
</div> 
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataProg" class="table table-responsive-sm" style="width: 100% !important;">
              <thead style="border: 2px solid #a4b7c1">
                <tr >
                  <th style="width: 35%;" rowspan="2" style="border-right: 2px solid #a4b7c1 !important;">Project Name</th>
                  <th style="width: 15%;" rowspan="2" style="border-right: 2px solid #a4b7c1 !important;">Project Manager</th>
                  <th style="width: 10%;" rowspan="2" style="border-right: 1px solid #a4b7c1">Deliverable</th>
                  <th style="width: 10%;" rowspan="2" style="border-right: 1px solid #a4b7c1">issue<br> <span style="font-size: 8px;">Open / Total</span></th>
                  <th style="width: 10%;" colspan="2" style="border-right: 1px solid #a4b7c1">Last week</th>
                  <th style="width: 10%;" colspan="2" style="border-right: 1px solid #a4b7c1">this Week</th>
                  <th style="width: 10%;" colspan="2" style="border-right: 1px solid #a4b7c1">Acquistion</th>
                  <th style="width: 10%;" rowspan="2">Date updated</th>
                </tr>
                <tr>
                  <th>Plan</th>
                  <th>Ach.</th>
                  <th>Plan</th>
                  <th>Ach.</th>
                  <th>Last Month</th>
                  <th>This Monht</th>
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
        function sidebarHidden() {
              setTimeout(function () {
                  console.log('sidebar-hidden');
                  $('body').addClass('sidebar-hidden');
              }, 1000);
          }
          var TableInitialize = function() {                  
                $('#dataProg').DataTable({
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
                      var columnCount = $("#dataMonitoringIssueAp tr:first th").length-3  ;
                      for (dimension_col = 0; dimension_col < columnCount; dimension_col++) {
                          // first_instance holds the first instance of identical td
                          var first_instance = null;
                          var rowspan = 1;
                          // iterate through rows
                          $("#dataMonitoringIssueAp").find('tr').each(function () {

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
                      'url'   :base_url+'monitoring/get_list_progress', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    },
                    aoColumns: [
                                { mData: 'NAME' },
                                { mData: 'PM_NAME' },
                                { mData: 'T_DELIV' },
                                {
                                   'mRender': function(data, type, obj){
                                    return obj.T_ISSUE_OPEN+" / <span class='text-success'>"+obj.T_ISSUE_CLOSED+"</span>"; 
                                  }

                                },
                                {'mRender': function(data, type, obj){
                                    return obj.L_PLAN+"%"; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.L_ACH+"%"; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.PLAN+"%"; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.ACH+"%"; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.LM_ACQ; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.M_ACQ; 
                                  }
                                },
                                {'mRender': function(data, type, obj){
                                    return obj.UPDATED_DATE; 
                                  }
                                },
                               ],  
                            columnDefs: [
                                { orderable: false, targets: [4,5] },
                              ],
                            fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                              var a = null;
                              if(aData['WEIGHT']==0){
                                $(nRow).addClass('disabled')  
                              }else{
                                $(nRow).addClass( aData['INDICATOR'] );
                              }   
                              return nRow;
                              }     
                });         
            };  
      return {
          init: function() { 
            sidebarHidden();
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#dataProg').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>