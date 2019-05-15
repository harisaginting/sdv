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
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects"> Projects Active</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/download_list_active_projects_detail" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 0px;" class="float-left"> &nbsp; Download Detail &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>

  <div class="pull-right" style="margin-right: 20px;" >
      <a href="<?= base_url(); ?>projects/download_list_active_projects" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 20px; class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div> 
</div>
</ol>

<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">
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
 
  <div class="float-right col-sm-2">
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
   
  <div class="float-right col-sm-2">
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

  <div class="float-right col-sm-2">
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
                  <th>ID</th>
                  <th>Project Name</th>
                  <th>Segmen</th>
                  <th>Type</th>
                  <th>Value</th>
                  <th>Weight</th>
                  <th>Achievment</th>
                  <th>End Date</th>
                  <th>Action</th>
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
                        { 
                            'mRender': function(data, type, obj){
                                    var w = "";
                                    if((obj.STATUS=='DELAY'||obj.STATUS=='LAG')&& (obj.REASON_OF_DELAY == ""||obj.REASON_OF_DELAY == null)){
                                      w = "&nbsp;&nbsp;&nbsp;<span  class='fa fa-exclamation-circle text-danger' data-toggle='tooltip' data-placement='right' data-original-title='Please fill reason of delay (symtom)' aria-describedby='tooltip549771'></span>";
                                    }   
                                    return obj.NAME+w;   
                            }            
                                    
                        }, 
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
                        { mData: 'END_DATE'},
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<a style='font-size:10px;width:48%;margin-right:1px;' class=\'circle2 nav-link-hgn btn btn-xs btn-success \' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></a>"+
                                            "<a style='font-size:10px;width:48%;margin-right:1px;' class=\'circle2 btn btn-xs nav-link-hgn btn-warning \' href='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-pencil'/></i></a>";       
                                    return a;
                            }

                        }, 
                       ],  
                       fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                          $(nRow).addClass( aData['INDICATOR'] );
                          return nRow;
                          }    
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


            <?php if(!empty($sidebarhidden)) : ?>
             sidebarHidden();
            <?php endif; ?>
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>