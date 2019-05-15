<ol class="breadcrumb">
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects"> Projects</li>
<li class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>projects/add"> <strong>Add</strong></li>
</ol>

<div class="container-fluid container-content">

<div class="col-sm-12">
  <div class="card">
  <div class="card-header">
  <strong>Add Project</strong>
  <small>Form</small>
  </div>
  <div class="card-body">
   <form method="POST" enctype="multipart/form-data" id="frmAdd">
    <div class="row">
        <div class="col-sm-6 merah">
            <div class="form-group">
              <label for="name">Project Name *</label>
              <textarea class="form-control" id="name" name="name" style="height: 90px;" placeholder="Project Name" required></textarea>
            </div>

            <div class="form-group">
              <label for="name">Segmen *</label>
              <select id="segmen" name="segmen" class="form-control form-control-sm" style="width: 100%;" required>
                <option></option>
                <?php foreach ($list_segmen as $key => $value) : ?>
                      <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Customer *</label>
                 <input id="customer_name" name="customer_name"  type="hidden">
                <select id="customer" name="customer" class="form-control form-control-sm Jselect2" style="width: 100%;" required>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Account Manager *</label>
              <input id="am_name" name="am_name"  type="hidden">
              <select id="am" name="am" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Project Manager *</label>
              <input id="pm_name" name="pm_name"  type="hidden">
              <select id="pm" name="pm" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                <option></option>
                <?php foreach ($list_pm as $key => $value) : ?>
                      <option value="<?= $list_pm[$key]['NIK']; ?>" data-name="<?= $list_pm[$key]['NAMA']; ?>"><?= $list_pm[$key]['NAMA']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Value *</label>
              <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" required>
              <input id="value_real" name="value_real"  type="hidden">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
              <label for="name">Start Date *</label>
              <input type="text" class="form-control date-picker" id="start_date" name="start_date" placeholder="Date Project Start" required>
            </div>

            <div class="form-group">
              <label for="name">End Date *</label>
              <input type="text" class="form-control date-picker" id="end_date" name="end_date" placeholder="Date Project End" required>
            </div>

            <div class="form-group">
              <label for="name">Description</label>
              <textarea id="description" name="description" rows="5" class="form-control" placeholder="Project description" required=""></textarea>
            </div>

            <div class="form-group">
              <label for="name">Regional *</label>
              <select id="regional" name="regional" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                    <?php if($user_regional == 0) : ?>
                      <option></option>
                      <option value="1">Regional 1</option>
                      <option value="2">Regional 2</option>
                      <option value="3">Regional 3</option>
                      <option value="4">Regional 4</option>
                      <option value="5">Regional 5</option>
                      <option value="6">Regional 6</option>
                      <option value="7">Regional 7</option>
                    <?php else :  ?>
                      <option></option>
                      <option value="<?= $user_regional; ?>">Regional <?= $user_regional; ?></option>
                    <?php endif; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Type *</label>
              <select id="type" name="type" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                    <option></option>
                    <option value="APPLICATION">Appplication</option>
                    <option value="CONNECTIVITY">Connectivity</option>
                    <option value="CPE & OTHERS">CPE & OTHERS</option>
                    <option value="SMART BUILDING">Smart Building</option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Category *</label>
              <select id="category" name="category" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                    <option></option>
                    <option value="SMALL">SMALL</option>
                    <option value="MEDIUM">MEDIUM</option>
                    <option value="BIG">BIG</option>
                    <option value="STRATEGIS">STRATEGIS</option>
              </select>
            </div>
        </div>

        <div class="col-sm-12" style="margin-top:20px;"> <label><b>Partners</b></label>
          <table id="dataPartners" class="table table-responsive-sm table-bordered" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 20%;">Partner</th>
                  <th style="width: 13%;">No. SPK / P8</th>
                  <th style="width: 12%;">Value SPK / P8</th>
                  <th style="width: 10%;">Payment</th>
                  <th style="width: 20;">Note</th>
                  <th style="width: 20%;">Document</th>
                  <th style="width: 5%;"><button type="button" class="btn circle btn-success" id="btn-add-partner"><i class="fa fa-plus"></i></button></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div>
        
        <div class="row container-content">
                <div class="col-md-12" style="margin-top:20px;"><label><b>Documents</b></label></div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document RFP</label>
                        <input id="doc_rfp" name="doc_rfp" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document Proposal</label>
                        <input id="doc_proposal" name="doc_proposal" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document Aanwizing</label>
                      <!-- <div id="ldoc_aanwizing" style="color:#909090;width:100%;height: 20px !important;" >No Data</div> -->
                        <input id="doc_aanwizing" name="doc_aanwizing" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document SPK Customer</label>
                        <!-- <div id="ldoc_spk" style="color:#909090;width:100%;height: 20px !important;" >No Data</div> -->
                        <input id="doc_spk" name="doc_spk" data-key="doc_spk"  type="file" accept="pdf" class="form-control file" > 
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document BAKN/P8</label>
                        <!-- <div id="ldoc_bakn" style="color:#909090;width:100%;height: 20px !important;" >No Data</div> -->
                        <input id="doc_bakn" name="doc_bakn" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document KB</label>
                        <!-- <div id="ldoc_kb" style="color:#909090;width:100%;height: 20px !important;" >No Data</div> -->
                        <input id="doc_kb" name="doc_kb" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class=" control-label">Document KL</label>
                        <!-- <div id="ldoc_kl" style="color:#909090;width:100%;height: 20px !important;" >No Data</div> -->
                        <input id="doc_kl" name="doc_kl" type="file" accept="pdf" class="form-control file" >
                    </div>
                  </div>
        </div>

    </div>

    <div class="row m-top-30">
      <div class="col-sm-12">
        <div class="col-sm-2 offset-sm-5">
            <button id="addProject" type="button" class="btn btn-success btn-addon"><i class="fa fa-plus"></i>
             &nbsp; Save
            </button>
        </div>
      </div>
    </div>
  </form>
  </div>
  </div>
</div>

</div>



<!-- deliverables modals -->
<div class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="btn-add-partner-modal">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
        <div class="modal-header">
              <h4 class="modal-title" id="modal-title-partner">Add Partner</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
        </div>
              <div class="modal-body relative">
                        <form method="POST" enctype="multipart/form-data" id="frmPartner">
                            <div class="form-group">
                              <select id="m-partner" name="m-partner" class="form-control form-control-sm Jselect2" required>
                                    <option></option>
                                    <?php foreach ($list_mitra as $key => $value) : ?>
                                          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
                                    <?php endforeach; ?>
                              </select>
                            </div>

                            <div class="form-group">
                              <input type="text" class="form-control" id="m-spk" name="m-spk" placeholder="No. SPK / P8" required>
                            </div>

                            <div class="form-group">
                              <input type="text" class="form-control rupiah" id="m-vspk" name="m-vspk" placeholder="Value SPK / P8" required>
                            </div>

                            <div class="form-group">
                              <select id="m-payment" name="m-payment" class="form-control form-control-sm Jselect2" required>
                                    <option></option>
                                    <option value="OTC">OTC</option>
                                    <option value="MONTHLY">MONTHLY</option>
                                    <option value="OTC MONTHLY">OTC MONTHLY</option>
                                    <option value="CUSTOM">CUSTOM</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="name">Note</label>
                              <textarea name="m-note" id="m-note" rows="5" class="form-control" placeholder="SPK / P8 Note"></textarea>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
                              <button type="button" id="btnAddPartner" class="btn btn-primary btnTab" data-tab="deliverables">Add Partners</button>
                          </div>
                        </form>
            </div>
    </div>
  </div>
</div>

<script type="text/javascript">    
  var Page = function () {   
      var counter = 1; 
      var table = $('#dataPartners').DataTable({
            paging: false,
            searching: false,
            info : false,
            ordering : false,
          });

      var addRowPartner = function(){
              table.row.add( [
                  $('#m-partner').select2('data')[0].text+"<input name=id_partner[] type='hidden' value='"+$('#m-partner').val()+"'/><input name=partner[] type='hidden' value='"+$('#m-partner').select2('data')[0].text+"'/>",
                  $('#m-spk').val()+"<input name='spk[]' type='hidden' value='"+$('#m-spk').val()+"'/>",
                  $('#m-vspk').val()+"<input name='v_spk[]' type='hidden' value='"+$('#m-vspk').unmask()+"'/>",
                  $('#m-payment').val()+"<input name='payment[]' type='hidden' value='"+$('#m-payment').val()+"'>",
                  $('#m-note').val()+"<input name='spk_note[]' type='hidden' value='"+$('#m-note').val()+"'>",
                  "<input name='document_spk[]' type='file' class='form-group' id='document_spk"+counter+"' data-show-preview='false' />",
                  "<button type='button' class='btn circle btn-danger btn-delete-row'><i class='fa fa-trash'></i></button>",
              ] ).draw( false );

              $('#document_spk'+counter).fileinput({
                initialPreview  : false,
                showUpload      : false,
                uploadAsync     : false,
                showUpload      : false,
                autoReplace: true,
                maxFileCount: 1,
              });

              counter++;
      }

      $('#dataPartners tbody').on( 'click', '.fa-trash', function () {
                    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      } );


      return {
          init: function() { 
              $('.rupiah').priceFormat({
                  prefix: 'Rp. ',
                  centsSeparator: ',',
                  thousandsSeparator: '.',
                  centsLimit: 0
              });
              $('.file').fileinput({
                uploadAsync: true,
                initialPreviewShowDelete : false,                   
                showRemove:false,
                showUpload:false,   
              });


              $(document).on('click','#addProject', function (e) {
                e.stopImmediatePropagation();

                if($('#frmAdd').valid()){
                    $('#pre-load-background').fadeIn();
                    $('.rupiah').unmask();
                    $('#value_real').val($('#value').unmask());
                    var form = $('form')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'projects/saveProject',
                                  type:'POST',
                                  dataType : "json",
                                  data:  formData ,
                                  async : true, //false is succes test true
                                  processData: false,
                                  contentType: false,
                                  processData:false,
                                  success:function(result){
                                    $('#pre-load-background').fadeOut();
                                       if(result.data.trim()=='success'){
                                        bootbox.alert("Success!", function(){ 
                                        window.location.href = base_url+"projects/candidate";
                                        });
                                      }else{
                                        bootbox.alert("Failed!", function(){});
                                        }
                                      return result;
                                  } 

                          });
                  }

              });

              $(document).on('click','#btn-add-partner',function(e){
                  e.stopImmediatePropagation();
                      $('#btn-add-partner-modal').modal('show');     
                  });

              $(document).on('click','#btnAddPartner',function(e){
                  if($('#frmPartner').valid()){
                      addRowPartner();      
                      $('#btn-add-partner-modal').modal('hide');  
                    }      
                  });
              $('#m-partner').select2({
                    placeholder: "Select Partner"
                });

              $('#regional').select2({
                    placeholder: "Select Regional"
                });

              $('#customer').select2({
                    placeholder: "Select Customer"
                });

              $('#pm').select2({
                    placeholder: "Select project Manager"
                });

              $('#am').select2({
                    placeholder: "Select Account Manager"
                });

              $('#m-payment').select2({
                    placeholder: "Select Payment Method"
                });

              $('#segmen').select2({
                    placeholder: "Select Segmen"
              });

              $('#type').select2({
                    placeholder: "Select Type Project"
              });

              $('#category').select2({
                    placeholder: "Select Category Project"
              });

              $(document).on('change','#segmen',function(e){
                    var segmen = $('#segmen').val();
                    $('#customer').empty();
                    $("#customer").select2({
                            placeholder: "Select Customer",
                            width: 'resolve',
                            ajax: {
                                type: 'POST',
                                delay: 200,
                                url:base_url+"json/get_json_customer?segmen="+segmen,
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
                                            return { id: obj.NIP_NAS, text: obj.STANDARD_NAME, name: obj.STANDARD_NAME};
                                        })
                                    };
                                },
                                
                            }
                    }); 

              });

              $('body').on('change','#customer',function(e){
                    var nipnas     = $('#customer').val();
                    var customer_name = $("#customer").select2('data')[0];
                    $('#customer_name').val(customer_name.name);
                    $('#am').empty();
                    $("#am").select2({
                            placeholder: "Select Account Manager",
                            width: 'resolve',
                            ajax: {
                                type: 'POST',
                                delay: 200,
                                url:base_url+"json/get_json_am?nipnas="+nipnas,
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
                                            return { id: obj.NIK, text: obj.NAME, name:obj.NAME};
                                        })
                                    };
                                },
                                
                            }
                    }); 

              });

              $('body').on('change','#am',function(e){
                    var pm_name = $("#am").select2('data')[0];
                    $('#am_name').val(pm_name.name);

              });

              $('body').on('change','#pm',function(e){
                    var pm_name = $("#pm").select2('data')[0];
                    $('#pm_name').val(pm_name.text);

              });



           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>