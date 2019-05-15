
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

<div class="col-sm-6 offset-sm-3">
  <div class="card">
  <div class="card-header">
  <strong><?= $partner_name; ?></strong>
  <small>Form</small>
  </div>
  <div class="card-body">
    <form id="formBast">
      <div class="row">

      <div class="col-sm-12">
          <div class="form-group hidden">
            <label for="name">Partner *</label>
            <input type="hidden" name="partner_id" id="partner_id" value="<?= $partner_id; ?>">
            <input type="hidden" name="partner_name" id="partner_name" value="<?= $partner_name; ?>">
          </div>

          <div class="form-group">
            <label for="name">Nama Pendanda Tangan Mitra</label>
            <input type="text" class="form-control" id="nama_signer_mitra" name="nama_signer_mitra" placeholder="Nama Penanda Tangan BAST dari sisi Mitra">
          </div>
            
          <div class="form-group">
            <label for="name">Jabatan Peananda Tangan Mitra</label>
            <input type="text" class="form-control" id="jabatan_signer_mitra" name="nama_signer_mitra" placeholder="Nama Penanda Tangan BAST dari sisi Mitra">
          </div>

      </div>

      </div>

      <div class="row m-top-30">
        <div class="col-sm-12">
          <div class="col-sm-4 offset-sm-4">
              <button class="btn btn-success btn-addon" id="btnSubmitBAST" type="button"><i class="fa fa-plus"></i>
               &nbsp; Download
              </button>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
</div> s

</div>