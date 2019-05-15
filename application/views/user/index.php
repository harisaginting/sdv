<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> Users</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>user/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Add User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>



<div class="container-fluid container-content"> 

<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2">
    <select id="type_users" name="type_users" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
        <option value="">All Type</option>
        <option value="AM">Account Manager</option>
        <option value="ADMIN_BAST">Admin BAST</option>
        <option value="ADMIN_PROJECT">Admin Project</option>
        <option value="PROJECT_MANAGER">Project Manager</option>
        <option value="SUBSIDIARY">Subsidiary</option>
        <option value="ADMIN_WEB">Administrator</option>
        <option value="GUEST">Guest</option>
        <option value="SUBSIDIARY">Subsidiary</option>
    </select>
  </div>

  <?php  
    $user_regional=  $this->session->userdata('regional');
    if($user_regional == '0' || empty($user_regional)): 
  ?>

  <div class="float-right col-sm-2">
    <select id="user_regional" name="user_regional" class="form-control form-control-sm Jselect2 Jselect2Active searchOnTable">
    <option value="">All Regional</option>
    <option value="x">HO</option>
    <option value="1">Regional 1</option>
    <option value="2">Regional 2</option>
    <option value="3">Regional 3</option>
    <option value="4">Regional 4</option>
    <option value="5">Regional 5</option>
    <option value="6">Regional 6</option>
    <option value="7">Regional 7</option>
    </select>
  </div>
  <?php else:  ?>
    <select id="user_regional" name="user_regional" style="display: none;">
    </select>
  <?php  endif; ?>
  

    


</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataUsers" class="table table-responsive-sm table-striped" style="width: 100%;">
              <thead>
                <tr>
                  <th style="min-width: 10% !important">ID</th>
                  <th style="min-width: 30% !important">Name</th>
                  <th style="min-width: 10% !important">Category</th>
                  <th style="min-width: 20% !important">E-mail</th>
                  <th style="min-width: 20% !important">Phone</th>
                  <th style="min-width: 10% !important">Regional</th>
                  <th></th>
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
    var tableInit = function(){    

        var table = $('#dataUsers').DataTable({
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
                                $('.rupiah').priceFormat({
                                    prefix: '',
                                    centsSeparator: ',',
                                    thousandsSeparator: '.',
                                    centsLimit: 0
                                });
                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                        'url'  :base_url+'user/get_datatables', 
                        'type' :'POST',
                        'data' : {
                                  type  : $('#type_users').val(),
                                  regional : $('#user_regional').val()
                                  }    
                        },
                    aoColumns: [
                                { mData: 'NIK'},
                                { mData: 'NAMA'},
                                { mData: 'TIPE'},
                                { mData: 'EMAIL'},
                                { mData: 'NO_HP'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            if(obj.REGIONAL != null && obj.REGIONAL != 0){
                                              return obj.REGIONAL;
                                            }else{
                                              return 'Head Office';
                                            };   
                                    }            
                                            
                                }, 
                                {
                                    'mRender': function(data, type, obj){
                                         var a = "<a style='font-size:10px;margin-right:1px;' class=\' circle nav-link-hgn btn  btn-success \' href='"+base_url+"user/profile/"+obj.NIK+"' ><i class='glyphicon glyphicon-new-window'/></i></a>";       
                                            return a;
                                    }

                                  } 
                                
                               ],           
                });  
    };    
      return {
          init: function() { 
            tableInit();
            $(document).on('change','.searchOnTable', function (e) {
              e.stopImmediatePropagation();
              $('#dataUsers').dataTable().fnDestroy();
              tableInit();
              });

            $(document).on('click','#select2-spk-container .select2-selection__clear',function(e){
                $('#spk').val(null).trigger('change');
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>