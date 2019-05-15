<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>master/subsidiary"> Subsidiary</li>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataSubsidiary" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="max-width: 5% !important">ID</th>
                  <th style="max-width: 50% !important">NAME</th>
                  <th style="max-width: 35% !important">EMAIL</th>
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
    var editemail= function(id,email){
        var url = base_url+"master/update_email_subsidiary";
        bootbox.prompt({
            title: "Edit Parner E-Mail<span style='font-size:12px;font-style:italic;font-weight:50px;' class='text-danger'> please separate each email with semicolumn ';'</span>",
            placeholder : 'email PIC',
            inputType: 'text',
            value:email,
            buttons: {
                    cancel: {
                        label: 'No',
                        className: 'btn-danger col-md-offset-4 col-md-2'
                    },
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success col-md-2'
                    }
            },
            callback: function (result) {
                if(result!=null){
                    $.ajax({
                        url: url+"?id="+id+"&email="+result,
                        dataType: 'json',
                        method: 'get'
                    });
                    $('#dataSubsidiary').dataTable().fnDestroy();
                    tableInit();
                    
                }
            }
        });
    };



    var tableInit = function(){    
        var table = $('#dataSubsidiary').DataTable({
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
                        'url'  :base_url+'master/get_datatables_subsidiary', 
                        'type' :'POST',
                        'data' : {
                                  type  : $('#type_users').val(),
                                  }    
                        },
                    aoColumns: [
                                { mData: 'KODE_PARTNER' },
                                { mData: 'NAMA_PARTNER' },
                                { mData: 'EMAIL_PARTNER' },
                                {
                                    'mRender': function(data, type, obj){
                                         var a = 
                                            "<span style='font-size:10px;margin-right:1px;' class=' circle btn  btn-success btn_add_pic_subsidiary' data-id='"+obj.KODE_PARTNER+"' data-email='"+obj.EMAIL_PARTNER+"' ><i class='fa fa-edit'/></i></span>";       
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
              $('#dataSubsidiary').dataTable().fnDestroy();
              tableInit();
              });

            $(document).on('click','#select2-spk-container .select2-selection__clear',function(e){
                $('#spk').val(null).trigger('change');
              });

            $('body').on('click','.btn_add_pic_subsidiary',function(e){
                    var id =  $(this).data('id');
                    var email =  $(this).data('email');
                    editemail(id,email);  
                });


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });      


           
</script>