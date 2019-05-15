<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/closed"> Projects Closed</li>
<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_pm_activity" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 0px;" class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div> 

  <div class="pull-right" style="margin-right: 10px;padding-top: 2px">
      <input type="text" id="start_date" name="start_date" class="form-control form-control-sm date-picker" placeholder="set cut off date">
  </div>
</div>
<?php  endif; ?>
</ol>




<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="pm" name="pm" class="form-control form-control-sm Jselect2">
    <option value="">All Project Manager</option>
    <?php foreach ($list_pm as $key => $value) : ?>
          <option value="<?= $list_pm[$key]['NIK']; ?>"><?= $list_pm[$key]['NAMA']; ?></option>
    <?php endforeach; ?>
    </select> 
  </div>


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuProjectClosed" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th>Project Manager</th>
                  <th>Total Project</th>
                  <th>Project Updated</th>
                  <th>Project Not Updated</th>
                  <th></th>
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
        var table = $('#datakuProjectClosed').DataTable({
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
                        'url'  :base_url+'monitoring/get_list_pm_activity', 
                        'type' :'POST',
                        'data' : {
                                  start_date  : $('#start_date').val(),
                                  pm      : $('#pm').val(),
                                  }   
                        },
                    aoColumns: [
                        { mData: 'PM_NAME'}, 
                        { mData: 'TOTAL'}, 
                        { mData: 'UPDATED'}, 
                        { mData: 'NOT_UPDATED'}, 
                        {
                            'mRender': function(data, type, obj){
                                 var a = "<a style='font-size:10px;margin-right:1px;' class=\' circle nav-link-hgn btn  btn-success \' href='"+base_url+"projects/view_closed/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></a>";       
                                    return "";
                            }

                        }
                       ],      
                });  
    };    
      return {
          init: function() { 
            tableInit();
            $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#datakuProjectClosed').dataTable().fnDestroy();
              tableInit();
              });


            $(document).on('change','#start_date', function (e) {
              e.stopImmediatePropagation();
              $('#datakuProjectClosed').dataTable().fnDestroy();
              tableInit();
              });


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>