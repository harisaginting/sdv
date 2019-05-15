
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

/*Page styles*/

.boxes {
  margin: auto;
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
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>bast"> BAST</li>
<li class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>bast/add"> <strong>Add</strong></li>

</ol>

<div class="container-fluid container-content">

<div class="col-sm-12">
  <div class="card">
  <div class="card-header">
  <strong>Add BAST</strong>
  <small>Form</small>
  </div>
  <div class="card-body">
    <form id="formBast">
      <div class="row">
      <div class="col-sm-6">

          <!-- <div class="form-group">
            <label for="name">ID Project</label>
            <div class="input-group">
              
              <input type="text" id="id_project" name="id_project" class="form-control" placeholder="ID Project" readOnly>
                <span class="input-group-append">
                  <button type="button" class="btn btn-warning" id="btn_clear_id_project">&nbsp;&nbsp;Clear &nbsp;&nbsp;</button>
                <button type="button" class="btn btn-primary" id="btn_id_project">ID Project</button>
                </span>
            </div>
          </div> -->

          <div class="form-group"> 
            <label for="name">Bast Date *</label>
            <input type="hidden" name="commend" id="commend">
            <input type="text" class="form-control date-picker spkTrigger" id="bast_date" name="bast_date" placeholder="BAST Date" required>
          </div>


          <div class="form-group">
            <label for="name">Partner *</label>
            <input type="hidden" name="partner_id" id="partner_id">
            <input type="hidden" name="partner_name" id="partner_name">
            <select style="width: 100%;" name="partner" id="partner" class="form-control Jselect2 spkTrigger" required>
                <option disabled selected>Select Partner</option>    
                        <?php 
                foreach ($list_partner as $key => $value) {
                    ?>
                        <option value="<?=$list_partner[$key]['KODE_PARTNER'].'||'.$list_partner[$key]['NAMA_PARTNER']?>"><?=$list_partner[$key]['NAMA_PARTNER']?></option>
                    <?php
                        }
                    ?> 
            </select>
          </div>

          <div class="form-group">
            <label for="name">No. SPK *</label> <label class="text-warning" id="wSPK"></label>
            <select style="width: 100%;" name="spk" id="spk" class="form-control" disabled required>
                <option></option>
            </select>
          </div>

          <div class="form-group">
            <label for="name">SPK Date*</label>
            <input type="text" class="form-control" id="spk_date" name="spk_date" placeholder="MM/DD/YYYY" readOnly required>
          </div>

          <div class="form-group">
            <label for="name">Customer Name *</label>
            <input type="hidden" id="customer_id" name="customer_id">
            <input type="text" id="customer_name" name="customer_name" class="form-control" readonly>
            <!-- <select style="width: 100%;" name="customer" id="customer" class="form-control Jselect2 spkTrigger" required>
                <option disabled selected>Select Customer</option>
                <?php foreach ($list_customer as $cc): ?>
                    <option value="<?=$cc['NIP_NAS']?>||<?=$cc['STANDARD_NAME']?>"><?=$cc['STANDARD_NAME']?></option>
                <?php endforeach; ?>
            </select> -->
          </div>

          <div class="form-group">
            <label for="name">Segmen *</label>
            <input type="text" id="segmen" name="segmen" class="form-control" readonly>
            <!-- <select style="width: 100%;" name="segmen" id="segmen" class="form-control Jselect2">
                <option disabled selected>Select Segmen</option>      
                        <?php 
                foreach ($list_segmen as $key => $value) {
                    ?>
                        <option value="<?=$list_segmen[$key]['SEGMEN']?>"><?=$list_segmen[$key]['SEGMENT_6_LNAME']?></option>
                    <?php
                        }
                    ?>
            </select> -->
          </div>


          <div class="form-group">
            <label for="name">Project Name *</label>
            <textarea id="project_name" name="project_name" rows="3" class="form-control" placeholder="Project Name" required></textarea>
          </div>

          <div class="form-group">
            <label for="name">Project Value (Before PPN 10%)*</label>
            <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" required>
          </div>

          <div class="form-group">
            <label for="name">No. KL</label>
            <input type="text" class="form-control" id="kl" name="kl" placeholder="No. KL">
          </div>

          <div class="form-group">
            <label for="name">KL Date*</label>
            <input type="text" class="form-control date-picker" id="kl_date" name="kl_date" placeholder="MM/DD/YYYY">
          </div>
      </div>

      <div class="col-sm-6">

          <div class="form-group">
            <label for="name">BAST Value *</label>
            <input type="text" class="form-control rupiah" id="bast_value" name="bast_value" placeholder="BAST Value" required>
          </div>

          <div class="form-group">
            <label for="name">Signer *</label>
            <select style="width: 100%;" name="signer" id="signer" class="form-control Jselect2" required>
                <option value="" disabled selected>Select Signer</option>
                <option value="Coordinator Project Management">Coordinator Project Management - Sosro Hutomo Karsosoemo</option>
                <option value="Senior Expert Project Management Office 1">Senior Expert Project Management Office 1 - Ristyawan Fauzi Mubarok</option>
                <option value="Senior Expert Project Management Office 2">Senior Expert Project Management Office 2 - Heri Ikhwan Diana</option>
                <option value="Senior Expert Delivery and Integration">Senior Expert Delivery and Integration - Retno Kurniawati</option>   
            </select>
          </div>

          <div class="form-group">
              <label class="control-label ">Payment Scheme *</label>
              <select style="width: 100%;" name="type_bast" id="type_bast" class="form-control" style="width: 100%;" required>
                  <option value="" disabled selected>Select Type</option>
                  <option value="OTC">OTC</option>
                  <option value="TERMIN">TERMIN</option>
                  <option value="PROGRESS">PROGRESS</option>
                  <option value="RECURRING">RECURRING</option>
              </select>
          </div>

          <div id="progress_periode" class="form-group">
            <label class="control-label">Periode Progress</label>
              <div class="input-daterange input-group">
                <input type="text" class="form-control date-picker" name="recc_start_date" placeholder="mm/dd/yyyy">
                  <span class="input-group-addon" style="color:#000;">&nbsp;&nbsp; to &nbsp;&nbsp;</span>
                  <input type="text" class="form-control date-picker" name="recc_end_date" placeholder="mm/dd/yyyy">
                </div>
            </div>

          <div class="form-group" id="c_progress_actual">
            <label for="progress_actual">Progress (%)</label>
            <input type="number" class="form-control" id="progress_actual" name="progress_actual" placeholder="Progress">
          </div>

          <div class="form-group" id="c_termin">
            <label for="name">Termin</label>
            <input type="text" class="form-control" id="termin" name="termin" placeholder="Termin Remarks">
          </div>

           <div id="evidence" class="form-group" style="margin-bottom: 7px !important">
               <label>Evidence</label>
               <div class="row">
               <div class="col-sm-2">
                 <div class="boxes">
                    <input type="checkbox" id="cSPK" name="cSPK" data-val="SPK">
                    <label for="cSPK">SPK</label>

                    <input type="checkbox" id="cWO" name="cWO"  data-val="WO">
                    <label for="cWO">WO</label>

                    <input type="checkbox" id="cKL" name="cKL" data-val="KL">
                    <label for="cKL">KL</label>
                  </div>
               </div>

               <div class="col-sm-10">
                 <div class="boxes">

                    <input type="checkbox" id="BAcustomer" name="BAcustomer" data-val="BAcustomer">
                    <label for="BAcustomer">BA Customer / BA Format Standar</label>

                    <input type="checkbox" id="BAperformansi" name="BAperformansi" data-val="BAperformansi">
                    <label for="BAperformansi">BA Performansi (Untuk layanan berbasis SLG)</label>

                    <input type="checkbox" id="BArekonsiliasi" name="BArekonsiliasi" data-val="BArekonsiliasi">
                    <label for="BArekonsiliasi">BA Rekonsiliasi (Untuk layanan Transaksional berbasis rekon)</label>

                    <input type="checkbox" id="BAprogress" name="BAprogress" data-val="BAprogress">
                    <label for="BAprogress" >BAPP (BA Progress Pekerjaan)</label>

                    <input type="checkbox" id="BAketerlambatan" name="BAketerlambatan" data-val="BAketerlambatan">
                    <label for="BAketerlambatan" >BA Keterlambatan</label>
                  
                  </div>          
               </div>
               </div>

           </div> 

          <div class="form-group">
            <label for="name">Project Manager </label>
            <input type="hidden" class="form-control" id="pm_name" name="pm_name">
            <select style="width: 100%;" name="pm" id="pm" class="form-control">
                <option></option>
            </select>
          </div>

          <div class="form-group ">
            <label for="name">Email PIC Partner / Subsidiary *</label>
            <input type="hidden" class="form-control" id="email_pic_partner2" name="email_pic_partner2">
            <select style="width: 100%;" name="email_pic_partner" id="email_pic_partner" class="form-control" required>
                <option></option>
            </select>
          </div>

          <div class="form-group hidden" id="c_pic_partner">
            <label for="name">PIC Partner / Subsidiary *</label>
             <input type="text" class="form-control" id="pic_partner" name="pic_partner" placeholder="PIC Partner / Subsidiary">
          </div>

          <input type="hidden" class="form-control" id="evidence_field" name="evidence">
      </div>

      </div>

      <div class="row m-top-30">
        <div class="col-sm-12">
          <div class="col-sm-2 offset-sm-5">
              <button class="btn btn-success btn-addon" id="btnSubmitBAST" type="button"><i class="fa fa-plus"></i>
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

<!-- Project modals -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="project-modal">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
        <div class="modal-header">
              <h4 class="modal-title" id="modal-title-partner">Add BAST for Project</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
        </div>
              <div class="modal-body relative">
                <form>             
                  <div class="input-group">
                    <input type="text" name="searchProject" id="searchProject" class="form-control" placeholder="search projects by project name / project id / no. spk(P8) / customer / partner">
                    <span class="input-group-append">
                    <button id="btnSearchProject" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    <!-- <button id="btnClearSearchProject" class="btn btn-secondary btn-warning" type="button"><i class="fa fa-trash"></i> Clear</button> -->
                    </span>
                  </div>                                         
                    <table id="dataku7" class="table table-responsive-sm table-striped" style="width: 100% !important;">
                        <thead>
                          <tr>
                            <th style="width: 25% !important;">Project Name</th>
                            <th style="width: 10% !important;">Segmen</th>
                            <th style="width: 30% !important;">SPK / P8</th>
                            <th style="width: 15% !important;">Customer</th>
                            <th style="width: 15% !important;">Partner</th>
                            <th style="width: 5% !important;"></th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> 
                  </form>
            </div>
    </div>
  </div>
</div>
<script type="text/javascript">    
  var Page = function () {  
    var tableInit = function(){ 
          var table = $('#dataku7').DataTable({
                  initComplete: function(settings, json) {
                                $('.rupiah').priceFormat({
                                    prefix: '',
                                    centsSeparator: ',',
                                    thousandsSeparator: '.',
                                    centsLimit: 0
                                });
                    },
                    dom: '<"top">rt<"bottom"p><"clear">',
                    processing: true,
                    serverSide: true,
                    ajax: { 
                        url  :base_url+'bast/get_list_project_active', 
                        type :'POST', 
                        data : {
                                  search_bast   : $('#searchProject').val(),
                                  } 
                        },
                    aoColumns: [
                        { mData: 'NAME'}, 
                        { mData: 'SEGMEN'},
                        { mData: 'NO_P8'}, 
                        { mData: 'STANDARD_NAME'},                       
                        { mData: 'PARTNER_NAME'},                       
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<span style='font-size:10px;margin-right:1px;' class=\'circle btn btn-xs btn-success btnAssignProject \' "+
                                      "data-id_project='"+obj.ID_PROJECT+"' "+
                                      "data-segmen='"+obj.SEGMEN+"' "+
                                      "data-nama_cc='"+obj.STANDARD_NAME+"' "+
                                      "data-nip_nas='"+obj.NIP_NAS+"' "+
                                      "data-id_partner='"+obj.ID_PARTNER+"' "+
                                      "data-partner_name='"+obj.PARTNER_NAME+"' "+
                                      "data-pm_name='"+obj.PM_NAME+"' "+
                                      "data-pm_nik='"+obj.PM_NIK+"' "+
                                      "data-no_spk='"+obj.NO_P8+"' "+
                                      "data-project_name='"+obj.NAME+"' "+
                                      "data-value='"+obj.VALUE+"' >"+
                                      "<i class='fa fa-arrow-alt-circle-right'></i></span>";       
                                    return a;
                            }

                        }, 
                       ],      
                });
          }

      var dTypeBast = function($vals=null) {
          $("#c_termin").addClass('hidden');    
          $("#progress_periode").addClass('hidden');   
          $("#c_progress_actual").addClass('hidden'); 
              
           switch ($vals) {
              case "OTC":
                  $("#bast_value").val($('#value').val());  
                  break;
              case "TERMIN":
                  $("#c_termin").removeClass('hidden');  
                  break;
              case "PROGRESS":
                  $("#c_progress_actual").removeClass('hidden');   
                  break;
              case "RECURRING":
                  $("#progress_periode").removeClass('hidden');  
                  break;
           } 
        }; 

        var get_spk = function(){
          var spkTrigger1 = $('#bast_date').val();
          var spkTrigger2 = $('#partner_id').val();
          var spkTrigger3 = $('#customer_id').val();
          console.log(spkTrigger1 + '|' + spkTrigger2 + '|' + spkTrigger3);
          if(spkTrigger2!='' &&spkTrigger2!=null){
            $('#spk').attr('disabled',false);
            $("#spk").select2({
                    placeholder: "No. SPK",
                    width: 'resolve',
                    //tags:true,
                    ajax: {
                        type: 'POST',
                        delay: 200,
                        url:base_url+"json/get_json_spk_bast",
                        dataType: "json",
                        data: function (params) {
                            return {
                                q: params.term,
                                page: params.page,
                                customer : $('#customer_id').val(),
                                partner :$('#partner_id').val(),
                                bast_date :$('#bast_date').val(),
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function(obj) {
                                    return { id: obj.NO_SPK, text: obj.NO_SPK, title: obj.PROJECT_NAME, CC:obj.CC, NIPNAS : obj.NIPNAS, SEGMEN : obj.SEGMEN, DATE : obj.DATE};
                                })
                            };
                        },
                        
                    }
            }); 
          };
        }


      $("#pm").select2({
                placeholder: "Select Project Manager",
                width: 'resolve',
                allowClear : true,
                ajax: {
                    type: 'POST',
                    delay: 200,
                    url:base_url+"json/get_json_pm",
                    dataType: "json",
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            customer : $('#customer_id').val(),
                            partner :$('#partner_id').val()
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.NIK, text: obj.NAMA};
                            })
                        };
                    },
                    
                }
        }); 

      $("#email_pic_partner").select2({
                placeholder: "Select Email PIC Partner",
                width: 'resolve',
                allowClear:true,
                tags:true,
                ajax: {
                    type: 'POST',
                    delay: 200,
                    url: base_url+"json/get_json_pic_partner",
                    dataType: "json",
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.NAMA+'||'+obj.EMAIL, text: obj.EMAIL };
                            })
                        };
                    },
                    
                }
            });


      return {
          init: function() { 
              $(document).on('change','.spkTrigger',function(e){
                            
                        }); 

              tableInit();dTypeBast();
              $('.rupiah').priceFormat({
                                    prefix: '',
                                    centsSeparator: ',',
                                    thousandsSeparator: '.',
                                    centsLimit: 0
                                });
              $(document).on('change','#email_pic_partner',function(e){
                  var eMval = $('#email_pic_partner').val();
                  var eMitra = eMval.split("||");
                  if(eMitra.length<=1){
                      $('#c_pic_partner').removeClass('hidden');
                      $('#email_pic_partner2').val(eMval);
                  }else{
                      $('#c_nama_pic_partner').addClass('hidden');
                      $('#email_pic_partner2').val(eMitra[1]);
                      $('#pic_partner').val(eMitra[0]);
                    }
              }); 

              $(document).on('click','#btn_clear_id_project',function(e){
                $('#id_project').val('');
              });
              $(document).on('change','#type_bast',function(e){
                    e.stopImmediatePropagation();
                    dTypeBast($(this).val());
              });
              $(document).on('click','#btn_id_project',function(e){
                    e.stopImmediatePropagation();
                    $('#project-modal').modal('show'); 
                    $('#dataku7').dataTable().fnDestroy();
                    tableInit();
              });
              $(document).on('click','#btnSearchProject',function(e){
                    e.stopImmediatePropagation();
                    $('#dataku7').dataTable().fnDestroy();
                    tableInit();
              });

              $(document).on('click','.btnAssignProject',function(e){
                    e.stopImmediatePropagation();
                    var data = $(this).data();         
                    $('#segmen').val(data.segmen).trigger('change');

                    if ($('#customer').find("option[value='" + data.nip_nas + "']").length) {
                        $('#customer').val(data.nip_nas).trigger('change');
                    } else { 
                        var newOption = new Option(data.nama_cc, data.nip_nas, true, true);
                        $('#customer').append(newOption).trigger('change');
                    } 

                    if ($('#customer').find("option[value='" + data.nip_nas + "']").length) {
                        $('#customer').val(data.nip_nas).trigger('change');
                    } else { 
                        var newOption = new Option(data.nama_cc, data.nip_nas, true, true);
                        $('#customer').append(newOption).trigger('change');
                    } 

                    if ($('#spk').find("option[value='" + data.no_spk + "']").length) {
                        $('#spk').val(data.no_spk).trigger('change');
                    } else { 
                        var newOption = new Option(data.no_spk, data.no_spk, true, true);
                        $('#spk').append(newOption).trigger('change');
                    } 

                    $('#project_name').text(data.project_name);
                    $('#project_name').val(data.project_name);
                    $('#id_project').val(data.id_project);

                    $('#project-modal').modal('hide'); 
              });

              $(document).on('change','#customer',function(e){
                  var val  = $('#customer').val();
                  var sval = val.split("||");
                  $('#customer_id').val(sval[0]);
                  $('#customer_name').val(sval[1]);
                  get_spk();
              });

              $(document).on('change','#partner',function(e){
                  var val  = $('#partner').val();
                  var sval = val.split("||");
                  $('#partner_id').val(sval[0]);
                  $('#partner_name').val(sval[1]);
                  get_spk();
              });


              $(document).on('change','#bast_date',function(e){
                  get_spk();
              });
               

              $(document).on('change','#spk',function(e){
                    var data = $("#spk").select2('data')[0];
                    cekSPK    = data.text.substring(0, 4);
                    console.log(cekSPK);
                    if(cekSPK != 'TEL.'){
                      $('#wSPK').html("make sure you've type correct SPK");
                    }else{
                      $('#wSPK').html("");
                    }
                    var date_spk = data.DATE.date.split(' ')[0];
                    date_spk = date_spk.split('-');
                    date_spk = date_spk[1]+'/'+date_spk[2]+"/"+date_spk[0];
                    $('#project_name').val(data.title);
                    $('#customer_name').val(data.CC);
                    $('#customer_id').val(data.NIPNAS);
                    $('#segmen').val(data.SEGMEN);
                    $('#spk_date').val(date_spk);
              });

              $(document).on('change','#pm',function(e){
                    var data = $("#pm").select2('data')[0];
                    $('#pm_name').val(data.text);
              });


              $(document).on('click','#btnSubmitBAST',function(e){
                    e.stopImmediatePropagation();
                      var evidence = [];
                      if ($('#BAcostumer').is(':checked')) {evidence.push($('#BAcostumer').data('val'))}else{evidence.push(' ');}
                      if ($('#BAperformansi').is(':checked')) {evidence.push($('#BAperformansi').data('val'))}else{evidence.push(' ');}
                      if ($('#BArekonsiliasi').is(':checked')) {evidence.push($('#BArekonsiliasi').data('val'))}else{evidence.push(' ');}
                      if ($('#BAprogress').is(':checked')) {evidence.push($('#BAprogress').data('val'))}else{evidence.push(' ');}
                      if ($('#BAketerlambatan').is(':checked')) {evidence.push($('#BAketerlambatan').data('val'))}else{evidence.push(' ');}   
                      if ($('#cSPK').is(':checked')) {evidence.push($('#cSPK').data('val'))}else{evidence.push(' ');}    
                      if ($('#cWO').is(':checked')) {evidence.push($('#cWO').data('val'))}else{evidence.push(' ');}    
                      if ($('#cKL').is(':checked')) {evidence.push($('#cKL').data('val'))}else{evidence.push(' ');}    

                      evidence.push($('#nama_termin').val());    
                      
                      $('#evidence_field').val(evidence);

                      if($('#formBast').valid()){
                          bootbox.prompt({
                                  title: "Confirm Data",
                                  placeholder: "Write some note?",
                                  inputType: 'textarea',
                                  buttons: {
                                      confirm: {
                                          label: '<i class="fa fa-check"></i> Proses',
                                          className: 'col-sm-2 btn-success'
                                      },
                                      cancel: {
                                          label: '<i class="fa fa-times"></i> Batal',
                                          className: 'col-sm-2 btn-danger col-sm-offset-4'
                                      }
                                  },
                                  callback: function(result) {
                                    //console.log(result);
                                      if(result!=null){
                                        $('#commend').val(result);
                                        $('#pre-load-background').fadeIn();
                                        $('.rupiah').unmask();
                                        $('#value').val($('#value').unmask());
                                        $('#bast_value').val($('#bast_value').unmask());

                                        var form = $('form')[0];
                                        var formData = new FormData(form);
                                        $.ajax({
                                                      url: base_url+'bast/submitBast',
                                                      type:'POST',
                                                      dataType : "json",
                                                      data:  formData ,
                                                      async : true, 
                                                      processData: false,
                                                      contentType: false,
                                                      processData:false,
                                                      success:function(result){
                                                        if(result.data=='success'){
                                                        bootbox.alert("Success!", function(){ 
                                                        var url = base_url+"bast/view/"+result.id_bast;
                                                        window.location.href = url;
                                                        
                                                        console.log('success Add BAST!'); 
                                                        });
                                                        }else{
                                                        bootbox.alert("Failed!", function(){ 
                                                        console.log('failed Add BAST!'); });
                                                        }
                                                      return result;
                                                      },
                                                       error: function(xhr, error){
                                                              bootbox.alert("Failed!", function(){ 
                                                              console.log('failed update BAST!'); });
                                                       },

                                              });
                                        $('#pre-load-background').fadeOut();
                                      }
                                      else{
                                          bootbox.hideAll();
                                      }
                                  }
                              }); 
                            
                      }

                       

              });

          }
      }

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>