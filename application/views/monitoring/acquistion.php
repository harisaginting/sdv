<style type="text/css">
  td{
    border : 0.5px solid #a4b7c1 !important;
  }

  .bg-info-es{
    background: #909090 !important;
  }
</style>
<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/planAch"> Monitoring Estimated Acquisition</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_acquisiton" class="btn btn-primary btn-addon "><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div> 
</ol>
<div class="container-fluid container-content">

<div class="col-md-12"> 
<div class="card">
 <div class="card-header">

  
  <div class="float-right col-sm-2">
    <select id="monitoring_acq_month" name="monitoring_acq_month" class="form-control form-control-sm Jselect2">
    <option value="">All Month</option>
    <option value="1">January</option>
    <option value="1">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
    </select>
  </div> 

</div>
<div class="card-body">
    <div class="col-md-12">                                                                 
          <table id="dataMonitoringBastProject" class="table table-responsive-sm" style="width: 100% !important;">
              <thead>
                <tr>
                  <th style="width: 5%;">Month / Year</th>
                  <th style="width: 20%;">Project</th>
                  <th style="width: 10%;">SEGMEN</th> 
                  <th style="width: 16%;">PM</th>
                  <th style="width: 16%;">Project Value</th>
                  <th style="width: 16%;">End Date</th>
                  <th style="width: 16%;">Progress / Termin ke</th>
                  <th style="width: 10%;text-align: center;">Value (Rp.)</th>
                  <th style="width: 10%;text-align: center;">Comulative (Rp.)</th> 
                  <th style="width: 12%;text-align: center;">Note</th>
                  <th style="width: 5%;"></th>
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
                $('#dataMonitoringBastProject').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: { 
                      'url'   :base_url+'monitoring/get_list_acq', 
                      'type'  :'POST',
                      'data'  : {
                          month  : $('#monitoring_acq_month').val()
                          } 
                    },
                    aoColumns: [
                                { 
                                    'mRender': function(data, type, obj){   
                                           return obj.MONTH+"/"+obj.YEAR;   
                                    }            
                                            
                                },
                                { mData: 'NAME' },
                                { mData: 'SEGMEN' },
                                { mData: 'PM_NAME' },
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='pull-right rupiah'>"+obj.PROJECT_VALUE+"</span> ";   
                                    }            
                                            
                                }, 
                                { mData: 'END_DATE2' },
                                { 
                                    'mRender': function(data, type, obj){   
                                            if(obj.TERMIN != '' && obj.TERMIN != null){
                                              return obj.PROGRESS2 + '% ( Termin Ke-'+obj.TERMIN+')';
                                            }else{
                                              return obj.PROGRESS2 + '%';
                                            } 
                                    }            
                                            
                                }, 
                                
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='pull-right rupiah'>"+obj.ACQ2+"</span> ";   
                                    }            
                                            
                                }, 
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.C_ACQ2+"</span> ";   
                                    }            
                                            
                                }, 
                                { 
                                    'mRender': function(data, type, obj){
                                    var a = "";
                                    if(obj.NOTE!='' && obj.NOTE != null){
                                      a = obj.NOTE;
                                    }   
                                            return "<span class=''>"+a+"</span> ";   
                                    }            
                                            
                                },
                                {
                                    'mRender': function(data, type, obj){

                                            var a = "<a style='font-size:10px;'  class=\'btn  btn-xs btn-success circle2 nav-link-hgn \' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"'  target='_blank'><i class='glyphicon glyphicon-new-window'></i></a>"


                                            return a;
                                    }

                                }
                               ],
                               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                  $(nRow).addClass(aData['CURRENT']); 
                                return nRow;
                                }  


                });          
            };  
      return {
          init: function() { 
             TableInitialize();
              $(document).on('change','.Jselect2', function (e) {
              e.stopImmediatePropagation();
              $('#dataMonitoringBastProject').dataTable().fnDestroy();
              TableInitialize();
              });

              <?php if(!empty($sidebarhidden)) : ?>
                 setTimeout(function () {
                  $('body').addClass('sidebar-hidden');
              }, 3000);
                <?php endif; ?>
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>