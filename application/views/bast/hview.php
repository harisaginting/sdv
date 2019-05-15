<link href="<?= base_url(); ?>assets/css/timeline.css"  rel="stylesheet"/>
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

/*Page styles*/
.form-control:disabled, .form-control[readonly]{
  background-color: #fff;
}

.form-control{
  border-top: 0px;
  border-right: 0px;
  border-left: 0px;
  background-color: #fff;
  font-size: 14px; 
}


form label{
  color: #9c9c9c !important;
}

.boxes {
  margin: auto;
}

<?php if(($bast['STATUS']!='APPROVED')&&($bast['STATUS']!='DONE')) : ?>
.file-caption-main{
  display: none;
}
<?php endif; ?>

.file-preview{
  width: 82%;
}

/*Checkboxes styles*/
input[type="checkbox"] { display: none; }
 
input[type="checkbox"] + label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 10px;
  font: 14px/20px;
  color: #000 !important;
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
<li class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>bast/view/<?= $id_bast; ?>"> <strong>view</strong></li>
</ol>

<div class="container-fluid container-content">

<div class="col-sm-12">
  <div class="card">
  <div class="card-header">
  <strong>BAST</strong>
  <small>Preview</small>
  </div>
  <div class="card-body">
    <form id="formBast">
      <div class="row">

       <div class="col-sm-12" style="margin-bottom: 10px;">
          <label style="color: #ff4a4a !important;">Document Status</label>
            <input style="font-size: 18px !important;color:#f42020 !important;font-weight: 900;" type="text" class="form-control" value="<?= !empty($bast['STATUS']) ? $bast['STATUS'] : ''; ?>" readOnly>
        </div> 

      <?php if(!empty($oldBast)) :  ?>
      <div class="col-sm-12">
        <h4><b>Previous BAST</b></h4>
        <table id="datakuBast" class="table table-responsive-sm table-striped" style="width: 100%;">
              <thead>
                
                <tr style="background:;">
                  <th>No. SPK</th>
                  <th>No. BAST</th>
                  <th>BAST Date</th>
                  <th>Status</th>
                </tr>

              </thead>
              <tbody>
                <?php foreach ($oldBast as $key => $value) : ?>
                  <tr>
                    <td><a href="<?= base_url()."bast/view/".$oldBast[$key]['ID_BAST'] ?>" target="_blank"><?= $oldBast[$key]['NO_SPK'] ?></a></td>
                    <td><?= $oldBast[$key]['NO_BAST'] ?></td>
                    <td><?= $oldBast[$key]['TGL_BAST2'] ?></td>
                    <td><?= $oldBast[$key]['STATUS'] ?></td>
                  </tr>
                <?php endforeach;?>

              </tbody>
          </table>
          <br>
      </div>
     <?php endif; ?>


      <?php if(!empty($bast['NO_BAST'])) : ?>
        <?php if(!empty($bast['ID_PROJECT'])) : ?>    
          <div class="col-md-6" style="margin-bottom: 10px;">
            <label>No. BAST</label>
              <input type="text" class="form-control" id="no_bast" name="no_bast" value="<?= !empty($bast['NO_BAST']) ? $bast['NO_BAST'] : ''; ?>" readOnly>
          </div>

          <div class="col-md-3" style="margin-bottom: 10px;">
            <label>ID PROJECT</label>
              <input type="text" class="form-control"  value="<?= !empty($bast['ID_PROJECT']) ? $bast['ID_PROJECT'] : ''; ?>" readOnly>
          </div>

          <div class="col-md-3" style="margin-bottom: 10px;">
            <label>ID LOP</label>
              <input type="text" class="form-control"  value="<?= !empty($bast['ID_LOP']) ? $bast['ID_LOP'] : '-'; ?>" readOnly>
          </div>
        
        <?php else : ?>
          <div class="col-sm-12" style="margin-bottom: 10px;">
            <label>No. BAST</label>
              <input type="text" class="form-control" id="no_bast" name="no_bast" value="<?= !empty($bast['NO_BAST']) ? $bast['NO_BAST'] : ''; ?>" readOnly>
          </div>
        <?php endif; ?>
      <?php endif; ?>
      <?php if(!empty($bast['FILENAME'])) : ?>
        <div class="col-sm-12" style="margin-bottom: 10px;">
          <label>Document BAST</label>
            <input type="text" class="form-control" id="filename" name="filename" placeholder="MM/DD/YYYY" value="<?= !empty($bast['FILENAME']) ? $bast['FILENAME'] : ''; ?>" readOnly>
        </div>
      <?php endif; ?>
      
      <div class="col-sm-6">
          <div class="form-group">
            <label for="name">Bast Date</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['TGL_BAST']) ? $bast['TGL_BAST2']  : ''; ?>" readOnly>
          </div>

          <div class="form-group">
            <label for="name">Partner / Subsidiary</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['NAMA_MITRA']) ? $bast['NAMA_MITRA'] : '"'  ?> " readOnly>
          </div>

          <div class="form-group hidden">
            <label for="name">Partner</label>
            <input type="hidden" name="partner_id" id="partner_id" value="<?= !empty($bast['ID_MITRA']) ? $bast['ID_MITRA'] : '' ?>">
            <input type="hidden" name="partner_name" id="partner_name" value="<?= !empty($bast['NAMA_MITRA']) ? $bast['NAMA_MITRA']: ''; ?>">
            <select style="width: 100%;" name="partner" id="partner" class="form-control Jselect2">
                <option value="<?= !empty($bast['ID_MITRA']) ? $bast['ID_MITRA'].'"'.' selected' : '"'  ?>  " ><?= !empty($bast['NAMA_MITRA']) ? $bast['NAMA_MITRA'] : 'Select Partner'; ?></option> 
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
            <label for="name">No. SPK</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['NO_SPK']) ? $bast['NO_SPK'] : '"'  ?> " readOnly>
          </div>

          <div class="form-group">
            <label>Segmen</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['SEGMENT']) ? $bast['SEGMENT'] : '"'  ?> " readOnly>
          </div>

          <div class="form-group">
            <label>Customer Name</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['NAMACC']) ? $bast['NAMACC'] : '"'  ?> " readOnly>
          </div>

          <div class="form-group">
            <label>SPK Date*</label>
            <input type="text" class="form-control" id="spk_date" name="spk_date" placeholder="MM/DD/YYYY" required value="<?= !empty($bast['TGL_SPK']) ? $bast['TGL_SPK2'] : ''; ?>" readOnly>
          </div>

          <div class="form-group">
            <label for="name">Project Name *</label>
            <textarea id="project_name" name="project_name" rows="3" class="form-control" placeholder="Project Name" required><?= !empty($bast['PROJECT_NAME']) ? $bast['PROJECT_NAME'] : ''; ?></textarea>
          </div>

          <div class="form-group">
            <label for="name">Project Value (Before PPN 10%)*</label>
            <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" required value="<?= !empty($bast['NILAI_PEKERJAAN']) ? $bast['NILAI_PEKERJAAN'] : '0';   ?>">
          </div>

          <?php if(!empty($bast['NO_KL'])) : ?>
          <div class="form-group">
            <label for="name">No. KL</label>
            <input type="text" class="form-control" id="kl" name="kl" placeholder="No. KL" value="<?= !empty($bast['NO_KL'])? $bast['NO_KL'] : '' ?>">
          </div>

          <div class="form-group">
            <label for="name">KL Date</label>
            <input type="text" class="form-control" id="kl_date" name="kl_date" placeholder="MM/DD/YYYY" value="<?= !empty($bast['TGL_KL2']) ? $bast['TGL_KL2'] : ''; ?>" readOnly>
          </div>
          <?php endif; ?>
      </div>

      <div class="col-sm-6">

          

          <div class="form-group">
            <label for="name">BAST Value</label>
            <input type="text" class="form-control rupiah" id="bast_value" name="bast_value" placeholder="BAST Value" required value="<?= !empty($bast['NILAI_RP_BAST']) ? $bast['NILAI_RP_BAST'] : ''; ?>">
          </div>

          <div class="form-group">
            <label for="name">Signer</label>
            <input type="text" name="" class="form-control" value="<?= !empty($bast['PENANDA_TANGAN']) ? $bast['PENANDA_TANGAN'] : '"'  ?> " readOnly>
          </div>

          <div class="form-group">
            <label for="name">Payment Scheme</label>
            <input type="text" name="type_bast" id="type_bast"" class="form-control" value="<?= !empty($bast['TYPE_BAST']) ? $bast['TYPE_BAST'] : '"'  ?> " readOnly>
          </div>

          <div id="progress_periode" class="form-group">
            <label class="control-label">Periode Progress</label>
              <div class="input-daterange input-group">
                <input type="text" class="form-control date-picker" name="recc_start_date" placeholder="mm/dd/yyyy" value="<?= !empty($bast['RECC_START_DATE']) ? $bast['RECC_START_DATE2'] : ''; ?>">
                  <span class="input-group-addon" style="color:#000;">&nbsp;&nbsp; to &nbsp;&nbsp;</span>
                  <input type="text" class="form-control date-picker" name="recc_end_date" placeholder="mm/dd/yyyy" value="<?= !empty($bast['RECC_END_DATE']) ? $bast['RECC_END_DATE2'] : ''; ?>" >
                </div>
            </div>

          <div class="form-group" id="c_progress_actual">
            <label for="progress_actual">Progress (%)</label>
            <input type="number" class="form-control" id="progress_actual" name="progress_actual" placeholder="Progress" value="<?= !empty($bast['PROGRESS_LAPANGAN']) ? $bast['PROGRESS_LAPANGAN'] : ''; ?>">
          </div>

          <div class="form-group" id="c_termin">
            <label for="name">Termin</label>
            <input type="text" class="form-control" id="termin" name="termin" value="<?= !empty($bast['NAMA_TERMIN'])? $bast['NAMA_TERMIN'] : ''; ?>" placeholder="Termin Remarks">
          </div>

           <div id="evidence" class="form-group" style="margin-bottom: 7px !important">
               <label>Evidence</label>
               <div class="row">
               <div class="col-sm-2">
                 <div class="boxes">
                    <input type="checkbox" id="cP71" name="cP71" data-val="P71" <?= ((!empty($evidence[10]))&&($evidence[10]!= ' ')) ? 'checked' : '';  ?>>
                    <label for="cP71">P7-1</label>

                    <input type="checkbox" id="cSP" name="cSP" data-val="SP" <?= ((!empty($evidence[11]))&&($evidence[11]!= ' ')) ? 'checked' : '';  ?>>
                    <label for="cSP">SP</label>

                    <input type="checkbox" id="cSPK" name="cSPK" data-val="SPK" <?= ((!empty($evidence[5]))&&($evidence[5]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="cSPK">SPK</label>

                    <input type="checkbox" id="cWO" name="cWO"  data-val="WO" <?= ((!empty($evidence[6]))&&($evidence[6]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="cWO">WO</label>

                    <input type="checkbox" id="cKL" name="cKL" data-val="KL" <?= ((!empty($evidence[7]))&&($evidence[7]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="cKL">KL</label>
                  </div>
               </div>

               <div class="col-sm-10">
                 <div class="boxes">

                    <input type="checkbox" id="Baut" name="Baut" data-val="Baut" <?= ((!empty($evidence[9]))&&($evidence[9]!= ' ')) ? 'checked' : '';  ?>>
                    <label for="Baut" >BA Uji Terima (BAUT) / BAPP Smart Building</label>

                    <input type="checkbox" id="BAprogress2" name="BAprogress2" data-val="BAprogress2" <?= ((!empty($evidence[12]))&&($evidence[12]!= ' ')) ? 'checked' : '';  ?>>
                    <label for="BAprogress2" >Lampiran Rincian Perhitungan Progress</label>

                    <input type="checkbox" id="BAcustomer" name="BAcustomer" data-val="BAcustomer" <?= ((!empty($evidence[0]))&&($evidence[0]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAcustomer">BA Customer / BA Format Standar</label>

                    <input type="checkbox" id="BAperformansi" name="BAperformansi" data-val="BAperformansi" <?= ((!empty($evidence[1]))&&($evidence[1]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAperformansi">BA Performansi (Untuk layanan berbasis SLG)</label>

                    <input type="checkbox" id="BArekonsiliasi" name="BArekonsiliasi" data-val="BArekonsiliasi" <?= ((!empty($evidence[2]))&&($evidence[2]!= ' ')) ? 'checked' : '';  ?>  >
                    <label for="BArekonsiliasi">BA Rekonsiliasi (Untuk layanan Transaksional berbasis rekon)</label>

                    <input type="checkbox" id="BAketerlambatan" name="BAketerlambatan" data-val="BAketerlambatan" <?= ((!empty($evidence[4]))&&($evidence[4]!= ' ')) ? 'checked' : '';  ?>  >
                    <label for="BAketerlambatan" >BA Keterlambatan Delivery</label>

                    <input type="checkbox" id="BAprogress" name="BAprogress" data-val="BAprogress" <?= ((!empty($evidence[3]))&&($evidence[3]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAprogress" >BAPP (BA Progress Pekerjaan)</label>

                    <input type="checkbox" id="OtherE" name="OtherE" data-val="Other" class="OtherE" <?= ((!empty($evidence[13]))&&($evidence[13]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="OtherE" class="OtherE" >Other</label>
                    <input style='' type="text" class="form-control <?= ((!empty($evidence[13]))&&($evidence[13]!= ' ')) ? '' : 'hidden';  ?>" name="val_other" id="val_other" placeholder="type another attached evidence" value="<?= ((!empty($evidence[13]))&&($evidence[13]!= ' ')) ? $evidence[13] : '';  ?>" >
                  
                  </div>          
               </div>
               </div>

           </div> 

          <div class="form-group hidden">
            <label for="name">Project Manager</label>
            <input type="hidden" class="form-control" id="pm_name" name="pm_name" val="<?= !empty($bast['NAMA_PM']) ? $bast['NAMA_PM'] : ''; ?>">
            <select style="width: 100%;" name="pm" id="pm" class="form-control">
                <option val="<?= !empty($bast['NIK_PM']) ? $bast['NIK_PM'] : ''; ?>"><?= !empty($bast['NIK_PM']) ? $bast['NAMA_PM'] : ''; ?></option>
            </select>
          </div>

          <div class="form-group" id="c_pic_partner">
            <label>PIC BAST</label>
             <input type="text" class="form-control" id="pic_partner" name="pic_partner" placeholder="PIC Partner / Subsidiary"  value="<?= !empty($bast['PIC_MITRA']) ? $bast['PIC_MITRA'] : ''; ?> [<?= $bast['EMAIL_MITRA']; ?>]" readOnly>
          </div>

          <input type="hidden" class="form-control" id="evidence_field" name="evidence">
      </div>

      </div>

      <div id="c_document" class="row m-top-30 <?= !empty($bast['FILENAME_URI'])? '' : 'hidden' ?>">
        <div class="col-md-4 offset-md-4">
          <div class="form-group">
              <input id="document" name="file_bast" type="file" accept="pdf" class="form-control file" >
          </div>
        </div>
      </div>     
    </form>

    <div class="row">

        <div class="col-sm-12" style="height: 10px;margin-top: 20px;">
          <div class="form-group ">
            <label><span class="text-primary">Document Status History</span></label>
          </div>
        </div>

      <div class="col-sm-12">

          <?php if(!empty($history)) : ?>
            <!-- Timeline -->
            <div id="timeline" style="margin-top: 0px;">
              <?php foreach($history as $key=>$value) :?>
                <div class="timeline-item">
                <!--Icon inside the circle-->
                <div class="timeline-icon">
                  <img class="img-timeline" src="<?= !empty($history[$key]['PHOTO_USER']) ? $history[$key]['PHOTO_USER'] : base_url().'assets/img/avatars/default.png';?>" alt="">
                </div>
                <!-- Content from timeline box and position (right or left)-->
                <div class="text-primary" style="text-align:<?= ($key % 2 == 0) ? 'right;'  : 'left;'; ?><?= ($key % 2 == 0) ? 'margin-right:50%;padding-right:5%;'  : 'margin-left:50%;padding-left:5%;'; ?>width: 50%;">
                  <?= $history[$key]['STATUS'] ?>
                </div>
                <div class="timeline-content <?= ($key % 2 == 0) ? 'left'  : 'right'; ?>">
                  <h2 style="text-align:<?= ($key % 2 == 0) ? 'left'  : 'right'; ?>">
                    <?= $history[$key]['NAME_USER']; ?>
                    <small class="<?= ($key % 2 == 0) ? 'pull-right'  : 'pull-left'; ?>">
                      <?= $history[$key]['TIME']; ?>
                    </small>
                  </h2>
                  <p>
                    <small><?= $history[$key]['COMMEND']; ?></small>
                  </p>
                </div>
              </div>
                    
              <?php endforeach; ?>
            </div>
          <?php endif; ?>


        </div>
    </div>

  </div>
  </div>
</div>

</div>


<script type="text/javascript">    
  var Page = function () {  
     <?php if(!empty($bast['FILENAME_URI'])) : ?>
              $("#document").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/<?= $bast['FILENAME_URI']; ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/<?= $bast['FILENAME_URI']; ?>", downloadUrl: "https://prime.telkom.co.id/<?= $bast['FILENAME_URI']; ?>",caption : "<?= $bast['FILENAME']; ?>"}, 
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




      var spkCheck = function(){
        $("#spk").select2({
                            placeholder: "No. SPK",
                            width: 'resolve',
                            tags:true,
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
                                        partner :$('#partner_id').val()
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function(obj) {
                                            return { id: obj.NO_SPK, text: obj.NO_SPK, title: obj.PROJECT_NAME};
                                        })
                                    };
                                },
                                
                            }
                    }); 
      }

      var dTypeBast = function($vals=null) {
          $("#c_termin").addClass('hidden');    
          $("#progress_periode").addClass('hidden');   
          $("#c_progress_actual").addClass('hidden'); 
              
           switch ($vals) {
              case "OTC":
                  /*$("#bast_value").val($('#value').val());*/  
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


      $("#pm").select2({
                placeholder: "Select Project Manager",
                width: 'resolve',
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
              dTypeBast($('#type_bast').val());
              /*<?php if($bast['TYPE_BAST']=='OTC') :  ?>
              $("#bast_value").val($('#value').val()); 
              <?php endif; ?>*/

              <?php if($bast['TYPE_BAST']=='TERMIN') :  ?>
              $("#c_termin").removeClass('hidden');  
              <?php endif; ?>

              <?php if($bast['TYPE_BAST']=='PROGRESS') :  ?>
              $("#c_progress_actual").removeClass('hidden');  
              <?php endif; ?>

              <?php if($bast['TYPE_BAST']=='RECURRING') :  ?>
              $("#progress_periode").removeClass('hidden'); 
              <?php endif; ?>

              $('.rupiah').priceFormat({
                                    prefix: '',
                                    centsSeparator: ',',
                                    thousandsSeparator: '.',
                                    centsLimit: 0
                                });



             

              $(document).on('click','#btnUpdateBAST',function(e){
                    e.stopImmediatePropagation();
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
                                    $('#pre-load-background').fadeOut();
                                      if(result!=null){
                                        $('#commend').val(result);
                                        $('#pre-load-background').fadeIn();
                                        $('.rupiah').unmask();
                                        $('#value').val($('#value').unmask());
                                        $('#bast_value').val($('#bast_value').unmask());
                                        var form = $('form')[0];
                                        var formData = new FormData(form);
                                        $.ajax({
                                                  url: base_url+'bast/updateBast2',
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
                                                    window.location.href = base_url+"bast/view/"+result.id_bast;
                                                    console.log('success update BAST!'); });
                                                    }else{
                                                    bootbox.alert("Failed!", function(){ 
                                                    console.log('failed update BAST!'); });
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
                            /**/
                      }
              });
        
            $('input, textarea, select, .select2-selection').css('background','');
            $('#status').css('background','#edff11');
          }
      }

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>