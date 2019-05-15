<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }

    #billboard-bast > .col-md-2{
      padding-left: 5px;
      padding-right: 5px;
    }

    #billboard-bast > .col-md-1{
      padding-left: 5px;
      padding-right: 5px;
    }

    #billboard-bast{
      padding-left: 20px !important;
      padding-right: 20px !important;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> BAST</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a  href="<?= base_url(); ?>bast/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Submit BAST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
  <div style="margin-right: 20px;" class="pull-right">
      <a href="<?= base_url(); ?>bast/download_list_bast" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>



<div class="container-fluid container-content">

  <div class="row" id="billboard-bast">

    <div class="col-md-1">
      <div class="card bg-primary">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Received</div>
          <div class="h3"><?= $countReAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-2 col-sm-4">
      <div class="card bg-info">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Check By Admin</div>
          <div class="h3"><?= $countCheADMAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-2 col-sm-4">
      <div class="card bg-info">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Check By SE PMO</div>
          <div class="h3"><?= $countChePMOAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-2 col-sm-4">
      <div class="card bg-info">
        <div class="card-body text-center">
          <div class="text-muted h6font-weight-bold">Check By OSM SDV</div>
          <div class="h3"><?= $countCheCORAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-1 col-sm-4">
      <div class="card bg-danger">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Revision</div>
          <div class="h3"><?= $countCheREVAll ?></div>
        </div>
      </div>
    </div>

    <div class="col-md-1 col-sm-4">
      <div class="card bg-warning">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Approved</div>
          <div class="h3"><?= $countCheAPPAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-1 col-sm-4">
      <div class="card bg-warning">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Done</div>
          <div class="h3"><?= $countDoAll?></div>
        </div>
      </div>
    </div>

    <div class="col-md-2 col-sm-4">
      <div class="card bg-success">
        <div class="card-body text-center">
          <div class="text-muted h6 font-weight-bold">Take Out</div>
          <div class="h3"><?= $countOutAll?></div>
        </div>
      </div>
    </div>


  </div>


<div class="col-md-12">
<div class="card border-primary">
<div class="card-header">

  <div class="float-right col-sm-2 hidden">
    <select id="spk" name="spk" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;"> 
      <option value="">All SPK</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="partner" name="partner" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="">All Partner</option>
    <?php foreach ($list_mitra as $key => $value) : ?>
          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
   
  <div class="float-right col-sm-2">
    <select id="customer" name="customer" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="">All Customer</option>
    <?php foreach ($list_cc as $key => $value) : ?>
          <option value="<?= $list_cc[$key]['NIP_NAS']; ?>"><?= $list_cc[$key]['STANDARD_NAME']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
      
  <div class="float-right col-sm-2">
    <select id="segmen" name="segmen" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
        <option value="">All Segmen</option>
        <?php foreach ($list_segmen as $key => $value) : ?>
              <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
        <?php endforeach; ?>
      </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="status" name="status" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="">All Status</option>
        <option value="TAKE OUT">TAKE OUT</option>
        <option value="TAKE OUT (REV)">TAKE OUT (REV)</option>
        <option value="CHECK BY ADM">CHECK BY ADM</option>
        <option value="CHECK BY SE PMO">CHECK BY SE PMO</option>
        <option value="REVISION">REVISION</option>
        <option value="REVISIONED">REVISIONED</option>
        <option value="RECEIVED">RECEIVED</option>
        <option value="DONE">DONE</option>
        <option value="CHECK BY COORD">CHECK BY COORD</option>
        <option value="APPROVED">APPROVED</option>
    </select>
  </div>


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuBast" class="table table-responsive-sm table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="min-width: 25% !important">Project Name</th>
                  <th style="min-width: 20% !important">Partner</th>
                  <th style="min-width: 20% !important">Customer</th>
                  <th style="min-width: 7% !important">Type</th>
                  <th style="min-width: 8% !important">Date</th>
                  <th style="min-width: 10% !important">Value</th>
                  <th style="min-width: 7% !important">Status</th>
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
        $("#spk").select2({
                            width: 'resolve',
                            allowClear : true,
                            ajax: {
                                type: 'POST',
                                delay: 200,
                                url:base_url+"json/get_json_spk_bast",
                                dataType: "json",
                                data: function (params) {
                                    return {
                                        q: params.term,
                                        page: params.page,
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function(obj) {
                                            return { id: obj.NO_SPK, text: obj.NO_SPK};
                                        })
                                    };
                                },
                                
                            }
                    }); 

        var table = $('#datakuBast').DataTable({
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
                        'url'  :base_url+'bast/get_datatables', 
                        'type' :'POST',
                        'data' : {
                                  status  : $('#status').val(),
                                  customer: $('#customer').val(),
                                  mitra   : $('#partner').val(),
                                  spk     : $('#spk').val(),                              
                                  segmen  : $('#segmen').val(),
                                  }    
                        },
                    aoColumns: [
                                { mData: 'PROJECT_NAME'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.NAMA_MITRA+"</br><span class='badge badge-primary'>"+obj.NO_SPK+"</span>";   
                                    }            
                                            
                                },
                                { mData: 'NAMACC'},
                                { mData: 'TYPE_BAST'},
                                { mData: 'TGL_BAST'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.NILAI_RP_BAST+"</span> ";   
                                    }            
                                            
                                }, 
                                { mData: 'STATUS'},
                                {
                                    'mRender': function(data, type, obj){

                                            var a = "<a style='font-size:10px;'  class=\'btn  btn-xs btn-success circle nav-link-hgn \' href='"+base_url+"bast/view/"+obj.ID_BAST+"' ><i class='glyphicon glyphicon-new-window'></i></a>"


                                            return a;
                                    }

                                }
                               
                               ],           
                });  

        $(document).on('click', 'tbody tr', function() {
              var row_data = table.row(this).data();
              console.log(row_data);
              //window.location.href = base_url + "bast/view/"+row_data.ID_BAST;
            });
    };    
      return {
          init: function() { 
            tableInit();    
            $(document).on('change','.searchOnTable', function (e) {
              e.stopImmediatePropagation();
              $('#datakuBast').dataTable().fnDestroy();
              tableInit();
              });

            $(document).on('click','#select2-spk-container .select2-selection__clear',function(e){
                $('#spk').val(null).trigger('change');
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>