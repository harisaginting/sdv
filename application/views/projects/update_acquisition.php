<style type="text/css">
  .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
  /*Checkboxes styles*/
}

input[type="checkbox"] { display: none; }

input[type="checkbox"] + label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 10px;
  font: 14px/20px;
  color: #000;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

input[type="checkbox"] + label:last-child { margin-bottom: 0; }

input[type="checkbox"] + label:before {
  border-radius: 50%;
  content: ''; 
  display: block;
  width: 20px;
  height: 20px;
  border: 2px solid #20a8d8;
  position: absolute;
  left: 0;
  top: 0;
  opacity: .6;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

input[type="checkbox"]:checked + label:before {
  width: 10px;
  top: -5px;
  left: 5px;
  border-radius: 0;
  opacity: 1;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

.date-picker[readonly]{
  background-color: #c2cfd6;
}

.bg-grey{
  background: #20a8d8;
  border-radius: 10px;
}

input[type="checkbox"]{
  display: none;
}


.tab-content > .active, .nav-tabs .nav-link.active {
  background: #ebfaff !important;
}

</style>
<ol class="breadcrumb">
<li class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate"> Projects</li>
<li class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>projects/view_candidate/<?= $id_project; ?>"> <strong>Assign</strong></li>
</ol>

<div class="container-fluid container-content">
  
<div class="col-sm-12">
  <div class="card">
  <div class="card-header">
  <strong>Update Acquisition Project <?= $id_project; ?></strong>
  <small><?= date('F Y') ?></small>
  </div>
  <div class="card-body">
    <div class="row"> 

        <div class="col-sm-12" style="margin-top:20px;"> <label><b>Acquisition</b></label>
          <table id="dataPartners" class="table table-responsive-sm table-bordered" style="width: 100% !important;">
              <thead class="thead-bg-blue">
                  <tr style="font-size: 12px;">
                      <th style="vertical-align: sub;width:5% !important;" rowspan="3">Month</th>
                      <th style="vertical-align: sub;width:10% !important;" rowspan="3">Term of Payment</th>
                      <th style="width:50%" colspan="4" >Acquisition</th>
                      <th style="vertical-align: sub;border:2px #a4b7c1 solid !important;width: 10% !important;" rowspan="3">Additional Info</th>
                      <th style="vertical-align: sub;width: 20%;" rowspan="3">Note</th>
                      <th style="vertical-align: sub;width: 5%;" rowspan="3">
                        <button type="button" class="btn circle2 btn-success" id="btn-add-partner"><i class="fa fa-plus"></i></button>
                      </th>
                  </tr>
                  <tr style="font-size: 12px;">
                      <th style="max-width:25%" colspan="2" >Target BAST</th>
                      <th style="max-width:25%" colspan="2" >Realisasi BAST</th>
                  </tr>
                  <tr style="font-size:12px;">
                      <th style="width:10%">Progress (%)</th>
                      <th style="width:15%">Rp.</th>
                      <th style="width:10%">Progress (%)</th>
                      <th style="width:15%">Rp.</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach ($acquistion as $key => $value) : ?>
                  <tr style="font-size:12px;">
                      <td><?= $value['MONTH']; ?></td>
                      <td><?= $value['TOP']; ?></td>
                      <td><?= $value['TARGET_PROGRESS']; ?></td>
                      <td class="rupiah"><?= $value['TARGET_ACQ']; ?></td>
                      <td><?= $value['PROGRESS']; ?></td>
                      <td class="rupiah"><?= $value['ACQ']; ?></td>
                      <td><?= $value['NOTE']; ?></td>
                      <td><?= $value['NOTE']; ?></td>
                      <td><!-- <button class="btn btn-danger circle2 deleteAcq"><i class='fa fa-trash'></i></button> --></td>

                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
        </div>

    </div>
  </div>
  </div>
</div>

</div>



<!-- deliverables modals -->
<div class="modal fade"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="btn-add-partner-modal">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
        <div class="modal-header">
              <h4 class="modal-title" id="modal-title-partner">Update Acquisition</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
        </div>
              <div class="modal-body relative">
              <form method="POST" enctype="multipart/form-data" id="frmAcq">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link active show" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true">
                    <i class="icon-calculator"></i> Target <?= date('F');?></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">
                    <i class="icon-basket-loaded"></i> Gained <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?></a>
                    </li>
                  </ul>
                    <div class="tab-content">
                    <div class="tab-pane active show" id="home3" role="tabpanel">
                        <input type="hidden"  id="month" name="month" value="<?= date('n'); ?>">
                        <input type="hidden"  id="id_project" name="id_project" value="<?= $id_project; ?>">
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc" name="otc" data-val="otc" class="topselect">
                            <label for="otc">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_otc">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="otc_value" name="otc_value" class="form-control c_otc rupiah" readOnly
                                value="<?= !empty($acq['OTC']['TARGET_ACQ']) ? $acq['OTC']['TARGET_ACQ'] : ''; ?>">
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="otc_percent" name="otc_percent" class="form-control c_otc" value="100" readOnly value="<?= !empty($acq['OTC']['TARGET_PROGRESS']) ? $acq['OTC']['TARGET_PROGRESS'] : '100' ?>">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="otc_note" name="otc_note" class="form-control c_otc"><?= !empty($acq['OTC']['NOTE']) ? $acq['OTC']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="reccuring" name="reccuring" data-val="recc" class="topselect">
                            <label for="reccuring">Reccuring</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_recc">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="recc_value" name="recc_value" class="form-control c_recc rupiah" value="<?= !empty($acq['RECCURING']['TARGET_ACQ']) ? $acq['RECCURING']['TARGET_ACQ'] : '' ?>" readOnly>
                              </div>
                            </div>

                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="recc_percent" name="recc_percent" class="form-control c_recc" value="<?= !empty($acq['RECCURING']['TARGET_PROGRESS']) ? $acq['RECCURING']['TARGET_PROGRESS'] : '' ?>" readOnly>
                              </div>
                            </div>

                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date Start</label>
                                <input type="text" id="recc_start" name="recc_start" class="form-control c_recc date-picker"readOnly >
                              </div>
                            </div>
                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date End</label>
                                <input type="text" id="recc_end" name="recc_end" class="form-control c_recc date-picker" readOnly>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="recc_note" name="recc_note" class="form-control c_recc"><?= !empty($acq['RECCURING']['NOTE']) ? $acq['RECCURING']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  


                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="termin" name="termin" data-val="termin" class="topselect">
                            <label for="termin">Termin</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_termin">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="termin_value" name="termin_value" class="form-control c_termin rupiah" readOnly value="<?= !empty($acq['TERMIN']['TARGET_ACQ']) ? $acq['TERMIN']['TARGET_ACQ'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="termin_percent" name="termin_percent" class="form-control c_termin"  readOnly
                                value="<?= !empty($acq['TERMIN']['TARGET_PROGRESS']) ? $acq['TERMIN']['TARGET_PROGRESS'] : '' ?>">
                              </div>
                            </div>

                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Termin Ke : </label>
                                <input type="number" id="termin_ke" name="termin_ke" class="form-control c_termin" value="<?= !empty($acq['TERMIN']['TARGET_KE']) ? $acq['TERMIN']['TARGET_KE'] : '' ?>" readOnly>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="termin_note" name="termin_note" value="<?= !empty($acq['TERMIN']['NOTE']) ? $acq['TERMIN']['NOTE'] : '' ?>" class="form-control c_termin"></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="progress" name="progress" data-val="progress" class="topselect">
                            <label for="progress">Progress</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_progress">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="progress_value" name="progress_value" class="form-control c_progress rupiah" readOnly value="<?= !empty($acq['PROGRESS']['TARGET_ACQ']) ? $acq['PROGRESS']['TARGET_ACQ'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="progress_percent" name="progress_percent" class="form-control c_progress"  readOnly value="<?= !empty($acq['PROGRESS']['TARGET_PROGRESS']) ? $acq['PROGRESS']['TARGET_PROGRESS'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="progress_note" name="progress_note" class="form-control c_progress"><?= !empty($acq['PROGRESS']['NOTE']) ? $acq['PROGRESS']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 

                        



                    </div>
                    <div class="tab-pane" id="profile3" role="tabpanel">
                         <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc_lm" name="otc_lm" data-val="otc_lm" class="topselect">
                            <label for="otc_lm">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_otc_lm">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="otc_value_lm" name="otc_value_lm" class="form-control c_otc_lm rupiah" readOnly value="<?= !empty($acq['OTC']['ACQ']) ? $acq['OTC']['ACQ'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="otc_percent_lm" name="otc_percent_lm" class="form-control c_otc_lm" value="100" readOnly value="<?= !empty($acq['OTC']['PROGRESS']) ? $acq['OTC']['PROGRESS'] : '' ?>">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="otc_note_lm" name="otc_note_lm" class="form-control c_otc_lm"></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="reccuring_lm" name="reccuring_lm" data-val="recc_lm" class="topselect">
                            <label for="reccuring_lm">Reccuring</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_recc_lm">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="recc_value_lm" name="recc_value_lm" class="form-control c_recc_lm rupiah" readOnly>
                              </div>
                            </div>

                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="recc_percent_lm" name="recc_percent_lm" class="form-control c_recc_lm" readOnly>
                              </div>
                            </div>

                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date Start</label>
                                <input type="text" id="recc_start_lm" name="recc_start_lm" class="form-control c_recc_lm date-picker"readOnly >
                              </div>
                            </div>
                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date End</label>
                                <input type="text" id="recc_end_lm" name="recc_end_lm" class="form-control c_recc_lm date-picker" readOnly>
                              </div>
                            </div>
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="recc_note_lm" name="recc_note_lm" class="form-control c_recc_lm"></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  


                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="termin_lm" name="termin_lm" data-val="termin_lm" class="topselect">
                            <label for="termin_lm">Termin</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_termin_lm">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="termin_value_lm" name="termin_value_lm" class="form-control c_termin_lm rupiah" readOnly>
                              </div>
                            </div>
                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="termin_percent_lm" name="termin_percent_lm" class="form-control c_termin_lm"  readOnly>
                              </div>
                            </div>

                            <div class="col-md-4" >
                              <div class="form-group">
                                <label>Termin Ke : </label>
                                <input type="number" id="termin_ke_lm" name="termin_ke_lm" class="form-control c_termin_lm"  readOnly>
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="termin_note_lm" name="termin_note_lm" class="form-control c_termin_lm"></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="progress_lm" name="progress_lm" data-val="progress_lm" class="topselect">
                            <label for="progress_lm">Progress</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey hidden" id="con_progress_lm">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="progress_value_lm" name="progress_value_lm" class="form-control c_progress_lm rupiah" readOnly>
                              </div>
                            </div>
                            <div class="col-md-6" >
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input type="text" id="progress_percent_lm" name="progress_percent_lm" class="form-control c_progress_lm"  readOnly>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea readOnly rows="2" type="text" id="progress_note_lm" name="progress_note_lm" class="form-control c_progress_lm"></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 
                    </div>
                    </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnsaveacq" class="btn btn-primary btnTab" data-tab="deliverables">Save Change</button>
                </div>
              </form>
            </div>
    </div>
  </div>
</div>



<script type="text/javascript">    
  var id_project = "<?= $id_project; ?>";
  var Page = function () {  
      var saveAcq = function(){
        $( ".rupiah" ).each(function( index ) {
              $(this).val($(this).unmask());
              console.log($(this).val());
            });
        var formData = new FormData(document.getElementById('frmAcq'));
        console.log(formData);
        $.ajax({
              url: base_url+'projects/saveAcq',
              type:'POST',
              dataType : "json",
              data:  formData ,
              async : true, 
              processData: false,
              contentType: false,
              processData:false,
              success:function(result){
                if(result.data=='success'){
                bootbox.alert("Success!", function(){ 
                var url = base_url+"projects/update_acquisition/<?= $id_project ?>";
                window.location.href = url;
                
                 
                });
                }else{
                bootbox.alert("Failed!", function(){ 
                 
                });
                }
              return result;
              },
               error: function(xhr, error){
                      bootbox.alert("Failed!", function(){ 
                      console.log('failed update Acquisition!'); });
               },

      });
      }

      return {
          init: function() { 
              $(document).on('change','.topselect',function(e){
                var top   = $(this).data().val;
                var check = 0;
                if ($(this).is(':checked')) {
                  $('#con_'+top).removeClass('hidden');                
                  $('.c_'+top).attr('readOnly',false);                 
                }else{
                  $('#con_'+top).addClass('hidden');                
                  $('.c_'+top).attr('readOnly',true);    
                }              
              });

              $(document).on('click','#btn-add-partner',function(e){
                  e.stopImmediatePropagation();
                      $('#btn-add-partner-modal').modal('show');     
                  });

              $(document).on('click','#btnsaveacq',function(e){
                      saveAcq();      
                      $('#btn-add-partner-modal').modal('hide');        
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>