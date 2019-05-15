<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>master/api"> Application Programing Interface</li>
  <div class="col-md-10">  
  </div>
</ol>



<div class="container-fluid container-content">

<div class="col-md-12">
<div class="card">

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="dataApi" class="table table-responsive-sm" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width:15%">DATE TIME </th>
                  <th style="width:12%">IP ADDRESS</th>
                    <th style="width:10%">USER ID</th>
                    <th style="width:20%">NAME </th>
                    <th style="width:10%">OBJECT</th>                   
                    <th style="width:20%">STATUS</th>
                    <th style="width:10%">TYPE</th>
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
      return {
          init: function() { 
          }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });      

           
</script>