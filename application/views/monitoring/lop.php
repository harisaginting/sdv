<style type="text/css">
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
<li class="breadcrumb-item col-md-2"> Monitoring LOP WIN</li>
</ol>

<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="type" name="type" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Type</option>
    <option value="APPLICATION">Application</option>
    <option value="CONNECTIVITY">Connectivity</option>
    <option value="SMART BUILDING">Smart Building</option>
    <option value="CPE & OTHERS">CPE & Others</option>
    </select>
  </div>
 
  <div class="float-right col-sm-2 hidden">
    <select id="pm" name="pm" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Project Manager</option>
    <?php foreach ($list_pm as $key => $value) : ?>
          <option value="<?= $list_pm[$key]['NIK']; ?>"><?= $list_pm[$key]['NAMA']; ?></option>
    <?php endforeach; ?>
    </select> 
  </div>
 
  <div class="float-right col-sm-2 hidden">
    <select id="partner" name="partner" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Partners</option>
    <?php foreach ($list_mitra as $key => $value) : ?>
          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="customer" name="customer" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Customers</option>
    <?php foreach ($list_cc as $key => $value) : ?>
          <option value="<?= $list_cc[$key]['NIP_NAS']; ?>"><?= $list_cc[$key]['STANDARD_NAME']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
   
  <div class="float-right col-sm-2 hidden">
    <select id="status" name="status" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Status</option>
    <option value="LEAD">LEAD</option>
    <option value="LAG">LAG</option>
    <option value="DELAY">DELAY</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="segmen" name="segmen" class="form-control form-control-sm Jselect2 Jselect2Active" style="width: 100%;">
        <option value="">All Segmen</option>
        <?php foreach ($list_segmen as $key => $value) : ?>
              <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
        <?php endforeach; ?>
      </select>
  </div>

  <div class="float-right col-sm-2 hidden">
    <select id="regional" name="regional" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Regional</option>
    <option value="1">Regional 1</option>
    <option value="2">Regional 2</option>
    <option value="3">Regional 3</option>
    <option value="4">Regional 4</option>
    <option value="5">Regional 5</option>
    <option value="6">Regional 6</option>
    <option value="7">Regional 7</option>
    </select>
  </div>


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataku" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="max-width: 12% !important;">ID LOP</th>
                  <th style="max-width: 36% !important;">Project Name</th>
                  <th style="max-width: 10% !important;">Segmen</th>
                  <th style="max-width: 15% !important;">AM</th>
                  <th style="max-width: 10% !important;">No. Quote</th>
                  <th style="max-width: 10% !important;">No. SO</th>
                  <th style="max-width: 5% !important;">SPK</th>
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
              $('body').addClass('sidebar-hidden');
          }, 3000);
      }

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
                                $(function () {
                                  $('[data-toggle="tooltip"]').tooltip()
                                });
                    },
                    processing: true,
                    serverSide: true,
                    order :[0,'desc'],
                    ajax: { 
                        'url'  :base_url+'monitoring/get_list_lop', 
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
                        { mData: 'PROJECT'}, 
                        { mData: 'SEGMENT'}, 
                         { 
                            'mRender': function(data, type, obj){
                              if(obj.NAMA_AM == null || obj.NAMA_AM== ""){
                                return "-";
                              }else{
                                return obj.NIK_AM+" - "+obj.NAMA_AM;
                              }   
                                       
                            }            
                                    
                        },
                        { mData: 'NOMOR_QUOTE'}, 
                        { mData: 'NOMOR_SO'}, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<a target='_blank' href='"+obj.FILE_SPK_CC+"'><i class='fa fa-file-o'><i></span> ";   
                            }            
                                    
                        }, 

                       ]  
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
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>