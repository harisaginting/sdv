<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/subsidiary">Monitoring Subsidiary</li>
<!-- <div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_monitoring_subsidiary" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> --> 
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataMonitoringPartner" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 25%;">Subsidiary</th>
                  <th style="width: 10%;">Id Project</th>
                  <th style="width: 25%;">Customer</th>
                  <th style="width: 10%;">Status</th>
                  <th style="width: 10%;">Plan</th>
                  <th style="width: 10%;">Ach.</th>
                  <th style="width: 10%;">End Date</th>
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
                $('#dataMonitoringPartner').DataTable({
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

                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                      'url'   :base_url+'monitoring/get_list_subsidiary', 
                      'type'  :'POST' 
                    },
                    aoColumns: [
                                { mData: 'PARTNER_NAME'},
                                { mData: 'ID_PROJECT'},
                                { mData: 'STANDARD_NAME'},
                                { mData: 'STATUS'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.PLAN + ' %';   
                                    }            
                                            
                                }, 
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.REAL + ' %';   
                                    }            
                                            
                                }, 
                                { mData: 'END_DATE'}
                               ],  
                            columnDefs: [
                                //{ orderable: false, targets: [4,5] },
                              ]    
                });         
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#dataMonitoringPartner').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>