<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>master/am"> History</li>
  <div class="col-md-10">  
  </div>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataHistory" class="table table-responsive-sm" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width:15%">DATE TIME </th>
                  <th style="width:12%">IP ADDRESS</th>
                    <th style="width:10%">USER ID</th>
                    <th style="width:20%">NAME </th>
                    <th style="width:10%">OBJECT</th>                   
                    <th style="width:20%">STATUS</th>
                    <th style="width:10%">TYPE</th>
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
    var tableInit = function(){    
        var table = $('#dataHistory').DataTable({
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
                        'url'  :base_url+'master/get_datatables_history', 
                        'type' :'POST',
                        'data' : {
                                  type  : $('#type_users').val(),
                                  }    
                        },
                    aoColumns: [
                                { mData: 'TIME' },
                                { mData: 'IP' },
                                { mData: 'ID_USER' },
                                { mData: 'NAME_USER' },
                                {
                                'mRender': function(data, type, obj){
                                    var id = obj.ID;
                                    var type = obj.TYPE;
                                    if(type=='PROJECT' || type=='API'){
                                        return "<a style='font-size:10px;width:100px;padding-right:20px;' class=\'btn btn-xs btn-success \' class='text-primary' href='"+base_url+"projects/detail_project/"+id+"' ><i class='pull-left glyphicon glyphicon-new-window'></i> &nbsp;"+id+"</a>";  
                                        }
                                    else if(type == 'BAST'){
                                        return "<a style='font-size:10px;width:100px;padding-right:20px;' class=\'btn btn-xs btn-success \' href='"+base_url+"index.php/bast/view/"+id+"' ><i class='pull-left glyphicon glyphicon-new-window'></i> &nbsp;Detail</a>";
                                        }
                                    else{
                                        return id;
                                         }
                                    }
                                },
                                { mData: 'STATUS' },
                                { mData: 'TYPE' },
                               ],           
                });  
    };    
      return {
          init: function() { 
            tableInit();
            $(document).on('change','.searchOnTable', function (e) {
              e.stopImmediatePropagation();
              $('#dataHistory').dataTable().fnDestroy();
              tableInit();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });      

           
</script>