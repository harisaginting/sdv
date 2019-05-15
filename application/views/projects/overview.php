<script src="<?= base_url(); ?>assets/plugin/gantt/codebase/dhtmlxgantt.js?v=6.0.7"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugin/gantt/codebase/dhtmlxgantt.css?v=6.0.7">

<style>
  /*.sidebar-fixed .main, .sidebar-fixed .app-footer{
  	margin-left: 0px;
  }*/


	/*.gantt_task_line.gantt_dependent_task{
		background-color : #65c16f;
		border : 1px solid #3c9445;
	}


	.gantt_task_line.gantt_dependent_task .gantt_task_progress{
		background-color : #46ad51	;
		border : 1px solid #3c9445;
	}*/

	.gantt_cal_template{
		height: 28px;
	}

	.gantt_cal_lsection{
		padding-bottom: 0px !important;
	}

	.gantt_cal_template #description_task{
		height: 80px !important;
	}

	.alert-success{
		width: 100%;
	}

/*.gantt_task_content{
	display: none;  
}*/
</style>

<ol class="breadcrumb" style="margin-top: 0px;"> 
<li style="width: 100%;">
	<span class="pull-left"> 
		<span class="breadcrumb-item nav-link-hgn" data-url="<?= base_url(); ?>projects">Projects</span>
		<strong class="breadcrumb-item active nav-link-hgn" data-url="<?= base_url(); ?>projects/view/<?= $id_project;?>">Detail Project <?= $id_project;?> </strong>
	</span>
	<button id="btnDocument" type="button" class="pull-right btn btn-outline-success"> 
		<i class="fa fa-file"></i>
		Document
	</button>
</li>	
<?=$this->session->flashdata('notif')?>  	
</ol>


<div class="container-content">
	<div class="row">

		<div class="col-sm-12 col-md-12">
			<div class="card">
				<div class="card-header bg-white no-border">
					Project Info
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample1" style="">
					<div class="row">
						<div class="col-md-6">
						<table class="table" style="border:1px solid #a4b7c1;">
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Id Project / Id LOP</td>
								<td><?= $project['ID_PROJECT'];?><?= !empty($project['ID_LOP_EPIC']) ? ' | '.$project['ID_LOP_EPIC'] : "" ?></td>
							</tr>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Name</td>
								<td><?= $project['NAME'];?></td>
							</tr>
							<?php if (empty($partners[0]['PARTNERS'])) { ?>
								<tr>
									<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Partners</td>
									<td> - </td>
								</tr>
							<?php }else{ ?>
								<tr>
									<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;" >Partners</td>
									<td><?=$partners[0]['PARTNERS']?></td>
								</tr>
							<?php } ?>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;" >Periode</td>	
								<td> <?= $project['START_DATE2']." To ".$project['END_DATE2'] ?></td>	
							</tr>

							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;" >Segmen</td>
								<td><?= $project['SEGMEN'].' - ['.$project['AM_NIK'].'] '.$project['AM_NAME'] ?></td>
							</tr>

						</table>
					</div>

					<div class="col-md-6">
						<table class="table" style="border:1px solid #a4b7c1;" >
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Type</td>
								<td><?= $project['TYPE'] ?></td>
							</tr>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Scale</td>
								<td><?= $project['SCALE'].' DEAL' ?></td>
							</tr>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Location</td>
								<td><?= 'Regional '.$project['REGIONAL']?></td>
							</tr>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Status Progress</td>
								<td><?= $project['STATUS']?></td>
							</tr>
							<tr>
								<td style="width: 30%;border-right: 1px solid #a4b7c1;border-left: 1px solid #a4b7c1;background-color: #20a8d8;">Last Update</td>
								<td><?= $project['UPDATED_DATE2']?></td>
							</tr>

						</table>
					</div>
					</div>

				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-8">
			<div class="card">
				<div class="card-header bg-white no-border">
					Deliverables Chart
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample2" style="">
					<div id="chartProgress" class="chart-view"></div>
				</div>
			</div>
		</div>

		<div class="col-sm-12 col-md-4">
			<div class="card">
				<div class="card-header bg-white no-border">
					Acquistion Chart
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample3" style="">
					<div id="chartAcquistion" class="chart-view"></div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="card">
				<div class="card-header bg-white no-border">
					Project Deliverables
					<div class="card-actions">
						<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#projectinformation" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="projectinformation" style="">
					<div id="gantt_here" style='width:100%; height:400px;'></div>
				</div>
			</div>
		</div>


		<div class="col-md-12">
		<ul class="nav nav-tabs" style="font-size: 14px;" role="tablist">
			<li class="nav-item">
				<a class="nav-link active show" data-toggle="tab" href="#issueAp" role="tab" aria-controls="issueAp" aria-selected="true">
				 Issue & Action Plan
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#bast" role="tab" aria-controls="bast" aria-selected="false">
				BAST
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#acquisition" role="tab" aria-controls="acquisition" aria-selected="false">
				Acquisition
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#history" role="tab" aria-controls="acquisition" aria-selected="false">
				History
				</a>
			</li>
		</ul>
			<div class="tab-content">
				<div class="tab-pane active show" id="issueAp" role="tabpanel">
						<div class="row">
							<div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px;padding-right: 30px !important;">
								<button id="btnIssueAction" type="button" class="pull-right btn-lg btn btn-success" style="margin-right: 10px;"> 
									<i class="fa fa-plus"></i> Add Issue Action Plan
								</button>
							</div>
						</div>
						<table id="datakuProjectClosed" class="table table-responsive-sm" style="width: 100% !important;">
			              <thead>
			                <tr>
			                  <th style="width: 25%;">Issue</th>
			                  <th style="width: 20%;">Impact</th>
			                  <th style="width: 20%;">Action Plan</th>
			                  <th style="width: 15%;">Date</th>
			                  <th style="width: 10%;">Status</th>
			                  <th style="width: 10%;">Update</th>
			                </tr>
			              </thead>
			              <tbody style="font-weight: 700px !important">
			              	<?php foreach ($issueAp as $key => $value): ?>
			              		<tr style="background-color:<?= $value['STATUS_ISSUE'] == 'OPEN' && (!empty($value['ID_ACTION_PLAN'])) ? 'bg-primary' : '' ;  ?> <?= $value['STATUS_ISSUE'] == 'OPEN' && (empty($value['ID_ACTION_PLAN'])) ? 'bg-danger' : '' ;  ?>">
			              			<td><?= $value['ISSUE_NAME']; ?></td>
			              			<td>
			              				<span style="font-size: 13px; font-weight: 900;color: #d00"><?= $value['RISK_IMPACT']; ?></span>
			              				<br>
			              				<?= $value['IMPACT']; ?>
			              			</td>
			              			<td>
			              				<?= $value['ACTION_NAME']; ?>
			              				<br>	
			              				 <?= !empty($value['ID_ACTION_PLAN']) ? "assigned to :" : '' ?> <span class="badge" style="font-weight: 900 !important;font-size: 12px;color: #00bb00;"><?= $value['ASSIGN_TO']; ?></span>	
			              			</td>
			              			<td>
			              				DISCOVER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $value['ISSUE_DATE']; ?>
			              				<br>
			              				TARGET CLOSED&nbsp; : <?= $value['DUE_DATE1']; ?>
			              				<br>
			              				ACTUAL CLOSED&nbsp; : <?= $value['CLOSED_DATE']; ?>
			              				<br>
			              			</td>
			              			<td><?= $value['STATUS_ISSUE']; ?></td>
			              			<td>
			              				<i class="fa fa-pen-square text-success updateIssueAp" 
			              				data-issue_id="<?=$value['ID_ISSUE1']?>" 
			              				data-action_id="<?=$value['ID_ACTION_PLAN']?>"
			              				style="font-size: 30px;"></i>

			              				<i class="fa fa-trash text-danger deleteIssueAp" 
			              				data-issue_id="<?=$value['ID_ISSUE1']?>" 
			              				data-action_id="<?=$value['ID_ACTION_PLAN']?>"
			              				style="font-size: 30px;"></i> 
			              			</td>
			              		</tr>
			              	<?php endforeach ?>

			              	<?php foreach ($action_only as $key => $value): ?>
			              		<tr>
			              			<td></td>
			              			<td></td>
			              			<td>
			              				<?= $value['ACTION_NAME']; ?>
			              				<br>	
			              				 <?= !empty($value['ID_ACTION_PLAN']) ? "assigned to :" : '' ?> <span class="badge" style="font-weight: 900 !important;font-size: 12px;color: #00bb00;"><?= $value['ASSIGN_TO']; ?></span>	
			              			</td>
			              			<td>
			              				TARGET CLOSED&nbsp; : <?= $value['DUE_DATE1']; ?>
			              				<br>
			              				ACTUAL CLOSED&nbsp; : <?= $value['CLOSED_DATE']; ?>
			              				<br>
			              			</td>
			              			<td><?= $value['ACTION_STATUS']; ?></td>
			              			<td><i class="fa fa-pen-square text-success updateIssueAp"  
			              				data-action_id="<?=$value['ID_ACTION_PLAN']?>"
			              				data-issue_id="" 
			              				style="font-size: 30px;"></i> </td>
			              		</tr>
			              	<?php endforeach ?>


			              </tbody>
			          	</table>
				</div>
				<div class="tab-pane" id="bast" role="tabpanel">
					<label style="font-size: 14px;font-weight: 900">List BAST Project</label>
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
				<div class="tab-pane" id="acquisition" role="tabpanel">
						<div class="row">
							<div class="col-md-12" style="margin-top: 10px;margin-bottom: 10px;padding-right: 30px !important;">
								<button id="btnAcquisition" type="button" class="pull-right btn-lg btn btn-success" style="margin-right: 10px;"> 
									<i class="fa fa-circle"></i> Update Acquisition
								</button>
							</div>
						</div>		

							<div id="" class="table-responsive w-xm wrapper">
							       		<table id="dataAcq" class="table  b-t" style="max-width:100% !important;border:1px solid #a4b7c1;">
							                <thead class="thead-bg-blue">
							                <tr style="font-size: 12px;">
							                    <th style="width:10% !important;vertical-align: sub;text-align: center; border-right:1px solid #a4b7c1;" rowspan="2">Year, Month</th>
							                    <!-- <th style="text-align: center;width:30% !important;border-right:1px solid #a4b7c1;" colspan="3">Progress</th> -->
							                    <th style="text-align: center;width:30% !important;border-right:1px solid #a4b7c1;" colspan="3">Value</th>
							                    <th style="width:30% !important;vertical-align: sub;text-align: center; border-right:1px solid #a4b7c1;" rowspan="2">Note</th>
							                </tr>
							                <tr>
							                	<!-- <th style="border-right:1px solid #a4b7c1;">Target</th>
							                	<th style="border-right:1px solid #a4b7c1;">Acquisited</th>
							                	<th style="border-right:1px solid #a4b7c1;">Total</th> -->
							                	<th style="border-right:1px solid #a4b7c1;">Target</th>
							                	<th style="border-right:1px solid #a4b7c1;">Acquisited</th>
							                	<th style="border-right:1px solid #a4b7c1;">Comulative</th>
							                </tr>
							                </thead>
							                <tbody style="font-size: 12px;">
							                	<?php 	if(!empty($acq2['MONTH'])) : 
							                			$c=0;$total = 0; foreach ($acq2['MONTH'] as $key => $value) :
							                			$dateObj = DateTime::createFromFormat('!m', intval($acq2['MONTH'][$c]));
							                			?>
							                	<tr  class="<?= date('n') == intval($acq2['MONTH'][$c])? 'bg-info' : ''; ?>" >
							                		<td ><?=  $dateObj->format('F').', '.$acq2['YEAR'][$c]; ?></td>
							                		<!-- <td class="" ><?=  $acq2['PROG1'][$c]; ?>%</td>
							                		<td class="" ><?=  $acq2['PROG2'][$c]; ?>%</td>
							                		<td class="h" ><?=  $acq2['PROG_C'][$c]; ?>%</td> -->
							                		<td class="rupiah" ><?=  $acq2['PLAN'][$c]; ?></td>
							                		<td class="rupiah" ><?=  $acq2['REAL'][$c]; ?></td>
							                		<td class="rupiah" ><?=  $acq2['REAL2'][$c]; ?></td>
							                		<td><?=  $acq2['NOTE'][$c]; ?></td>
							                	</tr>
							                	<?php  	$c++; 
							                			endforeach; 
							                			endif;
							                			?>
							                </tbody>
							            </table>
				            </div> 
				</div>
				<div class="tab-pane" id="history" role="tabpanel">
							<div id="" class="table-responsive w-xm wrapper">
							       		<table id="dataHistory" class="table table-striped b-t" style="max-width:100% !important;">
							                <thead class="thead-bg-blue">
							                <tr style="font-size: 12px;">
							                    <th style="min-width:20% !important;">Date</th>
							                    <th style="min-width:20% !important;">User</th>
							                    <th style="min-width:20% !important;">Action</th>
							                </tr>
							                </thead>
							                <tbody style="font-size: 12px;">
							                	<?php foreach ($history as $key => $value) : ?>
							                	<tr>
							                		<td><?=date('d F Y',strtotime($value['DATE_CREATED']))?></td>
							                		<td><?= '['.$value['ID_USER'].'] '.$value['NAME_USER']; ?></td>
							                		<td><?= $value['STATUS']; ?></td>
							                	</tr>
							                	<?php endforeach; ?>
							                </tbody>
							            </table>
				            </div> 
				</div>
			</div>
		</div>


<!-- Issue modals -->
	<div class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="issueAction">
	  <div class="modal-dialog modal-primary  modal-lg">
	    <div class="modal-content">
	    	<form method="POST" enctype="multipart/form-data" id="frmIssueAction">
	      	<div class="modal-header">
				<h4 class="modal-title" id="modal-title-issue">Add Issue Action Plan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
			</div>
			 <div class="modal-body">
                    
                        <div class="row" style="padding: 10px">
                        	<div class="col-md-6" style="border: 2px solid #ff6700;background:#999;" id="container_issue"" >
                        			<div class="row">
		                        		<div class="col-md-12" style="font-size: 16px !important;margin-top: 5px !important; margin-bottom: 15px !important;">
		                        			<input class=""  type="checkbox" id="use_issue" name="use_issue" style="transform: scale(1.7);"> Issue 
									          </div>
	                        				
	                        		</div>


                        			<div class="form-group row">
			                            <div class="col-md-3">
			                                <label class="form-control-label" for="l0">Name</label>
			                            </div>
			                            <div class="col-md-9">
			                                <input type="text" class="form-control use_issue" maxlength="150" name="issue_name" placeholder="Issue Name" id="issue_name"  readOnly>
			                            </div>

			                                <input type="hidden" name="issue_id"  id="issue_id"  readOnly>
			                        </div>

			                        <div class="form-group row">
			                            <div class="col-md-3">
			                                <label class="form-control-label" for="l0">Risk Impact</label>
			                            </div>
			                            <div class="col-md-9">
			                               <select name="risk_impact" id="risk_impact" class="form-control" ="">
			                               	<option value="" disabled selected>Select Risk Impact</option>
			                               	<option value="No Impact">No Impact</option>
			                               	<option value="Potential Risk">Potential Risk</option>
			                               	<option value="Significant Risk">Significant Risk</option>
			                               </select>
			                            </div>
			                        </div>

			                        <div class="form-group row">
			                            <div class="col-md-3">
			                                <label class="form-control-label">Remarks</label>
			                            </div>
			                            <div class="col-md-9">
			                                <textarea name="impact" id="impact" class="form-control use_issue" maxlength="300" rows="5" placeholder="Impact (Max. 300 Characters)" id="impact"  readOnly></textarea>
			                            </div>
			                        </div>
                        	</div>

                        	<div class="col-md-6" style="border: 2px solid #143ae4;background:#999;" id="container_actionPlan" >
                        		<div class="row">
	                        		<div class="col-md-12" style="font-size: 16px !important;margin-top: 5px !important; margin-bottom: 15px !important;">
	                        			<input class=""  type="checkbox" id="use_actionplan" name="use_actionplan" style="transform: scale(1.7);"> Action Plan 
								          </div>
                        				
                        		</div>

                        		<div class="form-group row">
		                            <div class="col-md-3">
		                                <label class="form-control-label" for="l0">Task Name</label>
		                            </div>
		                            <div class="col-md-9">
		                                <input type="text" class="form-control use_actionplan" maxlength="150" name="task_name" placeholder="Task Name" id="action_name"  readOnly>
		                            </div>

		                            <input type="hidden" name="action_id"  id="action_id"  readOnly>
		                        </div>

		                        <div class="form-group row">
		                            <div class="col-md-3">
		                                <label class="form-control-label">Due Date</label>
		                            </div>
		                            <div class="col-md-9">
		                            	<input type="text" name="due_date"  class="form-control date-picker" id="due_date" placeholder="mm/dd/yyyy"  readOnly />
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <div class="col-md-3">
		                                <label class="form-control-label" for="l0">Assign To</label>
		                            </div>
		                            <div class="col-md-9">
		                                <select name="assignto" class="form-control assignto"  id="assignto" >
		                                	<option value="">Select Assign To</option>
		                                	<?php foreach ($arrAssignTo as $assignts): ?>
		                                		<option value="<?=$assignts?>"><?=$assignts?></option>
		                                	<?php endforeach ?>
		                                </select>

		                                <select name="assignto_detail" id="assignto_detail" class="form-control assignto_detail hidden margin-top-10">
		                                	<?php 
								            foreach ($list_partner as $key => $value) {
								            ?>
								                <option class="assigntodetailselect_partner assigntodetailselect" value="<?=$list_partner[$key]['KODE_PARTNER'].'||'.$list_partner[$key]['NAMA_PARTNER']?>"><?=$list_partner[$key]['NAMA_PARTNER']?></option>
								            <?php
								            }
								         
							                foreach ($list_segmen as $key => $value) {
							                    ?>
							                        <option class="assigntodetailselect_segmen assigntodetailselect" value="<?=$list_segmen[$key]['SEGMEN']?>"><?=$list_segmen[$key]['SEGMENT_6_LNAME']?></option>
							                    <?php
							                }
							                ?>     
							                <option class="assigntodetailselect_bdm assigntodetailselect" value="BDM">BDM</option>       
							                <option class="assigntodetailselect_dss assigntodetailselect" value="DSS">DSS</option>       
							                <option class="assigntodetailselect_sdv assigntodetailselect" value="SDV">SDV</option> 


							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 1">TREG 1</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 2">TREG 2</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 3">TREG 3</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 4">TREG 4</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 5">TREG 5</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 6">TREG 6</option>       
							                <option class="assigntodetailselect_treg assigntodetailselect" value="TREG 7">TREG 7</option>       
							               </select>
		                            </div>
		                        </div>

		                        <div class="form-group row" style="margin-bottom: 0px !important;">
		                            <div class="col-md-3">
		                                <label class="form-control-label">PIC 1</label>
		                            </div>
		                            <div class="col-md-9">
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <div class="col-md-2 offset-md-1">
		                            	<label>Name</label>
		                            	<label>Email</label>
		                            </div>
		                            <div class="col-md-9">
		                            	<div class="input-group margin-bottom-5">
		                                    <input type="text" name="pic_name[]" id="action_picname0" class="form-control picClass use_actionplan" placeholder="PIC Name"   aria-selected=true   readOnly>
		                                </div>
		                                <div class="input-group margin-bottom-10">
		                                    <input type="email" name="pic_email[]" id="action_picemail0" class="form-control picClass use_actionplan" placeholder="PIC email"  readOnly>
		                                </div>
		                            </div>
		                        </div>

		                        <div class="form-group row" style="margin-bottom: 0px !important;">
		                            <div class="col-md-3">
		                                <label class="form-control-label">PIC 2</label>
		                            </div>
		                            <div class="col-md-9">
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <div class="col-md-2 offset-md-1">
		                            	<label>Name</label>
		                            	<label>Email</label>
		                            </div>
		                            <div class="col-md-9">
		                            	<div class="input-group margin-bottom-5">
		                                    <input type="text" name="pic_name[]" id="action_picname1" class="form-control picClass use_actionplan" placeholder="PIC Name"   aria-selected=true   readOnly>
		                                </div>
		                                <div class="input-group margin-bottom-10">
		                                    <input type="email" name="pic_email[]" id="action_picemail1" class="form-control picClass use_actionplan" placeholder="PIC email"  readOnly>
		                                </div>
		                            </div>
		                        </div>

		                        <div class="form-group row">
		                            <div class="col-md-3">
		                                <label class="form-control-label">Remarks</label>
		                            </div>
		                            <div class="col-md-9">
		                                <textarea name="remarks_action" class="form-control use_actionplan" rows="5" maxlength="300" placeholder="Remarks (Max. 300 Characters)" id="remarks_action"  readOnly></textarea>
		                            </div>
		                        </div>

                        	</div>
                        	
                        	

                        </div>
                        <div class="form-group row" id="c_statusIssueAction">
	                        <div class="col-md-12">
	                        	<label class="form-control-label">Status</label>
	                        	<select class="form-control" id="statusIssueAction" name="statusIssueAction">
	                        		<option value="OPEN">OPEN</option>
	                        		<option value="CLOSED">CLOSED</option>
	                        	</select>
	                        </div>
	                    </div>

	                    <div class="form-group row hidden" id="c_issueAction_closed_date">
	                        <div class="col-md-12">
	                        	<label class="form-control-label">CLOSED DATE</label>
	                        	<input type="text" name="issueAction_closed_date" id="issueAction_closed_date" class="form-control date-picker" readOnly placeholder="Closed Date">
	                        </div>
	                    </div>

                        <div class="row">
                        		<div class="col-md-2 offset-md-5 btn btn-lg btn-success" id="btnSaveIssueAction">Submit</div>
                        		<div class="col-md-2 offset-md-5 btn btn-lg btn-success hidden" id="btnUpdateIssueAction">Update</div>
                        </div>
                    
                </div>
	    	</form>
	    </div>
	  </div>
	</div>

<!-- Acquisition modals -->
<div class="modal fade"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="acquisitionModal">
  <div class="modal-dialog modal-lg modal-primary">
    <div class="modal-content">
        <div class="modal-header">
              <h4 class="modal-title" id="modal-title-acquisition">Update Acquisition</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
              </button>
        </div>
              <div class="modal-body relative">
              <form method="POST" enctype="multipart/form-data" id="frmAcquisition">
                <div id="target_acq" class="">
                        <div class="col-md-12 bg-info text-white>"  style="text-align: left;padding:5px;margin-bottom: 5px;">
                          <span><h3>Estimated Acquisition <?= date('F');?>, <?= date('Y') ?>  </h3></span>
                        </div>
                        <input type="hidden"  id="month" name="month" value="<?= date('n'); ?>">
                        <input type="hidden"  id="id_project" name="id_project" value="<?= $id_project; ?>">
                        <div class="col-md-12 bg-grey " id="con_termin">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                                  <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" id="target_value" name="target_value" class="form-control rupiah"  value="0">
                                  </div>
                                   
                                  <div class="form-group">
                                    <label>Term Of Payment </label>
                                    <select id="target_top" name="target_top" class="form-control" value="" >
                                  		<option value="OTC">OTC</option>
                                  		<option value="TERMIN">Termin</option>
                                  		<option value="PROGRESS">Progress</option>
                                  		<option value="DP">DP (Down Payment)</option>
                                    </select>
                                  </div>

                                  <div class="form-group">
                                    <label>Term Of Payment Description</label>
                                    <input type="text" id="target_top_exp" name="target_to_exp" class="form-control" value="" placeholder="Termin Ke - (?) / Periode Reccuring / Persentasi Progress">
                                  </div>

                                 </div>
                               

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Note</label>
                                      <textarea  rows="8" type="text" id="target_note" name="target_note" class="form-control"></textarea>
                                    </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                </div>    
                <div id="gained_acq" class="">
                        <div class="col-md-12 bg-info text-white" style="text-align: left;padding:5px;margin-bottom: 5px;">
                          <span><h3>Actual Acquisition <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?>, <?= (date('m') - 1 == 0) ? date('Y') - 1 : date('Y') ?></h3></span>
                        </div>
                        <div class="col-md-12 bg-grey " id="con_termin">
                            <div class="col-md-12">
                              	<div class="row">
	                                <div class="col-md-6" >
	                                  <div class="form-group">
	                                    <label>Value</label>
	                                    <input type="text" id="actual_value" name="actual_value" class="form-control rupiah"  value="0">
	                                  </div>
	                                   
	                                  <div class="form-group">
	                                    <label>Term Of Payment </label>
	                                    <select id="actual_top" name="actual_top" class="form-control" value="" >
	                                  		<option value="OTC">OTC</option>
	                                  		<option value="TERMIN">Termin</option>
	                                  		<option value="PROGRESS">Progress</option>
	                                  		<option value="DP">DP (Down Payment)</option>
	                                    </select>
	                                  </div>

	                                  <div class="form-group">
	                                    <label>Term Of Payment Description</label>
	                                    <input type="text" id="actual_top_exp" name="actual_to_exp" class="form-control" value="" placeholder="Termin Ke - (?) / Periode Reccuring / Persentasi Progress">
	                                  </div>

	                                 </div>
	                               

	                                  <div class="col-md-6">
	                                    <div class="form-group">
	                                      <label>Note</label>
	                                      <textarea  rows="8" type="text" id="actual_note" name="actual_note" class="form-control"></textarea>
	                                    </div>
	                                  </div>
	                              </div>
                            </div>
                        </div>
                </div>
                        	<div class="col-md-6 offset-md-6">
                        		<span>Gunakan klausul pada Kontrak Berlangganan (KB) antara Telkom dengan Customer (nilai sebelum PPN10%)</span>
                        	</div>
                        
                  <div class="modal-footer" id="">
                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnUpdateAcquisition" class="btn btn-primary">Update Acquisition</button>
                  </div>
              </form>
            </div>
    </div>
  </div>
</div>





	</div>
</div>

<script>
 var id_project = "<?= $id_project; ?>";
 var Page = function () {

    	var ganttchart = function(){                     
         				 // GANTT CHART
							var urlTask			= "<?= base_url() ?>projects/apiTask/<?= $id_project ?>";
							var getListItemHTML = function (type, count, active) {
								return '<li' + (active ? ' class="active"' : '') + '><a href="#">' + type + 's <span class="badge">' + count + '</span></a></li>';
							};



							gantt.templates.scale_cell_class = function (date) {
								if (date.getDay() == 0 || date.getDay() == 6) {
									return "weekend";
								}
							};
							gantt.templates.task_cell_class = function (item, date) {
								if (date.getDay() == 0 || date.getDay() == 6) {
									return "weekend";
								}
							};

							gantt.templates.rightside_text = function (start, end, task) {
								if (task.type == gantt.config.types.milestone) {
									return task.text;
								}
								return "";
							};

							gantt.templates.task_text=function(start, end, task){
						    return  Math.round(task.progress * 100) + "%";
							};
							gantt.templates.grid_date_format = function(date){
							    return gantt.date.date_to_str(gantt.config.date_grid)(date);
							};

							gantt.templates.grid_date_format = function(date){
						    return gantt.date.date_to_str(gantt.config.date_grid)(date);
							};

							gantt.config.columns = [
								{name: "text", label: "Task name", width: "*", tree: true},
								{name: "weight", label: "Weight(%)", align: "center", width: 40},
								{
									name: "start_date", label: "Start", template: function (obj) {
										return obj.start_date.getDate() + '-' + parseInt(obj.start_date.getMonth()+1) + '-' + obj.start_date.getFullYear();
									}, align: "center", width: 90
								},
								{
									name: "end_date", label: "Finish", template: function (obj) {
										return obj.end_date.getDate() + '-' + (obj.end_date.getMonth()+1) + '-' + obj.end_date.getFullYear();
									}, align: "center", width: 90
								},
								{name: "duration", label: "Days", align: "center", width: 40},
								{name: "add", label: "", width: 40},
							];

							gantt.config.order_branch = true;
							gantt.config.grid_width = 600;
							gantt.config.date_grid = "%F %d";
							gantt.config.scale_height = 60;
							gantt.config.scale_unit = "month";
							gantt.config.date_scale = "%F, %Y";
							gantt.config.subscales = [
							    {unit:"week", step:1, date:"Week #%W"}
							];

							gantt.config.lightbox.sections = [
						    	{name:"description", height:40, map_to:"text", type:"textarea", focus:true},
							    {name:"weight", height:30, type:"template", map_to:"my_template"}, 
							    {name:"progress", height:30, type:"template", map_to:"my_template2"}, 
							    {name:"description", height:90, type:"template", map_to:"my_template3"}, 
							    {name:"time", height:72, type:"duration", map_to:"auto"}
							];

							gantt.locale.labels.section_weight = "Weight (%)";
							gantt.locale.labels.section_progress = "Progress (%)";
							gantt.locale.labels.section_description = "Description";


							gantt.attachEvent("onBeforeLightbox", function(id) {
								$('#description_task').css('height', '80px !important');
								$('.gantt_cal_template:has(#description_task)').css('height', '80px !important');

							    var task = gantt.getTask(id);
							    var weight = task.weight;
							    var progress = task.progress;
							    var description = task.description;
							    var readOnly = "";
							    if(weight == null){
							    	weight = 0;
							    	readOnly = "readOnly style='background-color:#ddd;'";
							    }
							    if(progress == null){
							    	progress = 0;
							    }

							    if(description == null){
							    	description= "";
							    }

							    var max_weight = 100;
							    var max_progress = 100;
							    task.my_template = "<input type='number' id='weight_task' max='"+max_weight+"' value='"+ weight+"'  >";
							    task.my_template2 = "<input type='number' id='progress_task' "+readOnly+"  value='"+ progress*100+"'>";  
							    task.my_template3 = "<textarea id='description_task' class='form-control'>"+description+"</textarea>";  

							    return true;
							});

							gantt.config.order_branch = true;
							gantt.config.order_branch_free = true;

							gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
							gantt.init("gantt_here");
							gantt.load(urlTask);

							var dp = new gantt.dataProcessor(urlTask);
							dp.init(gantt);
							dp.setTransactionMode("REST");


							gantt.attachEvent("onLightboxSave", function(id,task){ 
								console.log(id);
								console.log(task);
								task.weight = $('#weight_task').val();
								task.progress = $('#progress_task').val()/100;
								task.description = $('#description_task').val();
								return true;
						       });

							gantt.attachEvent("onAfterTaskAdd", function (id, item) {
								console.log('task add');
								location.reload();
							});
							gantt.attachEvent("onAfterTaskDelete", function (id, item) {
								console.log('task delete');
							});

							gantt.attachEvent("onAfterAutoSchedule",function(taskId, updatedTasks){
							   console.log(taskId);
							   console.log(updatedTasks);
							});
							gantt.attachEvent("onAfterTaskUpdate", function(id,item){
						    console.log(item);
						    console.log(gantt.hasChild(item.parent));
						    console.log(id);
							});
    	};    

    	var linechart = function(){
    		var chartLine = Highcharts.chart('chartProgress', {
	        
			        chart: {
					        height: 400
							},
							credits: {
								enabled: false
							},
					        title: {
				                    text: '',
				                    x: -20, //center
				                    style: {
				                     // color: '#f42020',
				                     textTransform: 'uppercase',
				                     fontSize: '12px'
				                    },
				                },
				                subtitle: {
				                    text: "",
				                },
					        xAxis: {
					            categories: [<?php echo "'".implode("','", $kurva['WEEK'])."'"?>]
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
					                var tooltipsArr = [<?php echo "'".implode("','", $kurva['PERIOD'])."'"?>];
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
					            color: '#20a8d8',
					            data: [<?php echo implode(",", $kurva['PLAN'])?>]
					        }, {
					            name: 'Achievement',
					            color: '#4dbd74',
					            data: [<?php echo implode(",", $kurva['REAL'])?>]
					        }]
				    });


				    var render_width  = chartLine.chartWidth;
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
    	}


    	var linechartAcq = function(){
    		var chartLine2 = Highcharts.chart('chartAcquistion', {
	        
			        chart: {
					        height: 400
							},
							credits: {
								enabled: false
							},
					        title: {
				                    text: '',
				                    x: -20, //center
				                    style: {
				                     // color: '#f42020',
				                     textTransform: 'uppercase',
				                     fontSize: '12px'
				                    },
				                },
				                subtitle: {
				                    text: "",
				                },
					        xAxis: {
					            categories: [<?php echo "'".implode("','", $acq['MONTH'])."'"?>]
					        },
					        yAxis: {
					        	// max : 100,
					            title: {
					                text: ''
					            },
					            plotLines: [{
					                value: 0,
					                width: 1,
					                color: '#808080'
					            }]
					        },
					        tooltip: {
					            // valueSuffix: '%'
					            formatter: function () {
					                var tooltipsArr = [<?php echo "'".implode("','", $acq['PERIOD'])."'"?>];
					                return tooltipsArr[this.point.index] +'<br>'+ this.series.name +' : '+ Highcharts.numberFormat(this.point.y, 2);
					            }
					       		 },
					        legend: {
					            layout: 'horizontal',
					            align: 'center',
					            verticalAlign: 'bottom',
					            borderWidth: 0
					        },
					        series: [{
					            name: 'Target',
					            color: '#20a8d8',
					            data: [<?php echo implode(",", $acq['PLAN2'])?>]
					        }, {
					            name: 'Acquisited',
					            color: '#4dbd74',
					            data: [<?php echo implode(",", $acq['REAL2'])?>]
					        }]
				    });


				    var render_width  = chartLine2.chartWidth;
				    var render_height = render_width * chartLine2.chartHeight / chartLine2.chartWidth;

				    var svg = chartLine2.getSVG({
				        exporting: {
				            sourceWidth: chartLine2.chartWidth,
				            sourceHeight: chartLine2.chartHeight
				        }
				    });
				    var canvas = document.createElement('canvas');
				    canvas.height = render_height;
				    canvas.width = render_width;
    	}



	return {
		init: function() { 
		ganttchart();
		linechart();
		linechartAcq();

		$(document).on('click','#use_issue',function(e){
                if ($('#use_issue').is(':checked')) {
                	$('.use_issue').attr('readOnly',false);
                	$('.use_issue').prop('required',true);
                	$('#container_issue').css('background','#fff');
                }else{
                	$('.use_issue').attr('readOnly',true);
                	$('.use_issue').prop('required',false);
                	$('#container_issue').css('background','#999');
                }
         });

		$(document).on('click','#use_actionplan',function(e){
                if ($('#use_actionplan').is(':checked')) {
                	$('.use_actionplan').attr('readOnly',false);
                	$('.use_actionplan').prop('required',true);
                	$('#container_actionPlan').css('background','#fff');
                }else{
                	$('.use_actionplan').attr('readOnly',true);
                	$('.use_actionplan').prop('required',false);
                	$('#container_actionPlan').css('background','#999');
                }
         });

		$(document).on('click','#btnIssueAction', function () {
						$('#btnSaveIssueAction').removeClass('hidden');
						$('#btnUpdateIssueAction').addClass('hidden');
						$('#c_statusIssueAction').addClass('hidden');
						$('#c_issueAction_closed_date').addClass('hidden');

	        			$('#use_issue').prop('checked',false);
						$('#use_actionplan').prop('checked',false);
						$('.use_issue').attr('readOnly',true);
                		$('.use_issue').prop('required',false);
                		$('.use_actionplan').attr('readOnly',true);
                		$('.use_actionplan').prop('required',false);
                		$('#container_issue').css('background','#999');
                		$('#container_actionPlan').css('background','#999');
                		$('.use_actionplan').val('');
	        			$('.use_issue').val('');
	        			$("#issue_id").val('');
                		$("#action_id").val('');
                		$('#c_statusIssueAction').addClass('hidden');
						$('#issueAction').modal('show');
	            });

		$(document).on('click','.deleteIssueAp', function (e) {
				e.stopImmediatePropagation();
				var id_issue = $(this).data('issue_id');
				var id_action = $(this).data('action_id');
				 bootbox.confirm({
	                    message: "Delete this <i><b> issue & action plan </b><i> permanently?",
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
						                    url: base_url+"projects/delete_issueAction",
						                    type:'post',
						                    data:{'id_issue':id_issue, 'id_action' : id_action},
	                        				dataType :"json",
						                    success:function(result){
						                         return result;
						                    }

						            });
	                            
	                        }
	                    }
	                });
		});

		$(document).on('click','.updateIssueAp', function () {
						$('#btnSaveIssueAction').addClass('hidden');
						$('#btnUpdateIssueAction').removeClass('hidden');
						$('#c_statusIssueAction').removeClass('hidden');
						$('#c_issueAction_closed_date').addClass('hidden');
						$('#c_statusIssueAction').removeClass('hidden');

						$('#use_issue').prop('checked',false);
						$('#use_actionplan').prop('checked',false);
						$('.use_issue').attr('readOnly',true);
                		$('.use_issue').prop('required',false);
                		$('.use_actionplan').attr('readOnly',true);
                		$('.use_actionplan').prop('required',false);
                		$('#container_issue').css('background','#999');
                		$('#container_actionPlan').css('background','#999');
                		$('.use_actionplan').val('');
	        			$('.use_issue').val('');
	        			$("#issue_id").val('');
                		$("#action_id").val('');


                		$("#issue_id").val('');
                		$("#action_id").val('');

						var id_issue = $(this).data('issue_id');
						var id_action = $(this).data('action_id');
	        			$.ajax({
	                        type:"POST",
	                        url: base_url+"projects/get_detail_issueAction",
	                        data:{'id_issue':id_issue, 'id_action' : id_action},
	                        dataType :"json",
	                        async : true, 
	                        success: function(datajson) {
	                        	var issue 	= datajson.issue;
	                        	var action 	= datajson.action;
	                        	if(issue.ID_ISSUE !=  null){
	                        		$('#use_issue').prop('checked',true);
	                        		$('.use_issue').attr('readOnly',false);
				                	$('.use_issue').prop('required',true);
				                	$('#container_issue').css('background','#fff');

				                	$('#issue_id').val(issue.ID_ISSUE);
				                	$('#issue_name').val(issue.ISSUE_NAME);
				                	$('#impact').val(issue.IMPACT);
				                	$("#risk_impact").val(issue.RISK_IMPACT);

				                	if(issue.STATUS_ISSUE == 'CLOSED'){
				                		$('#c_issueAction_closed_date').removeClass('hidden');
				                		$("#issueAction_closed_date").val(issue.CLOSED_DATE);
				                	}
	                        	}


	                        	if(action.ID_ACTION_PLAN != null){
	                        		$('#use_actionplan').prop('checked',true);
	                        		$('.use_actionplan').attr('readOnly',false);
				                	$('.use_actionplan').prop('required',true);
				                	$('#container_actionPlan').css('background','#fff');
	                        		
	                        		$('#action_id').val(action.ID_ACTION_PLAN);
	                        		$('#action_name').val(action.ACTION_NAME);
	                        		$('#due_date').val(action.DUE_DATE1);
	                        		$('#assignto').val(action.ASSIGN_TO);
	                        		$('#remarks_action').val(action.ACTION_REMARKS);


	                        		if(action.pic != null){
	                        			$.each(action.pic, function( index, value ) {
										  $("#action_picname"+index).val(value.PIC_NAME);
										  $("#action_picemail"+index).val(value.PIC_EMAIL);
										});
	                        		}

	                        		if(action.STATUS_ISSUE == 'CLOSED'){
				                		$('#c_issueAction_closed_date').removeClass('hidden');
				                		$("#issueAction_closed_date").val(action.CLOSED_DATE);
				                	}

	                        		
	                        	}

	                        },
	                        complete: function() {
	                            $('#issueAction').modal('show');
	                        }

	                    });
	            });

		$(document).on('click','#btnSaveIssueAction', function (e) {
				e.stopImmediatePropagation();

				if($('#frmIssueAction').valid()){

						var dataForm  = $('#frmIssueAction').serialize();
						var url = base_url + "projects/saveIssueAction/"+id_project;
						$('#issueAction').modal('hide');
						$.ajax({
			                    url: url,
			                    type:'POST',
			                    data:  dataForm ,
			                    dataType : "json",
			                    success:function(result){
			                    	if(result.data == 'success'){
			                    		location.reload();
			                    	}
			                    		//location.reload();
			                         	//return result;
			                    }

			            });
				}
				
			});

		$(document).on('change','#statusIssueAction', function (e) {
			if($('#statusIssueAction').val()=='CLOSED'){
				$('#c_issueAction_closed_date').removeClass('hidden');
				$('#issueAction_closed_date').prop('required',true);;
			}else{
				$('#c_issueAction_closed_date').addClass('hidden');
				$('#issueAction_closed_date').prop('required',false);;

			}
			})

		$(document).on('click','#btnUpdateIssueAction', function (e) {
				e.stopImmediatePropagation();

				if($('#frmIssueAction').valid()){

						var dataForm  = $('#frmIssueAction').serialize();
						var url = base_url + "projects/updateIssueAction/"+id_project;
						$('#issueAction').modal('hide');
						$.ajax({
			                    url: url,
			                    type:'POST',
			                    data:  dataForm ,
			                    dataType : "json",
			                    success:function(result){
			                    	if(result.data == 'success'){
			                    		location.reload();
			                    	}
			                    		//location.reload();
			                         	//return result;
			                    }

			            });
				}	
			});

		$(document).on('click','#btnAcquisition', function () {
						$('#acquisitionModal').modal('show');
	        });

		$(document).on('click','#btnUpdateAcquisition', function (e) {
				e.stopImmediatePropagation();
				if($('#frmAcquisition').valid()){
						$('#target_value').val($('#target_value').unmask());
						$('#actual_value').val($('#actual_value').unmask());
						var dataForm  = $('#frmAcquisition').serialize();
						var url = base_url + "projects/updateAcqusition/"+id_project;
						$.ajax({
			                    url: url,
			                    type:'POST',
			                    data:  dataForm ,
			                    dataType : "json",
			                    success:function(result){
			                    	if(result.data == 'success'){
			                    		//location.reload();
			                    	}
			                    		//location.reload();
			                         	//return result;
			                    }

			            });
				}
					
			});


		}
	};

}();

jQuery(document).ready(function() {
      Page.init(event);
  }); 
</script>