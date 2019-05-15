
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
    <div class="row">
    <div class="col-sm-6">
        <div class="form-group">
          <label for="name">Customer Name *</label>
          <select style="width: 100%;" name="customer" id="customer" class="form-control Jselect2" required>
              <option disabled selected>Select Customer</option>
              <?php foreach ($list_customer as $cc): ?>
                  <option value="<?=$cc['NIP_NAS']?>||<?=$cc['STANDARD_NAME']?>"><?=$cc['STANDARD_NAME']?></option>
              <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="name">Segmen *</label>
          <select style="width: 100%;" name="segmen" id="segmen" class="form-control Jselect2" required>
              <option disabled selected>Select Segmen</option>      
                      <?php 
              foreach ($list_segmen as $key => $value) {
                  ?>
                      <option value="<?=$list_segmen[$key]['SEGMEN']?>"><?=$list_segmen[$key]['SEGMENT_6_LNAME']?></option>
                  <?php
                      }
                  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="name">Partner *</label>
          <select style="width: 100%;" name="partner" id="partner" class="form-control Jselect2" required>
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
          <label for="name">No. SPK *</label>
          <select style="width: 100%;" name="spk" id="spk" class="form-control" required>
              <option></option>
          </select>
        </div>

        <div class="form-group">
          <label for="name">SPK Date*</label>
          <input type="text" class="form-control date-picker" id="spk_date" name="spk_date" placeholder="" required>
        </div>

        <div class="form-group">
          <label for="name">Project Name *</label>
          <textarea id="textarea-input" name="textarea-input" rows="4" class="form-control" placeholder="Project Name"></textarea>
        </div>

        <div class="form-group">
          <label for="name">Project Value (Before PPN 10%)*</label>
          <input type="text" class="form-control" id="value" name="value" placeholder="Project Value" required>
        </div>

        <div class="form-group">
          <label for="name">No. KL</label>
          <input type="text" class="form-control" id="kl" name="kl" placeholder="No. KL" required>
        </div>

    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label ">Type BAST *</label>
            <select style="width: 100%;" name="type_bast" id="type_bast" class="form-control" style="width: 100%;" required>
                <option value="" disabled selected>Select Type</option>
                <option value="OTC">OTC</option>
                <option value="TERMIN">TERMIN</option>
                <option value="PROGRESS">PROGRESS</option>
                <option value="RECURRING">RECURRING</option>
            </select>
        </div>

        <div class="form-group">
          <label for="name">Bast Date*</label>
          <input type="text" class="form-control date-picker" id="" placeholder="BAST Date" required>
        </div>

        <div class="form-group">
          <label for="name">BAST Value*</label>
          <input type="text" class="form-control" id="bast_value" name="bast_value" placeholder="Project Value" required>
        </div>

        <div id="priode_progress" class="form-group col-sm-12 default-check-bast hidden" style="padding-left: 0px !important">
                        <label class="control-label col-sm-12" style="padding-left: 0px !important">Evidence </label>
                        <input type="hidden" id="kelengkapan" name="kelengkapan">
                            
                        <div class="col-md-8">
                            <div class="cbba">
                                <div id="ba_customer" class="form-check custom-check-bast2">
                                    <label class="form-check-label">
                                      <input name="BAcustomer" type="checkbox" data-val="BAcustomer" id="BAcustomer" class="custom-check-bast2 form-check-input bba">
                                      BA Customer / BA Format Standar
                                    </label>
                                  </div>

                                  <div id="ba_performansi" class="form-check  custom-check-bast">
                                    <label class="form-check-label">
                                      <input type="checkbox" data-val="BAperformansi" id="BAperformansi" class="bba custom-check-bast2 form-check-input">
                                      BA Performansi (Untuk layanan berbasis SLG)
                                    </label>
                                  </div>
                                  <div id="ba_rekonsiliasi" class="form-check  custom-check-bast">
                                    <label class="form-check-label">
                                      <input type="checkbox" data-val="BArekonsiliasi" id="BArekonsiliasi" class="bba custom-check-bast2 form-check-input">
                                      BA Rekonsiliasi (Untuk layanan Transaksional berbasis rekon)
                                    </label>
                                  </div>
                                  <div id="ba_progress" class="form-check  custom-check-bast">
                                    <label class="form-check-label">
                                      <input type="checkbox" data-val="BAprogress" id="BAprogress" class="bba form-check-input custom-check-bast2">
                                      BAPP (BA Progress Pekerjaan)
                                    </label>
                                  </div>
                                  <div id="ba_keterlambatan" class="form-check custom-check-bast">
                                    <label class="form-check-label">
                                      <input type="checkbox" data-val="BAketerlambatan" id="BAketerlambatan" class="bba custom-check-bast2 form-check-input">
                                      BA Keterlambatan
                                    </label>
                                  </div>
                            </div>      
                        </div>

                        <div class="col-md-4">
                            <div class="bespk">
                                 <div class="form-check">
                                    <label class="default-check-bast form-check-label">
                                      <input name="eSpk" type="checkbox" id="cSPK" data-val="SPK" class="form-check-input  espk" required>
                                      SPK
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <label class="default-check-bastform-check-label">
                                      <input name="eSpk" type="checkbox" id="cWO" class="form-check-input espk" data-val="WO">
                                      WO
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <label class="default-check-bast form-check-label">
                                      <input name="eSpk" type="checkbox" id="cKL" class="form-check-input espk" data-val="KL">
                                      KL
                                    </label>
                                  </div>
                            </div>    
                        </div>                        
        </div>

        <div class="form-group">
          <label for="name">Email PIC Mitra*</label>
          <input type="text" class="form-control" id="email_partner" name="email_partner" placeholder="Email PIC Partner" required>
        </div>

        <div class="form-group hidden">
        <input type="hidden" name="pic_mitra" id="pic_mitra" class="form-control">
        </div>

    </div>

    </div>

    <div class="row m-top-30">
      <div class="col-sm-12">
        <div class="col-sm-2 offset-sm-5">
            <button data-url="<?= base_url(); ?>projects/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
             &nbsp; Save
            </button>
        </div>
      </div>
    </div>

  </div>
  </div>
</div>

</div>

<script type="text/javascript">    
  var Page = function () {  
          var spkList = function(cc,mta){
            $("#spk").select2({
                            placeholder: "Nomor Surat Perintah Kerja",
                            width: 'resolve',
                            tags:true,
                            ajax: {
                                type: 'POST',
                                delay: 200,
                                url:base_url+"index.php/bast/getListSpkNumero2?nipnas="+cc[0]+"&id_mitra="+mta[0]+"&tahun="+'2017',
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
                                            return { id: obj.NoSPKSPWO, text: obj.NoSPKSPWO, title: obj.Judul };
                                        })
                                    };
                                },
                                
                            }
                    }); 

      return {
          init: function() { 
            $('body').on('change','#customer',function(e){
                 cc         = $('#customer').val().split('||');   
                 mta        = $('#partner').val().split('||');
                 
                 if(cc.length<=1){
                    cc[1] = cc[0];
                    cc[0] = "";                            
                    }
                 
                 spkList(cc,mta);    
                 $('body').on('change','#spk',function(e){
                    data=$("#spk").select2('data')[0];
                     $('#project_name').val(data.title);
                });
             }); 

           $('body').on('change','#partner',function(e){
               cc         = $('#customer').val().split('||');   
               mta        = $('#partner').val().split('||');  
               if(cc.length<=1){
                  cc[1] = cc[0];
                  cc[0] = "";                            
                  }

               spkList(cc,mta);
               $('body').on('change','#spk',function(e){
                  data=$("#spk").select2('data')[0];
                   $('#project_name').val(data.title);
              }); 
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>