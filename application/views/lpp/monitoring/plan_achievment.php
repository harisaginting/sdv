<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/planAch"> Monitoring Plan x Achievment Project This Week</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_monitoring_planAch" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> 
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataMonitoringIssueAp" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 20%;">Project Manager</th>
                  <th style="width: 30%;">Name</th>
                  <th style="width: 10%;">Plan</th>
                  <th style="width: 10%;">Ach.</th>
                  <th style="width: 15%;">Deliverables</th>
                  <th style="width: 15%;">Action Plan</th>
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
                $('#dataMonitoringIssueAp').DataTable({
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
                      'url'   :base_url+'monitoring/get_list_planAch', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    },
                    aoColumns: [
                                { mData: 'PM_NAME' },
                                {
                                   'mRender': function(data, type, obj){
                                    return "<a style='font-size:12px;' class='text-primary nav-link-hgn' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"' >"+obj.NAME+"</a>"; 
                                  }

                                },
                                { mData: 'PLAN' },
                                { mData: 'ACH' },
                                {
                                  'mRender': function(data, type, obj){
                                      var devmerah  = 'hidden'; var DEVmerah  = '0';
                                      var devkuning = 'hidden';var DEVkuning = '0';
                                      var devhijau  = 'hidden'; var DEVhijau  = '0';
                                      if(obj.DEV_MERAH!=null  || obj.DEV_MERAH!=undefined) {DEVmerah  = obj.DEV_MERAH; devmerah   = ''};
                                      if(obj.DEV_KUNING!=null || obj.DEV_KUNING!=undefined){DEVkuning = obj.DEV_KUNING;devkuning = ''};
                                      if(obj.DEV_HIJAU!=null  || obj.DEV_HIJAU!=undefined) {DEVhijau  = obj.DEV_HIJAU; devhijau   = ''};

                                      return "<label style='font-size:10px;width:32%;margin-right:1px;'    class='btn bg-danger  "+devmerah+" '>"+DEVmerah+"</label>"
                                              + "<label style='font-size:10px;width:32%;margin-right:1px;' class='btn bg-warning "+devkuning+"'>"+DEVkuning+"</label>"
                                              + "<label style='font-size:10px;width:32%;margin-right:1px;' class='btn bg-success "+devhijau+"'>"+DEVhijau+"</label>"; 
                                      
                                      }

                                  },
                                  {
                                  'mRender': function(data, type, obj){
                                      var apmerah  = 'hidden'; var APmerah  = '0';
                                      var apkuning = 'hidden';var APkuning = '0';
                                      var aphijau  = 'hidden'; var APhijau  = '0';
                                      if(obj.AP_MERAH!=null  || obj.AP_MERAH!=undefined) {APmerah  = obj.AP_MERAH; apmerah   = ''};
                                      if(obj.AP_KUNING!=null || obj.AP_KUNING!=undefined){APkuning = obj.AP_KUNING;apkuning = ''};
                                      if(obj.AP_HIJAU!=null  || obj.AP_HIJAU!=undefined) {APhijau  = obj.AP_HIJAU; aphijau   = ''};

                                      return "<label style='font-size:10px;width:32%;margin-right:1px;'    class='btn bg-danger  "+apmerah+" '>"+APmerah+"</label>"
                                              + "<label style='font-size:10px;width:32%;margin-right:1px;' class='btn bg-warning "+apkuning+"'>"+APkuning+"</label>"
                                              + "<label style='font-size:10px;width:32%;margin-right:1px;' class='btn bg-success "+aphijau+"'>"+APhijau+"</label>"; 
                                      
                                      }

                                  },
                               ],  
                            columnDefs: [
                                { orderable: false, targets: [4,5] },
                              ]    
                });         
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#dataMonitoringIssueAp').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>