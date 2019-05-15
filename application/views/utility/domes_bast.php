<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>utility/edit_bast">BAST DOMES</li>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
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
        <option value=""></option> 
        <option value="3">Waiting..</option>
        <option value="X">Not sent yet</option>
        <option value="2">Rejected</option>
        <option value="1">Approved</option>
    </select>
  </div>


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuBast" class="table table-responsive-sm table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="min-width: 12% !important">No. SPK</th>
                  <th style="min-width: 12% !important">No. BAST</th>
                  <th style="min-width: 20% !important">Partner</th>
                  <th style="min-width: 20% !important">Customer</th>
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
                        'url'  :base_url+'utility/get_datatables_bast_domes', 
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
                                { mData: 'NO_SPK'},
                                { mData: 'NO_BAST'},
                                { mData: 'NAMACC'},
                                { mData: 'NAMACC'},
                                { mData: 'TGL_BAST'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.NILAI_RP_BAST+"</span> ";   
                                    }            
                                            
                                }, 
                                {
                                    'mRender': function(data, type, obj){

                                            var result = "";
                                            var success = obj.DOMES;
                                            console.log(success);
                                            if(success == '3'){
                                                    result = "<span class='label bg-success text-white'> Waiting</span>";    
                                            }else if(success == '0'){
                                                    result = "<span class='label' style='background:#b7b7b7;'> Not sent yent</span>";
                                            }else if(success == '1'){
                                                    result = "<span class='label bg-info text-white'> Approved</span>"; 
                                            }else if(success == '2'){
                                                    result = "<span class='label bg-danger'> Rejected</span>";
                                            }else{
                                                    result = "#";
                                            }


                                            return result;
                                    }

                                },
                                {
                                    'mRender': function(data, type, obj){

                                            var a = "<a style='font-size:10px;' class=\'btn  btn-xs btn-success circle nav-link-hgn \' href='"+base_url+"utility/domes_bast_view/"+obj.ID_BAST+"' ><i class='glyphicon glyphicon-new-window'></i></a>"


                                            return a;
                                    }

                                }
                               
                               ],           
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