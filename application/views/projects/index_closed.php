<style type="text/css">
  table.dataTable td, table.dataTable th{
    border : 1px solid #758287;
  }

  .select2-container .select2-selection{
    background-color: #dfdfdf !important;
  }

  .select2-selection__rendered{
    color: #300 !important;
  }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/closed"> 
  <span class="title">
    Projects Closed
  </span>
</li>
<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/download_list_closed_projects" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 0px;" class="float-left"> DOWNLOAD</span>
      </a>
  </div>
</div>
<?php  endif; ?>
</ol>




<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="type" name="type" class="form-control form-control-sm Jselect2">
    <option value="">All Type</option> 
    <option value="APPLICATION">Application</option>
    <option value="CONNECTIVITY">Connectivity</option> 
    <option value="SMART BUILDING">Smart Building</option> 
    <option value="CPE & OTHERS">CPE & Others</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="pm" name="pm" class="form-control form-control-sm Jselect2">
    <option value="">All Project Manager</option>
    <option value="x">Not Escorde by PM</option>
    <?php foreach ($list_pm as $key => $value) : ?>
          <option value="<?= $list_pm[$key]['NIK']; ?>"><?= $list_pm[$key]['NAMA']; ?></option>
    <?php endforeach; ?>
    </select> 
  </div>

  <div class="float-right col-sm-2 hidden">
    <select id="partner" name="partner" class="form-control form-control-sm Jselect2">
    <option value="">All Partners</option>
    <?php foreach ($list_mitra as $key => $value) : ?>
          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="customer" name="customer" class="form-control form-control-sm Jselect2">
    <option value="">All Customers</option>
    <?php foreach ($list_cc as $key => $value) : ?>
          <option value="<?= $list_cc[$key]['NIP_NAS']; ?>"><?= $list_cc[$key]['STANDARD_NAME']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
   

  <div class="float-right col-sm-2">
    <select id="segmen" name="segmen" class="form-control form-control-sm Jselect2" style="width: 100%;">
        <option value="">All Segmen</option>
        <?php foreach ($list_segmen as $key => $value) : ?>
              <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
        <?php endforeach; ?>
      </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="regional" name="regional" class="form-control form-control-sm Jselect2">
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

  <div class="float-right col-sm-2" >
    <select id="escorded" name="escorded" class="form-control form-control-sm Jselect2">
    <option value="">Manage Service?</option>
    <option value="1">Manage Service</option>
    <option value="x">Not Manage Service</option>
    </select>
  </div>


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuProjectClosed" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>PROJECT NAME</th>
                  <th>SEGMEN</th>
                  <th>PROJECT MANAGER</th>
                  <th>TYPE</th>
                  <th>VALUE</th>
                  <th>CLOSED</th>
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
                                               .addClass('btn btn-md btn-con mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn-md btn-con mb-2')
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
                        'url'  :base_url+'projects/get_list_project_closed', 
                        'type' :'POST',
                        'data' : {
                                  status  : $('#status').val(),
                                  pm      : $('#pm').val(),
                                  customer: $('#customer').val(),
                                  regional: $('#regional').val(),
                                  type    : $('#type').val(),
                                  mitra   : $('#mitra').val(),
                                  segmen  : $('#segmen').val(),
                                  escorded: $('#escorded').val(),
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
                                    return "<span style='font-size:12px !important;font-family:sans-serif;font-weight:800;'>"+obj.NAME+"</span>";   
                            }            
                                    
                        }, 
                        { mData: 'SEGMEN'}, 
                       { 
                            'mRender': function(data, type, obj){   
                                    if(obj.PM_NIK!=null){
                                      return '['+obj.PM_NIK +'] '+ obj.PM_NAME;  
                                    }else{
                                      return 'NON PM';
                                    }
                           }
                                    
                        }, 
                        {  
                            'mRender': function(data, type, obj){   
                                    return obj.TYPE;   
                            }            
                                    
                        },   
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return obj.CLOSED_DATE+'<br><br>['+obj.CLOSED_BY_ID+'] '+obj.CLOSED_BY_NAME;   
                            }            
                                    
                        },
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<a target='_blank' style='font-size:10px;width:100%;margin-right:1px;margin-bottom:0.5px;padding-top:0px;padding-bottom:0px' class='nav-link-hgn btn btn-xs btn-primary' href='"+base_url+"projects/view_closed/"+obj.ID_PROJECT+"' >VIEW</a><br>"+
                                            "<a style='font-size:10px;padding-top:0px;padding-bottom:0px;width:100%;margin-right:1px;margin-top:0.5px;' class='btn btn-xs nav-link-hgn btn-primary' href='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' >EDIT</a>";       
                                    return a;
                            }

                        }, 
                       ],      
                       fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                          var a = null;
                          if(aData['MANAGE_SERVICE']==1){
                            $(nRow).addClass('bg-primary')  
                          }
                          return nRow;
                          }    
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


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>