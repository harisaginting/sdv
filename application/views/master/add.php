<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> Add User</li>
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
                  <input type="text" class="form-control" id="user_nik" name="user_nik" placeholder="User NIK" required>
            </div> 

            <div class="form-group">
                  <label for="name">Name *</label>
                  <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name" required>
            </div>

            <div class="form-group">
                  <label for="name">Organization *</label>
                  <select id="user_organization" name="user_organization" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option value="DES">Divisi Enterprise Service</option>
                    <option value="DSS">Divisi Service Solution</option>
                    <option value="SUBSIDIARY">Subsidiary </option>
                </select>
            </div>

            <div class="form-group hidden" id="user_subsidiary_c">
                  <label for="name">Subsidiary *</label>
                  <select style="width: 100%;" name="user_subsidiary" id="user_subsidiary" class="form-control Jselect2" required>
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
                  <label for="name">Priviledge Type *</label>
                  <select id="user_type" name="user_type" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option value="ADMIN_BAST">Admin BAST</option>
                    <option value="ADMIN_DES">Admin DES</option>
                    <option value="ADMIN_PROJECT">Admin Project</option>
                    <option value="ADMIN_WEB">Administrator</option>
                    <option value="AM">Account Manager</option>
                    <option value="PROJECT_MANAGER">Project Manager</option>
                    <option value="GUEST">Guest</option>
                </select>
            </div>

            <div class="form-group">
                  <label for="name">Category *</label>
                  <select id="user_category" name="user_category" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
                    <option value="INTERNAL">Internal</option>
                    <option value="EXTERNAL">External</option>
                </select>
            </div>

            <div id="user_band_c" class="form-group hidden">
                  <label for="name">BAND </label>
                  <select id="user_band" name="user_band" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                        <option value="">Undefined</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="J PM EXT">Junior Project Manager Eksternal</option>
                        <option value="PM EXT">Project Manager Eksternal</option>
                        <option value="SE PM EXT">Senior Expert Project Manager Eksternal</option>
                        <option value="SEPMO">Senior Expert Project Manager Officer</option>
                  </select>
            </div>         
          </div>

          <div class="col-md-6">
            <div class="form-group">
                  <label for="name">Phone *</label>
                  <input type="number" class="form-control" id="user_phone" name="user_phone" placeholder="Phone Number" required>
            </div>

            <div class="form-group">
                  <label for="name">Email *</label>
                  <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" required>
            </div>

            <div class="form-group">
                  <label for="name">Password *</label>
                  <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
            </div>

            <div class="form-group">
                  <label for="name">Confirm Password *</label>
                  <input type="password" class="form-control" id="user_password_re" name="user_password_re" placeholder="Repeat Password" required>
            </div>

            <div class="form-group">
                  <label for="name">Regional *</label>
                  <select id="user_regional" name="user_regional" class="form-control form-control-sm Jselect2"  style="width: 100%;" required>
                        <option value="1">Regional 1</option>
                        <option value="2">Regional 2</option>
                        <option value="3">Regional 3</option>
                        <option value="4">Regional 4</option>
                        <option value="5">Regional 5</option>
                        <option value="6">Regional 6</option>
                        <option value="7">Regional 7</option>
                  </select>
            </div>

          </div>


        </div>
        </form>
        <button type="button" id="user_add_btn" class="btn btn-block btn-success">Create User Account</button>
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

              $('body').on('change','#user_type',function(e){
                    var user_type = $("#user_type").select2('data')[0].id;
                    if(user_type == 'PROJECT_MANAGER'){
                      $('#user_band_c').removeClass('hidden');
                    }else{
                      $('#user_band_c').addClass('hidden');
                    }
              });

              $('body').on('change','#user_organization',function(e){
                    var user_organization = $("#user_organization").select2('data')[0].id;
                    if(user_organization == 'SUBSIDIARY'){
                      $('#user_subsidiary_c').removeClass('hidden');
                    }else{
                      $('#user_subsidiary_c').addClass('hidden');
                    }
              });


              $(document).on('click','#user_add_btn', function (e) {
                e.stopImmediatePropagation();

                if($('#frmAddUser').valid()){
                    $('#pre-load-background').fadeIn();
                    var form = $('form')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'user/save_add',
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
                                        setPage(base_url+"user/add");
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