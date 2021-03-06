
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

/*Page styles*/

.boxes {
  margin: auto;
  margin-top: 35px;
}

/*Checkboxes styles*/
input[type="checkbox"] { display: none; }

input[type="checkbox"] + label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 10px;
  font: 14px/20px;
  color: #000;
  cursor: pointer; 
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

input[type="checkbox"] + label:last-child { margin-bottom: 0; }

input[type="checkbox"] + label:before {
  content: ''; 
  display: block;
  width: 20px;
  height: 20px;
  border: 1px solid #6cc0e5;
  position: absolute;
  left: 0;
  top: 0;
  opacity: .6;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

input[type="checkbox"]:checked + label:before {
  width: 10px;
  top: -5px;
  left: 5px;
  border-radius: 0;
  opacity: 1;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>

<ol class="breadcrumb">
<li style="width: 100%;">
  <span class="pull-left"> 
    <span class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects">Projects</span>
    <strong class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>projects/edit/<?= $id_project;?>">Edit Project <?= $id_project;?> </strong>
  </span>
  <!-- <button id="btnDocument" type="button" class="pull-right btn btn-outline-success"> 
    <i class="fa fa-file"></i>
    Document
  </button>
  <a target="_blank" href="<?= base_url(); ?>report/project_detail/<?= $id_project; ?>" id="btnReport" class="pull-right btn btn-outline-danger" style="margin-right: 10px;"> 
    <i class="fa fa-file-pdf"></i>
    Report PDF
  </a> -->
</li>   
</ol>


<div class="container-fluid container-content">
 
<div class="col-sm-12">
  <div class="card">
  <div class="card-header">
  <strong>Edit Project</strong>
  <small><?= $id_project; ?></small>
  <small class="pull-right">Request by <b><?= '['.$data['REQUEST_BY_ID'].' - '.$data['REQUEST_BY_NAME'].']'; ?></b></small>
  </div>
  <div class="card-body">
   <form method="POST" enctype="multipart/form-data" id="frmAdd">
    <div class="row">
        <div class="col-sm-6 merah">
            <div class="form-group">
              <label>Status Project *</label>
              <input type="text" class="form-control" id="status_project" name="status_project" value="<?= $data['STATUS']; ?>" readOnly>
            </div>

            <div class="form-group">
              <label>ID Project *</label>
              <input type="text" class="form-control" id="id_project" name="id_project" value="<?= $id_project; ?>" readOnly>
            </div>

            <div class="form-group">
              <label>ID LOP </label>
              <input type="text" class="form-control" id="ID_LOP" name="id_lop" value="<?= !empty($data['ID_LOP_EPIC']) ? $data['ID_LOP_EPIC'] : ''; ?>" readOnly>
            </div>

            <div class="form-group">
              <label for="name">Project Name *</label>
              <textarea class="form-control" id="name" name="name" rows="5" ><?= $data['NAME']; ?></textarea>
            </div>

            <div class="form-group">
              <label for="name">Segmen *</label>
              <select id="segmen" name="segmen" class="form-control form-control-sm" style="width: 100%;">
                <option></option>
                <?php foreach ($list_segmen as $key => $value) : ?>
                      <option value="<?= $list_segmen[$key]['SEGMEN']; ?>" <?= $list_segmen[$key]['SEGMEN']==$data['SEGMEN']? 'selected' : '' ?> >
                        <?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?>
                        </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group" >
              <label for="name">Customer *</label>
                 <input id="customer_name" name="customer_name"  type="hidden" value="<?= $data['STANDARD_NAME']; ?>">
                <select id="customer" name="customer" class="form-control form-control-sm Jselect2" style="width: 100%;">
                  <option value="<?= $data['NIP_NAS']; ?>" selected><?= $data['STANDARD_NAME']; ?></option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Account Manager *</label>
              <input id="am_name" name="am_name"  type="hidden" value="<?= !empty($data['AM_NAME']) ? $data['AM_NAME'] : ''; ?>">
              <select id="am" name="am" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                <option value="<?= !empty($data['AM_NIK']) ? $data['AM_NIK'] : ''; ?>">
                  <?php
                  if(!empty($data['AM_NAME']))
                  {
                    echo  $data['AM_NAME'];
                  }else{
                    if(!empty($data['AM_NIK'])){
                      echo $data['AM_NIK'];
                    } 
                  }   
                  ?>
                </option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Value *</label>
              <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" value="<?= !empty($data['VALUE'])? $data['VALUE'] : '' ?>" required>
              <input id="value_real" name="value_real"  type="hidden" value="<?= !empty($data['VALUE'])? $data['VALUE'] : '' ?>">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
              <label for="name">Start Date *</label>
              <input type="text" class="form-control date-picker" id="start_date" name="start_date" placeholder="Date Project Start" 
              value="<?= !empty($data['START_DATE'])? $data['START_DATE2'] : '' ?>" required readOnly>
            </div>

            <div class="form-group">
              <label for="name">End Date *</label>
              <input type="text" class="form-control date-picker" id="end_date" name="end_date" placeholder="Date Project End" 
              value="<?= !empty($data['END_DATE'])? $data['END_DATE2'] : '' ?>" required readOnly>
            </div>

            <div class="form-group">
              <label for="name">Description</label>
              <textarea id="description" name="description" rows="5" class="form-control" placeholder="Project description"><?= !empty($data['DESCRIPTION'])? $data['DESCRIPTION'] : '' ?></textarea>
            </div>

            <div class="form-group">
              <label for="name">Regional *</label>
              <select id="regional" name="regional" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                    <option></option>
                    <option 
                    value="1" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='1')  ? 'selected' : ''; ?>>Regional 1
                    </option>
                    <option 
                    value="2" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='2')  ? 'selected' : ''; ?>>Regional 2
                    </option>
                    <option 
                    value="3" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='3')  ? 'selected' : ''; ?>>Regional 3
                    </option>
                    <option 
                    value="4" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='4')  ? 'selected' : ''; ?>>Regional 4
                    </option>
                    <option 
                    value="5" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='5')  ? 'selected' : ''; ?>>Regional 5
                    </option>
                    <option 
                    value="6" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='6')  ? 'selected' : ''; ?>>Regional 6
                    </option>
                    <option 
                    value="7" <?= !empty($data['REGIONAL'])&&($data['REGIONAL']=='7')  ? 'selected' : ''; ?>>Regional 7
                    </option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">TYPE *</label>
              <select id="type" name="type" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                    <option></option>
                    <option value="APPLICATION"
                    <?= !empty($data['TYPE'])&&($data['TYPE']=='APPLICATION')  ? 'selected' : ''; ?>>Appplication</option>
                    <option value="CONNECTIVITY"
                    <?= !empty($data['TYPE'])&&($data['TYPE']=='CONNECTIVITY')  ? 'selected' : ''; ?>>Connectivity</option>
                    <option value="CPE & OTHERS"
                    <?= !empty($data['TYPE'])&&($data['TYPE']=='CPE & OTHERS')  ? 'selected' : ''; ?>>CPE & OTHERS</option>
                    <option value="SMART BUILDING"
                    <?= !empty($data['TYPE'])&&($data['TYPE']=='SMART BUILDING')  ? 'selected' : ''; ?>>Smart Building</option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">CATEGORY *</label>
              <select id="category" name="category" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                    <option></option>
                    <option value="SMALL"
                    <?= !empty($data['CATEGORY'])&&($data['CATEGORY']=='SMALL')  ? 'selected' : ''; ?>>Small</option>
                    <option value="MEDIUM"
                    <?= !empty($data['CATEGORY'])&&($data['CATEGORY']=='MEDIUM')  ? 'selected' : ''; ?>>Medium</option>
                    <option value="BIG"
                    <?= !empty($data['CATEGORY'])&&($data['CATEGORY']=='BIG')  ? 'selected' : ''; ?>>Big</option>
                    <option value="STRATEGIS"
                    <?= !empty($data['CATEGORY'])&&($data['CATEGORY']=='STRATEGIS')  ? 'selected' : ''; ?>>Strategis</option>
              </select>
            </div>

            <div class="form-group">
              <label for="name">Project Manager *</label>
              <input id="pm_name" name="pm_name"  type="hidden" value="<?= !empty($data['PM_NAME']) ? $data['PM_NAME'] : '' ?>">
              <select id="pm" name="pm" class="form-control form-control-sm Jselect2"  style="width: 100%;">
                <option></option>
                <?php foreach ($list_pm as $key => $value) : ?>
                      <option value="<?= $list_pm[$key]['NIK']; ?>" data-name="<?= $list_pm[$key]['NAMA']; ?>"  <?= !empty($data['PM_NIK'])&&($list_pm[$key]['NIK']==$data['PM_NIK']) ? 'selected' :''; ?> ><?= $list_pm[$key]['NAMA']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="boxes">
                    <input type="checkbox" id="manage_service" name="manage_service"  data-val="manage_service">
                    <label for="manage_service">Manage Service</label>
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
                      <label class=" control-label">Document SPK Customer *</label>
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
        <div class="col-sm-2 offset-sm-4">
            <button id="saveEditProject" type="button" style="width: 100%;" class="btn btn-info btn-addon"><i class="fa fa-floppy-o"></i>
             &nbsp; Save
            </button>        
        </div>
        <div class="col-sm-2">
            <button id="btnClosedProject" type="button" style="width: 100%;" class="btn btn-warning btn-addon"><i class="fa fa-check"></i>
             &nbsp; Close Project
            </button>        
        </div>
    </div>
  </form>
  </div>
  </div>
</div>

</div>


<!-- deliverables modals -->
<div class="modal fade"  role="dialog" aria-labelledby="modalCloseDocument" aria-hidden="true" id="modalCloseDocument">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
        <div class="modal-header">
      <h4 class="modal-title" id="modal-title-deliverable">Documents Project Closed</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body relative">
                  <div class="modalLoading" style="display:none;">
            <div class="progress">
              <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width: 100%">
              </div>
            </div>
                  </div>
                    <form method="POST" enctype="multipart/form-data" id="frmProjectClosed">
                         <div class="row">
                          <div class="col-sm-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Close date*</label>
                                  <input type="text" class="form-control date-picker" id="closed_date" name="closed_date" placeholder="MM/DD/YYYY" value="<?= date("m/d/Y") ?>" require readOnly>
                                </div>    

                                <div class="form-group">
                                  <label for="name">Lesson Learned</label>
                                  <textarea id="lesson_learned" name="lesson_learned" rows="3" class="form-control" placeholder="Lesson Learned From Project"></textarea>
                                </div>

                                <div class="form-group">
                                   <label>Document Evidence*</label> 
                                   <input type="file" class="form-control" name="documentProjectClose" id="documentProjectClose" accept="pdf">
                                </div>
                            

                            </div>
                            
                            <div class="offset-md-4 col-md-4">
                              
                            </div>  
                            <div class="offset-md-5 col-md-2">
                              <button type="button" 
                              style="width: 100%;" 
                              class="btn btn-warning" 
                              id="btnDocumentClosedSubmit">
                                Save
                              </button>
                            </div>  
                          </div>
                         </div>
                         

                    </form>
                </div>
    </div>
  </div>
</div>



<!-- Partners modals -->
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
                              <select id="m-partner" name="m-partner" class="form-control form-control-sm Jselect2">
                                    <option></option>
                                    <?php foreach ($list_mitra as $key => $value) : ?>
                                          <option value="<?= $list_mitra[$key]['KODE_PARTNER'];?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
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
                              <select id="m-payment" name="m-payment" class="form-control form-control-sm Jselect2">
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
  var id_project = "<?= $id_project; ?>";
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
                  $('#m-spk').val()+"<input name='spk[]' type='hidden' value='"+$('#m-spk').val()+"' />",
                  $('#m-vspk').unmask()+"<input name='v_spk[]' type='hidden' value='"+$('#m-vspk').unmask()+"'/>",
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

      $('#dataPartners tbody').on( 'click', '.btn-delete-row', function () {
                    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      } );


      <?php if(!empty($partners)) : foreach($partners as $key => $value): ?>
          table.row.add( [
                      "<?= $partners[$key]['PARTNER_NAME']; ?><input name=id_partner[] type='hidden' value='<?= $partners[$key]['ID_PARTNER']; ?>'/><input name=partner[] type='hidden' value='<?= $partners[$key]['PARTNER_NAME']; ?>'/><input name=id_row[] type='hidden' value='<?= $partners[$key]['ID_ROW']; ?>'/>",
                      "<?= $partners[$key]['NO_P8']; ?><input name='spk[]' type='hidden' value='<?= $partners[$key]['NO_P8']; ?>'/>",
                      "<span class='rupiah'><?= $partners[$key]['NILAI_KONTRAK']; ?></span> <input name='v_spk[]' type='hidden' value='<?= $partners[$key]['NILAI_KONTRAK']; ?>'/>",
                      "<?= $partners[$key]['SKEMA_PEMBAYARAN']; ?><input name='payment[]' type='hidden' value='<?= $partners[$key]['SKEMA_PEMBAYARAN']; ?>'>",
                      "<?= preg_replace( "/\r|\n/", "", $partners[$key]['CATATAN_SKEMA_PEMBAYARAN']); ?><input name='spk_note[]' type='hidden' id='catatan_skema_pembayaran"+counter+"' />",
                      <?php if(!empty($partners[$key]['LINK_P8'])): ?>
                         "<span><a href='<?= $partners[$key]['LINK_P8']; ?>' target='_blank'>Link SPK</a><span>"+
                         "<input name='document_spk[]' type='file' class='form-group' id='document_spk"+counter+"' data-show-preview='false' />",
                      <?php else : ?>
                          "<input name='document_spk[]' type='file' class='form-group' id='document_spk"+counter+"' data-show-preview='false' />",
                      <?php endif;?>
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

            $('#catatan_skema_pembayaran'+counter).val("<?= preg_replace( "/\r|\n/", "", $partners[$key]['CATATAN_SKEMA_PEMBAYARAN']); ?>");
            counter++;

        <?php endforeach; endif;?>


      return {
          init: function() { 
              $('.rupiah').priceFormat({
                  prefix: 'Rp. ',
                  centsSeparator: ',',
                  thousandsSeparator: '.',
                  centsLimit: 0 
              });

              $(document).on('click','#btnClosedProject', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                $('#modalCloseDocument').modal('show'); 
              });

              $(document).on('click','#saveEditProject', function (e) {
                e.stopImmediatePropagation();
                e.preventDefault();
                $('.rupiah').unmask();
                $('#value_real').val($('#value').unmask());
                var form = $('form')[0];
                var formData = new FormData(form);
                //$('#pre-load-background').fadeIn();
                var pm_name = encodeURI($('#pm_name').val());
                bootbox.confirm({
                    message: "<b>Save Change ?</b>?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){
                          if($('#frmAdd').valid()){
                            $('#pre-load-background').fadeIn();
                            $('.rupiah').unmask();
                            $('#value_real').val($('#value').unmask());
                            var form = $('form')[0];
                            var formData = new FormData(form);
                            $.ajax({
                                          url: base_url+'projects/save_editProject',
                                          type:'POST',
                                          data:  formData ,
                                          async : true,
                                          contentType:false,
                                          processData:false,
                                          dataType : "json",
                                          success:function(result){
                                          $('#pre-load-background').fadeOut();
                                           if(result.data=='success'){
                                            bootbox.alert("Success!", function(){ 
                                            window.location.href = base_url+'projects/edit/<?= $id_project; ?>' ; 
                                            });
                                          }else{
                                            bootbox.alert("Failed!", function(){});
                                            }
                                          return result;
                                          }

                                  });
                          }
                        }
                    }
                });  
              });

              $(document).on('click','#btn-add-partner',function(e){
                  e.stopImmediatePropagation();
                      $('#btn-add-partner-modal').modal('show');     
                  });

              $(document).on('click','#btnAddPartner',function(e){
                      addRowPartner();      
                      $('#btn-add-partner-modal').modal('hide');        
                  });
              $('#m-partner').select2({
                    placeholder: "Select Partner"
                });

              $('#pm').select2({
                    placeholder: "Select Regional"
                });

              $('#regional').select2({
                    placeholder: "Select Regional"
                });

              $('#customer').select2({
                    placeholder: "Select Customer"
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
                    e.stopImmediatePropagation();
                    var am_name = $("#am").select2('data')[0];
                    $('#am_name').val(am_name.name);
              });

              $('body').on('change','#pm',function(e){
                    e.stopImmediatePropagation();
                    var pm_name = $("#pm").select2('data')[0];
                    $('#pm_name').val(pm_name.text.trim());

              });

              <?php if(!empty($data['DOC_RFP'])) : ?>
              $("#doc_rfp").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_RFP'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_RFP'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_PROPOSAL'])) : ?>
              $("#doc_proposal").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_PROPOSAL'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_PROPOSAL'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_AANWIZING'])) : ?>
              $("#doc_aanwizing").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_AANWIZING'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_AANWIZING'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_SPK'])) : ?>
              $("#doc_spk").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_SPK'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_SPK'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_BAKN_PB'])) : ?>
              $("#doc_bakn").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_BAKN_PB'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_BAKN_PB'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_KB'])) : ?>
              $("#doc_kb").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_KB'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_KB'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($data['DOC_KL'])) : ?>
              $("#doc_kl").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $data['DOC_KL'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $data['DOC_KL'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              $('#documentProjectClose').fileinput({
                      maxFileCount: 1,    
                      autoReplace: true,               
                      dropZoneEnabled: false,
                      mainClass: "input-group",
                      showUpload:false,
                      showRemove:false,
                      initialPreview  : false,
                      uploadAsync     : false,
                      autoReplace: true,
                      maxFileCount: 1,
              });

              $(document).on('click','#btnDocumentClosedSubmit', function (e) {
                e.stopImmediatePropagation();
                if($('#frmProjectClosed').valid()){
                    $('#pre-load-background').fadeIn();
                    var form = $('#frmProjectClosed')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'projects/saveCloseProject/<?= $id_project; ?>',
                                  type:'POST',
                                  dataType : "json",
                                  data:  formData ,
                                  async : true, 
                                  processData: false,
                                  contentType: false,
                                  processData:false
                            }).done(function(result) {
                            $('#pre-load-background').fadeOut();
                                        if(result.data.trim()=='success'){
                                          bootbox.alert("Success!", function(){ 
                                            var url = base_url+"projects/view_closed/<?= $id_project; ?>";
                                            window.location.href = url;
                                        });
                                        }else{
                                          console.log(result);
                                        }
                    });;
                }

              });

              $('.file').fileinput({
                uploadAsync: true,
                initialPreviewShowDelete : false,                   
                showRemove:false,
                showUpload:false,   
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>