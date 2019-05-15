<style type="text/css">
  .label{
    font-size: 12px;
  }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4"> Validation No. Quote AND NO. SO</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>utility/download_validation_wfm" style="" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> 
</ol>
<div class="container-fluid container-content"> 

<div class="row">
  <div class="col-md-6">
      <div class="card">
        <div class="card-body">
            <div class="form-group">
              <label for="id_lop" class="label">Select ID LOP</label>
              <select id="id_lop"  name="id_lop" class="form-control" style="width: 100%;"></select>
            </div> 
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          Detail Project
        </div>
        <div class="card-body" id="container_detail">
          <table id="dataku7" class="table table-responsive-sm " style="width: 100% !important;">
                <tr>
                  <th style="width: 25% !important;">Name</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th  style="width: 25% !important;">Value</th>
                  <th class="rupiah" style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">Segmen</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">Customer</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">Partner</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">PM</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">AM</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
                <tr>
                  <th style="width: 25% !important;">End Date</th>
                  <th style="width: 75% !important;">:</th>
                </tr>
            </table> 
        </div>
      </div>
  </div>

  <div class="col-md-6"> 
      <div class="card">
        <div class="card-header">
          
        </div>
        <div class="card-body" id="project_no">
        </div>
    </div>
  </div>
</div>


</div>


<script type="text/javascript">    
  var Page = function () {  
      var projectInitialize = function($no_p8=null, $id_row = null) {
              $.ajax({  type:"post",
                  async: true,
                  data: { no_p8 : $no_p8, id_row : $id_row},
                  url: base_url+"json/get_detail_project_view",
                  success: function(data) {
                      $('#container_detail').empty();
                      $('#container_detail').append(data);
                      $('.rupiah').priceFormat({
                            prefix: 'Rp. ',
                            centsSeparator: ',',
                            thousandsSeparator: '.',
                            centsLimit: 0
                        });
                  } 
              });

              if($no_p8 != null){
                  $.ajax({  type:"post",
                  async: true,
                  data: { no_p8 : $no_p8, id_row : $id_row},
                  url: base_url+"json/get_detail_qo_so",
                      success: function(data) {
                          $('#project_no').empty();
                          $('#project_no').append(data);
                      }
                  });
              } 
        }; 


      $("#id_lop").select2({
                placeholder: "Select Projects",
                width: 'resolve',
                allowClear : true,
                ajax: {
                    type: 'POST',
                    delay: 200,
                    url:base_url+"json/projects_so",
                    dataType: "json",
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page,
                            customer : $('#customer_id').val(),
                            partner :$('#partner_id').val()
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function(obj) {
                                return { id: obj.NO_P8, text: obj.PROJECT_NAME};
                            })
                        };
                    },
                    
                }
        }); 

      return {
          init: function() {
          var no_p8 = "<?= $no_p8; ?>";
          projectInitialize(no_p8);  
              $('body').on('change','#id_lop, #bast_approved_month',function(e){  
                e.stopImmediatePropagation();
                projectInitialize($('#id_lop').val());                             
            });

          $('body').on( 'click', '#addNo', function () {
                var no_quote  = $('#no_quote').val();
                var no_so     = $('#no_so').val();
                var id_row    = $('#id_row').val();
                var no_spk    = $('#no_spk').val();

                /*if(no_quote==null || no_quote== ""){
                  $('#quote_empty').removeClass('hidden');
                }else{
                  $('#quote_empty').addClass('hidden');
                }*/

                if(no_so==null || no_so==""){
                  $('#so_empty').removeClass('hidden');
                }else{
                  $('#so_empty').addClass('hidden');
                  $.ajax({
                          url: base_url + 'json/addNoQoSo',
                          type:'POST',
                          data:  {no_quote : no_quote , no_so : no_so, no_spk : no_spk, id_row : id_row},
                          success:function(data){
                            $('#project_no').empty();
                            $('#project_no').append(data);
                            // location.reload();
                            return true;
                          }
                  });
                }

                
              

                console.log(no_quote+' / '+no_so);

                
            });


          $('body').on('change','.validateaction',function(e){
              e.stopImmediatePropagation();
                if($(this).is(':checked')){
                        $.ajax({
                            url: base_url+'json/validNoQoSo',
                            type:'POST',
                            data: {no_quote : $(this).data('quote') , no_so : $(this).data('so'),  no_spk : $('#no_spk').val()},
                            success:function(data){
                              $('#project_no').empty();
                              $('#project_no').append(data);
                              // location.reload();
                              return true;
                            }
                        });
                    }
                else{
                    $.ajax({
                            url: base_url+'json/unvalidNoQoSo',
                            type:'POST',
                            data: {no_quote : $(this).data('quote') , no_so : $(this).data('so'), no_spk : $('#no_spk').val()},
                            success:function(data){
                            $('#project_no').empty();
                            $('#project_no').append(data);
                            // location.reload();
                            return true;
                          }
                        });
                  
                  }       

            });                  


          }
      }

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>