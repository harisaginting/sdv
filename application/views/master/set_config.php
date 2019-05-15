<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>
<style type="text/css">
  .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  height: 26px;
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 12px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  height: 26px;
  background-color: #2196F3;
}

input:focus + .slider {
  height: 16px;
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(40px);
  -ms-transform: translateX(40px);
  transform: translateX(40px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> Set Config</li>
</ol>

<div class="container-fluid container-content">

<div class="row ">
  <div class="col-md-6" style="padding-right: 0px;">
    <div class="card mx-4">
      <div class="card-header" style="border-top-right-radius: 0px;border-top-left-radius: 0px;">
        Notification
        </div>
      <div class="card-body p-4">
        
        <form method="POST" enctype="multipart/form-data" id="formNotification" action="<?=base_url();?>master/set_config_notification">
          <div class="col-md-12">
            <div class="form-group">
                  <label>Title *</label>
                  <input type="text" class="form-control" id="title_notification" name="title_notification" placeholder="Title Notification" value="<?= !empty($notification['NAME']) ? $notification['NAME'] : ''; ?>" required>
            </div>

              <div class="form-group">
                    <label>Content *</label>
                    <textarea class="form-control" rows="7" id="content_notification" name="content_notification" placeholder="Content Notification"><?= !empty($notification['VALUE']) ? $notification['VALUE'] : ''; ?></textarea>
              </div>
              <div class="form-group">
                    <label class="input-group">Active / Inactive</label>
                    <label class='switch'>
                      <input class='validateaction'  type='checkbox' name="status_notification" id="status_notification" <?= $notification['ACTIVE'] == 1 ? 'checked' : ''; ?>><span class='slider round'></span>
                    </label>
              </div>
 
          </div>
          <button type="button" id="config_notification_btn" class="btn btn-block btn-success col-md-4 offset-md-4">Save Notification</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-6" style="padding-left: 0px;">
    <div class="card mx-4">
      <div class="card-header" style="border-top-right-radius: 0px;border-top-left-radius: 0px;">
        E-mail
        </div>
      <div class="card-body p-4">
        
        <form method="POST" enctype="multipart/form-data" id="formEmail" name="formEmail" action="<?=base_url();?>master/set_config_email">
          <div class="col-md-12">
            <div class="form-group">
                  <label>Protocol *</label>
                  <input type="text" class="form-control" id="email_protocol" name="email_protocol" placeholder="Email Protocol" value="<?= $email['protocol'] ?>" required>
            </div>

              <div class="form-group">
                    <label>SMTP Host *</label>
                    <input type="text" class="form-control" id="email_host" name="email_host" placeholder="Email Host" value="<?= $email['smtp_host'] ?>" required>
              </div>

              <div class="form-group">
                    <label>SMTP User *</label>
                    <input type="text" class="form-control" id="email_user" name="email_user"  value="<?= $email['smtp_user'] ?>" placeholder="Email Host" required>
              </div>

              <div class="form-group">
                    <label>SMTP Pass *</label>
                    <input type="text" class="form-control" id="email_password" name="email_password" value="<?= $email['smtp_pass'] ?>" placeholder="Email Host" required>
              </div>

              <div class="form-group">
                    <label>Mail Type *</label>
                    <input type="text" class="form-control" id="email_type" name="email_type" value="<?= $email['mailtype'] ?>" placeholder="Email Host" required>
              </div>

          </div>
          <button type="button" id="config_email_btn" class="btn btn-block btn-success col-md-4 offset-md-4">Save Email</button>
        </form>
      </div>
    </div>
  </div>

</div>

</div>

<script type="text/javascript">    
  var Page = function () {  
    
    return {
          init: function() { 
             $(document).on('click','#config_email_btn',function(e){
                            //alert('x');
                            if($('#formEmail').valid()){
                              var myForm = document.getElementById('formEmail');
                              var formData  =new FormData(myForm);
                              console.log(formData);
                              $.ajax({
                                                      url: base_url+'master/set_config_email',
                                                      type:'POST',
                                                      dataType : "json",
                                                      data:  $('#formEmail').serializeArray() ,
                                                      async : true, 
                                                      success:function(result){
                                                        if(result.data=='success'){
                                                        bootbox.alert("Success!", function(){ 
                                                        var url = base_url+"master/config";
                                                        window.location.href = url; 
                                                        });
                                                        }else{
                                                        bootbox.alert("Failed!", function(){ 
                                                        console.log('failed!'); });
                                                        }
                                                      return result;
                                                      }

                                              });
                            }
              }); 


              $(document).on('click','#config_notification_btn',function(e){
                            //alert('x');
                            if($('#formNotification').valid()){
                              var myForm = document.getElementById('formNotification');
                              var formData  = new FormData(myForm);
                              console.log(formData);
                              $.ajax({
                                                      url: base_url+'master/set_config_notification',
                                                      type:'POST',
                                                      dataType : "json",
                                                      data:  $('#formNotification').serializeArray() ,
                                                      async : true, 
                                                      success:function(result){
                                                        if(result.data=='success'){
                                                        bootbox.alert("Success!", function(){ 
                                                        var url = base_url+"master/config";
                                                        window.location.href = url; 
                                                        });
                                                        }else{
                                                        bootbox.alert("Failed!", function(){ 
                                                        console.log('failed!'); });
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