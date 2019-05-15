
<ol class="breadcrumb">
<li class="breadcrumb-item active"> <strong>BAST</strong></li>
</ol>
<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card border-primary">
<div class="card-header">
List BAST

  <div class="float-right col-sm-2">
      <button data-url="<?= base_url(); ?>bast/add" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Add BAST</span>
      </button>
  </div>

  <div class="float-right col-sm-2">
    <select id="select3" name="select3" class="form-control form-control-sm">
    <option value="0">All SPK</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="select3" name="select3" class="form-control form-control-sm">
    <option value="0">All Partners</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="select3" name="select3" class="form-control form-control-sm">
    <option value="0">All Customers</option>
    </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="select3" name="select3" class="form-control form-control-sm">
    <option value="0">All Status</option>
    </select>
  </div>
  

</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataku" class="table table-responsive-sm table-striped">
              <thead>
                <tr>
                  <th style="max-width: 20% !important">Project Name</th>
                  <th>Partner</th>
                  <th>Customer</th>
                  <th>Type</th>
                  <th>Date BAST</th>
                  <th>Value BAST</th>
                  <th>Status</th>
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
    var tableInit = function(status=null){                     
        var table = $('#dataku').DataTable({
            destroy:true,
            processing: true,
            serverSide: true,
            ajax: { 
                'url'  :base_url+'bast/get_datatables_ajax', 
                'type' :'POST',
                'data' : {status : status}   
                },
            aoColumns: [
                { mData: 'PROJECT_NAME'},
                { mData: 'NAMA_MITRA'},
                { mData: 'NAMACC'},
                { mData: 'TYPE_BAST'},
                { mData: 'TGL_BAST'},
                { mData: 'NILAI_RP_BAST'},
                { mData: 'STATUS'},
                {
                    'mRender': function(data, type, obj){

                            var a = "";
                            var success = "";
                            if(priviledge > 2){ success = "<a style='font-size:10px;width:30%' class=\'btn  btn-xs btn-success  \' href='"+base_url+"bast/view/"+obj.ID_BAST+"' ><i class='glyphicon glyphicon-new-window'></i></a> "; }else{
                                 success = "<a style='font-size:10px;width:30%' class=\'btn  btn-xs btn-disabled\' ><i class='glyphicon glyphicon-new-window'></i></a> ";
                            }
                            if(obj.STATUS=='DONE' || obj.STATUS=='TAKE OUT'){
                             a = success +
                                    "<a target='_blank' style='font-size:10px;width:30%' class=\'btn btn-xs btn-primary \' href='"+base_url+'../'+obj.FILENAME_URI+"' ><i class='glyphicon glyphicon-eye-open'></i></a> "+  
                                    "<a download        style='font-size:10px;width:30%' class=\'btn btn-xs btn-primary \' href='"+base_url+'../'+obj.FILENAME_URI+"' ><i class='glyphicon glyphicon-cloud-download'></i></a> ";    
                            }else{
                                 a = success +
                                    "<a style='font-size:10px;width:30%' class=\'btn  btn-xs btn-disabled \' ><i class='glyphicon glyphicon-eye-open'></i></a> "+  
                                    "<a style='font-size:10px;width:30%' class=\'btn  btn-xs btn-disabled \' ><i class='glyphicon glyphicon-cloud-download'></i></a> ";    
                            }


                            return a;
                    }

                }
               
               ],      
        });  
    };    
      return {
          init: function() { 
            
            tableInit();

           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>