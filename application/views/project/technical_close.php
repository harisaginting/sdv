<style type="text/css">

  .callout{
    background: #595959;
    color: #fff;
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
    /*background: #dadada !important;*/
    background: #f7f7f7 !important;
  } 

  .id_project{
    background-color: #e5e5e5 !important;
    color: #000;
    line-height: 1.5;
    border: #758287 1px solid;
    border-bottom: 0px;
    padding-left: 5px !important;
    padding-top: 5px !important
  }

  .sorting_1{
    padding: 0px !important;
  }

  .breadcrumb{
    margin-bottom: 2px;
  }

  table.dataTable td, table.dataTable th{
    border : 0.5px solid #758287;
  }

  .select2-container .select2-selection{
    background-color: #dfdfdf !important;
  }

  .select2-selection__rendered{
    color: #300 !important;
  }
</style>

<ol class="breadcrumb col-md-12">
  <span class="judul">Projects Technical Close</span>
</li>

<div class="col-md-10 offset-md-12">  
  <div class="pull-right" style="margin-right: 20px;" >
      <a href="<?= base_url(); ?>projects/download_list_active_projects" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 20px;" class="float-left"> DOWNLOAD</span>
      </a>
  </div> 
</div>
</ol>

<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="type" name="type" class="form-control form-control-sm Jselect2 Jselect2Active">
    <option value="">All Type</option>
    <?php foreach ($list_type as $key => $value) : ?>
        <option value="<?= $value['VALUE'] ?>"><?= $value['VALUE'] ?></option>
    <?php endforeach; ?>
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
                <tr style="background: #595959;color: #f7f7f7;">
                  <th style="vertical-align: top;max-width: 5% !important;">ID</th>
                  <th style="vertical-align: top;max-width: 45% !important;">PROJECT NAME</th>
                  <th style="vertical-align: top;max-width: 15% !important;">VALUE (IDR)</th>
                  <th style="vertical-align: top;max-width: 15% !important;">PROGRESS</th>
                  <th style="vertical-align: top;max-width: 15% !important;">PERIOD</th>
                  <th style="vertical-align: top;max-width: 5% !important;text-align: center;">&nbsp;</th>
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
                                               .text('FIND')
                                               .addClass('btn btn-md btn-primary mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('CLEAR')
                                               .addClass('btn btn-md btn-primary mb-2')
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
                        'url'  :base_url+'project/get_list_project_technical_close', 
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
                          { 
                            'mRender': function(data, type, obj){   
                                    var a = "";
                                    var b = "";
                                    if(obj .ID_LOP_EPIC == null){
                                        a = "<div class='id_project' style='font-size:12px;'>"+obj.ID_PROJECT+"</div>";                     
                                    }else{
                                        a = "<div class='id_project' style='font-size:12px;'>"+obj.ID_PROJECT+"</div>"+"<div class='id_project' style='font-size:12px;'>"+obj.ID_LOP_EPIC+"</div>";
                                    }   
                                    return a+b;
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){
                                    var w = "";
                                    if((obj.STATUS=='DELAY'||obj.STATUS=='LAG')){
                                      if(obj.REASON_OF_DELAY == ""||obj.REASON_OF_DELAY == null){
                                        w = "&nbsp;&nbsp;&nbsp;<br><span  class='fa fa-exclamation-circle text-danger' data-toggle='tooltip' data-placement='right' data-original-title='Please fill reason of delay (Symptom)' aria-describedby='tooltip549771'></span>";
                                      }else{
                                        w = "<span class='text-primary'><br>SYMPTOM <span class='text-danger'>"+obj.REASON_OF_DELAY+"</span></span>";
                                      }
                                      
                                    }   
                                    return "<span style='font-size:12px !important;font-family:sans-serif;font-weight:800;'>"+obj.NAME+"</span>"+"<div class='text-primary' style='font-size:10px;' >[SEGMEN <span class='text-info' >"+obj.SEGMEN+"</span>], "
                                      +"[PM <span class='text-info' >"+obj.PM_NAME+"</span>]"+w+"</div>";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<div class='clearfix'>"
                                            +"<div class='float-left'>"
                                            +"<strong>"+obj.WEIGHT+"%</strong>"
                                            +"</div>"
                                            +"<div class='float-right'>"
                                            +"<small class='text-muted'>PLAN</small>"
                                            +"</div>"
                                            +"</div>"
                                            +"<div class='progress progress-xs'>"
                                            +"<div class='progress-bar bg-info' role='progressbar' "
                                            +"style='width: "+obj.WEIGHT+"' aria-valuenow='"+obj.WEIGHT+"' aria-valuemin='0' "
                                            +"aria-valuemax='100'></div>"
                                            +"</div>"
                                            +"<div class='clearfix'>"
                                            +"<div class='float-left'>"
                                            +"<strong>"+obj.ACH+"%</strong>"
                                            +"</div>"
                                            +"<div class='float-right'>"
                                            +"<small class='text-muted'>ACHIEVEMENT</small>"
                                            +"</div>"
                                            +"</div>"
                                            +"<div class='progress progress-xs'>"
                                            +"<div class='progress-bar bg-success' role='progressbar' "
                                            +"style='width: "+obj.ACH+"%' aria-valuenow='"+obj.ACH+"' aria-valuemin='0' "
                                            +"aria-valuemax='100'></div>"
                                            +"</div>"
                                            ; 
                            }            
                                    
                        },   
                        { 
                            'mRender': function(data, type, obj){   
                                   return "<strong style='font-size:12px !important;'>START = "+obj.START_DATE2 + '<br>END &nbsp;&nbsp;&nbsp;&nbsp;= '+obj.END_DATE2 +'</strong>'; 
                                    // return "<span style='font-size:12px !important;'>"+obj.START_DATE2+"<br>"+obj.END_DATE2+"</span>";   
                            }            
                                    
                        },
                        <?php if($this->auth->get_access_value('PROJECT')>2) : ?>
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<a target='_blank' style='font-size:10px;width:100%;margin-right:1px;margin-bottom:0.5px;padding-top:0px;padding-bottom:0px' class='nav-link-hgn btn btn-xs btn-primary' href='"+base_url+"project/view/"+obj.ID_PROJECT+"' >VIEW</a><br>"+
                                            "<a style='font-size:10px;padding-top:0px;padding-bottom:0px;width:100%;margin-right:1px;margin-top:0.5px;' class='btn btn-xs nav-link-hgn btn-primary' href='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' >EDIT</a>";       
                                    return a;
                            }

                        }, 
                        <?php else : ?>
                          {
                            'mRender': function(data, type, obj){
                                    var a = "<a target='_blank' style='font-size:10px;width:100%;margin-right:1px;padding-top:0px;padding-bottom:0px;margin-bottom:0.5px;' class=\' nav-link-hgn btn btn-xs btn-primary \' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"' >VIEW</a>"+
                                            "<a style='font-size:10px;width:100%;margin-right:1px;margin-top:0.5px;padding-top:0px;padding-bottom:0px;' class=\'btn btn-xs nav-link-hgn btn-disabled href='#'>EDIT</a>";       
                                    return a;
                            }

                        },
                        <?php endif; ?>


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