<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/candidate"> Projects Candidate</li>

</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">
List Cron Email BAST to Partner

  
  <div class="float-right col-sm-2">
    <input type="text" name="dateHappen" id="dateHappen" class="form-control date-picker" placeholder="Select Date" value="<?= date('m/d/Y',strtotime("-1 weekdays")); ?>" readOnly>
  </div>

</div> 

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataku" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th>KODE</th>
                  <th>PARTNER</th>
                  <th>STATUS</th>
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
                $('#dataku').DataTable({
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
                      'url'   :base_url+'utility/get_list_history_cron_partner', 
                      'type'  :'POST',
                      'data'  : {
                          dateHappen  : $('#dateHappen').val()
                          } 
                    },
                    aoColumns: [
                        { mData: 'KODE_PARTNER'},
                        { mData: 'NAMA_PARTNER'},
                        
                        { 
                            'mRender': function(data, type, obj){  
                                    if(obj.STATUS == 'SUCCESS'){
                                        return obj.STATUS;                   
                                    }else{
                                        return "<a class='btn btn-success btn-addon' href='"+base_url+"utility/sendEmailPartner/"+obj.KODE_PARTNER+"' target='_blank'><i class='fa fa-share-square'></i>Send Email</a>" ;
                                    }   
                                    
                            }            
                                    
                        },
                       ],      
                });         
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','#dateHappen', function (e) {
              e.stopImmediatePropagation();
              $('#dataku').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>