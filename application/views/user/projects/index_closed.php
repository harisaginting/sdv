<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/closed"> Projects Closed</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/download_list_closed_projects" class="btn btn-primary btn-addon"><i class="fa fa-download"></i><span class="badge badge-warning">DEV</span>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>

<div class="col-md-12">
<div class="card border-primary">
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
   
  <div class="float-right col-sm-2 hidden" >
    <select id="status" name="status" class="form-control form-control-sm Jselect2">
    <option value="">All Status</option>
    <option value="LEAD">LEAD</option>
    <option value="LAG">LAG</option>
    <option value="DELAY">DELAY</option>
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


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuProjectClosed" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Project Name</th>
                  <th>Segmen</th>
                  <th>AM</th>
                  <th>PM</th>
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
                        'url'  :base_url+'projects/get_list_project_closed', 
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
                        { mData: 'NAME'}, 
                        { mData: 'SEGMEN'}, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return '('+obj.AM_NIK +') '+ obj.AM_NAME;   
                            }            
                                    
                        }, 
                       { 
                            'mRender': function(data, type, obj){   
                                    if(obj.PM_NIK!=null){
                                      return '('+obj.PM_NIK +') '+ obj.PM_NAME;  
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
                                    return obj.CLOSED_DATE+'<br>by ('+obj.CLOSED_BY_ID+') '+obj.CLOSED_BY_NAME;   
                            }            
                                    
                        },
                        {
                            'mRender': function(data, type, obj){
                                 var a = "<a style='font-size:10px;margin-right:1px;' class=\' circle nav-link-hgn btn  btn-success \' href='"+base_url+"projects/view_closed/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></a>";       
                                    return a;
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


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>