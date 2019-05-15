
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);

/*Page styles*/

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

      <?php if(!empty($oldBast)) :  ?>
      <div class="col-sm-12">
        <h4><b>Previous BAST</b></h4>
        <table id="datakuBast" class="table table-responsive-sm table-striped" style="width: 100%;">
              <thead>
                
                <tr style="background:#b1ffa1;">
                  <th>No. SPK</th>
                  <th>No. BAST</th>
                  <th>BAST Date</th>
                  <th>Status</th>
                </tr>

              </thead>
              <tbody>
                <?php foreach ($oldBast as $key => $value) : ?>
                  <tr>
                    <td><?= $oldBast[$key]['NO_SPK'] ?></td>
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
        <div class="col-sm-12" style="margin-bottom: 10px;">
          <label>No. BAST</label>
            <input type="text" class="form-control" id="no_bast" name="no_bast" placeholder="MM/DD/YYYY" value="<?= !empty($bast['NO_BAST']) ? $bast['NO_BAST'] : ''; ?>" readOnly>
        </div>
      <?php endif; ?>
      <?php if(!empty($bast['FILENAME'])) : ?>
        <div class="col-sm-12" style="margin-bottom: 10px;">
          <label>Document BAST</label>
            <input type="text" class="form-control" id="filename" name="filename" placeholder="MM/DD/YYYY" value="<?= !empty($bast['FILENAME']) ? $bast['FILENAME'] : ''; ?>" readOnly>
        </div>
      <?php endif; ?>
      
      <div class="col-sm-6">
          <div class="form-group">
            <label for="name">Bast Date *</label>
            <input type="hidden" name="id_bast" value="<?= $id_bast; ?>">
            <input type="hidden" name="commend" id="commend">
            <input type="text" class="form-control date-picker" id="bast_date" name="bast_date" placeholder="BAST Date" required value="<?= !empty($bast['TGL_BAST']) ? $bast['TGL_BAST2']  : ''; ?>">
          </div>

          <div class="form-group">
            <label for="name">Partner *</label>
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
            <label for="name">No. SPK *</label> <label class="text-warning" id="wSPK"></label>
            <select style="width: 100%;" name="spk" id="spk" class="form-control" required readOnly>
                <option value="<?= !empty($bast['NO_SPK']) ? $bast['NO_SPK'].'"'.' selected' : '"'  ?>  " ><?= !empty($bast['NO_SPK']) ? $bast['NO_SPK'] : ''; ?></option>
            </select>
          </div>
          
          <!-- <div class="form-group">
            <label>ID Project *</label>
            <div class="input-group">
              
              
              <input type="text" id="id_project" name="id_project" class="form-control" placeholder="ID Project" 
              value="<?= !empty($id_project) ? $id_project :''; ?>" readOnly>
                <span class="input-group-append">
                  <button type="button" class="btn btn-warning" id="btn_clear_id_project">&nbsp;&nbsp;Clear &nbsp;&nbsp;</button>
                <button type="button" class="btn btn-primary" id="btn_id_project">ID Project</button>
                </span>
            </div>
          </div> -->

          <div class="form-group">
            <label for="name">Segmen *</label>
            <select style="width: 100%;" name="segmen" id="segmen" class="form-control Jselect2">
                <option disabled selected>Select Segmen</option>      
                        <?php 
                foreach ($list_segmen as $key => $value) {
                    ?>
                        <option  <?= $bast['SEGMENT'] == $list_segmen[$key]['SEGMEN']? 'selected' : '';  ?> value="<?=$list_segmen[$key]['SEGMEN']?>"><?=$list_segmen[$key]['SEGMENT_6_LNAME']?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>

          <div class="form-group">
            <label for="name">Customer Name *</label>
            <input type="hidden" id="customer_id" name="customer_id" value="<?= !empty($bast['NIPNAS'])? $bast['NIPNAS'] : ''; ?>">
            <input type="hidden" id="customer_name" name="customer_name" value="<?= !empty($bast['NAMACC']) ? $bast['NAMACC'] : '' ?>" >
            <select style="width: 100%;" name="customer" id="customer" class="form-control Jselect2" required>
                <option value="<?= !empty($bast['NIPNAS'])||!empty($bast['NAMACC']) ? $bast['NIPNAS'].'||'.$bast['NAMACC'].'"'.' selected' : '"'  ?>  " ><?= !empty($bast['NAMACC']) ? $bast['NAMACC'] : 'Select Partner'; ?></option> 
                <?php foreach ($list_customer as $cc): ?>
                    <option value="<?=$cc['NIP_NAS']?>||<?=$cc['STANDARD_NAME']?>"><?=$cc['STANDARD_NAME']?></option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="name">SPK Date*</label>
            <input type="text" class="form-control date-picker" id="spk_date" name="spk_date" placeholder="MM/DD/YYYY" required value="<?= !empty($bast['TGL_SPK']) ? $bast['TGL_SPK2'] : ''; ?>">
          </div>

          <div class="form-group">
            <label for="name">Project Name *</label>
            <textarea id="project_name" name="project_name" rows="3" class="form-control" placeholder="Project Name" required><?= !empty($bast['PROJECT_NAME']) ? $bast['PROJECT_NAME'] : ''; ?></textarea>
          </div>

          <div class="form-group">
            <label for="name">Project Value (Before PPN 10%)*</label>
            <input type="text" class="form-control rupiah" id="value" name="value" placeholder="Project Value" required value="<?= !empty($bast['NILAI_PEKERJAAN']) ? $bast['NILAI_PEKERJAAN'] : '0';   ?>">
          </div>

          <div class="form-group">
            <label for="name">No. KL</label>
            <input type="text" class="form-control" id="kl" name="kl" placeholder="No. KL" value="<?= !empty($bast['NO_KL'])? $bast['NO_KL'] : '' ?>">
          </div>

          <div class="form-group">
            <label for="name">KL Date*</label>
            <input type="text" class="form-control date-picker" id="kl_date" name="kl_date" placeholder="MM/DD/YYYY" value="<?= !empty($bast['TGL_KL2']) ? $bast['TGL_KL2'] : ''; ?>">
          </div>
      </div>

      <div class="col-sm-6">

          

          <div class="form-group">
            <label for="name">BAST Value *</label>
            <input type="text" class="form-control rupiah" id="bast_value" name="bast_value" placeholder="BAST Value" required value="<?= !empty($bast['NILAI_RP_BAST']) ? $bast['NILAI_RP_BAST'] : ''; ?>">
          </div>

          <div class="form-group">
            <label for="name">Signer *</label>
            <select style="width: 100%;" name="signer" id="signer" class="form-control Jselect2" required>
                <option disabled selected>Select Signer</option>
                <option value="Coordinator Project Management" <?= ((!empty($bast['PENANDA_TANGAN']))&&($bast['PENANDA_TANGAN']=='Coordinator Project Management')) ? 'selected' : ''; ?> >Coordinator Project Management - Sosro Hutomo Karsosoemo</option>
                <option value="Senior Expert Project Management Office 1" <?= ((!empty($bast['PENANDA_TANGAN']))&&($bast['PENANDA_TANGAN']=='Senior Expert Project Management Office 1')) ? 'selected' : ''; ?> >Senior Expert Project Management Office 1 - Ristyawan Fauzi Mubarok</option>
                <option value="Senior Expert Project Management Office 2" <?= ((!empty($bast['PENANDA_TANGAN']))&&($bast['PENANDA_TANGAN']=='Senior Expert Project Management Office 2')) ? 'selected' : ''; ?>>Senior Expert Project Management Office 2 - Heri Ikhwan Diana</option>
                <option value="Senior Expert Delivery and Integration" <?= ((!empty($bast['PENANDA_TANGAN']))&&($bast['PENANDA_TANGAN']=='Senior Expert Delivery and Integration')) ? 'selected' : ''; ?>>Senior Expert Delivery and Integration - Retno Kurniawati</option>   
            </select>
          </div>

          <div class="form-group">
              <label class="control-label ">Payment Scheme *</label>
              <select style="width: 100%;" name="type_bast" id="type_bast" class="form-control" style="width: 100%;" required>
                  <option value="" disabled selected>Select Type</option>
                  <option value="OTC" <?= $bast['TYPE_BAST']=='OTC' ? 'selected' : ''; ?> >OTC</option>
                  <option value="TERMIN" <?= $bast['TYPE_BAST']=='TERMIN' ? 'selected' : ''; ?>>TERMIN</option>
                  <option value="PROGRESS" <?= $bast['TYPE_BAST']=='PROGRESS' ? 'selected' : ''; ?> >PROGRESS</option>
                  <option value="RECURRING" <?= $bast['TYPE_BAST']=='RECURRING' ? 'selected' : ''; ?>>RECURRING</option>
              </select>
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

                    <input type="checkbox" id="BAcustomer" name="BAcustomer" data-val="BAcustomer" <?= ((!empty($evidence[0]))&&($evidence[0]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAcustomer">BA Customer / BA Format Standar</label>

                    <input type="checkbox" id="BAperformansi" name="BAperformansi" data-val="BAperformansi" <?= ((!empty($evidence[1]))&&($evidence[1]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAperformansi">BA Performansi (Untuk layanan berbasis SLG)</label>

                    <input type="checkbox" id="BArekonsiliasi" name="BArekonsiliasi" data-val="BArekonsiliasi" <?= ((!empty($evidence[2]))&&($evidence[2]!= ' ')) ? 'checked' : '';  ?>  >
                    <label for="BArekonsiliasi">BA Rekonsiliasi (Untuk layanan Transaksional berbasis rekon)</label>

                    <input type="checkbox" id="BAprogress" name="BAprogress" data-val="BAprogress" <?= ((!empty($evidence[3]))&&($evidence[3]!= ' ')) ? 'checked' : '';  ?> >
                    <label for="BAprogress" >BAPP (BA Progress Pekerjaan)</label>

                    <input type="checkbox" id="BAketerlambatan" name="BAketerlambatan" data-val="BAketerlambatan" <?= ((!empty($evidence[4]))&&($evidence[4]!= ' ')) ? 'checked' : '';  ?>  >
                    <label for="BAketerlambatan" >BA Keterlambatan</label>
                  
                  </div>          
               </div>
               </div>

           </div> 

          <div class="form-group">
            <label for="name">Project Manager</label>
            <input type="hidden" class="form-control" id="pm_name" name="pm_name" val="<?= !empty($bast['NAMA_PM']) ? $bast['NAMA_PM'] : ''; ?>">
            <select style="width: 100%;" name="pm" id="pm" class="form-control">
                <option val="<?= !empty($bast['NIK_PM']) ? $bast['NIK_PM'] : ''; ?>"><?= !empty($bast['NIK_PM']) ? $bast['NAMA_PM'] : ''; ?></option>
            </select>
          </div>

          <div class="form-group ">
            <label>Email PIC Partner / Subsidiary *</label>
            <input type="hidden" class="form-control" id="email_pic_partner2" name="email_pic_partner2">
            <select style="width: 100%;" name="email_pic_partner" id="email_pic_partner" class="form-control" val="<?= !empty($bast['EMAIL_MITRA']) ? $bast['EMAIL_MITRA'] : ''; ?>" required>
                <option val="<?= !empty($bast['EMAIL_MITRA']) ? $bast['EMAIL_MITRA'] : ''; ?>" ><?= !empty($bast['EMAIL_MITRA']) ? $bast['EMAIL_MITRA'] : ''; ?></option>
            </select>
          </div>

          <div class="form-group" id="c_pic_partner">
            <label>PIC Partner / Subsidiary *</label>
             <input type="text" class="form-control" id="pic_partner" name="pic_partner" placeholder="PIC Partner / Subsidiary"  value="<?= !empty($bast['PIC_MITRA']) ? $bast['PIC_MITRA'] : ''; ?>">
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

      <div class="row m-top-3">
        <div class="col-sm-12">
          <div class="form-group ">
            <label><span class="text-primary">Document Status</span></label>
            <div class="input-group">
              <select name="status" id="status" class="form-control text-primary" style="height: inherit;">
                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='RECEIVED') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY ADM" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY ADM') ? ' selected' : '' ?> >CHECK BY ADM</option>
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='TAKE OUT (REV)') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="REVISIONED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='RECEIVED') ? ' selected' : '' ?> >RECEIVED</option>
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='REVISIONED') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY ADM" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY ADM') ? ' selected' : '' ?> >CHECK BY ADM</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY ADM') :  ?>\
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY ADM" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY ADM') ? ' selected' : '' ?> >CHECK BY ADM</option>  


                   
                    <?php if($bast['PENANDA_TANGAN'] =='Senior Expert Delivery and Integration') :  ?>
                        <option value="CHECK BY SE DI" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE DI') ? ' selected' : '' ?> >CHECK BY SE DI</option>
                    <?php else : ?>
                        <option value="CHECK BY SE PMO" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO') ? ' selected' : '' ?> >CHECK BY SE PMO</option>
                    <?php endif; ?>
                    
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO' && ( $bast['PENANDA_TANGAN'] =='Senior Expert Project Management Office 1' || $bast['PENANDA_TANGAN'] =='Senior Expert Project Management Office 1' )) :   ?>  
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY SE PMO" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO') ? ' selected' : '' ?> >CHECK BY SE PMO</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>  
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO' && ( $bast['PENANDA_TANGAN'] =='Senior Expert Project Management Office 2' || $bast['PENANDA_TANGAN'] =='Senior Expert Project Management Office 2' )) :   ?>  
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY SE PMO" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO') ? ' selected' : '' ?> >CHECK BY SE PMO</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>  
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE DI' && $bast['PENANDA_TANGAN'] =='Senior Expert Delivery and Integration') :   ?> 
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY SE DI" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE DI') ? ' selected' : '' ?> >CHECK BY SE DI</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>  
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO' &&  $bast['PENANDA_TANGAN'] =='Coordinator Project Management') :   ?> 
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY SE PMO" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE PMO') ? ' selected' : '' ?> >CHECK BY SE PMO</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>  
                    <option value="CHECK BY COORD" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE COORD') ? ' selected' : '' ?> >CHECK BY COORD</option> 
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE DI' &&  $bast['PENANDA_TANGAN'] =='Coordinator Project Management') :   ?>  
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY SE DI" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE DI') ? ' selected' : '' ?> >CHECK BY SE DI</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>  
                    <option value="CHECK BY COORD" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE COORD') ? ' selected' : '' ?> >CHECK BY COORD</option> 
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 


                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY COORD') :  ?>  
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY COORD" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY SE COORD') ? ' selected' : '' ?> >CHECK BY COORD</option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>    
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?> 

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="APPROVED" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='APPROVED') ? ' selected' : '' ?> >APPROVED</option>
                    <option value="DONE" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='DONE') ? ' selected' : '' ?> >DONE</option>
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?>

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='DONE') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="DONE" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='DONE') ? ' selected' : '' ?> >DONE</option>
                    <option value="TAKE OUT" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='TAKE OUT') ? ' selected' : '' ?> >TAKE OUT</option>
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?>

                    
                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="CHECK BY ADM" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='CHECK BY ADM') ? ' selected' : '' ?> >CHECK BY ADM</option>
                    <option value="TAKE OUT (REV)" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='TAKE OUT') ? ' selected' : '' ?> >TAKE OUT</option>
                    <?php endif; ?>

                    <?php if(!empty($bast['STATUS'])&&$bast['STATUS']=='TAKE OUT') :  ?>
                    <option value="<?= $bast['STATUS']; ?>" style="color:#000 !important;"><?= $bast['STATUS']; ?></option>
                    <option value="REVISION" <?= (!empty($bast['STATUS'])&&$bast['STATUS']=='REVISION') ? ' selected' : '' ?> >REVISION</option>
                    <?php endif; ?>
              </select>
              <span class="input-group-append">
                <button class="btn btn-success" id="btnUpdateBAST" type="button">
                   &nbsp; Update
                </button>
              </span>
            </div>
          </div>
        </div>
      </div>

     
    </form>

    <div class="row">
      <div class="col-sm-12">

          <?php if(!empty($history)) : ?>
            <!-- Timeline -->
            <div id="timeline">
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
     <?php if(!empty($bast['FILENAME_URI'])) : ?>
              $("#document").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/<?= $bast['FILENAME_URI']; ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/<?= $bast['FILENAME_URI']; ?>", downloadUrl: false,caption : "<?= $bast['FILENAME']; ?>"}, 
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
              tableInit();dTypeBast($('#type_bast').val());


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

              $(document).on('change','#status',function(e){
                    e.stopImmediatePropagation();
                    if($('#status').val()=='DONE'){
                      $('#c_document').removeClass('hidden');
                      $('#document').fileinput({
                        initialPreview  : false,
                        showUpload      : false,
                        uploadAsync     : false,
                        showUpload      : false,
                        autoReplace: true,
                        maxFileCount: 1,
                      }); 
                    }
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
                  spkCheck();
              });

              $(document).on('change','#partner',function(e){
                  var val  = $('#partner').val();
                  var sval = val.split("||");

                  $('#partner_id').val(sval[0]);
                  $('#partner_name').val(sval[1]);
                  spkCheck();
              });
               

              $(document).on('change','#spk',function(e){
                    var data = $("#spk").select2('data')[0];
                    cekSPK    = data.text.substring(0, 4);
                    if(cekSPK != 'TEL.'){
                      $('#wSPK').html("make sure you've type correct SPK");
                    }else{
                      $('#wSPK').html("");
                    }
                    $('#project_name').val(data.title);
              });

              $(document).on('change','#pm',function(e){
                    var data = $("#pm").select2('data')[0];
                    $('#pm_name').val(data.text);
              });


              $(document).on('click','#btnUpdateBAST',function(e){
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
                                                  url: base_url+'bast/updateBast',
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
          

            $('input, textarea, select, .select2-selection').css('background','#b1ffa1');
            $('#status').css('background','#edff11');
          }
      }

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>