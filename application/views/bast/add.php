
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

/*Page styles*/

.form-control:disabled, .form-control[readonly]{
  background-color: #fff;
}

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
  <strong><?= $partner_name; ?></strong>
  <small>Form</small>
  </div>
  <div class="card-body">
    <form id="formBast">
      <div class="row">
      <div class="col-sm-6">
          <div class="form-group hidden">
            <label for="name">Partner *</label>
            <input type="hidden" name="partner_id" id="partner_id" value="<?= $partner_id; ?>">
            <input type="hidden" name="partner_name" id="partner_name" value="<?= $partner_name; ?>">
          </div>

          <div class="form-group">
            <label for="name">No. SPK *</label> <label class="text-warning" id="wSPK"></label>
            <select style="width: 100%;" name="spk" id="spk" class="form-control" required>
                <option></option>
            </select>
          </div>

          <div class="form-group">
            <label for="id_lop">ID LOP</label> <label class="text-warning" id="lop"></label>
            <input type="text" placeholder="ID LOP (EPIC)" style="width: 100%;" name="id_lop" id="id_lop" class="form-control" readOnly>    
          </div>

          <div class="form-group" style="min-height: 50px;padding-top: 10px;">
              <div class="row">
                <div class="col-md-3">
                  <input type="checkbox" id="bapp" name="bapp" data-val="bapp">
              <label for="bapp" class="pull-left">BAPP</label>
                </div>
                <div class="col-md-6">
                  <input type="checkbox" id="p71" name="p71" data-val="P71" style="margin">
              <label for="p71" >Menggunakan P71</label>
                </div> 
              </div>       
          </div>

          <div class="form-group">
            <label for="name">SPK Date*</label>
            <input type="text" class="form-control" id="spk_date" name="spk_date" placeholder="MM/DD/YYYY" readOnly required>
          </div>

          <div class="form-group">
            <label for="name">Customer Name *</label>
            <input type="hidden" id="customer_id" name="customer_id">
            <input type="text" id="customer_name" name="customer_name" class="form-control" readonly>
          </div>

          <div class="form-group">
            <label for="name">Segmen *</label>
            <input type="text" id="segmen" name="segmen" class="form-control" readonly>
          </div>


          <div class="form-group">
            <label for="name">Project Name *</label>
            <textarea id="project_name" name="project_name" rows="3" class="form-control" placeholder="Project Name" required></textarea>
          </div>

          <div class="form-group">
            <label for="name">Project Value (IDR Before PPN 10%)*</label>
            <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" required>
          </div>

          <div class="form-group">
            <label for="name">No. KL</label>
            <input type="text" class="form-control" id="kl" name="kl" placeholder="No. KL">
          </div>

          <div class="form-group">
            <label for="name">KL Date</label>
            <input type="text" class="form-control date-picker" id="kl_date" name="kl_date" placeholder="MM/DD/YYYY" readOnly>
          </div>

      </div>

      <div class="col-sm-6">
          <div class="form-group"> 
            <label for="name">Bast Date *</label>
            <input type="hidden" name="commend" id="commend">
            <input type="text" class="form-control date-picker " id="bast_date" name="bast_date" placeholder="BAST Date" required readOnly>
          </div>

          <div class="form-group">
            <label for="name">BAST Value(IDR) *</label>
            <input type="text" class="form-control rupiah" id="bast_value" name="bast_value" placeholder="BAST Value" required>
            <strong class="text-warning hidden" id="otc_warning">Make sure BAST value with OTC payment scheme same as Project Value! </strong>
          </div>

          <div class="form-group" id="c_progress_actual">
            <label for="progress_actual">Progress (%)</label>
            <input type="number" class="form-control" id="progress_actual" name="progress_actual" placeholder="Progress">
          </div>

          <div class="form-group">
            <label for="name">Signer *</label>
            <select style="width: 100%;" name="signer" id="signer" class="form-control Jselect2" required>
                <option value="" disabled selected>Select Signer</option>
                <option value="Coordinator Project Management">OSM Service Delivery - Sosro Hutomo Karsosoemo</option>
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
                  <option value="OTC & RECURRING">OTC & RECURRING</option>
              </select>
          </div> 

          <div id="progress_periode" class="form-group">
            <label class="control-label">Periode Progress Reccuring</label>
              <div class="input-daterange input-group">
                <input type="text" class="form-control date-picker" name="recc_start_date" placeholder="mm/dd/yyyy">
                  <span class="input-group-addon" style="color:#000;">&nbsp;&nbsp; to &nbsp;&nbsp;</span>
                  <input type="text" class="form-control date-picker" name="recc_end_date" placeholder="mm/dd/yyyy">
                </div>
            </div>

          <div id="c_reccuring_val" class="form-group">
            <label class="control-label">Reccuring Value (Rp.)</label>
                <input type="text" class="form-control rupiah" id="reccuring_val" name="reccuring_val" placeholder="Reccuring value">
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
                    <input type="checkbox" id="cP71" name="cP71" data-val="P71">
                    <label for="cP71">P7-1</label>

                    <input type="checkbox" id="cSP" name="cSP" data-val="SP">
                    <label for="cSP">SP</label>

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

                    <input type="checkbox" id="Baut" name="Baut" data-val="Baut">
                    <label for="Baut" >BA Uji Terima (BAUT) / BAPP Smart Building</label>

                    <input type="checkbox" id="BAprogress2" name="BAprogress2" data-val="BAprogress2">
                    <label for="BAprogress2" >Lampiran Rincian Perhitungan Progress</label>

                    <input type="checkbox" id="BAcustomer" name="BAcustomer" data-val="BAcustomer">
                    <label for="BAcustomer">BA Customer (BASO/BAST Customer)</label>

                    <input type="checkbox" id="BAperformansi" name="BAperformansi" data-val="BAperformansi">
                    <label for="BAperformansi">BA Performansi (Untuk layanan berbasis SLG)</label>

                    <input type="checkbox" id="BArekonsiliasi" name="BArekonsiliasi" data-val="BArekonsiliasi">
                    <label for="BArekonsiliasi">BA Rekonsiliasi (Untuk layanan Transaksional berbasis rekon)</label>

                    <input type="checkbox" id="BAketerlambatan" name="BAketerlambatan" data-val="BAketerlambatan">
                    <label for="BAketerlambatan" >BA Keterlambatan Delivery</label>

                    <input type="checkbox" id="BAprogress" name="BAprogress" data-val="BAprogress">
                    <label for="BAprogress" >BAPP (BA Progress Pekerjaan)</label>

                    <input type="checkbox" id="OtherE" name="OtherE" data-val="Other" class="OtherE">
                    <label for="OtherE" class="OtherE" >Other</label>
                    <input type="text" class="form-control hidden" name="val_other" id="val_other" placeholder="type another attached evidence">
                  
                  </div>          
               </div>
               </div>

           </div> 

          <div class="form-group hidden">
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
</div> s

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
      var dTypeBast = function($vals=null) {
          $("#c_termin").addClass('hidden');    
          $("#progress_periode").addClass('hidden');   
          $("#c_reccuring_val").addClass('hidden');   
          // $("#c_progress_actual").addClass('hidden'); 
          $("#otc_warning").addClass('hidden'); 
          $("#bast_value").removeClass('readOnly',false); 
          console.log($vals);
           switch ($vals) {
              case "OTC":
                  $("#bast_value").val($('#value').val()); 
                  $("#otc_warning").removeClass('hidden'); 
                  $("#bast_value").removeClass('readOnly',true); 
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
              case "OTC & RECURRING":
                  $("#progress_periode").removeClass('hidden');  
                  $("#c_reccuring_val").removeClass('hidden');  
                  break;
           } 
        }; 


        var validManual = function() {
          if ($('#p71').is(':checked')) {
            return true;
          }

          var bast_date_arr = $('#bast_date').val().split('/'); 
          var spk_date_arr  = $('#spk_date').val().split('/'); 
          var bast_date     = bast_date_arr[2]+""+bast_date_arr[0]+bast_date_arr[1];
          var spk_date     = spk_date_arr[2]+""+spk_date_arr[0]+spk_date_arr[1];

          var cekKL  = $('#kl').val().substring(0, 6);
          if(cekKL != 'K.TEL.'){
            if(cekKL.length > 0){
              bootbox.alert("KL number isn't valid", function(){ 
              });
              return false;
            }
          }


          if((bast_date-spk_date)>0){
            return true;
          }else{
            bootbox.alert("Bast Date is lower than or same as SPK date", function(){ 
              });
            return false;
          }
        }; 



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
               $(document).on('click','#p71',function(e){
                if ($('#p71').is(':checked')) {
                    $("#spk").select2({
                              placeholder: "No. P71",
                              width: 'resolve',
                              ajax: {
                                  type: 'POST',
                                  delay: 200,
                                  url:base_url+"json/get_json_p71_bast_local",
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
                                              return { id: obj.NO_P71, text: obj.NO_P71, title: obj.PROJECT_NAME, CC:obj.CC, NIPNAS : obj.NIPNAS, SEGMEN : obj.SEGMEN, DATE : obj.DATES, ID_LOP : obj.ID_LOP};
                                          })
                                      };
                                  },
                                  
                              }
                      });
                }else{
                   $("#spk").select2({
                              placeholder: "No. SPK",
                              width: 'resolve', 
                              ajax: {
                                  type: 'POST',
                                  delay: 200,
                                  url:base_url+"json/get_json_spk_bast_local",
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
                                              return { id: obj.NO_SPK, text: obj.NO_SPK, title: obj.PROJECT_NAME, CC:obj.CC, NIPNAS : obj.NIPNAS, SEGMEN : obj.SEGMEN, DATE : obj.DATES, ID_LOP : obj.ID_LOP};
                                          })
                                      };
                                  },
                                  
                              }
                      });
                }  
              });


              $("#spk").select2({
                      placeholder: "No. SPK",
                      width: 'resolve',
                      ajax: {
                          type: 'POST',
                          delay: 200,
                          url:base_url+"json/get_json_spk_bast_local",
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
                                      return { id: obj.NO_SPK, text: obj.NO_SPK, title: obj.PROJECT_NAME, CC:obj.CC, NIPNAS : obj.NIPNAS, SEGMEN : obj.SEGMEN, DATE : obj.DATES, ID_LOP : obj.ID_LOP};
                                  })
                              };
                          },
                          
                      }
              }); 

              dTypeBast();
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

              $(document).on('click','.OtherE',function(e){
                if ($('#OtherE').is(':checked')) {
                      $('#val_other').removeClass('hidden');
                }else{
                      $('#val_other').addClass('hidden');
                }  
              }); 

              $(document).on('click','#btn_clear_id_project',function(e){
                $('#id_project').val('');
              });
              $(document).on('change','#type_bast',function(e){
                    e.stopImmediatePropagation();
                    dTypeBast($(this).val());
              });

              $(document).on('change','#value',function(e){
                    e.stopImmediatePropagation();
                    dTypeBast($('#type_bast').val());
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
                    $('#id_lop').val(data.id_lop);

                    $('#project-modal').modal('hide'); 
              });

              $(document).on('change','#customer',function(e){
                  var val  = $('#customer').val();
                  var sval = val.split("||");
                  $('#customer_id').val(sval[0]);
                  $('#customer_name').val(sval[1]);
                  /*get_spk();*/
              });              

              $(document).on('change','#spk',function(e){
                    var data = $("#spk option:selected").data().data;
                    console.log(data);
                    cekSPK    = data['id'].substring(0, 4);
                    if(cekSPK != 'TEL.'){
                      $('#wSPK').html("make sure you've type correct SPK");
                    }else{
                      $('#wSPK').html("");
                    }
                    var date_spk = data['DATE'];

                    console.log(data['ID_LOP']);

                    $('#spk_date').val(date_spk);
                    $('#project_name').val(data['title']);
                    $('#customer_name').val(data['CC']);
                    $('#customer_id').val(data['NIPNAS']);
                    $('#segmen').val(data['SEGMEN']);
                    $('#id_lop').val(data['ID_LOP']);
                    $('#spk_date').css("background-color","#4CAF50");
                    $('#segmen').css("background-color","#4CAF50");
                    $('#customer_name').css("background-color","#4CAF50");
                    

              });

              $(document).on('change','#pm',function(e){
                    var data = $("#pm").select2('data')[0];
                    $('#pm_name').val(data.text);
              });


              $(document).on('click','#btnSubmitBAST',function(e){
                    e.stopImmediatePropagation();
                      var evidence = [];
                      if ($('#BAcustomer').is(':checked')) {evidence.push($('#BAcustomer').data('val'))}else{evidence.push(' ');}
                      if ($('#BAperformansi').is(':checked')) {evidence.push($('#BAperformansi').data('val'))}else{evidence.push(' ');}
                      if ($('#BArekonsiliasi').is(':checked')) {evidence.push($('#BArekonsiliasi').data('val'))}else{evidence.push(' ');}
                      if ($('#BAprogress').is(':checked')) {evidence.push($('#BAprogress').data('val'))}else{evidence.push(' ');}
                      if ($('#BAketerlambatan').is(':checked')) {evidence.push($('#BAketerlambatan').data('val'))}else{evidence.push(' ');}   
                      if ($('#cSPK').is(':checked')) {evidence.push($('#cSPK').data('val'))}else{evidence.push(' ');}    
                      if ($('#cWO').is(':checked')) {evidence.push($('#cWO').data('val'))}else{evidence.push(' ');}    
                      if ($('#cKL').is(':checked')) {evidence.push($('#cKL').data('val'))}else{evidence.push(' ');}       
                     /*8*/ evidence.push($('#nama_termin').val());    
                      if ($('#Baut').is(':checked')) {evidence.push($('#Baut').data('val'))}else{evidence.push(' ');} 
                      if ($('#cP71').is(':checked')) {evidence.push($('#cP71').data('val'))}else{evidence.push(' ');}   
                      if ($('#cSP').is(':checked')) {evidence.push($('#cSP').data('val'))}else{evidence.push(' ');}  
                      if ($('#BAprogress2').is(':checked')) {evidence.push($('#BAprogress2').data('val'))}else{evidence.push(' ');}  
                      if ($('#OtherE').is(':checked')) {evidence.push($('#val_other').val())}else{evidence.push(' ');}  
                      $('#evidence_field').val(evidence);

                      if(validManual()&&($('#formBast').valid())){
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
                                        $('#reccuring_val').val($('#reccuring_val').unmask());

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