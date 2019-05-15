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

.date-picker[]{
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
                      <th style="vertical-align: sub;width:4% !important;"  rowspan="2">Month</th>
                      <th style="vertical-align: sub;width:10% !important;" rowspan="2">BAST Type</th>
                      <th style="vertical-align: sub;width:28% !important;text-align: center;" colspan="2" rowspan="1">Achievement</th>
                      <th style="vertical-align: sub;width:28% !important;text-align: center;" colspan="2" rowspan="1">Cumulative</th>
                      <th style="vertical-align: sub;width:20% !important; "rowspan="2">Note</th>
                      <!-- <th style="vertical-align: sub;width: 5%;" rowspan="2">
                        <button type="button" class="btn circle2 btn-success" id="btn-add-acq"><i class="fa fa-plus"></i></button>
                      </th> -->
                  </tr>
                  <tr style="font-size:12px;">
                      <th style="width:14%;text-align: center;">(%)</th>
                      <th style="width:14%;text-align: center;">(Rp)</th>
                      <th style="width:14%;text-align: center;">(%)</th>
                      <th style="width:14%;text-align: center;">(Rp)</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach ($acquistion as $key => $value) : ?>
                  <tr style="font-size:12px;" class="<?= date('n') == $value['MONTH']? 'bg-info' : ''; ?>">
                      <td><?= $value['MONTH']; ?></td>
                      <td><?= $value['TOP']; ?></td>
                      <td style="text-align: center;"><?= round(($value['ACQ']/$value_project)*100,4); ?>%</td>
                      <td class="rupiah"><?= $value['ACQ']; ?></td>
                      <td style="text-align: center;"><?= ($value['C_ACQ']/$value_project)*100; ?>%</td>
                      <td class="rupiah"><?= $value['COMULATIVE']; ?></td>
                      <td><?= $value['NOTE']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
          </table>
        </div>
        <button type="button" class="btn btn-success col-md-2 offset-md-5 btn-addon" id="btn-add-acq"><i class="fa fa-plus"></i>Update Acquisition</button>
    </div>
  </div>
  </div>
</div>

</div>



<!-- Acquisition modals -->
<div class="modal fade"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="btn-add-acq-modal">
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
                <div id="target_acq" class="hidden">
                        <div class="col-md-12 bg-info text-white" style="text-align: center;padding:5px;margin-bottom: 5px;">
                          <span><h3>Target Acquisition BAST <?= date('F');?>  </h3></span>
                        </div>
                        <input type="hidden"  id="month" name="month" value="<?= date('n'); ?>">
                        <input type="hidden"  id="id_project" name="id_project" value="<?= $id_project; ?>">
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc" name="otc" data-val="otc" class="topselect" <?= !empty($acq['OTC']['ACQ']) ? 'checked' : '' ?>>
                            <label for="otc">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq['OTC']['ACQ']) ? '' : 'hidden' ?>" id="con_otc">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="otc_value" name="otc_value" class="form-control c_otc rupiah" 
                                value="<?= !empty($acq['OTC']['ACQ']) ? $acq['OTC']['ACQ'] : ''; ?>">
                              </div>

                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input min="0" max="100" type="number" id="otc_percent" name="otc_percent" class="form-control c_otc" value="100"  value="<?= !empty($acq['OTC']['PROGRESS']) ? $acq['OTC']['PROGRESS'] : '100' ?>">
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="4" type="text" id="otc_note" name="otc_note" class="form-control c_otc"><?= !empty($acq['OTC']['NOTE']) ? $acq['OTC']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 

                        <!-- <br><br> -->
                        <div class="form-group hidden">
                          <div class="boxes">
                            <input type="checkbox" id="reccuring" name="reccuring" data-val="recc" class="topselect" <?= !empty($acq['RECCURING']['ACQ']) ? 'checked' : '' ?>>
                            <label for="reccuring">Reccuring</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey  <?= !empty($acq['RECCURING']['ACQ']) ? '' : 'hidden' ?>" id="con_recc">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="recc_value" name="recc_value" class="form-control c_recc rupiah" value="<?= !empty($acq['RECCURING']['ACQ']) ? $acq['RECCURING']['ACQ'] : '' ?>" >
                              </div>
                            </div>

                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Period</label>
                                <input type="number" id="recc_period" name="recc_period" class="form-control c_recc" value="<?= !empty($acq['RECCURING']['PERIOD']) ? $acq['RECCURING']['PERIOD'] : '1' ?>" >
                              </div>
                            </div>

                            <!-- <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date Start</label>
                                <input type="text" id="recc_start" name="recc_start" class="form-control c_recc date-picker" >
                              </div>
                            </div>
                            <div class="col-md-2" >
                              <div class="form-group">
                                <label>Date End</label>
                                <input type="text" id="recc_end" name="recc_end" class="form-control c_recc date-picker" >
                              </div>
                            </div> -->
                            
                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="2" type="text" id="recc_note" name="recc_note" class="form-control c_recc"><?= !empty($acq['RECCURING']['NOTE']) ? $acq['RECCURING']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  


                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="termin" name="termin" data-val="termin" class="topselect" <?= !empty($acq['TERMIN']['ACQ']) ? 'checked' : '' ?>>
                            <label for="termin">Termin</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq['TERMIN']['ACQ']) ? '' : 'hidden' ?>" id="con_termin">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                                  <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" id="termin_value" name="termin_value" class="form-control c_termin rupiah"  value="<?= !empty($acq['TERMIN']['ACQ']) ? $acq['TERMIN']['ACQ'] : '' ?>">
                                    <div class="form-group">
                                      <label>Termin Ke : </label>
                                      <input type="number" id="termin_ke" name="termin_ke" class="form-control c_termin" value="<?= !empty($acq['TERMIN']['TARGET_KE']) ? $acq['TERMIN']['TARGET_KE'] : '1' ?>" >
                                    </div>
                                  </div>
                                </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Note</label>
                                      <textarea  rows="4" type="text" id="termin_note" name="termin_note" class="form-control c_termin"><?= !empty($acq['TERMIN']['NOTE']) ? $acq['TERMIN']['NOTE'] : '' ?></textarea>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>  

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="progress" name="progress" data-val="progress" class="topselect" <?= !empty($acq['PROGRESS']['ACQ']) ? 'checked' : '' ?>>
                            <label for="progress">Progress</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq['PROGRESS']['ACQ']) ? '' : 'hidden' ?>" id="con_progress">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                                <div class="form-group">
                                  <label>Value</label>
                                  <input type="text" id="progress_value" name="progress_value" class="form-control c_progress rupiah"  value="<?= !empty($acq['PROGRESS']['ACQ']) ? $acq['PROGRESS']['ACQ'] : '' ?>">
                                </div>

                                <div class="form-group">
                                    <label>Percentage (%)</label>
                                    <input  min="0" max="100" type="number" id="progress_percent" name="progress_percent" class="form-control c_progress"   value="<?= !empty($acq['PROGRESS']['PROGRESS']) ? $acq['PROGRESS']['PROGRESS'] : '0' ?>">
                                  </div>
                              </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="4" type="text" id="progress_note" name="progress_note" class="form-control c_progress"><?= !empty($acq['PROGRESS']['NOTE']) ? $acq['PROGRESS']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 


                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="dp" name="dp" data-val="dp" class="topselect" <?= !empty($acq['DP']['ACQ']) ? 'checked' : '' ?>>
                            <label for="dp">Down Payment</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq['DP']['ACQ']) ? '' : 'hidden' ?>" id="con_dp">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                                <div class="form-group">
                                  <label>Value</label>
                                  <input type="text" id="dp_value" name="dp_value" class="form-control c_dp rupiah"  value="<?= !empty($acq['DP']['ACQ']) ? $acq['DP']['ACQ'] : '' ?>">
                                </div>

                                 <div class="form-group">
                                  <label>Percentage (%)</label>
                                  <input  min="0" max="100" type="number" id="dp_percent" name="dp_percent" class="form-control c_dp"   value="<?= !empty($acq['DP']['PROGRESS']) ? $acq['DP']['PROGRESS'] : '0' ?>">
                                </div>
                              </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="4" type="text" id="dp_note" name="dp_note" class="form-control c_dp"><?= !empty($acq['DP']['NOTE']) ? $acq['DP']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 
                </div>    
                <div id="gained_acq" class="">
                        <div class="col-md-12 bg-info text-white" style="text-align: center;padding:5px;margin-bottom: 5px;">
                          <span><h3>Gained Acquisition <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?></h3></span>
                        </div>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc_lm" name="otc_lm" data-val="otc_lm" class="topselect" <?= !empty($acq_lm['OTC']['ACQ']) ? 'checked' : '' ?>>
                            <label for="otc_lm">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq_lm['OTC']['ACQ']) ? '' : 'hidden' ?>" id="con_otc_lm">
                          <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                                  <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" id="otc_value_lm" name="otc_value_lm" class="form-control c_otc_lm rupiah"  value="<?= !empty($acq_lm['OTC']['ACQ']) ? $acq_lm['OTC']['ACQ'] : '' ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Percentage (%)</label>
                                    <input  min="0" max="100" type="number" id="otc_percent_lm" name="otc_percent_lm" class="form-control c_otc_lm" value="100"  value="<?= !empty($acq_lm['OTC']['PROGRESS']) ? $acq_lm['OTC']['PROGRESS'] : '0' ?>">
                                  </div>
                                </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Note</label>
                                  <textarea  rows="2" type="text" id="otc_note_lm" name="otc_note_lm" class="form-control c_otc_lm"><?= !empty($acq_lm['OTC']['NOTE']) ? $acq_lm['OTC']['NOTE'] : '' ?></textarea>
                                </div>
                              </div>
                              </div>
                          </div>
                        </div> 

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="termin_lm" name="termin_lm" data-val="termin_lm" class="topselect"
                            <?= !empty($acq_lm['TERMIN']['ACQ']) ? 'checked' : '' ?> >
                            <label for="termin_lm">Termin</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq_lm['TERMIN']['ACQ']) ? '' : 'hidden' ?>" id="con_termin_lm">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="termin_value_lm" name="termin_value_lm" class="form-control c_termin_lm rupiah" value="<?= !empty($acq_lm['TERMIN']['ACQ']) ? $acq_lm['TERMIN']['ACQ'] : '' ?>" >
                              </div>
                              <div class="form-group">
                                <label>Termin Ke : </label>
                                <input type="number" id="termin_ke_lm" name="termin_ke_lm" class="form-control c_termin_lm" value="<?= !empty($acq_lm['TERMIN']['TERMIN']) ? $acq_lm['TERMIN']['TERMIN'] : '1' ?>"  >
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="2" type="text" id="termin_note_lm" name="termin_note_lm" class="form-control c_termin_lm"><?= !empty($acq_lm['TERMIN']['NOTE']) ? $acq_lm['TERMIN']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                              </div>
                            </div>
                        </div>  

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="progress_lm" name="progress_lm" data-val="progress_lm" class="topselect" <?= !empty($acq_lm['PROGRESS']['ACQ']) ? 'checked' : '' ?>>
                            <label for="progress_lm">Progress</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq_lm['PROGRESS']['ACQ']) ? '' : 'hidden' ?>" id="con_progress_lm">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input  type="text" id="progress_value_lm" name="progress_value_lm" class="form-control c_progress_lm rupiah"  value="<?= !empty($acq_lm['PROGRESS']['ACQ']) ? $acq_lm['PROGRESS']['ACQ'] : '0' ?>" >
                              </div>
                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input min="0" max="100" type="number" type="text" id="progress_percent_lm" name="progress_percent_lm" class="form-control c_progress_lm" value="<?= !empty($acq_lm['PROGRESS']['PROGRESS']) ? $acq_lm['PROGRESS']['PROGRESS'] : '0' ?>"  >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="2" type="text" id="progress_note_lm" name="progress_note_lm" class="form-control c_progress_lm"><?= !empty($acq_lm['PROGRESS']['NOTE']) ? $acq_lm['PROGRESS']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div>

                        <br><br>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="dp_lm" name="dp_lm" data-val="dp_lm" class="topselect" <?= !empty($acq_lm['DP']['ACQ']) ? 'checked' : '' ?>>
                            <label for="dp_lm">Down Payment</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq_lm['DP']['ACQ']) ? '' : 'hidden' ?>" id="con_dp_lm">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                                <div class="form-group">
                                  <label>Value</label>
                                  <input type="text" id="dp_lm_value" name="dp_value_lm" class="form-control c_dp_lm rupiah"  value="<?= !empty($acq_lm['DP']['ACQ']) ? $acq_lm['DP']['ACQ'] : '' ?>">
                                </div>

                                 <div class="form-group">
                                  <label>Percentage (%)</label>
                                  <input  min="0" max="100" type="number" name="dp_percent_lm" class="form-control c_dp_lm"   value="<?= !empty($acq_lm['DP']['PROGRESS']) ? $acq_lm['DP']['PROGRESS'] : '0' ?>">
                                </div>
                              </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Note</label>
                                <textarea  rows="4" type="text" id="dp_note_lm" name="dp_note_lm" class="form-control c_dp_lm"><?= !empty($acq_lm['DP']['NOTE']) ? $acq_lm['DP']['NOTE'] : '' ?></textarea>
                              </div>
                            </div>
                            </div>
                        </div>
                        </div> 
                </div>
                        
                        
                  <div class="modal-footer" id="footerAcq1">
                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnvalidacq" class="btn btn-primary">Valid Acquisition <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?></button>
                  </div>

                  <div class="modal-footer hidden" id="footerAcq2">
                    <button type="button" class="btn btn-danger z-index-top" id="backAcq">Cancel</button>
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
                  $('.c_'+top).attr('',false);                 
                }else{
                  $('#con_'+top).addClass('hidden');                
                  $('.c_'+top).attr('',true);    
                }              
              });

              $(document).on('click','#btnvalidacq',function(e){
                  e.stopImmediatePropagation();
                  if($('#frmAcq').valid()){
                    $('#gained_acq').addClass('hidden');
                    $('#footerAcq1').addClass('hidden');
                    $('#target_acq').removeClass('hidden');
                    $('#footerAcq2').removeClass('hidden');
                  }
                  
                  });

              $(document).on('click','#backAcq',function(e){
                  e.stopImmediatePropagation();
                    $('#target_acq').addClass('hidden');
                    $('#footerAcq2').addClass('hidden');
                    $('#gained_acq').removeClass('hidden');
                    $('#footerAcq1').removeClass('hidden');
                  });

              $(document).on('click','#btn-add-acq',function(e){
                  e.stopImmediatePropagation();
                      $('#btn-add-acq-modal').modal('show');     
                  });

              $(document).on('click','#btnsaveacq',function(e){
                      saveAcq();      
                      $('#btn-add-acq-modal').modal('hide');        
              });
           }
      };

  }();

  jQuery(document).ready(function() {
      Page.init();
  });       
           
</script>