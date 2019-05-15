<style type="text/css">
  table.dataTable td, table.dataTable th{
    border : 0.5px solid #758287;
  }

  .select2-container .select2-selection{
    background-color: #dfdfdf !important;
  }

  .select2-selection__rendered{
    color: #300 !important;
  }
</style>
<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/candidate"> 
  <span class="judul">Projects Candidate</span>
</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; ADD PROJECT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
  <div style="margin-right: 20px;" class="pull-right">
      <a href="<?= base_url(); ?>projects/download_list_candidate_projects" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; DOWNLOAD &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">
<div class="card-header">
List Projects Candidate

  
  <div class="float-right col-sm-2">
    <select id="source_project" name="source_project" class="form-control form-control-sm Jselect2">
    <option value="">All Source</option>
    <option value="LOP">LOP</option>
    <option value="NON-LOP">NON-LOP</option> 
    </select>
  </div>

</div> 

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataku" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>PROJECT NAME</th>
                  <th>CUSTOMER</th>
                  <th>PARTNER</th>
                  <th>VALUE(IDR)</th>
                  <th>SOURCE</th>
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
          var TableInitialize = function() {                  
                $('#dataku').DataTable({
                     initComplete: function(settings, json) {
                     var input = $('.dataTables_filter input').unbind(),
                                    self = this.api(),
                                    $searchButton = $('<button>')
                                               .text('search')
                                               .addClass('btn btn-md btn-con mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn-md btn-con mb-2')
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
                      'url'   :base_url+'projects/get_list_project_candidate', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    },
                    aoColumns: [
                        { 
                            'mRender': function(data, type, obj){   
                                    var a = "";
                                    var b = "";
                                    if(obj .ID_LOP_EPIC == null){
                                        a = "<div class='id_project' style='font-size:12px;'>"+obj.ID_PROJECT+"</div>";                     
                                    }else{
                                        a = "<div class='id_project' style='font-size:12px;'>"+obj.ID_PROJECT+"</div>"+"<div class='id_project' style='font-size:12px;'>"+obj.ID_LOP_EPIC+"</div>";
                                    }   
                                    return a+b;
                            }            
                                    
                        },
                        { 
                            'mRender': function(data, type, obj){  
                                    return "<span style='font-size:12px !important;font-family:sans-serif;font-weight:800;'>"+obj.NAME+"</span>";   
                            }            
                                    
                        }, 
                        { mData: 'STANDARD_NAME'},
                        { 
                            'mRender': function(data, type, obj){   
                                    var a = "";
                                    var b = "";
                                    if(obj.PARTNER_NAME==null || obj.PARTNER_NAME=='null'){
                                        b = "";
                                     }else{
                                        b = obj.PARTNER_NAME;
                                     }

                                    if(obj.NO_P8_2==null || obj.NO_P8_2=='null' || obj.NO_P8_2=='-'){
                                        a = "";
                                     }else{
                                        a = "<br><span class='badge badge-info'>"+obj.NO_P8_2+"</span>";       
                                     }
                                    return b+a;   
                            }            
                                    
                        },
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { mData: 'SOURCE_PROJECT'},
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<a target='_blank' style='font-size:10px;width:100%;margin-right:1px;margin-bottom:0.5px;padding-top:0px;padding-bottom:0px' class='nav-link-hgn btn btn-xs btn-primary' href='"+base_url+"projects/view_candidate/"+obj.ID_PROJECT+"' >ASSIGN</a>"       
                                    return a;
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
              $('#dataku').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>