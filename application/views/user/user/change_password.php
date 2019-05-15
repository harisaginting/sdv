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
  <div class="col-md-6">
    <div class="card mx-4">
      <div class="card-body p-4">
        
        <form method="POST" enctype="multipart/form-data" id="frmUserChangePassword">
        <div class="row">
          
          <div class="col-md-12">
            <div class="form-group">
                  <label for="name">Current Password *</label>
                  <input type="password" class="form-control" id="user_current_password"  name="user_current_password" placeholder="Old Password" required>
            </div>

            <div class="form-group">
                  <label for="name">New Password *</label>
                  <input type="password" class="form-control" id="user_new_password" name="user_new_password" placeholder="Password" required>
            </div>

            <div class="form-group">
                  <label for="name">Confirm New Password *</label>
                  <input type="password"   class="form-control" id="user_new_password_re" name="user_new_password_re" placeholder="Repeat Password" required>
            </div>      
          </div>


        </div>
        </form>
        <button type="button" id="user_change_password_btn" class="btn btn-block btn-success">Change Password</button>
      </div>
    </div>
  </div>
</div>

</div>

<script type="text/javascript">   
  $('#frmUserChangePassword').validate({
                  /*onkeyup: false,
                  onfocusout: false,*/
                  rules : {
                    user_new_password_re :{
                      equalTo : "#user_new_password"
                    },
                    user_current_password :{
                      checkPassword : true
                    }
                  } 
              });

  var Page = function () {
    var tableInit = function(){    

        
    };    
    
    return {
          init: function() { 

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


              $(document).on('click','#user_change_password_btn', function (e) {
                e.stopImmediatePropagation();
                if($('#frmUserChangePassword').valid()){
                    $('#pre-load-background').fadeIn();
                    var form = $('form')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'user/save_change_password',
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
                                        bootbox.alert("Success change password!", function(){ 
                                        window.location.href = base_url+"user/profile/"+"<?= $nik; ?>";
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