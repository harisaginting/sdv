<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>master/am"> Account Manager</li>
<div class="col-md-10">  
  <div class="pull-right">
      <button class="btn btn-success btn-addon" data-toggle="modal" data-target="#modalAm_cc"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Add Mapping AM - CC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </button>
  </div>
</div>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataAm_cc" class="table table-responsive-sm" style="width: 100%;">
              <thead>
                <tr>
                  <th style="min-width: 30% !important">NAME</th>
                  <th style="min-width: 15% !important">NIK</th>
                  <th style="min-width: 30% !important">CC</th>
                  <th style="min-width: 10% !important">NIPNAS</th>
                  <th style="min-width: 5% !important"></th>
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




<!-- Modal Add Mapping AM CC-->
<div class="modal fade" id="modalAm_cc" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Add Data Mapping AM CC</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
            <hr>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="inputNik">NIK - NAME AM</label>
                      <select name="am_cc_nik" id="am_cc_nik" class="form-control Jselect2" required="required" style="width:100%;">
                      <option value=""></option>
                        <?php foreach ($list_am as $am): ?>
                            <option value="<?=$am['NIK']?>||<?=$am['NAME']?>"><?=$am['NAME']?></option>
                      <?php endforeach; ?>  
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputNipnas">NIPNAS - STANDARD NAME</label>
                    <select name="am_cc_nipnas" id="am_cc_nipnas" class="form-control Jselect2" required="required" style="width:100%;">
                        <option value=""></option>
                        <?php foreach ($list_customer as $cc): ?>
                            <option value="<?=$cc['NIP_NAS']?>||<?=$cc['STANDARD_NAME']?>"><?=$cc['STANDARD_NAME']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
              
                <div class="modal-footer">
                   <button type="button" class="btn btn-danger btn-sm col-md-offset-4 col-md-2" data-dismiss="modal">Close</button>
                    <button type="button" id="am_cc_btn_add" class="btn btn-success btn-sm col-md-2">Save changes</button>
                  </div>
            </form>
      </div>
    </div>
  </div>
</div>





<script type="text/javascript">    
  var Page = function () {
    var am_cc_add = function(id,cc){
        var url = base_url+"master/add_am_cc";
        $.ajax({
            url: url+"?am="+id+"&cc="+cc,
            method: 'get',
            dataType : "json",
            success:function(result){
                    $('#pre-load-background').fadeOut();
                     if(result.data.trim()=='success'){
                      bootbox.alert("Success!", function(){ 
                      bootbox.hideAll();
                      $('#modalAm_cc').fadeOut();
                      window.location.reload();
                      });
                    }else{
                      bootbox.alert("Failed!", function(){});
                      }
                    return result;
                    }
        });
        
    };



    var tableInit = function(){    

        var table = $('#dataAm_cc').DataTable({
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
                         MergeCommonRows($('#dataAm_cc'));        
                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                        'url'  :base_url+'master/get_datatables_am', 
                        'type' :'POST',
                        'data' : {
                                  type  : $('#type_users').val(),
                                  }    
                        },
                    aoColumns: [
                                { mData: 'NAMA_AM'},
                                { mData: 'NIK'},
                                { mData: 'NAMA_CC'},
                                { mData: 'NIPNAS'},   
                                {
                                    'mRender': function(data, type, obj){
                                         var a = "<span style='font-size:10px;margin-right:1px;' class=' circle btn btn-danger btn_delete_am_cc' data-nik='"+obj.NIK+"' data-nipnas='"+obj.NIPNAS+"' ><i class='fa fa-trash'/></i></span>";       
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
              $('#dataAm_cc').dataTable().fnDestroy();
              tableInit();
              });

            $(document).on('click','.btn_delete_am_cc',function(e){
                e.stopImmediatePropagation();
                e.preventDefault();
                var nik = $(this).data('nik');
                var nipnas = $(this).data('nipnas');
                bootbox.confirm({
                    message: "Delete this mapping AM to CC?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if(result){
                          $.ajax({
                                  url: base_url+'master/delete_am_cc?nik='+nik+'&nipnas='+nipnas,
                                  async : true,
                                  contentType:false,
                                  processData:false,
                                  dataType: 'json',
                                  success:function(result){
                                  $('#pre-load-background').fadeOut();
                                  console.log(result);
                                   if(result.data=='success'){
                                    bootbox.alert("Success!", function(){ 
                                    $('#dataAm_cc').dataTable().fnDestroy();
                                    tableInit();
                                    bootbox.hideAll();
                                    });
                                  }else{
                                    bootbox.alert("Failed!", function(){});
                                    }
                                  return result;
                                  }

                          });
                        }
                    }
                }); 
              });

            $('body').on('click','#am_cc_btn_add',function(e){
                e.stopImmediatePropagation();
                    var nik    =  $('#am_cc_nik').val();
                    var cc     =  $('#am_cc_nipnas').val();
                    am_cc_add(nik,cc);  
                });

           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });      



function MergeCommonRows(table) { 
    var firstColumnBrakes = [];
    // iterate through the columns instead of passing each column as function parameter:
    for(var i=1; i<=table.find('th').length-1; i++){
        var previous = null, cellToExtend = null, rowspan = 1;
        table.find("td:nth-child(" + i + ")").each(function(index, e){
            var jthis = $(this), content = jthis.text();
            // check if current row "break" exist in the array. If not, then extend rowspan:
            if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1) {
                // hide the row instead of remove(), so the DOM index won't "move" inside loop.
                jthis.addClass('hidden');
                cellToExtend.attr("rowspan", (rowspan = rowspan+1));
            }else{
                // store row breaks only for the first column:
                if(i === 1) firstColumnBrakes.push(index);
                rowspan = 1;
                previous = content;
                cellToExtend = jthis;
            }
        });
    }
    // now remove hidden td's (or leave them hidden if you wish):
    $('td.hidden').remove();
}

           
</script>