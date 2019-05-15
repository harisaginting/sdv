<script src="<?=base_url()?>assets/plugin/cropit/dist/jquery.cropit.js" type="text/javascript"></script>

<style type="text/css">
  .card{
    /*border-radius: 0px;*/
  }

#accordion > .card, #accordion > .card > .card-header{
  border-radius: 0px;
}

.image-editor {
   text-align: center;
}

.cropit-preview {
  background-color: #f8f8f8;
  background-size: cover;
  border: 5px solid #ccc;
  border-radius: 3px;
  margin-top: 7px;
  width: 250px;
  height: 250px;
   display: inline-block;
}

.cropit-preview-image-container {
  cursor: move;
  background-size: contain;
  /*background-image: url(<?= base_url().'../user_picture/default-profile-picture.png'; ?>);*/
}

.cropit-preview-background {
  opacity: .2;
  cursor: auto;
}

.image-size-label {
  margin-top: 10px;
}

input, .export {
  /* Use relative position to prevent from being covered by image background */
  position: relative;
  z-index: 10;
  display: block;
}

button {
  margin-top: 10px;
}
</style>
<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> Add Post</li>
</ol>

 

<div class="container-fluid container-content">

<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="card mx-4">
      <div class="card-body p-4">
        
        <form method="POST" enctype="multipart/form-data" id="formPost">
        <div class="row">
          
          <div class="col-md-6">
            <div class="form-group">
                  <label for="name">Title *</label>
                  <textarea class="form-control" id="post_title" name="post_title" required></textarea>
            </div> 

            <div class="form-group">
                  <label for="name">People </label>
                  <select class="form-control" id="post_people" name="post_people[]" placeholder="People" multiple="multiple" required></select>
            </div>

            <div class="form-group">
                  <label for="name">Content *</label>
                  <textarea class="form-control" id="post_content" name="post_content" rows="20" required></textarea>
            </div> 
         
          </div>

          <div class="col-md-6">
            <div class="form-group">
                  <label for="name">Point *</label>
                  <input type="number" name="post_point" id="post_point" class="form-control" placeholder="Credit Point" max="100">
            </div>
            <div class="form-group">
                  <label for="name">Date *</label>
                  <input type="text" name="post_date" id="post_date" class="form-control date-picker" placeholder="MM/DD/YYYY" value="<?= date('m/d/Y') ?>" readonly>
            </div>

            <div class="form-group">
                  <label for="name">Picture *</label>
                  <div class="image-editor">
                     <input id="input_foto_profile" type="file" class="cropit-image-input hidden">
                     <div class="cropit-preview"></div>
                     <input type="range" class="cropit-image-zoom-input" style="width: 100%;">
                  </div>
                  <div style="width:100%;margin-top: 10px;">
                  <span class=" h4 btn btn-info " id="post_select_image">    <i class="fa fa-plus"></i> Select Image</span>
                  <span class=" h4 btn btn-success" id="post_upload_foto" > <i class="fa fa-upload"></i> Upload Foto</span>
              </div>
            </div>


          </div>


        </div>
        <button type="button" id="submitPost" class="btn btn-block btn-success center col-md-2 offset-md-5" >Submit Post</button>
        </form>
        
      </div>
    </div>
  </div>
</div>

</div>

<script type="text/javascript">    
  var Page = function () {
        $(document).on('click','#post_select_image', function (e) {
              e.stopImmediatePropagation();
              $('#input_foto_profile').click();
              });   


           $('.image-editor').cropit({
              exportZoom: 1.25,
              imageBackground: true,
              imageBackgroundBorderWidth: 50,
            });


           $('#submitPost').click(function(e) {
               e.stopImmediatePropagation();
                var image = $('.image-editor').cropit('export', {
                    type: 'image/jpeg',
                    quality: .9,
                    originalSize: true
                      });
               var dataf = $('#formPost').serializeArray();
                if($('#formPost').valid()){
                  $.ajax({
                          type: "POST",
                          url: base_url+"timeline/savePost",
                          data: { 
                             profile_picture : image, data : dataf
                          },
                          success: function(json) {
                            if(json.data == 'success'){
                              location.reload();
                            }
                          }
                        }).done(function() {
                        }); 
                }
                
            });
    
    return {
          init: function() { 
              $("#post_people").select2({
                    placeholder: "PIC",
                    width: 'resolve',
                    //tags:true,
                    ajax: {
                        type: 'POST',
                        url:base_url+"json/get_json_users",
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
                                    return { id: obj.NIK, text: obj.NAMA };
                                })
                            };
                        },
                        
                    }
            }); 
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>