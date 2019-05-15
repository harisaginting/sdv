<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }

    #billboard-bast > .col-md-2{
      padding-left: 5px;
      padding-right: 5px;
    }

    #billboard-bast > .col-md-1{
      padding-left: 5px;
      padding-right: 5px; 
    }

    #billboard-bast{
      padding-left: 20px !important; 
      padding-right: 20px !important;
    }

    .font-weight-bold{
      color: #000 !important;
      font-weight: 1000;
      font-size: 10px;
    }
    .col-md-3{
      padding-left: 5px !important;
      padding-right: 5px !important;
    }

    .received{
      background-color: #bef9ff50;
    }

    .cadm{
      background-color: #7ee8f350;
    }
    .csepmo{
      background-color: #52d5e250;
    }

    .ccoord{
      background-color: #00b7ca50;
    }

    .revision{
      background-color: #f9ff0050;
    }

    .approved{
      background-color: #74f9a250;
    }

    .done{
      background-color: #0dfd6050;
    }
    .takeout{
      background-color: #00cc4650; 
    }

    .col-md-3 > .card{
      min-height: 90px !important;
    }


    .select2-container .select2-selection{
    background-color: #dfdfdf !important;
  }

  .select2-selection__rendered{
    color: #300 !important;
  }
</style>

<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-2" data-url="<?= base_url(); ?>bast"> BAST</li>
<div class="col-md-10"> 
<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
  <div class="pull-right">
      <a  href="<?= base_url(); ?>bast/add_1" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Submit BAST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
<?php else: ?>
  <div class="pull-right">
      <a  href="<?= base_url(); ?>bast/add_2" class="btn btn-success btn-addon nav-link-hgn"><i class="fa fa-plus"></i>
        <span class="float-left"> &nbsp; Submit BAST &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
<?php endif; ?> 
  <?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
   <div style="margin-right: 20px;" class="pull-right">
      <a href="<?= base_url(); ?>bast/download_list_bast_revision" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download Rev. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>

  <div style="margin-right: 20px;" class="pull-right">
      <a href="<?= base_url(); ?>bast/download_list_bast" class="btn btn-info btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
  <?php endif; ?>
</div>
</ol>

<div class="container-fluid container-content">
  <!-- <div class="col-sm-12">
  <div class="card">
  <div class="card-header">Currrent Status
  <div class="card-header-actions pull-right">
  <a class="card-header-action btn-minimize " href="#" data-toggle="collapse" data-target="#collapseBAST" aria-expanded="false">
  <i class="icon-arrow-up"></i>
  </a>
  </div>
  </div>
  <div class="card-body" id="collapseBAST" style="">
    
  </div>
  </div>
  </div> -->

<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') : ?>
    <div class="row" id="billboard-bast">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-3">
              <div class="card" style="background: #bef9ff;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold">Received / Submit by Partner</div>
                  <div class="h3"><?= $countReAll+$countRe2All?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #7ee8f3;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold"> Admin</div>
                  <div class="h3"><?= $countCheADMAll?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #52d5e2;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold"> SE PMO</div>
                  <div class="h3"><?= $countChePMOAll?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #00b7ca;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold"> OSM SDV</div>
                  <div class="h3"><?= $countCheCORAll?></div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-3">
              <div class="card" style="background: #f9ff00;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold">Revision</div>
                  <div class="h3"><?= $countCheREVAll ?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #74f9a2;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold">Approved</div>
                  <div class="h3"><?= $countCheAPPAll?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #0dfd60;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold">Done</div>
                  <div class="h3"><?= $countDoAll?></div>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card" style="background: #00cc46;">
                <div class="card-body text-center">
                  <div class="text-muted h6 font-weight-bold">Take Out</div>
                  <div class="h3"><?= $countOutAll?></div>
                </div>
              </div>
            </div>
        </div>
      </div>


      <div class="col-md-6">
        <div id="container" style="min-width: 310px; height: 150px; margin: 0 auto"></div>
      </div>

    </div>
    <?php endif; ?>





<div class="col-md-12">
<div class="card">
<div class="card-header">

  <div class="float-right col-sm-2 hidden">
    <select id="spk" name="spk" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;"> 
      <option value="">All SPK</option>
    </select>
  </div>

  <div class="float-right col-sm-2 <?= $this->session->userdata('tipe_sess')=='SUBSIDIARY'? 'hidden' : '' ?>">
    <select id="partner" name="partner" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="x">All Partner</option>
    <?php if($this->session->userdata('tipe_sess')=='SUBSIDIARY') : ?>
    <option value="<?= $this->session->userdata('mitra') ?>"><?= $this->session->userdata('mitra_name') ?></option>
    <?php endif; ?>
    <?php foreach ($list_mitra as $key => $value) : ?>
          <option value="<?= $list_mitra[$key]['KODE_PARTNER']; ?>"><?= $list_mitra[$key]['NAMA_PARTNER']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
   
  <div class="float-right col-sm-2">
    <select id="customer" name="customer" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="">All Customer</option>
    <?php foreach ($list_cc as $key => $value) : ?>
          <option value="<?= $list_cc[$key]['NIP_NAS']; ?>"><?= $list_cc[$key]['STANDARD_NAME']; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
      
  <div class="float-right col-sm-2">
    <select id="segmen" name="segmen" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
        <option value="">All Segmen</option>
        <?php foreach ($list_segmen as $key => $value) : ?>
              <option value="<?= $list_segmen[$key]['SEGMEN']; ?>"><?= $list_segmen[$key]['SEGMENT_6_LNAME']; ?></option>
        <?php endforeach; ?>
      </select>
  </div>

  <div class="float-right col-sm-2">
    <select id="status" name="status" class="form-control form-control-sm Jselect2 searchOnTable" style="width: 100%;">
    <option value="">All Status</option>
        <option value="TAKE OUT">TAKE OUT</option>
        <option value="TAKE OUT (REV)">TAKE OUT (REV)</option>
        <option value="CHECK BY ADM">CHECK BY ADMIN</option>
        <option value="CHECK BY SE PMO">CHECK BY SE PMO</option>
        <option value="REVISION">REVISION</option>
        <option value="REVISIONED">REVISIONED</option>
        <option value="RECEIVED">RECEIVED</option>
        <option value="DONE">DONE</option>
        <option value="CHECK BY COORD">CHECK BY OSM</option>
        <option value="APPROVED">APPROVED</option>
        <option value="SUBMIT BY PARTNER">SUBMIT BY PARTNER</option>
    </select>
  </div>
</div>

<div class="card-body">
    <div class="col-md-12">
    <?=$this->session->flashdata('notif')?>                                                                  
          <table id="datakuBast" class="table table-responsive-sm" style="width: 100%;">
              <thead>
                <tr>
                  <th style="min-width: 33% !important">Project Name</th>
                  <th style="min-width: 20% !important">Partner</th>
                  <th style="min-width: 8% !important">Type</th>
                  <th style="min-width: 15% !important">Date</th>
                  <th style="min-width: 10% !important">Value</th>
                  <th style="min-width: 14% !important">Status</th>
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
    var tableInit = function(){    
        $("#spk").select2({
                            width: 'resolve',
                            allowClear : true,
                            ajax: {
                                type: 'POST',
                                delay: 200,
                                url:base_url+"json/get_json_spk_bast",
                                dataType: "json",
                                data: function (params) {
                                    return {
                                        q: params.term,
                                        page: params.page,
                                    };
                                },
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function(obj) {
                                            return { id: obj.NO_SPK, text: obj.NO_SPK};
                                        })
                                    };
                                },
                                
                            }
                    }); 

        var table = $('#datakuBast').DataTable({
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
                                $(function () {
                                  $('[data-toggle="tooltip"]').tooltip()
                                });
                    },
                    processing: true,
                    serverSide: true,
                    ajax: { 
                        'url'  :base_url+'bast/get_datatables', 
                        'type' :'POST',
                        'data' : {
                                  status  : $('#status').val(),
                                  mitra   : $('#partner').val(),
                                  spk     : $('#spk').val(),                              
                                  segmen  : $('#segmen').val(),
                                  customer: $('#customer').val(),
                                  }    
                        },
                    aoColumns: [
                                { mData: 'PROJECT_NAME'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return obj.NAMA_MITRA+"</br><span class='badge badge-primary'>"+obj.NO_SPK+"</span>";   
                                    }            
                                            
                                },
                                { mData: 'TYPE_BAST'},
                                { mData: 'TGL_BAST2'},
                                { 
                                    'mRender': function(data, type, obj){   
                                            return "<span class='rupiah pull-right'>"+obj.NILAI_RP_BAST+"</span> ";   
                                    }            
                                            
                                }, 
                                { mData: 'STATUS'}, 
                                {
                                    'mRender': function(data, type, obj){

                                            var a = "<a style='font-size:10px;'  class=\'btn  btn-xs btn-success circle2 nav-link-hgn \' href='"+base_url+"bast/view/"+obj.ID_BAST+"'  target='_blank'><i class='glyphicon glyphicon-new-window'></i></a>"


                                            return a;
                                    }

                                }
                               
                               ],
                               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                  var s = aData['STATUS'];
                                  switch(s) {
                                      case 'RECEIVED':
                                          $(nRow).addClass('received'); 
                                          break;
                                      case 'REVISION':
                                          $(nRow).addClass('revision'); 
                                          break;
                                      case 'REVISIONED':
                                          $(nRow).addClass('revision'); 
                                          break;    
                                      case 'TAKE OUT (REV)':
                                          $(nRow).addClass('revision'); 
                                          break;
                                      case 'CHECK BY ADM':
                                          $(nRow).addClass('cadm'); 
                                          break;
                                      case 'CHECK BY SE PMO':
                                          $(nRow).addClass('csepmo'); 
                                          break;
                                      case 'CHECK BY SE DI':
                                          $(nRow).addClass('csepmo'); 
                                          break;
                                      case 'CHECK BY COORD':
                                          $(nRow).addClass('ccoord'); 
                                          break;
                                      case 'APPROVED':
                                          $(nRow).addClass('approved'); 
                                          break;    
                                      case 'DONE':
                                          $(nRow).addClass('done'); 
                                          break;
                                      case 'TAKE OUT':
                                          $(nRow).addClass('takeout'); 
                                          break;    
                                      default:
                                          console.log(s);
                                    }

                                return nRow;
                                }            
                });  

        $(document).on('click', 'tbody tr', function() {
              var row_data = table.row(this).data();
              console.log(row_data);
              //window.location.href = base_url + "bast/view/"+row_data.ID_BAST;
            });
    };    
      return {
          init: function() { 
            tableInit();    
            $(document).on('change','.searchOnTable', function (e) {
              e.stopImmediatePropagation();
              $('#datakuBast').dataTable().fnDestroy();
              tableInit();
              });

            $(document).on('click','#select2-spk-container .select2-selection__clear',function(e){
                $('#spk').val(null).trigger('change');
              });
           }
      };

  }();

  jQuery(document).ready(function() { 
      Page.init();

        Highcharts.chart('container', {
            chart: {
                type: 'line',
                height : '200'
            },
            title: {
                text: 'BAST Received <?= date('F Y') ?>',
                style: {
                      fontSize: '10px'
                      },
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: <?= !empty($days) ? json_encode($days) : '[]'; ?>
            },
            yAxis: {
                title: {
                    text: 'Total'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            credits: {
                    text: 'SDV - DES',
                    href: 'https://prime.telkom.co.id/sdv/bast',
                    style: {
                      color: '#a40000',
                      fontSize: '6px'
                      },
                },
            tooltip: {
                    // valueSuffix: '%'
                    formatter: function () {
                        return this.series.name;
                    }
                },
            series: [
            {
                name: 'Received',
                style: {
                      fontSize: '6px'
                      },
                data:  <?= !empty($bast_received) ? json_encode($bast_received) : '[]' ?>
            }, /*{
                name: 'Done',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }*/
            ]
        });

  });       
           
</script>