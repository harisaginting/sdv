<style type="text/css">
  .list-group::-webkit-scrollbar {
    width: 0.5em;
  }
   
  .list-group::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  }
   
  .list-group::-webkit-scrollbar-thumb {
    background-color: darkgrey;
    outline: 1px solid slategrey;
  }
</style>

<ol class="breadcrumb">
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>monitoring/pm"> Monitoring Partners / Subsidiary</li>
</ol>
<div class="container-fluid container-content">

<div class="row">
  <div class="col-md-12">
    <div class="card" >
      <div class="card-header">
      Subsidiary
      </div>
      <div class="card-body row" style="max-height: 600px;">
        <div class="col-md-4">
          <div class="list-group" style="max-height: 540px;overflow-y: scroll !important;overflow-x: hidden;">
            <?php foreach ($subsidiary as $key => $value) : ?>
                <span class="list-group-item list-group-item-action flex-column align-items-start list_partner" data-kode_partner="<?= $subsidiary[$key]['KODE_PARTNER']; ?>" <?= ($key==0) ? "style='background-color:#6af4204a'" : ''  ?> >
                

                <div class="row">
                  <div class="col-md-4">
                    <img src="https://prime.telkom.co.id/dev/<?= !empty($subsidiary[$key]['PHOTO_URL'])? $subsidiary[$key]['PHOTO_URL'] : '../user_picture/default-profile-picture.png' ; ?>" class="img-avatar" alt="<?= $subsidiary[$key]['NAMA_PARTNER']; ?>" style="max-height: 70px;">
                  </div>
                  <div class="col-md-8">
                    <div class="cursor-pointer">
                      <h5 class="mb-1"><b><?= $subsidiary[$key]['NAMA_PARTNER']; ?></b></h5>
                    </div>
                  </div>
                </div>
                
                
                </span>
            <?php endforeach; ?>        
          </div>
        </div>

        <div class="col-md-8" >
            <div id="dataMonitoringSubsidiary" style="max-height: 580px; overflow-y: scroll;">
              Select Subsidiary
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">    
  var Page = function () {
          $(document).on('click','.list_partner',function(e){
            $('.list_partner').css('backgroundColor','#fff');
            $(this).css('backgroundColor','#6af4204a');
            e.stopImmediatePropagation();
                $('#dataMonitoringSubsidiary').empty();
                var kode_partner = $(this).data('kode_partner');
                $("#dataMonitoringSubsidiary").load(base_url+'monitoring/getProjectSubsidiary', { id : kode_partner }, function() {
                  
                });
              });
      return {
          init: function() { 
            $('#dataMonitoringSubsidiary').empty();
            var kode_partner = "<?= $subsidiary[0]['KODE_PARTNER']; ?>";
            $("#dataMonitoringSubsidiary").load( base_url+'monitoring/getProjectSubsidiary', { id : kode_partner }, function() {});
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>