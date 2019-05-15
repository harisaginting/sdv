
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
  <small>Select Subsidary / Partner </small>
  </div>
  <div class="card-body">
    <form id="formBast" method="post" action="<?=base_url();?>bast/add">
      <div class="row">
      <div class="offset-md-3 col-sm-6">
          <div class="form-group">
            <label for="name">Subsidiary / Partner *</label>
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
          
      </div>
      </div>

      <div class="row m-top-30">
        <div class="col-sm-12">
          <div class="col-sm-2 offset-sm-5">
              <button class="btn btn-success btn-addon" id="btnSubmitBAST" type="button"><i class="fa fa-angle-double-right"></i>
               &nbsp; Next
              </button>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>
</div>

</div>


<script type="text/javascript">
  
  $(document).on('click','#btnSubmitBAST',function(e){
                  var val  = $('#partner').val();
                  
                  if(val != null){
                    var sval = val.split("||");
                    $('#partner_id').val(sval[0]);
                    $('#partner_name').val(sval[1]);
                    console.log(sval[0]);
                    console.log(sval[1]);
                    $('#formBast').submit();
                  }else{
                    alert('Please select Subsidiary or Partner!');
                  }


              });

</script>