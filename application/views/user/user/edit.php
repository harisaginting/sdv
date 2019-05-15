<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> Edit User</li>
</ol>



<div class="container-fluid container-content">

<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="card mx-4">
      <div class="card-body p-4">
        
        <form method="POST" enctype="multipart/form-data" id="frmAddUser">
        <div class="row">
          
          <div class="col-md-6">
            <div class="form-group">
                  <label for="name">NIK *</label>
                  <input type="text" class="form-control" id="user_nik" name="user_nik" placeholder="User NIK" value="<?= $user['NIK']; ?>" required readOnly>
            </div> 

            <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" value="<?= $user['NAMA']; ?>" required>
            </div>

            <div class="form-group">
                  <label for="name">Organization *</label>
                  <select id="user_organization" name="user_organization" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option <?= $user['DIVISI']=="DES"? 'selected' : '' ; ?> value="DES">Divisi Enterprise Service</option>
                    <option <?= $user['DIVISI']=="DSS"? 'selected' : '' ; ?> value="DSS">Divisi Service Solution</option>
                    <option <?= $user['DIVISI']=="SUBSIDIARY"? 'selected' : '' ; ?>value="SUBSIDIARY">Subsidiary </option>
                </select>
            </div>

            <div class="form-group hidden" id="user_subsidiary_c">
                  <label for="name">Subsidiary *</label>
                  <select style="width: 100%;" name="user_subsidiary" id="user_subsidiary" class="form-control Jselect2" required>
                      <option disabled selected>Select Partner</option>    
                              <?php 
                      foreach ($list_partner as $key => $value) {
                          ?>
                              <option <?= $user['MITRA'] == $list_partner[$key]['KODE_PARTNER'] ? 'selected' : ''; ?> value="<?=$list_partner[$key]['KODE_PARTNER']; ?>"><?=$list_partner[$key]['NAMA_PARTNER']?></option>
                          <?php
                              }
                          ?> 
                  </select>
            </div>

            <div class="form-group">
                  <label for="name">Priviledge Type **</label>
                  <?php if($this->auth->get_access_value('USERS')>2) : ?>
                  <select id="user_type" name="user_type" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option <?= $user['TIPE']=="ADMIN_BAST"? 'selected' : '' ; ?> value="ADMIN_BAST">Admin BAST</option>
                    <option <?= $user['TIPE']=="ADMIN_DES"? 'selected' : '' ; ?> value="ADMIN_DES">Admin DES</option>
                    <option <?= $user['TIPE']=="ADMIN_PROJECT"? 'selected' : '' ; ?> value="ADMIN_PROJECT">Admin Project</option>
                    <option <?= $user['TIPE']=="ADMIN_WEB"? 'selected' : '' ; ?> value="ADMIN_WEB">Administrator</option>
                    <option <?= $user['TIPE']=="AM"? 'selected' : '' ; ?> value="AM">Account Manager</option>
                    <option <?= $user['TIPE']=="GUEST"? 'selected' : '' ; ?> value="GUEST">Account Manager</option>
                    <option <?= $user['TIPE']=="PROJECT_MANAGER"? 'selected' : '' ; ?> value="PROJECT_MANAGER">Project Manager</option>
                    <option <?= $user['TIPE']=="GUEST"? 'selected' : '' ; ?> value="GUEST">Guest</option>
                </select>
                <?php else : ?>
                    <input type="text" name="user_type" id="user_type" value="<?= $user['TIPE']; ?>" class="form-control" readOnly>
                <?php  endif; ?>
            </div>

            <div class="form-group">
                  <label for="name">Category *</label>
                  <select id="user_category" name="user_category" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option <?= $user['KATEGORI']=="INTERNAL"? 'selected' : '' ; ?> value="INTERNAL">Internal</option>
                    <option <?= $user['KATEGORI']=="EXTERNAL"? 'selected' : '' ; ?> value="EXTERNAL">External</option>
                </select>
            </div>

            <div id="user_band_c" class="form-group  <?= !empty($user['BAND'])? '' : 'hidden' ; ?> ">
                  <label for="name">BAND </label>
                  <select id="user_band" name="user_band" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                        <option <?= $user['BAND'] == '' ? 'selected' : '' ; ?> value="">Undefined</option>
                        <option <?= $user['BAND'] == 'III' ? 'selected' : '' ; ?> value="III">III</option>
                        <option <?= $user['BAND'] == 'IV'  ? 'selected' : '' ; ?> value="IV">IV</option>
                        <option <?= $user['BAND'] == 'J PM EXT' ? 'selected' : '' ; ?> value="J PM EXT">Junior Project Manager Eksternal</option>
                        <option <?= $user['BAND'] == 'PM EXT' ? 'selected' : '' ; ?> value="PM EXT">Project Manager Eksternal</option>
                        <option <?= $user['BAND'] == 'SE PM EXT' ? 'selected' : '' ; ?> value="SE PM EXT">Senior Expert Project Manager Eksternal</option>
                        <option <?= $user['BAND'] == 'SEPMO' ? 'selected' : '' ; ?> value="SEPMO">Senior Expert Project Manager Officer</option>
                  </select>
            </div>         
          </div>

          <div class="col-md-6">
            <div class="form-group">
                  <label for="name">Phone *</label>
                  <input type="number" class="form-control" id="user_phone" name="user_phone" placeholder="Phone Number" value="<?= !empty($user['NO_HP'])? $user['NO_HP'] : '' ?>" required>
            </div>

            <div class="form-group">
                  <label for="name">Email *</label>
                  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?= !empty($user['EMAIL'])? $user['EMAIL'] : '' ?>" required>
            </div>

            <!-- <div class="form-group">
                  <label for="name">Password *</label>
                  <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
            </div>

            <div class="form-group">
                  <label for="name">Confirm Password *</label>
                  <input type="password" class="form-control" id="user_password_re" name="user_password_re" placeholder="Repeat Password" required>
            </div> -->

            <div class="form-group">
                  <label for="name">Regional *</label>
                  <select id="user_regional" name="user_regional" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                    <?php if($user_regional == 0) : ?>
                      <option <?= $user['REGIONAL'] == '0' ? 'selected' : '' ; ?> value="0">HO</option>
                      <option <?= $user['REGIONAL'] == '1' ? 'selected' : '' ; ?> value="1">Regional 1</option>
                      <option <?= $user['REGIONAL'] == '2' ? 'selected' : '' ; ?> value="2">Regional 2</option>
                      <option <?= $user['REGIONAL'] == '3' ? 'selected' : '' ; ?> value="3">Regional 3</option>
                      <option <?= $user['REGIONAL'] == '4' ? 'selected' : '' ; ?> value="4">Regional 4</option>
                      <option <?= $user['REGIONAL'] == '5' ? 'selected' : '' ; ?> value="5">Regional 5</option>
                      <option <?= $user['REGIONAL'] == '6' ? 'selected' : '' ; ?> value="6">Regional 6</option>
                      <option <?= $user['REGIONAL'] == '7' ? 'selected' : '' ; ?> value="7">Regional 7</option>
                    <?php else :  ?>
                      <option value="<?= $user_regional; ?>">Regional <?= $user_regional; ?></option>
                    <?php endif; ?>
                  </select>
            </div>

          </div>


        </div>
        </form>
        <button type="button" id="user_edit_btn" class="btn btn-block btn-success">Update User Account</button>
      </div>
    </div>
  </div>
</div>

</div>

<script type="text/javascript">    
  var Page = function () {
    var tableInit = function(){    

        
    };    
    
    return {
          init: function() { 
              $('#frmaddUser').validate({
                  rules : {
                      user_password_re : {
                          equalTo : "#user_password"
                      }
                  }
              });


              <?php if($this->auth->get_access_value('USERS')>2) : ?>
              $('body').on('change','#user_type',function(e){
                    var user_type = $("#user_type").select2('data')[0].id;
                    if(user_type == 'PROJECT_MANAGER'){
                      $('#user_band_c').removeClass('hidden');
                    }else{
                      $('#user_band_c').addClass('hidden');
                    }
              });
              <?php endif; ?>

              $('body').on('change','#user_organization',function(e){
                    var user_organization = $("#user_organization").select2('data')[0].id;
                    if(user_organization == 'SUBSIDIARY'){
                      $('#user_subsidiary_c').removeClass('hidden');
                    }else{
                      $('#user_subsidiary_c').addClass('hidden');
                    }
              });


              $(document).on('click','#user_edit_btn', function (e) {
                e.stopImmediatePropagation();

                if($('#frmAddUser').valid()){
                    $('#pre-load-background').fadeIn();
                    var form = $('form')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'user/save_update',
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
                                        setPage(base_url+"user/profile_edit/"+"<?= $user['NIK']; ?>");
                                        });
                                      }else{
                                        bootbox.alert("Failed!", function(){});
                                        }
                                      return result;
                                  } 

                          });
                  }

              });

           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>