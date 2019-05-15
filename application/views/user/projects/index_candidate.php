<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>projects/candidate"> Projects Candidate</li>
<div class="col-md-10">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>projects/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Add Project &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
  <div style="margin-right: 20px;" class="pull-right">
      <a href="<?= base_url(); ?>projects/download_list_candidate_projects" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">
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
                  <th>Project Name</th>
                  <th>Customer</th>
                  <th>SPK / P8</th>
                  <th>Value</th>
                  <th>Source</th>
                  <th>Action</th>
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
                      'url'   :base_url+'projects/get_list_project_candidate', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    },
                    aoColumns: [
                        { 
                            'mRender': function(data, type, obj){   
                                    if(obj .ID_LOP_EPIC == null){
                                        return obj.ID_PROJECT;                     
                                    }else{
                                        return "<u>"+obj.ID_PROJECT+"</u><br>"+obj.ID_LOP_EPIC;
                                    }   
                            }            
                                    
                        },
                        { mData: 'NAME'},
                        { mData: 'STANDARD_NAME'},
                        { mData: 'NO_P8_2'},
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { mData: 'SOURCE_PROJECT'},
                        {
                            'mRender': function(data, type, obj){
                                /*if(obj.NO_P8_2==null &&obj.SOURCE_PROJECT == 'LOP'&&obj.VALUE==0){  */ 
                                if(obj.VALUE==0 && obj.NO_P8_2==null){
                                    var a = "";       
                                    return a;
                                 }else{
                                    var a = "<a style='font-size:10px;margin-right:1px;' class=\' circle nav-link-hgn btn  btn-success \' href='"+base_url+"projects/view_candidate/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></a>";       
                                    return a;
                                 }
                            }

                        }
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