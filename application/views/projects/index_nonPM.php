<style type="text/css">
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

<ol class="breadcrumb">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/nonPM"> <span class="judul">Projects Non PM</span> </li>
<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/download_projects_non_pm" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span style="padding-right: 0px;" class="float-left"> &nbsp; DOWNLOAD</span>
      </a>
  </div>
</div>
<?php  endif; ?>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="type" name="type" class="form-control form-control-sm Jselect2 Jselect2NonPM">
    <option value="">All Type</option>
    <option value="APPLICATION">Application</option>
    <option value="CONNECTIVITY">Connectivity</option>
    <option value="SMART BUILDING">Smart Building</option>
    <option value="CPE & OTHERS">CPE & Others</option>
    </select> 
  </div>
 
  <div class="float-right col-sm-2">
    <select id="pm" name="pm" class="form-control form-control-sm Jselect2 Jselect2NonPM">
    <option value="">All Project Manager</option>
    <?php foreach ($list_pm as $key => $value) : ?>
          <option value="<?= $list_pm[$key]['NIK']; ?>"><?= $list_pm[$key]['NAMA']; ?></option>
    <?php endforeach; ?>
    </select> 
  </div>

  <div class="float-right col-sm-2 hidden">
    <select id="partner" name="partner" class="form-control form-control-sm Jselect2 Jselect2NonPM">
    <option value="">All Partners</option>
    <?php foreach ($list_mitra as $key => $value) : ?>
          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="customer" name="customer" class="form-control form-control-sm Jselect2 Jselect2NonPM">
    <option value="">All Customers</option>
    <?php foreach ($list_cc as $key => $value) : ?>
          <option value="<?= $list_cc[$key]['NIP_NAS']; ?>"><?= $list_cc[$key]['STANDARD_NAME']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
   
  <div class="float-right col-sm-2">
    <select id="status" name="status" class="form-control form-control-sm Jselect2 Jselect2NonPM">
    <option value="">All Status</option>
    <option value="LEAD">LEAD</option>
    <option value="LAG">LAG</option>
    <option value="DELAY">DELAY</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="segmen" name="segmen" class="form-control form-control-sm Jselect2 Jselect2NonPM" style="width: 100%;">
        <option value="">All Segmen</option>
        <?php foreach ($list_segmen as $key => $value) : ?>
              <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
        <?php endforeach; ?>
      </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="regional" name="regional" class="form-control form-control-sm Jselect2 Jselect2NonPM">
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
          <table id="datakuProjectNonPM" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="max-width: 5% !important;" >ID</th>
                  <th style="max-width: 35% !important;">PROJECT NAME</th>
                  <th style="max-width: 15% !important;">ACCOUNT MANAGER</th>
                  <th style="max-width: 15% !important;">SPK CUSTOMER</th>
                  <th style="max-width: 10% !important;">VALUE(IDR)</th>
                  <th style="max-width: 5% !important;"></th>
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
        var table = $('#datakuProjectNonPM').DataTable({
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
                        'url'  :base_url+'projects/get_list_project_nonPM', 
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
                                    return "<span style='font-size:12px !important;font-family:sans-serif;font-weight:800;'>"+obj.NAME+"</span>";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){  
                                    return "<div class='text-primary' style='font-size:12px;' >[SEGMEN <span class='text-info' >"+obj.SEGMEN+"</span>], "
                                      +"[AM <span class='text-info' >"+obj.AM_NAME+"</span>]</div>";   
                            }            
                                    
                        },    
                        { mData: 'NO_SPK_CC'},    
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
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
                                    var a = "<a target='_blank' style='font-size:10px;width:100%;margin-right:1px;padding-top:0px;padding-bottom:0px;margin-bottom:0.5px;' class=\' nav-link-hgn btn btn-xs btn-primary \' href='"+base_url+"project/view/"+obj.ID_PROJECT+"' >VIEW</a>"+
                                            "<a style='font-size:10px;width:100%;margin-right:1px;margin-top:0.5px;padding-top:0px;padding-bottom:0px;' class=\'btn btn-xs nav-link-hgn btn-disabled href='#'>EDIT</a>";       
                                    return a;
                            }

                        },
                        <?php endif; ?>
                       ],      
                });  
    };    
      return {
          init: function() { 
            tableInit();
            $(document).on('change','.Jselect2NonPM', function (e) {
              e.stopImmediatePropagation();
              $('#datakuProjectNonPM').dataTable().fnDestroy();

              tableInit();
              }); 


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>