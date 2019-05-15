<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2"><a class="text-dark" href="<?= base_url(); ?>timeline/post">Post</a></li>
<div class="col-md-8">  
  <div class="pull-right">
      <a href="<?= base_url(); ?>timeline/add_post" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Add Post &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">

<div class="card-header">
List Post


</div>

<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="datakuPost" class="table table-responsive-sm table-striped" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 15% !important">Date</th>
                  <th style="width: 20% !important">PIC</th>
                  <th style="width: 50% !important">Title</th>
                  <th style="width: 10% !important">Credit Point</th>
                  <th style="width: 5%  !important"></th>
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
                $('#datakuPost').DataTable({
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
                      'url'   :base_url+'timeline/get_list_post', 
                      'type'  :'POST',
                      'data'  : {
                          source  : $('#source_project').val()
                          } 
                    },
                    aoColumns: [
                        { mData: 'DATE_EVENT'},
                        { mData: 'PIC'},
                        { mData: 'TITLE'},
                        { mData: 'POINT'},
                        {
                                    'mRender': function(data, type, obj){

                                            var a = "<a style='font-size:10px;'  class=\'btn  btn-xs btn-success circle nav-link-hgn \' href='"+base_url+"timeline/view_post/"+obj.ID+"' ><i class='glyphicon glyphicon-new-window'></i></a>"


                                            return a;
                                    }

                        }
                       ],  
                    columnDefs: [
                                { orderable: false, targets: [4] },
                              ]       
                });         
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#datakuPost').dataTable().fnDestroy();
              TableInitialize();
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>