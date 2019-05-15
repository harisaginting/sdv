<ol class="breadcrumb">
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects/nonPM"> Projects Non PM</li>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">
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
                  <th>ID</th>
                  <th>Project Name</th>
                  <th>Segmen</th>
                  <th>NIK AM</th>
                  <th>NO SPK Customer</th>
                  <th>VALUE</th>
                  <th>Report</th>
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
                                    if(obj .ID_LOP_EPIC == null){
                                        return obj.ID_PROJECT;                     
                                    }else{
                                        return "<u>"+obj.ID_PROJECT+"</u><br>"+obj.ID_LOP_EPIC;
                                    }   
                            }            
                                    
                        },
                        { mData: 'NAME'}, 
                        { mData: 'SEGMEN'}, 
                        { mData: 'AM_NIK'},  
                        { mData: 'NO_SPK_CC'},    
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<a style='font-size:10px;width:40%;margin-right:1px;' class=\'circle nav-link-hgn btn btn-xs btn-success \' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></a>"+  
                                            "<a style='font-size:10px;width:48%;margin-right:1px;' class=\'circle btn btn-xs nav-link-hgn btn-warning \' href='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-pencil'/></i></a>";       
                                    return a;
                            }

                        }, 
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