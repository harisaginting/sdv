<script src="<?=base_url()?>assets/plugin/cropit/dist/jquery.cropit.js" type="text/javascript"></script>

<style type="text/css">
  .card{
    /*border-radius: 0px;*/
  }

#accordion > .card, #accordion > .card > .card-header{
  border-radius: 0px;
}

.projectdashboard{
  font-size: 16px;
  font-weight: 700;
}

.titleminidashboard{
  font-size: 14px;
  font-weight: 900;
}

.c_projectdashboard{
  width: 100%;
  text-align: center;
}

.image-editor {
   text-align: center;
}

.cropit-preview {
  background-color: #f8f8f8;
  background-size: cover;
  border: 5px solid #ccc;
  border-radius: 3px;
  margin-top: 7px;
  width: 250px;
  height: 250px;
   display: inline-block;
}

.cropit-preview-image-container {
  cursor: move;
  background-size: contain;
  background-image: url(<?= !empty($this->session->userdata('photo')) ? base_url().$this->session->userdata('photo') : base_url().'../user_picture/default-profile-picture.png'; ?>);
}

.cropit-preview-background {
  opacity: .2;
  cursor: auto;
}

.image-size-label {
  margin-top: 10px;
}

.profilepeojectdashboard > .row > .col-md-3, .profilepeojectdashboard > .row > .col-md-3 > .col-sm-12{
  padding-left: 5px !important;
  padding-right: 5px !important;
}

input, .export {
  /* Use relative position to prevent from being covered by image background */
  position: relative;
  z-index: 10;
  display: block;
}

button {
  margin-top: 10px;
}
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item col-md-2"> User Profile</li>
</ol>

<div class="container-fluid container-content"> 

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
      
        <div class="row">
          
<?php if($this->session->userdata('nik_sess')==$user['NIK']) : ?>
        
        <div class="col-md-4">
              <h2><?= $user['NAMA']; ?></h2>
              <h4><?= $user['NIK']; ?></h4>
              
              <div class="image-editor">
                 <input id="input_foto_profile" type="file" class="cropit-image-input hidden">
                 <div class="cropit-preview"></div>
                 <input type="range" class="cropit-image-zoom-input" style="width: 100%;">
              </div>

              <div style="width:100%;margin-top: 30px;">
              <span class=" h4 btn btn-info " id="profile_select_image">    <i class="fa fa-plus"></i> Select Image</span>
              <span class=" h4 btn btn-success" id="profile_upload_foto" > <i class="fa fa-upload"></i> Upload Foto</span>
              <a href="<?= base_url(); ?>user/profile_edit/<?= $user['NIK']; ?>" class="h4 btn btn-warning "><i class="fa fa-edit"></i> Edit</a>
              <a href="<?= base_url(); ?>user/profile_change_password/<?= $user['NIK']; ?>" class="h4 btn btn-warning "><i class="fa fa-lock"></i> Change Password</a>
              </div>



        </div>

<?php else : ?>
        <div class="col-md-4">
              <h2><?= $user['NAMA']; ?></h2>
              <h4><?= $user['NIK']; ?></h4>
              <img src="<?= !empty($user['PHOTO_URL'])? "https://prime.telkom.co.id/sdv/".$user['PHOTO_URL'] : "https://prime.telkom.co.id/sdv/../user_picture/default-profile-picture.png"?>" style="max-width: 100%;" class="img-circle">
              <br>
              <a href="<?= base_url(); ?>user/profile_edit/<?= $user['NIK']; ?>" class="h4 btn btn-warning "><i class="fa fa-edit"></i> Edit</a>
              <a href="<?= base_url(); ?>user/profile_change_password/<?= $user['NIK']; ?>" class="h4 btn btn-warning "><i class="fa fa-lock"></i> Change Password</a>
          </div>
<?php endif; ?>
                    
          

            <div class="col-md-8 profilepeojectdashboard" style="border-left: 2px solid #f42020;">
                <h3>Projects</h3>
                <div class="row" style="text-align: center;">
                  <div class="col-md-3"><span class="titleminidashboard"> APPLICATION </span>
                    <div class="col-sm-12">
                      <div class="card text-white bg-success">
                        <div class="card-header c_projectdashboard">
                        LEAD
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"> <?= $db['APPLICATION']['LEAD']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-warning">
                        <div class="card-header c_projectdashboard">
                        LAG
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['APPLICATION']['LAG']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-danger">
                        <div class="card-header c_projectdashboard">
                        DELAY
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['APPLICATION']['DELAY']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-primary">
                        <div class="card-header c_projectdashboard">
                        CLOSED
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['APPLICATION']['CLOSED']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-3"><span class="titleminidashboard"> CONNECTIVITY </span>
                    <div class="col-sm-12">
                      <div class="card text-white bg-success">
                        <div class="card-header c_projectdashboard">
                        LEAD
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CONNECTIVITY']['LEAD']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-warning">
                        <div class="card-header c_projectdashboard">
                        LAG
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CONNECTIVITY']['LAG']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-danger">
                        <div class="card-header c_projectdashboard">
                        DELAY
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CONNECTIVITY']['DELAY']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-primary">
                        <div class="card-header c_projectdashboard">
                        CLOSED
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CONNECTIVITY']['CLOSED']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3"><span class="titleminidashboard"> CPE & OTHERS </span>
                    <div class="col-sm-12">
                      <div class="card text-white bg-success">
                        <div class="card-header c_projectdashboard">
                        LEAD
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CPE & OTHERS']['LEAD']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-warning">
                        <div class="card-header c_projectdashboard">
                        LAG
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CPE & OTHERS']['LAG']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-danger">
                        <div class="card-header c_projectdashboard">
                        DELAY
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CPE & OTHERS']['DELAY']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-primary">
                        <div class="card-header c_projectdashboard">
                        CLOSED
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['CPE & OTHERS']['CLOSED']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3"><span class="titleminidashboard"> SMART BUILDING </span>
                    <div class="col-sm-12">
                      <div class="card text-white bg-success">
                        <div class="card-header c_projectdashboard">
                        LEAD
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['SMART BUILDING']['LEAD']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-warning">
                        <div class="card-header c_projectdashboard">
                        LAG
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['SMART BUILDING']['LAG']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-danger">
                        <div class="card-header c_projectdashboard">
                        DELAY
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['SMART BUILDING']['DELAY']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <div class="card text-white bg-primary">
                        <div class="card-header c_projectdashboard">
                        CLOSED
                        </div>
                        <div class="card-body">
                          <div class="c_projectdashboard">
                            <span class="projectdashboard"><?= $db['SMART BUILDING']['CLOSED']; ?></span>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div> 
                </div>
            </div>
        </div>
      
      </div>
    </div>
  </div>

<div class="col-sm-12 hide">

  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  </div> 
                  
<table id="datatableProjectProfile" hidden>
    <thead>
        <tr>
            <th></th>
            <th>LEAD</th>
            <th>LAG</th>
            <th>DELAY</th>
            <th>CLOSED</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>APPLICATION</th>
            <td><?= $type_project['APPLICATION']['LEAD']->TOTAL ?></td>
            <td><?= $type_project['APPLICATION']['LAG']->TOTAL ?></td>
            <td><?= $type_project['APPLICATION']['DELAY']->TOTAL ?></td>
            <td><?= $type_project['APPLICATION']['CLOSED']->TOTAL ?></td>
        </tr>
        <tr>
            <th>CONNECTIVITY</th>
            <td><?= $type_project['CONNECTIVITY']['LEAD']->TOTAL ?></td>
            <td><?= $type_project['CONNECTIVITY']['LAG']->TOTAL ?></td>
            <td><?= $type_project['CONNECTIVITY']['DELAY']->TOTAL ?></td>
            <td><?= $type_project['CONNECTIVITY']['CLOSED']->TOTAL ?></td>
        </tr>
        <tr>
            <th>CPE & OTHERS</th>
            <td><?= $type_project['CPE & OTHERS']['LEAD']->TOTAL ?></td>
            <td><?= $type_project['CPE & OTHERS']['LAG']->TOTAL ?></td>
            <td><?= $type_project['CPE & OTHERS']['DELAY']->TOTAL ?></td>
            <td><?= $type_project['CPE & OTHERS']['CLOSED']->TOTAL ?></td>
        </tr>
        <tr>
            <th>SMART BUILDING</th>
            <td><?= $type_project['SMART BUILDING']['LEAD']->TOTAL ?></td>
            <td><?= $type_project['SMART BUILDING']['LAG']->TOTAL ?></td>
            <td><?= $type_project['SMART BUILDING']['DELAY']->TOTAL ?></td>
            <td><?= $type_project['SMART BUILDING']['CLOSED']->TOTAL ?></td>
        </tr>
    </tbody>
</table>


<div class="row">
  <div class="col-md-12">
    
  </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-trophy"></i> Credit Points
          <!-- <small>Project Manager</small> -->
        </div>
        <div class="card-body">
            <div id="accordion" role="tablist">
              <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed text-dark">
                    Points This Week<span class="badge badge-success" style="font-size: 14px;font-weight: 700;margin-left: 5px;"> <?= !empty($user['TPOINT']) ? $user['TPOINT'] : '0' ?></span>
                    </a>
                    </h5>
                  </div>
                  <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                    <div class="card-body">
                        <table class="table" id="data_credit_point_week" style="width: 100%;">
                          <thead style="background-color: #e4e5e6;">
                              <th style="width: 35%;">DATE EVENT</th>
                              <th style="width: 55%;">Task</th>
                              <th style="width: 10%;text-align: center;">Point</th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>
              <div class="card">
              <div class="card-header" role="tab" id="headingTwo">
                  <h5 class="mb-0">
                    <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo text-dark">
                    <span style="color: #29363d !important;"> All times point </span> 
                    <span class="badge badge-success" style="font-size: 14px !important;font-weight: 700;margin-left: 5px;"> <?= !empty($user['ALLTPOINT']) ? $user['ALLTPOINT'] : '0' ?></span>
                    </a>
                  </h5>
              </div>
                  <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <table class="table" id="data_credit_point" style="width: 100%;">
                          <thead style="background-color: #e4e5e6;">
                              <th style="width: 35%;">DATE EVENT</th>
                              <th style="width: 55%;">Task</th>
                              <th style="width: 10%;text-align: center;">Point</th>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-md-6">
      <div class="card">
          <div class="card-header">
            <i class="fa fa-clock"></i> Latest Activity
          </div>
          <div class="card-body">
            <table class="table" id="data_latest_activity" style="width: 100%;">
              <thead style="background-color: #e4e5e6;">
                  <th style="width: 35%;">DATE EVENT</th>
                  <th style="width: 25%;">TYPE</th>
                  <th style="width: 40%;">ACTIVITY</th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
      </div>     
    </div>
</div>


  </div>
</div>

<script type="text/javascript">    
  var Page = function () {
    var tableInit = function(){                     
        var table = $('#dataku_profile').DataTable({
                  initComplete: function(settings, json) {
                     var input = $('.dataTables_filter input').unbind(),
                                    self = this.api(),
                                    $searchButton = $('<button>')
                                               .text('search')
                                               .addClass('btn btn-md btn-success mb-2')
                                               .click(function() {
                                                  self.search(input.val()).draw();
                                               }),
                                    $clearButton = $('<button>')
                                               .text('clear')
                                               .addClass('btn btn-md btn-info mb-2')
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
                        'url'  :base_url+'projects/get_list_project_active', 
                        'type' :'POST',
                        'data' : {
                                  status  : $('#status').val(),
                                  pm      : $('#pm').val(),
                                  customer: $('#customer').val(),
                                  regional: $('#regional').val(),
                                  type    : $('#type').val(),
                                  mitra   : $('#mitra').val(),
                                  segmen  : $('#segmen').val()
                                  }   
                        },
                    aoColumns: [
                        { mData: 'ID_PROJECT'}, 
                        { mData: 'NAME'}, 
                        { mData: 'SEGMEN'}, 
                        { mData: 'TYPE'}, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return "<span class='rupiah pull-right'>"+obj.VALUE+"</span> ";   
                            }            
                                    
                        }, 
                        { 
                            'mRender': function(data, type, obj){   
                                    return obj.WEIGHT + ' %';   
                            }            
                                    
                        },  
                        { 
                            'mRender': function(data, type, obj){   
                                    return obj.ACH + ' %';   
                            }            
                                    
                        },
                        
                        {
                            'mRender': function(data, type, obj){
                                    var a = "<span style='font-size:10px;width:48%;margin-right:1px;' class=\'circle nav-link-hgn btn btn-xs btn-success \' data-url='"+base_url+"projects/view/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-new-window'/></i></span>"+
                                            "<span style='font-size:10px;width:48%;margin-right:1px;' class=\'circle btn btn-xs nav-link-hgn btn-warning \' data-url='"+base_url+"projects/edit/"+obj.ID_PROJECT+"' ><i class='glyphicon glyphicon-pencil'/></i></span>";       
                                    return a;
                            }

                        }, 
                       ],      
                });

        var table_credit_point_week = $('#data_credit_point_week').DataTable({
                    processing: true,
                    serverSide: true,
                    order : [0,'DESC'],
                    paging : false,
                    info : false,
                    searching : false,
                    ajax: { 
                        'url'  :base_url+"user/get_datatables_credit_week/<?= $user['NIK'] ?>", 
                        'type' :'POST',
                        },
                    aoColumns: [
                                { mData: 'DATE_EVENT2'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.CONTENT+" <span class='badge badge-primary'>"+obj.TITLE+"</span>";   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return " <div style='text-align:center;width:100% !important;'>"+obj.POINT+"</div>";   
                                    }            
                                            
                                },                               
                               ],           
                }); 


          var table_credit_point = $('#data_credit_point').DataTable({
                    processing: true,
                    serverSide: true,
                    order : [0,'DESC'],
                    paging : false,
                    info : false,
                    searching : false,
                    ajax: { 
                        'url'  :base_url+"user/get_datatables_credit/<?= $user['NIK'] ?>", 
                        'type' :'POST',
                        },
                    aoColumns: [
                                { mData: 'DATE_EVENT2'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.CONTENT+" <span class='badge badge-primary'>"+obj.TITLE+"</span>";   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return " <div style='text-align:center;width:100% !important;'>"+obj.POINT+"</div>";   
                                    }            
                                            
                                },                               
                               ],           
                });  


            var table_latest_activity = $('#data_latest_activity').DataTable({
                    processing: true,
                    serverSide: true,
                    info : false,
                    searching : false,
                    ajax: { 
                        'url'  :base_url+"user/get_datatables_latest_activity/<?= $user['NIK'] ?>", 
                        'type' :'POST',
                        },
                    aoColumns: [
                                { mData: 'DATE_CREATED2'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.TYPE;   
                                    }            
                                            
                                },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.STATUS;   
                                    }            
                                            
                                },                               
                               ],           
                });   
    };    
      return {
          init: function() { 
            tableInit();

            $(document).on('click','#profile_select_image', function (e) {
              e.stopImmediatePropagation();
              $('#input_foto_profile').click();
              });

            $(document).on('click','#profile_upload_foto', function (e) {
              e.stopImmediatePropagation();
              var image = $('.image-editor').cropit('export', {
                  type: 'image/jpeg',
                  quality: .9,
                  originalSize: true
                    });

               console.log(image);
                if(image!=undefined){
                    $.ajax({
                          type: "POST",
                          dataType : "json",
                          url: base_url+"user/update_photo",
                          data: { 
                                  profile_picture : image
                                },
                          success: function(result) { 
                          }
                        }).done(function(result) {
                           $('#pre-load-background').fadeOut();
                           if(result.data.trim()=='success'){
                            bootbox.alert("Success!", function(){ 
                            location.reload(true);  
                            setPage(base_url+"user/profile/"+"<?= $user['NIK']; ?>");
                            });
                            }else{
                            bootbox.alert("Failed!", function(){});
                            }
                          return result;
                        });;
                }
              });



           $('.image-editor').cropit({
              exportZoom: 1.25,
              imageBackground: true,
              imageBackgroundBorderWidth: 50,
            });


           $('#updatePic').click(function() {
               var image = $('#image-cropper').cropit('export', {
                  type: 'image/jpeg',
                  quality: .9,
                  originalSize: true
                    });

               console.log(image);
               var dataf = $('#formUser').serialize();
                if(image!=undefined){
                    $.ajax({
                          type: "POST",
                          url: base_url+"users/update_photo",
                          data: { 
                             profile_picture : image, data : dataf
                          },
                          success: function(json) {
                            window.location.reload();
                          }
                        }).done(function() {
                          window.location.reload();
                        });;
                }
            });


            $(document).on('change','.Jselect2Active', function (e) {
              e.stopImmediatePropagation();
              $('#dataku_profile').dataTable().fnDestroy();

              tableInit();
              });

            var nik = "<?= $user['NIK'] ?>";  
            var lLead = [];

            Highcharts.chart('container', {
              colors: ['#1ec100', '#ce8500', '#ffc107','#d34836'],
                chart: {
                    type: 'bar',
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Application', 'Connectivity', 'CPE & Others', 'Smart Building']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Project'
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                    shared: true
                },
                plotOptions: {
                    column: {
                        stacking: 'percent'
                    }
                },
                data: {
                    table: 'datatableProjectProfile'
                },
                credits:''
            });


           


           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>