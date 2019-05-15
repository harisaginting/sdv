<style type="text/css">
  .table > tbody > tr > td{
    font-size: 14px;  
  }

  .table>tbody>tr.danger>td{
    background: #fd180033 !important;
  }
  .table>tbody>tr.info>td{
    background: #dfdfdf !important;
  }
 
  .table>tbody>tr.warning>td{
    background: #ffcc0033 !important;
  }
  .table>tbody>tr.success>td{
    background: #00ff5933 !important;
  }
</style>
 
<ol class="breadcrumb">
<li style="width: 100%;">
	<span class="pull-left"> 
		<span class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects">Projects</span>
		<strong class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>projects/view/<?= $id_project;?>">Detail Project <?= $id_project;?> </strong>
	</span>
	<button id="btnDocument" type="button" class="pull-right btn btn-outline-success"> 
		<i class="fa fa-file"></i>
		Document
	</button>
	<a target="_blank" href="<?= base_url(); ?>report/project_detail/<?= $id_project; ?>" id="btnReport" class="pull-right btn btn-outline-danger" style="margin-right: 10px;"> 
		<i class="fa fa-file-pdf"></i> 
		Report PDF
	</a>
</li>		
</ol>


<div class="container-content">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="card">
				<div class="card-header">
				Diagram 
					<div class="card-actions">
					<a href="#" class="btn-minimize" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample" style="">
					<div id="chartArea" class="chart-view"></div>
				</div>
			</div>
		</div>
	</div>	

	<div class="row">
		<div class="col-sm-12 col-md-12"> 
			<div class="card">
				<div class="card-header">
				Detail
					<div class="card-actions">
					<a href="#" class="btn-minimize" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample">
					<div class="row">	
						<div class="col-sm-12 col-md-12">
							<table class="table table-striped">
									<tr>
										<td>Project Name</td>
										<td>: <?=$listDetail['NAME']?></td>
									</tr>
									<tr>
										<td>Value</td>
										<td>: <?=number_format($listDetail['VALUE'])?></td>
									</tr>
									<tr>
										<td>Customer</td>
										<td>: <?=$listDetail['STANDARD_NAME']?></td>
									</tr>
									<?php if (empty($partners[0]['PARTNERS'])) { ?>
										<tr>
											<td>Partners</td>
											<td>: </td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td>Partners</td>
											<td>: <?=$partners[0]['PARTNERS']?></td>
										</tr>
									<?php } ?>
										<td>AM NIK / AM NAME</td>
										<td>: <?=$listDetail['AM_NIK']?> / <?=$listDetail['AM_NAME']?></td>
									</tr>
									<tr>
										<td>PM NIK / PM NAME</td>
										<td>: <?=$listDetail['PM_NIK']?> / <?=$listDetail['PM_NAME']?></td>
									</tr>
									<tr>
										<td>Start Date</td>
										<td>: <?=date('d/m/Y',strtotime($listDetail['START_DATE']))?></td>
									</tr>
									<tr>
										<td>End Date</td>
										<td>: <?=date('d/m/Y',strtotime($listDetail['END_DATE']))?></td>
									</tr>
									<tr>
										<td>Segmen</td>
										<td>: <?=$listDetail['SEGMEN']?></td>
									</tr>
									<tr>
										<td>Type</td>
										<td>: <?=$listDetail['TYPE']?></td>
									</tr>
									<tr>
										<td>Category</td>
										<td>: <?=$listDetail['SCALE']?></td>
									</tr>
									<tr>
										<td>Progress Status</td>
										<td>: <span style="font-weight: bold !important;font-style: bold;"><?=$listDetail['STATUS']?></span> </td>
									</tr>
								<?php if ($listDetail['STATUS'] == 'LAG' || $listDetail['STATUS'] == 'DELAY') : ?>
									<tr>
										<td>Symtom </td>
										<td>
											<select  id="symptomx" class="form-control" style="width:100%;">
												<option value="" disabled <?= empty($list['REASON_OF_DELAY']) ? 'selected' : ''; ?>>Select Reason Of Delay</option>
												<option value="1.Delivery barang/jasa (mitra)" <?= $listDetail['REASON_OF_DELAY'] == "1.Delivery barang/jasa (mitra)" ? 'selected' : ''; ?> >1.Delivery barang/jasa (mitra)</option>
												<option value="2.Kesiapan lokasi ( customer)"  <?= $listDetail['REASON_OF_DELAY'] == "2.Kesiapan lokasi ( customer)" ? 'selected' : ''; ?>>2.Kesiapan lokasi ( customer)</option>
												<option value="3.Perubahan desain/spek pelanggan (customer)"  <?= $listDetail['REASON_OF_DELAY'] == "3.Perubahan desain/spek pelanggan (customer)" ? 'selected' : ''; ?> >3.Perubahan desain/spek pelanggan (customer)</option>
												<option value="4.Keterlambatan BAST (customer)" <?= $listDetail['REASON_OF_DELAY'] == "4.Keterlambatan BAST (customer)" ? 'selected' : ''; ?> >4.Keterlambatan BAST (customer)</option>
												<option value="5.Keterlambatan SPK ke mitra (di awal) (Telkom)" <?= $listDetail['REASON_OF_DELAY'] == "5.Keterlambatan SPK ke mitra (di awal) (Telkom)" ? 'selected' : ''; ?> >5.Keterlambatan SPK ke mitra (di awal) (Telkom)</option>
												<option value="6.Masalah Administrasi & pembayaran mitra (Telkom)" <?= $listDetail['REASON_OF_DELAY'] == "6.Masalah Administrasi & pembayaran mitra (Telkom)" ? 'selected' : ''; ?> >6.Masalah Administrasi & pembayaran mitra (Telkom)</option>
												<option value="7.SoW belum sepakat (Telkom)" <?= $listDetail['REASON_OF_DELAY'] == "7.SoW belum sepakat (Telkom)" ? 'selected' : ''; ?> >7.SoW belum sepakat (Telkom)</option>
												<option value="8.CR (perubahan yang belum terkendali) & amandemen (customer)" <?= $listDetail['REASON_OF_DELAY'] == "8.CR (perubahan yang belum terkendali) & amandemen (customer)" ? 'selected' : ''; ?>> 8.CR (perubahan yang belum terkendali) & amandemen (customer)</option>
												<option value="9.Produk non core &non enterprise level solution (mitra)" <?= $listDetail['REASON_OF_DELAY'] == "9.Produk non core &non enterprise level solution (mitra)" ? 'selected' : ''; ?> >9.Produk non core &non enterprise level solution (mitra)</option>
												<option value="10.Keterbatasan kapabilitas mitra (mitra)" <?= $listDetail['REASON_OF_DELAY'] == "10.Keterbatasan kapabilitas mitra (mitra)" ? 'selected' : ''; ?> >10.Keterbatasan kapabilitas mitra (mitra)</option>
												<option value="11.Komitmen mitra(termasuk deal harga)(mitra)" <?= $listDetail['REASON_OF_DELAY'] == "11.Komitmen mitra(termasuk deal harga)(mitra)" ? 'selected' : ''; ?> >11.Komitmen mitra(termasuk deal harga)(mitra)</option>
											</select>
																					
											 <?php if(($this->session->userdata('nik_sess') == $listDetail['PM_NIK'])||($this->auth->get_access_value('MASTER')>0)) : ?>
											<button type="button" id="update_symtom" class="btn btn-info btn-addon col-md-4 offset-md-8" data-key="Add"><i class="fa fa-edit"></i> Update SYMTOM
											<?php endif; ?>
							</button>
										</td>
									</tr>
								<?php endif; ?>

							</table>
						</div>
						<div class="col-sm-12 col-md-12">
							<div class="row">

								<?php if(!empty($listDetail['DOC_RFP'])) : ?>
					            <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document RFP</label>
					                    <input id="doc_rfp" name="doc_rfp" type="file" accept="pdf" class="form-control file" >
					                </div>
					              </div>
					            <?php endif;?>

					              <?php if(!empty($listDetail['DOC_PROPOSAL'])) : ?>
					              <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document Proposal</label>
					                    <input id="doc_proposal" name="doc_proposal"type="file" accept="pdf" class="form-control file" >
					                </div>
					              </div>
					              <?php endif;?>

					              <?php if(!empty($listDetail['DOC_AANWIZING'])) : ?>
					              <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document Aanwizing</label>
					                    <input id="doc_aanwizing" name="doc_aanwizing" type="file" accept="pdf" class="form-control file" >
					                </div>
					              </div>
					              <?php endif;?>

					              <?php if(!empty($listDetail['DOC_SPK'])) : ?>
					              <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document SPK Customer *</label>
					                    <input id="doc_spk" name="doc_spk" data-key="doc_spk"  type="file" accept="pdf" class="form-control file" > 
					                </div>
					              </div>
					              <?php endif;?>

					              <?php if(!empty($listDetail['DOC_BAKN_PB'])) : ?>
					              <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document BAKN/P8</label>
					                    <input id="doc_bakn" name="doc_bakn" type="file" accept="pdf" class="form-control file" >
					                </div>
					              </div>
					              <?php endif;?>

					              <?php if(!empty($listDetail['DOC_KB'])) : ?>
					              <div class="col-md-3">
					                <div class="form-group">
					                  <label class=" control-label">Document KB</label>
					                    <input id="doc_kb" name="doc_kb" type="file" accept="pdf" class="form-control file" >
					                </div>
					              </div>
					              	<?php endif;?>

					              <?php if(!empty($listDetail['DOC_KL'])) : ?>
						              <div class="col-md-3">
						                <div class="form-group">
						                  <label class=" control-label">Document KL</label>
						                    <input id="doc_kl" name="doc_kl" type="file" accept="pdf" class="form-control file" >
						                </div>
						              </div>
					          		<?php endif;?>
					        </div>
						</div>
					</div>	

					
					
				</div>
			</div>
		</div>
	</div>	

	<div class="row">
		<div class="col-sm-12 col-md-12">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#deliverable" role="tab" aria-controls="deliverable">Deliverable <span class="badge badge-pill	 badge-info" style="font-size: 10px;visibility: hidden;" id="#badge_deliverable">0</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#issue" role="tab" aria-controls="issue">Issue <span class="badge badge-pill	 badge-info" style="font-size: 10px;visibility: hidden;" id="#badge_issue">0</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#action" role="tab" aria-controls="action">Action Plan <span class="badge badge-pill	 badge-info" style="font-size: 10px;visibility: hidden;" id="#badge_action">0</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#history" role="tab" aria-controls="history">Action History <span class="badge badge-pill	 badge-info" style="font-size: 10px;visibility: hidden;" id="#badge_history">0</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#bast" role="tab" aria-controls="history">BAST <span class="badge badge-pill	 badge-info" style="font-size: 10px;"><?= count($bast); ?> </span></a>
			</li>
		</ul>
			<div class="tab-content">
			<div class="tab-pane active" id="deliverable" role="tabpanel">
				<div class="row">
						<div class="col-sm-2">
							<button type="button" class="btn btn-success btnAddDeliverable btnGuest btn-addon" data-key="Add"><i class="fa fa-plus"></i> Add Deliverable
							</button>
	          			</div>
					
	          			<div class="col-sm-6 offset-md-4">   
	          				<div class="row">   		
		          				<div class="col-sm-6">
									<div class="card">
									<div class="card-body">
									<div>Sum Of Realization 
										<strong class="badge badge-pill badge-primary "><span class="h4"><?=number_format($sum_weight_real['TOTAL_WEIGHT'],2)?> %</span></strong>
									</div>
									<div class="progress progress-xs my-3">
									<div class="progress-bar bg-primary" role="progressbar" style="width: <?=number_format($sum_weight_real['TOTAL_WEIGHT'],2)?>%" aria-valuenow="<?=number_format($sum_weight_real['TOTAL_WEIGHT'])?> %" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="card">
									<div class="card-body">
									<div>Sum Of Realization 
										<strong class="badge badge-pill badge-success "><span class="h4"><?=number_format($sum_weight_real['REAL'],2)?> %</span></strong>
									</div>
									<div class="progress progress-xs my-3">
									<div class="progress-bar bg-success" role="progressbar" style="width: <?=number_format($sum_weight_real['REAL'],2)?>%" aria-valuenow="<?= number_format($sum_weight_real['REAL']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									</div>
									</div>
								</div>
							</div>
	          			</div>
	          	</div>

		              		 <div class="table-responsive w-xm wrapper">
							       	<table id="dataDeliverable" class="table b-t" style="width:100% !important;">
						                <thead class="thead-bg-blue">
						                <tr style="font-size: 12px;">
						                    <th style="width:10% !important">ID</th>
						                    <th style="width:30% !important">Deliverable</th>
						                    <th style="width:20%">Description</th>
						                    <th style="width:10%">Start Date</th>
						                    <th style="width:10%">End Date</th>
						                    <th style="width:5%">Weight</th>
						                    <th style="width:5%">Achievment</th>
						                    <th style="width:10% !important;">Action</th>
						                </tr>
						                </thead>
						                <tbody style="font-size: 12px;">
						                </tbody>
						            </table>
				            </div> 

				            <br>
				            <br>
				            <br>
				            <!-- <label>Detail Progress Deliverables</label> -->
				            <div class="col-sm-2" style="margin-bottom: 10px;">
								<!-- <button type="button" id="saveDetailDeliverable"  class=" btn btn-success btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>"><i class="fa fa-floppy-o"></i>Save
								</button> -->
								<a target="_blank" id="editDetailDeliverable"  class="btn btn-success btn-addon <?= ($this->auth->get_access_value('MASTER')>0||$this->session->userdata('nik_sess')==$listDetail['PM_NIK'])? '': 'hidden' ?>" href="<?= base_url();?>projects/listDeliverable/<?= $id_project;?>"><i class="fa fa-floppy-o"></i>Edit S Curve Manually
								</a>
		          			</div>
				            <!-- <div class="row nomarginLR" style="max-height: 700px !important; overflow-x: scroll;">
							       	<div id="listDeliverable" style="width: 100% !important;"></div>
				            </div>  -->


				            <!-- <label style="margin-top: 35px;">Detail PLAN</label>
				            <div class="col-sm-2" style="margin-bottom: 10px;">
								<a target="_blank" id="editDetailDeliverable"  class="btn btn-success btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>" href="<?= base_url();?>projects/listPlan/<?= $id_project;?>"><i class="fa fa-floppy-o"></i>Edit 
								</a>
		          			</div>
				            <div class="row nomarginLR" style="max-height: 700px !important; overflow-x: scroll;">
							       	<div id="listPlan" style="width: 100% !important;"></div>
				            </div>  --> 




			</div>
			<div class="tab-pane" id="issue" role="tabpanel">

      		<button type="button" class="col-sm-2 btn btn-success btnAddIssue btnGuest btn-addon" data-key="Add"><i class="fa fa-plus"></i> Add Issue
			</button>
							<div id="tableAll" class="table-responsive w-xm wrapper">
							       	<table id="dataIssue" class="table table-striped b-t" style="width:100% !important;">
						                <thead class="thead-bg-blue">
						                <tr style="font-size: 12px;">
						                    <th style="width:20% !important">Issue Name</th>
						                    <th style="width:20%">Impact</th>
						                    <th style="width:20%">Risk Impact</th>
						                    <th style="width:10%">Status</th>
						                    <th style="width:10%">Action Plan</th>
						                    <th style="width:4%">Action</th>
						                </tr>
						                </thead>
						                <tbody style="font-size: 12px;">
						                </tbody>
						            </table>
				            </div> 


			</div>
			<div class="tab-pane" id="action" role="tabpanel">
					<button type="button" class="col-sm-2 btn btn-success btnAddCheck btnAction btnGuest btn-addon" data-key="Add">
						<i class="fa fa-plus"></i> Add Action Plan
					</button>

					<div id="" class="table-responsive w-xm wrapper">
								       	<table id="dataActionPlan" class="table table-striped b-t" style="width:100% !important;">
							                <thead class="thead-bg-blue">
							                <tr style="font-size: 12px;">
							                    <th style="width:20% !important">Action Name</th>
							                    <th style="width:20%">Issue Name</th>
							                    <th style="width:20%">Due Date</th>
							                    <th style="width:10%">Remarks</th>
							                    <th style="width:10%">Risk Impact</th>
							                    <th style="width:4%">Action</th>
							                </tr>
							                </thead>
							                <tbody style="font-size: 12px;">
							                </tbody>
							            </table>
					            </div> 
			</div>
			<div class="tab-pane" id="history" role="tabpanel">
							<div id="" class="table-responsive w-xm wrapper">
								       	<table id="dataHistory" class="table table-striped b-t" style="width:100% !important;">
							                <thead class="thead-bg-blue">
							                <tr style="font-size: 12px;">
							                    <th style="width:20% !important">Action Name</th>
							                    <th style="width:20%">Issue Name</th>
							                    <th style="width:20%">Due Date</th>
							                    <th style="width:20%">Closed Date</th>
							                    <th style="width:10%">Remarks</th>
							                    <th style="width:10%">Status</th>
							                    <th style="width:10%">Risk Impact</th>
							                </tr>
							                </thead>
							                <tbody style="font-size: 12px;">
							                </tbody>
							            </table>
					            </div> 
			</div>

			<div class="tab-pane" id="bast" role="tabpanel">
				<label>List BAST Project</label>
							<div id="" class="table-responsive w-xm wrapper">
								       	<table id="dataBAST" class="table table-striped b-t" style="width:100% !important;">
							                <thead class="thead-bg-blue"> 
							                <tr style="font-size: 12px;">
							                    <th style="width:20% !important">Date Received</th>
							                    <th style="width:25%">No. SPK</th>
							                    <th style="width:25%">No. BAST</th>
							                    <th class="center" style="width:10%">Value</th>
							                    <th class="center" style="width:10%">Progress</th>
							                    <th style="width:10%">Status</th>
							                </tr>
							                </thead>
							                <tbody style="font-size: 12px;">
							                	<?php
							                	if(!empty($bast)) :
							                	 	foreach ($bast as $key => $value) :
							                	 ?>
							                	 	<tr class="nav-link-hgn" data-url="<?= base_url(); ?>bast/view/<?= $bast[$key]['ID_BAST']?>">
							                	 		<td><?= $bast[$key]['DATE_CREATED']; ?></td>
							                	 		<td><a href="<?= base_url().'bast/view/'.$bast[$key]['ID_BAST']; ?>"><?= $bast[$key]['NO_SPK']; ?></a></td>
							                	 		<td><?= $bast[$key]['NO_BAST']; ?></td>
							                	 		<td><span class='rupiah pull-right'><?= $bast[$key]['NILAI_RP_BAST']; ?></span></td>
							                	 		<td>
							                	 		<?php 
							                	 			if($bast[$key]['TYPE_BAST']=='OTC'||$bast[$key]['TYPE_BAST']=='PROGRESS'){ 
							                	 				echo $bast[$key]['PROGRESS_LAPANGAN']."%";
							                	 			}elseif ($bast[$key]['TYPE_BAST']=='TERMIN') {
							                	 			 	echo $bast[$key]['NAMA_TERMIN'];
							                	 			}else{
							                	 				echo $bast[$key]['RECC_START_DATE']." - ".$bast[$key]['RECC_END_DATE'];
							                	 				} ?>

							                	 		</td>
							                	 		<td><?= $bast[$key]['STATUS']; ?></td>
							                	 	</tr>
							                	<?php 
							                		endforeach;
							                	endif;
							                	?>
							                </tbody>
							            </table>
					            </div> 
			</div>
			</div> 
		</div>
	</div>

</div>





<!-- deliverables modals -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add-deliverables">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
      	<div class="modal-header">
			<h4 class="modal-title" id="modal-title-deliverable">Add Deliverable</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
		</div>
		<div class="modal-body relative">
                	<div class="modalLoading" style="display:none;">
						<div class="progress">
						  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width: 100%">
						  </div>
						</div>
                	</div>
                    <form method="POST" enctype="multipart/form-data" id="frmDeliver">
                    	<input type="hidden" name="id_project" id="id_project">
                    	<input type="hidden" name="id_lop_epic" id="id_lop_epic">
                    	<input type="hidden" name="status_proj" id="status_proj">
                    	<input type="hidden" name="symptom" id="symptom">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" class="form-control inputLogin" value="<?=$this->security->get_csrf_hash()?>">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Deliverable Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" maxlength="200" name="name" placeholder="Name" id="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Weight</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="weight" placeholder="Weight (Ex: 2.5)" max="<?=$deliv_weight['WEIGHT']?>" id="weight" value="">
                            	<span class="text-small">* Max. Input Weight <span id="devWeigVal"><?php echo ($deliv_weight['WEIGHT']);?></span></span>
                            </div>
                        </div>
                        <div class="form-group row editInput">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Progress Value</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="progress_value" placeholder="Progress Value" max="<?=$deliv_weight['ACH']?>" id="ach">
                            	<span class="text-small">* Max. Input Progress Value <span id="devAchVal"><?php echo ($deliv_weight['ACH']);?></span></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Start Date</label>
                            </div>
                            <div class="col-md-8">
                                <input type='text' class="form-control date-picker" id="start_date" placeholder="mm/dd/yyyy" name="start_date" readOnly/>
                                <input type='hidden' name="tamp_SD" id="tamp_SD"/>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">End Date</label>
                            </div>
                            <div class="col-md-8">
                                <input type='text' class="form-control date-picker"  placeholder="mm/dd/yyyy" id="end_date" name="end_date" readOnly/>
                                <input type='hidden' name="tamp_ED" id="tamp_ED"/>
                            </div> 
                        </div>
                         <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Attachment</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control attachment" name="attachment_deliverable" id="attachment_deliverable" accept="pdf">
                                <input type="hidden" name="attachment_deliverable_value" id="attachment_deliverable_value">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-control-label" for="l0">Description</label>
                            </div>
                            <div class="col-md-8">
                                <textarea name="description" cols="10" rows="3" class="form-control" maxlength="300" placeholder="Description" id="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                        	<div id="deliverable_last_update"  style="position: fixed;left:0%;margin-left: 5%;"></div>
		                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
		                    <button type="button" id="saveDeliverable" class="btn btn-primary btnTab" data-tab="deliverables">Save Deliverables</button>

		                </div>
                    </form>
                </div>
    </div>
  </div>
</div>

<!-- Mass upload modals -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="upload-deliverables">
  <div class="modal-dialog modal-primary">
    <div class="modal-content">
      	<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Mass Upload Deliverable</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
		</div>
		 <div class="modal-body relative">
        	<div class="modalLoading" style="display:none;">
				<div class="progress">
				  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width: 100%">
				  </div>
				</div>
        	</div>
            <form method="POST" enctype="multipart/form-data" id="frmMassUpload" action="<?=base_url()?>index.php/projects/UploadExcel/<?=$listDetail['ID_PROJECT']?>" method="post">    
                	<div class="form-group">
                    	<label>Pilih File : </label>
                    	<input name="file" class="form-control" type="file" />
                    </div>
						<div class="modal-footer center-block">
		                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
		                    <button type="submit" class="btn btn-primary btnTab inputFileAjx" data-tab="deliverables">Submit</button>
		                </div>                        
            </form>
        </div>
    </div>
  </div>
</div>

<!-- Issue modals -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add-issue">
	  <div class="modal-dialog modal-primary">
	    <div class="modal-content">
	      	<div class="modal-header">
				<h4 class="modal-title" id="modal-title-issue">Add Issue</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
			</div>
			 <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="frmIssue">
                    	<input type="hidden" name="idPro" value="<?=$listDetail['ID_PROJECT']?>">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="l0">Issue Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" maxlength="150" name="issue_name" placeholder="Issue Name" id="issue_name" required>
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="l0">Risk Impact</label>
                            </div>
                            <div class="col-md-9">
                               <select name="risk_impact" id="risk_impact" class="form-control" required="required">
                               	<option value="" disabled selected>Select Risk Impact</option>
                               	<option value="No Impact">No Impact</option>
                               	<option value="Potential Risk">Potential Risk</option>
                               	<option value="Significant Risk">Significant Risk</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">PIC Of Task</label>
                            </div>
                            <div class="col-md-9">
                            	<div class="input-group margin-bottom-5">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" name="pic_name[]" id="issue_picname1" class="form-control picClass" placeholder="PIC Name 1" style="width: 135px;" required>
                                </div>
                                <div class="input-group margin-bottom-10">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="email" name="pic_email[]" id="issue_picemail1" class="form-control picClass" placeholder="PIC Email 1" style="width: 135px;" required>
                                </div>

                                <div class="input-group margin-bottom-5">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" name="pic_name[]" id="issue_picname2" class="form-control picClass" placeholder="PIC Name 2" style="width: 135px;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="email" name="pic_email[]" id="issue_picemail2" class="form-control picClass" placeholder="PIC Email 2" style="width: 135px;">
                                </div>
                            </div>
                        </div>
                         <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Impact</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="impact" id="impact" class="form-control" maxlength="300" placeholder="Impact (Max. 300 Characters)" id="impact" required></textarea>
                            </div>
                        </div>

                       	<div class="form-group row" id="issue_attachment">
                            <div class="col-md-3">
                                <label class="form-control-label">Attachment</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control attachment" name="attachment_issue" id="attachment_issue">
                                <div class="linkAttc" style="display:none;">
                                	<a title="Download" class="btn btn-xs btn-default"></a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="attachment_issue_value" id="attachment_issue_value">
                        <div class="form-group row editInput">
                            <div class="col-md-3">
                                <label class="form-control-label">Status</label>
                            </div>
                            <div class="col-md-9">
                            	<input type="hidden" id="issueStatusId">
                                <select name="status" class="form-control statusSelect"  id="issueStatus">
                                	<option value="" disabled selected>Select Status</option>
                                	<option value="OPEN">OPEN</option>
                                	<option value="CLOSED">CLOSED</option>
                                </select>
                                <div id="cLosedArea">
                                	
                                </div>
                            </div>
                        </div>
                        <div class="form-group row closedIssue" style="display:none;">
                            <div class="col-md-3">
                                <label class="form-control-label cd">Closed Date</label>
                            </div>
                            <div class="col-md-9">
                               <input type="text" name="closed_date" placeholder="mm/dd/yyyy" class="date-picker form-control date-picker datepicker closed_date_issue">
                            </div>
                        </div>
                        <div class="modal-footer">
                        	<div id="issue_last_update"  style="position: fixed;left:0%;margin-left: 5%;"></div>
		                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
		                    <button type="button" class="btn btn-primary"  id="saveIssue" data-tab="issue">Save Issue</button>
		                </div>
                    </form>
                </div>
	    </div>
	  </div>
	</div>

<!-- Action Plan modals -->
 	<div class="modal fade" id="add-action-plan" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-primary" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<h4 class="modal-title">Add Action Plan</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
				</div>


                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="frmAction">
                    	<input type="hidden" name="idPro" value="<?=$listDetail['ID_PROJECT']?>">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" class="form-control inputLogin" value="<?=$this->security->get_csrf_hash()?>">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="l0">Task Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" maxlength="150" name="task_name" placeholder="Task Name" id="action_name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="l0">Assign To</label>
                            </div>
                            <div class="col-md-9">
                                <select name="assignto" class="form-control assignto" required>
                                	<option value="">Select Assign To</option>
                                	<?php foreach ($arrAssignTo as $assignts): ?>
                                		<option value="<?=$assignts?>"><?=$assignts?></option>
                                	<?php endforeach ?>
                                </select>

                                <select name="assignto_detail" class="form-control assignto_detail hidden margin-top-10"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Related Issue</label>
                            </div>
                            <div class="col-md-9">
                            	<select name="issued" id="issue_id" class="form-control" style="width:100%">
                            		<option value="" disabled selected>Select Related Issue</option>
	                            	<?php  
	                            		foreach ($get_list_issue->result() as $key => $value) {
	                            			?>
	                            				<option value="<?=$value->ID_ISSUE?>"><?=$value->ISSUE_NAME?></option>
	                            			<?php
	                            		}
	                            	?>
                            	</select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Due Date</label>
                            </div>
                            <div class="col-md-9">
                            	<input type="text" name="due_date"  class="form-control date-picker" id="due_date" placeholder="mm/dd/yyyy" required readOnly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">PIC Of Task</label>
                            </div>
                            <div class="col-md-9">
                            	<div class="input-group margin-bottom-5">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" name="pic_name[]" id="action_picname1" class="form-control picClass" placeholder="PIC Name 1"   aria-selected=true required  style="max-width: 135px;">
                                </div>
                                <div class="input-group margin-bottom-10">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="email" name="pic_email[]" id="action_picemail1" class="form-control picClass" placeholder="PIC Email 1" required  style="max-width: 135px;">
                                </div>

                                <div class="input-group margin-bottom-5">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input type="text" name="pic_name[]" id="action_picname2" class="form-control picClass" placeholder="PIC Name 2"  style="max-width: 135px;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-envelope"></i>
                                    </span>
                                    <input type="email" name="pic_email[]" id="action_picemail2" class="form-control picClass" placeholder="PIC Email 2"  style="max-width: 135px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label" for="l0">Attachment</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control attachment" name="attachment_action" id="attachment_action" accept="pdf">
                                <input type="hidden" name="attachment_action_value" id="attachment_action_value">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Remarks</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="remarks_action" class="form-control" maxlength="300" placeholder="Remarks (Max. 300 Characters)" id="remarks_action" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row editInput">
                            <div class="col-md-3">
                                <label class="form-control-label">Status</label>
                            </div>
                            <div class="col-md-9">
                                <select name="status_action" id="status_action" class="form-control statusSelect">
                                	<option value="" disabled selected>Select Status</option>
                                	<option value="OPEN">OPEN</option>
                                	<option value="CLOSED">CLOSED</option>
                                </select>
                            </div>
                        </div>
                         <div class="form-group row closedeAction hide" id="c_closedeAction">
                            <div class="col-md-3">
                                <label class="form-control-label cd">Closed Date</label>
                            </div>
     
                            <div class="col-md-9">
                               <input type="text" name="action_closed_date" placeholder="mm/dd/yyyy" class="form-control datepicker date-picker" id="action_close_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                        	<input type="hidden" name="cek_btn_AP" id="cek_btn_AP" value="old">
		                    <div id="action_last_update"  style="position: fixed;left:0%;margin-left: 5%;"></div>
		                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                    <button type="button" class="btn btn-SAP btn-primary btnTab" id="saveAction" data-tab="action_plan">
		                    	Save Action Plan
		                    </button>
		                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- list document modal -->
	<div class="modal fade" id="modalDocs" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">List Document</h4>
	      </div>
	      <div class="modal-body" style="overflow-x: auto !important;">
	        <form method="POST" enctype="multipart/form-data">
	        </form>
	        <table class="table table-striped" style="display: inherit;">
	        	<tbody style="overflow:scroll;display: inherit;">
	        		<?php if (array_filter($listDocs->row_array())): ?>
	        			<?php foreach ($listDocs->result_array() as $key => $value): ?>
	        				<?php foreach ($listDocs->list_fields() as $fields): ?>
	        				<?php if (!empty($value[$fields])): ?>
	        					<tr>
			        				<td style="display: auto !important;"><?=$value[$fields]?></td>
			        				<td><?=humanize($fields)?></td>
			        				<td class="col-xs-2">
			        					<a href="<?=base_url('../_files/'.$value[$fields])?>" download class="btn btn-primary btn-xs">
			        						<i class="glyphicon glyphicon-download-alt"></i> Download
			        					</a>
			        				</td>
			        			</tr>
	        				<?php endif; ?>
	        				<?php endforeach; ?>
	        			<?php endforeach; ?>
	        		<?php else: ?>
	        			<tr>
	        				<td colspan="4" class="text-center">No Document Available</td>
	        			</tr>
	        		<?php endif;?>
	        	</tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


<!-- MODAL -->

<!-- deliverables modals -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalDocument" aria-hidden="true" id="modalDocument">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
      	<div class="modal-header">
			<h4 class="modal-title" id="modal-title-deliverable">Documents Project</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
				</button>
		</div>
		<div class="modal-body relative">
                	<div class="modalLoading" style="display:none;">
						<div class="progress">
						  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width: 100%">
						  </div>
						</div>
                	</div>
                    <form method="POST" enctype="multipart/form-data" id="frmDocumentProject">
                         <div class="row">
                         	<div class="col-sm-12">
                         		<div class="col-md-12">
                         			<table id="dataAll" class="table b-t" style="width:100% !important;overflow-x:hidden;">
						                  <thead class="thead-bg-blue">
						                  <tr>
						                  	  <th style="width:10%;">Category</th>
						                      <th style="width:80%;">Document</th>					                      
						                      <th style="width:10%;">Download</th>                  
						                  </tr>
						                  </thead>
						                  <tbody>
						                  	<?php foreach($document as $key=>$value) :?>
						                          <tr>
						                              <td><?= $document[$key]['CATEGORY']; ?></td>
						                              <td><?= $document[$key]['ATTACHMENT']; ?></td>
						                              <td>
						                              	<a style="font-size:10px;width:30px;margin-left: 10px;" 
						                              	class="circle btn btn-xs btn-success"
						                              	href="<?= $document[$key]['CATEGORY']=='P8'? $document[$key]['ATTACHMENT'] : 
						                              	'https://prime.telkom.co.id/sdv/../_files/'.$document[$key]['ATTACHMENT']; ?>" download target="_blank">
						                              		<i class="fa fa-arrow-circle-down"></i>
						                              	</a>
						                              </td>
						                          </tr>
						                      <?php endforeach; ?>
						                  </tbody>
						              </table>
                         		</div>

                          		<div class="row">
                         			<div class="offset-md-4 col-md-4">
	                         			<div class="form-group">
				                                <input type="file" class="form-control" name="documentProject[]" id="documentProject">
				                        </div>
	                         		</div>
                         		</div>

                         		<div class="row">
                         			<div class="offset-md-4 col-md-4">
	                         			<div class="form-group">
				                               <select class="form-control" name="document_category" id="document_category">
					                               	<option value="Documentation">Documentation</option>
					                               	<option value="MOM">Minute Of Meeting</option>
					                               	<option value="Presentation">Presentation</option>
					                               	<option value="Others">Others</option>
				                               </select>
				                        </div>
	                         		</div>
                         		</div>
                         		
	                         			
	                         		
                         		
                         		<div class="offset-md-5 col-md-2">
                         			<button type="button" 
                         			style="width: 100%;" 
                         			class="btn btn-success" 
                         			id="btnDocumentSubmit">
                         				Submit
                         			</button>
                         		</div>	
                         	</div>
                         </div>
                         

                    </form>
                </div>
    </div>
  </div>
</div>


<script type="text/javascript">  
var id_project = "<?= $id_project; ?>";
var weight 			= '<?=$deliv_weight['WEIGHT']?>';
var total_weight 	= '<?=$sum_weight_real['TOTAL_WEIGHT']?>'; 
var start_week_1	= '<?=$listDetail['START_WEEK_1']?>';


	var Page = function () {

		<?php if(!empty($listDetail['DOC_RFP'])) : ?>
              $("#doc_rfp").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_RFP'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_RFP'] ?>", downloadUrl: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_RFP'] ?>"}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_PROPOSAL'])) : ?>
              $("#doc_proposal").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_PROPOSAL'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_PROPOSAL'] ?>", downloadUrl: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_PROPOSAL'] ?>"}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_AANWIZING'])) : ?>
              $("#doc_aanwizing").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_AANWIZING'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_AANWIZING'] ?>", downloadUrl: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_AANWIZING'] ?>"}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_SPK'])) : ?>
              $("#doc_spk").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_SPK'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_SPK'] ?>", downloadUrl: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_SPK'] ?>"}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_BAKN_PB'])) : ?>
              $("#doc_bakn").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_BAKN_PB'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_BAKN_PB'] ?>", downloadUrl: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_BAKN_PB'] ?>"}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_KB'])) : ?>
              $("#doc_kb").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_KB'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_KB'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>

              <?php if(!empty($listDetail['DOC_KL'])) : ?>
              $("#doc_kl").fileinput({
                  overwriteInitial: false,
                  initialPreview: [
                      "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_KL'] ?>",
                  ],
                  initialPreviewAsData: true,
                  initialPreviewConfig: [
                      {type: "pdf", url: "https://prime.telkom.co.id/_files/<?= $listDetail['DOC_KL'] ?>", downloadUrl: false}, 
                  ],
                  purifyHtml: true, 
                  autoReplace: true,
                  maxFileCount: 1,
                  overwriteInitial: true,
                  initialPreviewShowDelete : false,                   
                  showRemove:false,
                  showUpload:false,
              });
              <?php endif; ?>
              $(".file-caption-main").addClass('hidden');
		
		var tmp = "";
		var awesomplete3 = new Awesomplete('#issue_picname1', {
	        minChars: 1,
	    });
	    var awesomplete4 = new Awesomplete('#issue_picname2', {
	        minChars: 1,
	    });

	    var awesomplete5 = new Awesomplete('#action_picname1', {
	        minChars: 1,
	    });

	    var awesomplete6 = new Awesomplete('#action_picname2', {
	        minChars: 1,
	    });

	    $('#documentProject').fileinput({
            maxFileCount: 1,    
            autoReplace: true,               
            dropZoneEnabled: false,
            mainClass: "input-group",
            showUpload:false,
            showRemove:false,
            initialPreview  : false,
            uploadAsync     : false,
            autoReplace: true, 
            maxFileCount: 1,
		});  


		$('#attachment_deliverable').fileinput({
						  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
			              showRemove:false,
		});   
		$('#attachment_issue').fileinput({
						  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
						  showRemove:false, 		
		});	
		$('#attachment_action').fileinput({
						  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
						  showRemove:false,
		});

      	var tableDeliverable  	= function(){
      				$('#dataDeliverable').DataTable({
      		initComplete: function(settings, json) {
               console.log('table deliverables initiation');
              },
            dom: '<f"top">rt<"bottom"><"clear">',
            responsive: false,
            order: [0,'asc'],
            processing: true,
            serverSide: true,
            paging : false,
            destroy: true,
            ajax: { 'url':base_url+'projects/get_list_deliverable', 'type':'POST','data' : {id_project : id_project}  },
            aoColumns: [
                { mData: 'ID_DELIVERABLE'},
                { mData: 'NAME'},
                { mData: 'DESCRIPTION' },
                { mData: 'START_DATE' },
                { mData: 'END_DATE' },
                { 
                    'mRender': function(data, type, obj){   
                            return obj.WEIGHT2 + ' %';   
                    }            
                },
                { 
                    'mRender': function(data, type, obj){   
                            if(obj.PROGRESS_VALUE != null){
                                return obj.PROGRESS + ' %';
                            }else{
                                return "0 %";
                            }   
                    }            
                            
                },
                {
                    'mRender': function(data, type, obj){

                           return   "<span style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success BtnUpdateDeliverable  circle2 \' data-id='"+obj.ID_DELIVERABLE+"' ><i class='fa fa-cloud-upload-alt'></i></span> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteDeliverable circle2  \' data-id='"+obj.ID_DELIVERABLE+"' data-url="+base_url+"projects/deleteDeliverable?id_deliverable="+obj.ID_DELIVERABLE+"&id_project="+id_project+"  ><i class='fa fa-trash'></i></a> ";
                    }

                }
               ],
               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $(nRow).addClass( aData['INDIKATOR'] );
                    return nRow;
                    }         
       			 });
      	}
      				
   		var tableIssue 			= function(){
   					$('#dataIssue').DataTable({
            dom: '<"top">rt<"bottom"f><"clear">',
            destroy: true,
            responsive: false,
            processing: true,
            serverSide: true,
            paging : false,
            "order": [[ 3, 'desc' ], [ 0, 'asc' ]],
            /*searching : false,*/
            ajax: { 'url':base_url+'projects/get_list_Issue', 'type':'POST','data' : {id_project : id_project}  },
            aoColumns: [
                { mData: 'ISSUE_NAME'},
                { mData: 'IMPACT'},
                { mData: 'RISK_IMPACT'},
                { mData: 'STATUS_ISSUE'},
                { 
                    'mRender': function(data, type, obj){   
                            if(obj.ACTION_NAME != null){
                                return obj.ACTION_NAME;
                            }else{
                                return "-";
                            }   
                    }            
                            
                },
                {
                    'mRender': function(data, type, obj){

                           return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateIssue   \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteIssue  \' data-id='"+obj.ID_ISSUE+"' data-url='"+base_url+"projects/deleteIssue?&id_issue="+obj.ID_ISSUE+"&id_project="+id_project+"'  ><i class='fa fa-trash'></i></a> ";
                    }

                }
               ],
               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $(nRow).addClass( aData['ISSUE'] );
                    return nRow;
                    }         
    		    });
    	}

    	var tableActionPlan 	= function(){
    				$('#dataActionPlan').DataTable({
    				destroy: true,
		            dom: '<"top">rt<"bottom"f><"clear">',
		            responsive: false,
		            processing: true,
		            serverSide: true,
		            paging : false,
		            /*searching : false,*/
		            ajax: { 'url':base_url+'projects/get_list_ActionPlan', 'type':'POST','data' : {id_project : id_project}  },
		            aoColumns: [
		                { mData: 'ACTION_NAME'},
		                { mData: 'ISSUE_NAME'},
		                { mData: 'DUE_DATE'},
		                { mData: 'ACTION_REMARKS'},
		                { mData: 'RISK_IMPACT'},
		                {
		                    'mRender': function(data, type, obj){

		                           return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateActionPlan  \' data-id='"+obj.ID_ACTION_PLAN+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
		                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteActionPlan  \' data-id='"+obj.ID_ACTION_PLAN+"' data-url='"+base_url+"projects/delete_action_plan/"+obj.ID_ACTION_PLAN+"/"+obj.ID_PROJECT+"'  ><i class='fa fa-trash'></i></a> ";
		                    }

		                }
		               ],
		               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		                    $(nRow).addClass( aData['ISSUE'] );
		                    return nRow;
		                    }         
					});
    	}

		var tableHistory 		= function(){

					$('#dataHistory').DataTable({
		            dom: '<"top">rt<"bottom"f><"clear">',
		            destroy: true,
		            responsive: false,
		            processing: true,
		            serverSide: true,
		            paging : false,
		            /*searching : false,*/
		            ajax: { 'url':base_url+'projects/get_list_HisActionPlan', 'type':'POST','data' : {id_project : id_project}  },
		            aoColumns: [
		                { mData: 'ACTION_NAME'},
		                { mData: 'ISSUE_NAME'},
		                { mData: 'DUE_DATE'},
		                { mData: 'ACTION_CLOSED_DATE'},
		                { mData: 'ACTION_REMARKS'},
		                { mData: 'ACTION_STATUS'},
		                { mData: 'RISK_IMPACT'}
		               ],
		               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		                    $(nRow).addClass( aData['ISSUE'] );
		                    return nRow;
		                    }         
			        });
		}

		var save_chart 		= function(){

					$('#dataHistory').DataTable({
		            dom: '<"top">rt<"bottom"f><"clear">',
		            destroy: true,
		            responsive: false,
		            processing: true,
		            serverSide: true,
		            paging : false,
		            /*searching : false,*/
		            ajax: { 'url':base_url+'projects/get_list_HisActionPlan', 'type':'POST','data' : {id_project : id_project}  },
		            aoColumns: [
		                { mData: 'ACTION_NAME'},
		                { mData: 'ISSUE_NAME'},
		                { mData: 'DUE_DATE'},
		                { mData: 'ACTION_CLOSED_DATE'},
		                { mData: 'ACTION_REMARKS'},
		                { mData: 'ACTION_STATUS'},
		                { mData: 'RISK_IMPACT'}
		               ],
		               fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
		                    $(nRow).addClass( aData['ISSUE'] );
		                    return nRow;
		                    }         
			        });
		}

      return {	
          init: function() { 
          	tableDeliverable();
          	tableIssue();
          	tableActionPlan();
          	tableHistory();
          	$('#issue_picname1').on("keyup", function(e){
					e.stopImmediatePropagation();
				    var q = $(this).val();
				    if(tmp!=q){
					    $.ajax({
					        type:"GET",
					        url: base_url+"json/get_json_pic?q="+q,
					        success : function(data){
					            tmp = q;
					            var results = JSON.parse(data).map(function(i){
					                    return { label: i.NAMA+' - '+i.EMAIL, value: i.NAMA };
					                });
					                awesomplete3.list = results;
					        }
					    });
					}
				});

		    Awesomplete.$('#issue_picname1').addEventListener("awesomplete-selectcomplete", function(e) {
		    	e.stopImmediatePropagation();
		        var q = $(this)[0]['value'];
		        $.ajax({
		            type:"GET",
		            url: base_url+"json/get_json_pic_email?q="+q,
		            success : function(data){
		                $("#issue_picemail1").val(data);
		            }
		        });
		    });

		    
		    $('#issue_picname2').on("keyup", function(){
		        var q = $(this).val();
		        if(tmp!=q){
			        $.ajax({
			            type:"GET",
			            url: base_url+"json/get_json_pic?q="+q,
			            success : function(data){
			                tmp = q;
			                var results = JSON.parse(data).map(function(i){
			                        return { label: i.NAMA+' - '+i.EMAIL, value: i.NAMA };
			                    });
			                    awesomplete4.list = results;
			            }
			        });
			    }
		    });

		    Awesomplete.$('#issue_picname2').addEventListener("awesomplete-selectcomplete", function() {
		        var q = $(this)[0]['value'];
		        $.ajax({
		            type:"GET",
		            url: base_url + "json/get_json_pic_email?q="+q,
		            success : function(data){
		                $("#issue_picemail2").val(data);
		            }
		        });
		    });

		    $('#action_picname1').on("keyup", function(){
		        var q = $(this).val();
		        if(tmp!=q){
			        $.ajax({
			            type:"GET",
			            url: base_url + "json/get_json_pic?q="+q,
			            success : function(data){
			                tmp = q;
			                var results = JSON.parse(data).map(function(i){
			                        return { label: i.NAMA+' - '+i.EMAIL, value: i.NAMA };
			                    });
			                    awesomplete5.list = results;
			            }
			        });
			    }
		    });

		    Awesomplete.$('#action_picname1').addEventListener("awesomplete-selectcomplete", function() {
		        var q = $(this)[0]['value'];
		        $.ajax({
		            type:"GET",
		            url: base_url+ "json/get_json_pic_email?q="+q,
		            success : function(data){
		                $("#action_picemail1").val(data);
		            }
		        });
		    });

		    

		    $('#action_picname2').on("keyup", function(){
		        var q = $(this).val();
		        if(tmp!=q){
			        $.ajax({
			            type:"GET",
			            url: base_url + "json/get_json_pic?q="+q,
			            success : function(data){
			                // console.log(data);
			                var results = JSON.parse(data).map(function(i){
			                        return { label: i.NAMA+' - '+i.EMAIL, value: i.NAMA };
			                    });
			                    awesomplete6.list = results;
			            }
			        });
			    }
		    });

		    Awesomplete.$('#action_picname2').addEventListener("awesomplete-selectcomplete", function() {
		        var q = $(this)[0]['value'];
		        $.ajax({
		            type:"GET",
		            url: base_url+ "json/get_json_pic_email?q="+q,
		            success : function(data){
		                $("#action_picemail2").val(data);
		            }
		        });
		    });


		    Awesomplete.$('#issue_picname1').addEventListener("awesomplete-selectcomplete", function() {
		        var q = $(this)[0]['value'];
		        $.ajax({
		            type:"GET",
		            url: base_url +  "json/get_json_pic_email?q="+q,
		            success : function(data){
		                $("#issue_picemail1").val(data);
		            }
		        });
		    });
			
			$("body").on('click','#saveDeliverable', function (e) {
				e.stopImmediatePropagation();
				var dataForm  = $('#frmDeliver').serialize();
				var url = base_url + $("#frmDeliver").attr('action');
				$('#add-deliverables').modal('hide');
				$('#pre-load-background').fadeIn();
				$.ajax({
	                    url: url,
	                    type:'POST',
	                    data:  dataForm ,
	                    success:function(result){
	                    	tableDeliverable();
	                    	$('#pre-load-background').fadeOut();
	                    	location.reload();
	                         return result;
	                    }

	            });
			});


			$(document).on('click','#btnDocumentSubmit', function (e) {
                e.stopImmediatePropagation();
                if($('#frmDocumentProject').valid()){
                    $('#pre-load-background').fadeIn();
                    var form = $('#frmDocumentProject')[0];
                    var formData = new FormData(form);
                    $.ajax({
                                  url: base_url+'projects/addDocumentProject/<?= $id_project; ?>',
                                  type:'POST',
                                  dataType : "json",
                                  data:  formData ,
                                  async : true, 
                                  processData: false,
                                  contentType: false,
                                  processData:false
                          	}).done(function(result) {
							  	$('#pre-load-background').fadeOut();
                                  if(result.result.trim()=='success'){
                                  	bootbox.alert("Success!", function(){ 
                                    	location.reload(); 
                                	});
                                  }else{
                                  	console.log(result);
                                  }
							});;
                  }

              });

			$(document).on('click','#btnDocument', function (e) {
				e.stopImmediatePropagation();
				$('#modalDocument').modal('show');
			});

			$("body").on('click','#saveIssue', function (e) {
				e.stopImmediatePropagation();
				var dataForm  = $('#frmIssue').serialize();
				var url = base_url + $("#frmIssue").attr('action');
				$('#add-issue').modal('hide');
				$('#pre-load-background').fadeIn();
				$.ajax({
	                    url: url,
	                    type:'POST',
	                    data:  dataForm ,
	                    success:function(result){
	                    	tableIssue();
	                    	tableHistory();
	                    	$('#pre-load-background').fadeOut();
			                location.reload(); 
	                         return result;
	                    }

	            });
			});

			$("body").on('click','#saveAction', function (e) {
				e.stopImmediatePropagation();
				var dataForm  = $('#frmAction').serialize();
				var url = $("#frmAction").attr('action');
				$('#add-action-plan').modal('hide');
				$('#pre-load-background').fadeIn();
				$.ajax({
	                    url: url,
	                    type:'POST',
	                    data:  dataForm ,
	                    success:function(result){
	                    	tableActionPlan();
	                    	tableHistory();
	                    	$('#pre-load-background').fadeOut();
			                console.log(result); 
	                         return result;
	                    }

	            });
			});

			$(document).on('change', '.attachment', function(event, numFiles, label) {
				console.log('file upload');
				$(this).fileinput("upload");
			});
            
            $(document).on('change', '#status_action', function(event, numFiles, label) {
				var stts 	= $('#status_action').val();
				if(stts == 'CLOSED'){
					$('#c_closedeAction').removeClass('hide');
				}else{
					$('#c_closedeAction').addClass('hide');
				}
			});
               

			$(document).on('fileuploaded','#attachment_deliverable', function(event, data, previewId, index) {
			     var file_path = data.response.file_name;
			     $('#attachment_deliverable_value').val(file_path); 
			});

			$(document).on('fileuploaderror','#attachment_deliverable', function(event, data, previewId, index) {
				$('#attachment_deliverable_value').val('');
			});

			$(document).on('fileuploaded','#attachment_issue', function(event, data, previewId, index) {
			     var file_path = data.response.file_name;
			     alert(file_path);
			     $('#attachment_issue_value').val(file_path); 
			});

			$(document).on('fileuploaderror','#attachment_issue', function(event, data, previewId, index) {
				$('#attachment_issue_value').val('');
			});

			$(document).on('fileuploaded','#attachment_action', function(event, data, previewId, index) {
			     var file_path = data.response.file_name;
			     $('#attachment_action_value').val(file_path);
			     console.log($('#attachment_action_value').val()); 
			});

			$(document).on('fileuploaderror','#attachment_action', function(event, data, previewId, index) {
				$('#attachment_action_value').val('');
			});


			$(document).on('click','.btnAddDeliverable', function () {
                    $("#frmDeliver").attr('action','projects/addDeliverable/<?= $id_project;?>');
                    $('#name').val('');
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#description').text('');
                    $("#weight").attr('max',Number(weight));
                    $("#devWeigVal").html(Number(weight));
                    $("#deliverable_last_update").html('');
                    $("#modal-title-deliverable").html("Add Deliverable");

                    $(".editInput").hide();
                    $("#start_date").removeAttr('readonly');
                    $("#end_date").removeAttr('readonly');
                    if (Number(total_weight)==100) {
                        $("#weight").attr('readonly','readonly'); 
                        $("#weight").removeAttr('max');
                    }else{
                        $("#weight").removeAttr('readonly');
                    }

                    $('#attachment_deliverable_value').val('');
                    $('#attachment_deliverable').fileinput('clear');
                    $('#attachment_deliverable').fileinput('destroy');

                    $('#attachment_deliverable').fileinput({
						  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
						  showRemove:false,
					});
                    $('#add-deliverables').modal('show');       
            });


	         $("#ui-view").on('click','.BtnUpdateDeliverable', function (e) {
	         		e.stopImmediatePropagation();
	                $.ajax({
	                        type:"POST",
	                        url:base_url+"projects/get_detail_deliverable",
	                        data:{'id_deliverable':$(this).data('id')},
	                        success: function(datajson) {
	                            var data = jQuery.parseJSON(datajson);
	                            $("#frmDeliver").attr('action','projects/updateDeliverable/'+data['ID_DELIVERABLE']);
	                            $("#id_project").val(data['ID_PROJECT']);
	                            $("#id_lop_epic").val(data['ID_LOP_EPIC']);
	                            $("#status_proj").val(data['STATUS']);
	                            $("#symptom").val(data['REASON_OF_DELAY']);
	                            $("#name").val(data['NAME']);
	                            $("#weight").attr('readonly','readonly');
	                            if (Number(total_weight)==100) {
	                                $("#weight").val(data['WEIGHT']);
	                                $("#weight").attr('readonly','readonly');
	                                $("#weight").removeAttr('max');
	                            }else{
	                                $("#weight").val(data['WEIGHT']);
	                                $("#weight").attr('max',Number(data['WEIGHT']));
	                                $("#devWeigVal").html(Number(data['WEIGHT']));
	                            }
	                            
	                            $("#ach").val(data['PROGRESS_VALUE']);
	                            $("#deliverable_last_update").html("last update "+data['LAST_UPDATE2']);
	                            $("#ach").attr('max',Number(data['WEIGHT']));
	                            $("#devAchVal").html(Number(data['WEIGHT']));
	                            $("#start_date").datepicker('setDate', new Date(data['START_DATE']));
	                            $("#end_date").datepicker('setDate',new Date(data['END_DATE']));
	                            $("#tamp_SD").datepicker('setDate', new Date(data['START_DATE']));
	                            $("#tamp_ED").datepicker('setDate',new Date(data['END_DATE']));
	                            $("#description").val(data['DESCRIPTION']);
	                            var attachment_deliverable = data['ATTACHMENT'];

	                           	if(attachment_deliverable != null){
		                        	$("#attachment_deliverable_value").val(attachment_deliverable);
		                            $("#attachment_deliverable").fileinput('destroy');
		                            $("#attachment_deliverable").fileinput({
						                  overwriteInitial: true,
						                  initialPreview: [
						                      	'https://prime.telkom.co.id/_files/'+id_project+'/deliverable/'+attachment_deliverable,
						                  ],
						                  initialPreviewAsData: true,
						                  initialPreviewConfig: [
						                      {type: "pdf", url: 'https://prime.telkom.co.id/_files/'+id_project+'/deliverable/'+attachment_deliverable, downloadUrl: false}, 
						                  ],
						                  purifyHtml: true, 
						                  autoReplace: true,
						                  maxFileCount: 1,
						                  overwriteInitial: true,
						                  initialPreviewShowDelete : false,                   
						                  showRemove:false,
						                  showUpload:false,
						                  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
										  autoReplace: true,
								          maxFileCount: 1,                   
								          dropZoneEnabled: false,
							              mainClass: "input-group"
						              });
	                            }
	                            $(".editInput").show();
	                            $("#modal-title-deliverable").html("Update Progress Deliverable");
	                        },
	                        complete: function() {
	                            $('#add-deliverables').modal('show');
	                        },
	                    })     
	            });

	        $('#ui-view').on('click','.btnDeleteDeliverable', function (e) {
	        	e.stopImmediatePropagation();
	                var url = $(this).data('url');
	                bootbox.confirm({
	                    message: "Did you sure delete this <i><b> Deliverable </b><i> permanently?",
	                    buttons: {
	                            cancel: {
	                                label: 'No',
	                                className: 'btn-danger col-md-offset-4 col-md-2'
	                            },
	                            confirm: {
	                                label: 'Yes',
	                                className: 'btn-success col-md-2'
	                            }
	                    },
	                    callback: function (result) {
	                        if(result){
									$('#add-deliverables').modal('hide');
									$('#pre-load-background').fadeIn();
									$.ajax({
						                    url: url,
						                    type:'get',
						                    async:false,
						                    success:function(result){
						                    	tableDeliverable();
						                    	$('#pre-load-background').fadeOut();
						                         return result;
						                    }

						            });
	                            
	                        }
	                    }
	                });
	        });

	        $(document).on('click','.btnAddIssue', function () {
	        			$('#issue_name').val('');
	        			$('#impact').text('');
	                    $("#frmIssue").attr('action','projects/add_issue/'+id_project);
	                    $("#modal-title-issue").html("Add New Issue");
	                    $(".editInput").hide();
	         			$("#issue_last_update").html('');
	                    $('#attachment_issue_value').val('');
	                    $('#attachment_issue').fileinput('clear'); 
	                    $('#attachment_issue').fileinput('destroy'); 
	                    $('#attachment_issue').fileinput({
							  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
							  autoReplace: true,
					          maxFileCount: 1,                   
					          dropZoneEnabled: false,
				              mainClass: "input-group",
			              	  showUpload:false,
						  	  showRemove:false,
						});	    
						$('#add-issue').modal('show');
	            });

	        $(document).on('click','.btnUpdateIssue', function (e) {
	        	e.stopImmediatePropagation();
	            var id_issue = $(this).data('id');
	                $("#issueStatusId").val(id_issue);
	                    $.ajax({
	                        type:"POST",
	                        url: base_url+"projects/get_detail_issue",
	                        data:{'id_issue':id_issue},
	                        beforeSend: function() {
	                            $(".loaderArea").fadeIn('slow');
	                        },
	                        success: function(datajson) {
	                            var data = jQuery.parseJSON(datajson);
	                            $("#frmIssue").attr('action','projects/updateIssue/'+ id_issue);
	                            $("#issue_name").val(data['ISSUE_NAME']);
	                            $("#risk_impact").val(data['RISK_IMPACT']);
	                            $("#mitigation_plan").val(data['MITIGATION_PLAN']);
	                            $("#impact").val(data['IMPACT']);
	                            $("#issue_last_update").html("last update "+data['LAST_UPDATE2']);
	                            if (data['pics'].length > 0) {
	                                if (data['pics'][0]['PIC_NAME'] != null) {
	                                    $("#issue_picname1").val(data['pics'][0]['PIC_NAME']);
	                                }
	                                if (data['pics'][0]['PIC_EMAIL'] != null) {
	                                    $("#issue_picemail1").val(data['pics'][0]['PIC_EMAIL']);
	                                }
	                                if ($.isPlainObject(data['pics'][1])) {
	                                    if (data['pics'][1]['PIC_NAME'] != null) {
	                                        $("#issue_picname2").val(data['pics'][1]['PIC_NAME']);
	                                    }
	                                    if (data['pics'][1]['PIC_EMAIL'] != null) {
	                                        $("#issue_picemail2").val(data['pics'][1]['PIC_EMAIL']);
	                                    }
	                                    
	                                }
	                            }
	                            $('.statusSelect').val(data['STATUS_ISSUE']);
	                            if (data['ISSUE_ATTACHMENT'] !=null && data['ISSUE_ATTACHMENT'] != '' && data['ISSUE_ATTACHMENT'] != 'null') {
	                                $(".linkAttc a").attr('href',base_url+"../_files/"+data['ISSUE_ATTACHMENT']);
	                                $(".linkAttc a").text(data['ISSUE_ATTACHMENT']);
	                                $(".linkAttc").show();
	                                $("#attachment_issue_value").val(data['ISSUE_ATTACHMENT']);
		                            var attachment_issue = data['ISSUE_ATTACHMENT'];
		                        	console.log(attachment_issue);
		                            $("#attachment_issue").fileinput('destroy');
		                            $("#attachment_issue").fileinput({
						                  overwriteInitial: false,
						                  initialPreview: [
						                      'https://prime.telkom.co.id/_files/'+id_project+'/issue/'+ attachment_issue,
						                  ],
						                  initialPreviewAsData: true,
						                  initialPreviewConfig: [
						                      {type: "pdf", url: 'https://prime.telkom.co.id/_files/'+id_project+'/issue/'+attachment_issue, downloadUrl: false}, 
						                  ],
						                  purifyHtml: true, 
						                  autoReplace: true,
						                  maxFileCount: 1,
						                  overwriteInitial: true,
						                  initialPreviewShowDelete : false,                   
						                  showRemove:false,
						                  showUpload:false,
						                  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
										  autoReplace: true,
								          maxFileCount: 1,                   
								          dropZoneEnabled: false,
							              mainClass: "input-group"
						              });
	                            	//$("#issue_attachment").removeClass("hidden");
	                            }else{
	                                $(".linkAttc").hide();
	                                $(".file-caption-name").attr('title','');
	                                //$("#issue_attachment").addClass("hidden");
	                            }

	                            if(data['STATUS_ISSUE']=="CLOSED" && data['ISSUE_CLOSED_DATE2']!= null){
	                                $(".closed_date_issue").val(data['ISSUE_CLOSED_DATE2'])
	                                $(".closedIssue").show();
	                            }
	                            $(".editInput").show();
	                            $(".modal-title").html("Update Issue");

	                            
	                        },
	                        complete: function() {
	                            $('#add-issue').modal('show');
	                        }

	                    });
	                
	            });
			
			$(document).on('change','.statusSelect', function (e) {
				if($('.statusSelect').val() == "CLOSED"){
					$(".closedIssue").show();
				}else{
					$(".closedIssue").hide();
				}
			});

	        $(document).on('click','.btnDeleteIssue', function (e) {
	        		e.stopImmediatePropagation();
	                var url = $(this).data('url');
	                bootbox.confirm({
	                    message: "Did you sure delete this <i><b> Issue </b><i> permanently?",
	                    buttons: {
	                            cancel: {
	                                label: 'No',
	                                className: 'btn-danger col-md-offset-4 col-md-2'
	                            },
	                            confirm: {
	                                label: 'Yes',
	                                className: 'btn-success col-md-2'
	                            }
	                    },
	                    callback: function (result) {
	                        if(result){                            
								$('#pre-load-background').fadeIn();
								$.ajax({
					                    url: url,
					                    type:'get',
					                    async:false,
					                    success:function(result){
					                    	tableIssue();
					                    	$('#pre-load-background').fadeOut();
							                console.log(result); 
					                         return result;
					                    }

					            });
	                            
	                        }
	                    }
	                });
	        });

	        $(document).on('click','.btnMUpload', function () {
				$('#upload-deliverables').modal('show');			
				});

	        $(document).on('click','.btnAction', function (e) {
	        	e.stopImmediatePropagation();
	        		$('#c_closedeAction').addClass('hide');
	        		$("#due_date").val('');
	        		$("#remarks_action").val('');
	        		$("#action_name").val('');
	        		$("#action_last_update").html('');
	        		$("#attachment_action_value").val('');
	        		$("#attachment_action").fileinput('destroy');
	        		var attachment_action = 'null';

					$('#attachment_action').fileinput({
							  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
							  autoReplace: true,
					          maxFileCount: 1,                   
					          dropZoneEnabled: false,
				              mainClass: "input-group",
			             	  showUpload:false,
						  	  showRemove:false, 
						});	
						$("#frmAction").attr('action','<?=base_url()?>index.php/projects/addAction/<?=$listDetail['ID_PROJECT']?>');
						$(".modal-title").html("Add Action Plan");
						$(".editInput").hide();
						$('#add-action-plan').modal('show');
				});

	        $(document).on('click','.btnAddIssue', function () {
                    $("#frmIssue").attr('action','projects/addIssue/'+id_project);
                    $(".modal-title").html("Add New Issue");
                    $(".editInput").hide();
                    $('#add-issue').modal('show');         
            });


	        $(document).on('click','.btnUpdateActionPlan', function (e) {
	        	e.stopImmediatePropagation();
	        	$('#c_closedeAction').addClass('hide');
	        	var attachment_action = 'null';
	            var id_ap = $(this).data('id');
	                $.ajax({
	                type:"POST",
	                url: base_url+"projects/get_detail_action_plan",
	                data: {'id_action_plan': id_ap},
	                beforeSend: function() {
	                    $(".loaderArea").fadeIn('slow');
	                },
	                success: function(datajson) {
	                    var data = jQuery.parseJSON(datajson);
	                    $("#frmAction").attr('action',base_url+'projects/update_action_plan_proccess/'+data['ID_ACTION_PLAN']);
	                    // assign to
	                    $(".assignto").val(data['ASSIGN_TO']);
	                    $(".assignto_detail").html("");
	                    $('.assignto_detail option[value=FMS]').attr('selected','selected');
	                    $("#action_name").val(data['ACTION_NAME']);
	                    $("#issue_id").val(data['ID_ISSUE']);
	                    $("#action_last_update").html("last update "+data['LAST_UPDATE2']);
	                    $("#due_date").datepicker('setDate',new Date(data['DUE_DATE_N']));
	                    $("#remarks_action").val(data['ACTION_REMARKS']);
	                    if (data['pics'].length > 0) {
	                        if (data['pics'][0]['PIC_NAME'] != null) {
	                            $("#action_picname1").val(data['pics'][0]['PIC_NAME']);
	                        }
	                        if (data['pics'][0]['PIC_EMAIL'] != null) {
	                            $("#action_picemail1").val(data['pics'][0]['PIC_EMAIL']);
	                        }
	                        if ($.isPlainObject(data['pics'][1])) {
	                            if (data['pics'][1]['PIC_NAME'] != null) {
	                                $("#action_picname2").val(data['pics'][1]['PIC_NAME']);
	                            }
	                            if (data['pics'][1]['PIC_EMAIL'] != null) {
	                                $("#action_picemail2").val(data['pics'][1]['PIC_EMAIL']);
	                            }
	                            
	                        }
	                    }

	                    if(data['ACTION_STATUS']=="CLOSED"){
	                        $("#action_close_date").val(moment(new Date (data['ACTION_CLOSED_DATE'])).format('mm/dd/yyyy'))
	                        $(".closedeAction").show();
	                    }

	                    $('#attachment_action_value').val(data['ATTACHMENT']);
	                    this.attachment_action = data['ATTACHMENT'];
	                    if (data['ATTACHMENT'] !=null && data['ATTACHMENT'] != '' && data['ATTACHMENT'] != 'null') {
	                                $(".linkAttc a").attr('href',base_url+"../_files/"+data['ISSUE_ATTACHMENT']);
	                                $(".linkAttc a").text(data['ISSUE_ATTACHMENT']);
	                                $(".linkAttc").show();
	                                $("#attachment_issue_value").val(data['ISSUE_ATTACHMENT']);
		                            var attachment = data['ATTACHMENT'];
		                            $("#attachment_action").fileinput('destroy');
		                            $("#attachment_action").fileinput({
						                  overwriteInitial: false,
						                  initialPreview: [
						                  		'https://prime.telkom.co.id/_files/'+id_project+'/action/'+attachment_action
						                  ],
						                  initialPreviewAsData: true,
						                  initialPreviewConfig: [
						                      {type: "pdf", url: 'https://prime.telkom.co.id/_files/'+id_project+'/action/'+attachment_action, downloadUrl: false}, 
						                  ],
						                  purifyHtml: true, 
						                  autoReplace: true,
						                  maxFileCount: 1,
						                  overwriteInitial: true,
						                  initialPreviewShowDelete : false,                   
						                  showRemove:false,
						                  showUpload:false,
						                  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
										  autoReplace: true,
								          maxFileCount: 1,                   
								          dropZoneEnabled: false,
							              mainClass: "input-group"
						              });
		                            console.log(attachment_action);
	                            	//$("#issue_attachment").removeClass("hidden");
	                            }else{
	                                $(".linkAttc").hide();
	                                $(".file-caption-name").attr('title','');
	                                //$("#issue_attachment").addClass("hidden");
	                            }

	                    $('.statusSelect').val(data['ACTION_STATUS']);
	                    $(".editInput").show();
	                    $(".modal-title").html("Update Action Plan");
	                },
	                complete: function() {
	
	                    $(".loaderArea").hide();
	                    $('#add-action-plan').modal('show');
	                },
	            });    
	        });


	        $(document).on('click','.btnDeleteActionPlan', function (e) {
	                e.stopImmediatePropagation();
	                var url = $(this).data('url');
	                bootbox.confirm({
	                    message: "Did you sure delete this <i><b> Action Plan </b><i> permanently?",
	                    buttons: {
	                            cancel: {
	                                label: 'No',
	                                className: 'btn-danger col-md-offset-4 col-md-2'
	                            },
	                            confirm: {
	                                label: 'Yes',
	                                className: 'btn-success col-md-2'
	                            }
	                    },
	                    callback: function (result) {
	                        if(result){
	                          $('#pre-load-background').fadeIn();
								$.ajax({
					                    url: url,
					                    type:'get',
					                    async:false,
					                    success:function(result){
					                    	tableIssue();
					                    	$('#pre-load-background').fadeOut();
					                    	location.reload();
							                console.log(result); 
					                         return result;
					                    }

					            });
	                            
	                        }
	                    }
	                });
	        });

	        $(document).on('click','#update_symtom', function (e) {
	                e.stopImmediatePropagation();
	                bootbox.confirm({
	                    message: "Update <i><b>  Reason of Delay (SYMTOM) </b><i>?",
	                    buttons: {
	                            cancel: {
	                                label: 'No',
	                                className: 'btn-danger col-md-offset-4 col-md-2'
	                            },
	                            confirm: {
	                                label: 'Yes',
	                                className: 'btn-success col-md-2'
	                            }
	                    },
	                    callback: function (result) {
	                        if(result){
	                          $.ajax({
                                      url: base_url+'projects/update_symtom/<?= $id_project ?>',
                                      type:'POST',
                                      dataType : "json",
                                      data:  {symptom : $('#symptomx').val()},
                                      success:function(result){
                                        if(result.data=='success'){
                                        bootbox.alert("Success!", function(){ 
                                        window.location.href = base_url+"projects/view/<?= $id_project ?>";
                                        console.log('success update SYMTOM!'); });
                                        }else{
                                        bootbox.alert("Failed!", function(){ 
                                        console.log('failed update SYMTOM!'); });
                                        }
                                      return result;
                                      },
                                       error: function(xhr, error){
                                              bootbox.alert("Failed!", function(){ 
                                              console.log('failed update SYMTOM!'); });
                                       },

                              });                          
	                        }
	                    }
	                });
	        });

          	var chartLine = Highcharts.chart('chartArea', {
        
		        chart: {
				        height: 400
						},
						credits: {
							enabled: false
						},
				        title: {
				            text: 'S Curve',
				            x: -20 //center
				        },
				        subtitle: {
				            text: "<?php echo preg_replace("![^a-z0-9]+!i", " ",$listDetail['NAME']);?>",
				            x: -20
				        },
				        xAxis: {
				            categories: ['WEEK',<?php echo "'".implode("','", $kurva['WEEK'])."'"?>]
				        },
				        yAxis: {
				        	// max : 100,
				            title: {
				                text: ''
				            },
				            max: 100,
				            plotLines: [{
				                value: 0,
				                width: 1,
				                color: '#808080'
				            }]
				        },
				        tooltip: {
				            // valueSuffix: '%'
				            formatter: function () {
				                var tooltipsArr = ['WEEK 0',<?php echo "'".implode("','", $kurva['PERIOD'])."'"?>];
				                return tooltipsArr[this.point.index] +'<br>'+ this.series.name +' : '+ Highcharts.numberFormat(this.point.y, 2) +'%';
				            }
				        },
				        legend: {
				            layout: 'horizontal',
				            align: 'center',
				            verticalAlign: 'bottom',
				            borderWidth: 0
				        },
				        series: [{
				            name: 'Plan',
				            color: 'red',
				            data: [0,<?php echo implode(",", $kurva['PLAN'])?>]
				        }, {
				            name: 'Realization',
				            data: [0,<?php echo implode(",", $kurva['REAL'])?>]
				        }]
			    });


		    var render_width = chartLine.chartWidth;
		    var render_height = render_width * chartLine.chartHeight / chartLine.chartWidth;

		    var svg = chartLine.getSVG({
		        exporting: {
		            sourceWidth: chartLine.chartWidth,
		            sourceHeight: chartLine.chartHeight
		        }
		    });
		    var canvas = document.createElement('canvas');
		    canvas.height = render_height;
		    canvas.width = render_width;

		    var image = new Image;
		    image.onload = function() {
		        canvas.getContext('2d').drawImage(this, 0, 0, render_width, render_height);
		        var data = canvas.toDataURL("image/png");
		        $("#ac").html("<img src='"+data+"' width='570' style='display:none;'>");

		        var a = document.createElement('a');
			    a.download = 'hagin';
			    a.href = data;
			    var idProject = '<?= $id_project; ?>';
			    $("#ac").html("<img src='"+data+"' width='570px'>");
			    var frmdata = new FormData();
					frmdata.append('data', data);
					$.ajax({
					    type: 'POST',
					    url: '<?=base_url()?>report/upload_chart',
					    data: frmdata,
					    processData: false,
					    contentType: false
					});


		    };
		    image.src = 'data:image/svg+xml;base64,' + window.btoa(svg);         

          }
      };

  }();

  jQuery(document).ready(function() {
      Page.init(event);
  }); 

	


var dataObject = <?= json_encode($deliverable); ?>;
var hotElement = document.querySelector('#listDeliverable');
var hotElementContainer = hotElement.parentNode;
var hotSettings = {
  data: dataObject,
  columns: [
    {
      data: 'ID_DELIVERABLE',
      type: 'text',
      width: 70,
      readOnly: true
    },
    {
      data: 'NAME',
      type: 'text',
      width: 250,
      readOnly: true
    },
    {
      data: 'PROGRESS_VALUE',
      type: 'text',
      readOnly: true
    },
    <?php foreach ($kurva['WEEK'] as $key => $value) { ?>
    {
      data: '<?= $key+1; ?>',
      type: 'text',
    },
    <?php } ?>
  ],
  outsideClickDeselects: false,
  stretchH: 'all',
  autoWrapRow: true,
  maxRows: 100,
  rowHeaders: true,
  minSpareRows: 0,
  minSpareCols: 0,
  colHeaders: [
    'ID',
    'Deliverable',
    'Ach.',
    <?php foreach ($kurva['WEEK'] as $key => $value) { ?>
    '<?= $key+1; ?>',
    <?php } ?>
  ],
  cell: [
  		<?php for ($i=0; $i <= $t_deliverable  ; $i++) : ?>
  		 {row:<?= $i; ?>, col: 0, className: "htLeft"},
  		 {row:<?= $i; ?>, col: 1, className: "htLeft"},
  		<?php endfor; ?>
      
    ],
  className: "htRight",
  fixedColumnsLeft: 3,
  columnSorting: true,
  sortIndicator: true,
  hiddenColumns: {
      columns: [1],
      indicators: true
    }
};
//var hot = new Handsontable(hotElement, hotSettings);

function sendEditDetailDeliverable(){
	var data =  hot.getData();
	for (var i = 0; i < data.length; i++) {
		//console.log(data[i]);
		$.ajax({
	        type:"POST",
	        async: false,
	        data: {data : data[i]},
	        url: base_url+'projects/editTableDeliverable/<?= $id_project; ?>',
	        success : function(data){
	            
	        }
	    });
	}
	location.reload();
}


var dataObject2 = <?= json_encode($plan); ?>;
var hotElement2 = document.querySelector('#listPlan');
var hotElementContainer2 = hotElement2.parentNode;
var hotSettings2 = {
  data: dataObject2,
  columns: [
    {
      data: 'ID_DELIVERABLE',
      type: 'text',
      width: 70,
      readOnly: true
    },
    {
      data: 'NAME',
      type: 'text',
      width: 250,
      readOnly: true
    },
    {
      data: 'WEIGHT',
      type: 'text',
      readOnly: true
    },
    <?php foreach ($kurva['WEEK'] as $key => $value) { ?>
    {
      data: '<?= $key+1; ?>',
      type: 'text',
    },
    <?php } ?>
  ],
  outsideClickDeselects: false,
  stretchH: 'all',
  autoWrapRow: true,
  maxRows: 100,
  rowHeaders: true,
  minSpareRows: 0,
  minSpareCols: 0,
  colHeaders: [
    'ID',
    'Deliverable',
    'Weight',
    <?php foreach ($kurva['WEEK'] as $key => $value) { ?>
    '<?= $key+1; ?>',
    <?php } ?>
  ],
  cell: [
  		<?php for ($i=0; $i <= $t_deliverable  ; $i++) : ?>
  		 {row:<?= $i; ?>, col: 0, className: "htLeft"},
  		 {row:<?= $i; ?>, col: 1, className: "htLeft"},
  		<?php endfor; ?>
      
    ],
  className: "htRight",
  fixedColumnsLeft: 3,
  columnSorting: true,
  sortIndicator: true,
  hiddenColumns: {
      columns: [1],
      indicators: true
    }
};
//var hot2 = new Handsontable(hotElement2, hotSettings2);

function sendEditDetailDeliverable(){
	var data =  hot.getData();
	for (var i = 0; i < data.length; i++) {
		//console.log(data[i]);
		$.ajax({
	        type:"POST",
	        async: false,
	        data: {data : data[i]},
	        url: base_url+'projects/editTableDeliverable/<?= $id_project; ?>',
	        success : function(data){
	            
	        }
	    });
	}
	location.reload();
}


$("body").on('click','#saveDetailDeliverable', function (e) {
	e.stopImmediatePropagation();
	console.log(hot.getData());
	sendEditDetailDeliverable();
	/*$.ajax({
	        type:"POST",
	        data: {data : hot.getData()},
	        url: base_url+'projects/editTableDeliverable',
	        success : function(data){
	            
	        }
	    });*/

}); 

</script>