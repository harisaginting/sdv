<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2"><a class="text-dark" href="<?= base_url(); ?>timeline/post">Credit Point</a></li>
<div class="col-md-10">  
</div>
</ol>
<div class="container-fluid container-content">

<div class="col-md-6 offset-md-3">
<div class="card border-primary">


<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="datakuPoint" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 60% !important;">User</th>
                  <th style="width: 40% !important;">Point</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
        </div> 
</div>
</div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {       
          var TableInitialize = function() {                  
                $('#datakuPoint').DataTable({
                     initComplete: function(settings, json) {
                     var input = $('.dataTables_filter input').unbind(),
                                    self = this.api(),
                                    $searchButton = $('<button>')
                                               .text('search')
                                               .addClass('btn btn btn-success mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn btn-info mb-2')
                                               .click(function() {
                                                  input.val('');
                                                  $searchButton.click(); 
                                               }) 
                                $('.dataTables_filter').append($searchButton,$clearButton);
                    },
                    processing: true,
                    serverSide: true,
                    order : [ 1, 'desc' ],
                    ajax: { 
                      'url'   :base_url+'timeline/get_list_point', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    }, 
                    aoColumns: [
                        { 
                            'mRender': function(data, type, obj){   
                                    var photo = obj.PHOTO_URL;
                                    if(photo == '' || photo == null || photo == undefined|| photo == 'null'){
                                      photo = 'https://prime.telkom.co.id/user_picture/default-profile-picture.png';
                                    }else{
                                      photo  = base_url + photo;
                                    }
                                    return "<a href='"+base_url+"user/profile/"+obj.NIK+"'><img src="+photo+" class='img-avatar' alt='<?= $this->session->userdata('nama_sess')?>' height='50'>"+
                                    "<br><span class=''> "+obj.NAMA+"</span><br><span class='h6' >"+obj.NIK+"</span></a>";   
                            }            
                                    
                        },
                        { 
                            'mRender': function(data, type, obj){   
                                    console.log(obj.TPOINT);
                                    if(obj.TPOINT == null || obj.TPOINT == '' || obj.TPOINT == undefined || obj.TPOINT == 'null'){
                                      return "<span style='text-align: center !important;'>0</span> ";
                                    }else{
                                      return "<span style='text-align: center !important;'>"+obj.TPOINT+"</span> ";
                                    }
                            }            
                                    
                        }, 
                       ],        
                });         
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#datakuPoint').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>