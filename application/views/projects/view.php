<style type="text/css">
    .select2-container .select2-selection{
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    }
  	/*Checkboxes styles*/
	}
 
	.input-group div.awesomplete {
		width: 98% !important;
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
	  .no-border{
	  	border : 0px !important;
	  } 

	  .name-pm{
	  	font-family: 'Ubuntu' ,'sans-serif';
	  	color: #000;
	  	font-size: 18px;
	  }

	  .sub-name-pm{
	  	font-family: 'Ubuntu' ,'sans-serif';
	  	color: #000;
	  	font-size: 10px;
	  }

	  .title-pm{
	  	color: #000;
	  	font-size: 12px;
	  }

	  .td-info{
	  	background-color: #20a8d8;
	  	color: #fff;
	  }

	  .nav-tabs-d{
	  	background-color: #fff;
	  	border : 1px #a4b7c1 solid;
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
	<?php if($this->session->userdata('tipe_sess')!='SUBSIDIARY') {?>
	<a target="_blank" href="<?= base_url(); ?>report/project_detail/<?= $id_project; ?>" id="btnReport" class="pull-right btn btn-outline-danger" style="margin-right: 10px;"> 
		<i class="fa fa-file-pdf"></i> 
		Report PDF
	</a>
	<?php } ?>
</li>		
</ol>


<div class="container-content">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="card">
				<div class="card-header bg-white no-border">
					S Curve <!-- Project <?php echo preg_replace("![^a-z0-9]+!i", " ",$listDetail['NAME']);?> in <?= $week; ?> --> 
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true"><i class="icon-arrow-up"></i></a>
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
				<div class="card-header bg-white no-border">
					Deliverable Schedule <!-- Project <?php echo preg_replace("![^a-z0-9]+!i", " ",$listDetail['NAME']);?> in <?= $week; ?> --> 
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapsedeliverable" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapsedeliverable" style="">
					<div id="container_deliverable" class="chart-view"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 col-md-12"> 
			<div class="card">
				<div class="card-header no-border bg-white">
				Data Project 
					<div class="card-actions">
					<a href="#" class="btn-minimize no-border" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="true"><i class="icon-arrow-up"></i></a>
					</div>
				</div>
				<div class="card-body collapse show" id="collapseExample1">
					<div class="row">	
						<div class="col-md-9">
							<table class="table" style="border: 1px #a4b7c1 solid">
									<tr>
										<td class="td-info" style="width: 20% !important;">Project Name</td>
										<td><?=$listDetail['NAME']?></td>
									</tr>
									<tr>
										<td class="td-info">Value</td>
										<td><?=number_format($listDetail['VALUE'])?></td>
									</tr>
									<tr>
										<td class="td-info">Customer</td>
										<td><?=$listDetail['STANDARD_NAME']?></td>
									</tr>
									<?php if (empty($partners[0]['PARTNERS'])) { ?>
										<tr>
											<td class="td-info">Partners</td>
											<td></td>
										</tr>
									<?php }else{ ?>
										<tr>
											<td class="td-info">Partners</td>
											<td><?=$partners[0]['PARTNERS']?></td>
										</tr>
									<?php } ?>
										<td class="td-info">AM NIK / AM NAME</td>
										<td><?=$listDetail['AM_NIK']?> / <?=$listDetail['AM_NAME']?></td>
									</tr>
									<tr>
										<td class="td-info">Start Date</td>
										<td><?=date('d/m/Y',strtotime($listDetail['START_DATE']))?></td>

									</tr>
									<tr>
										<td class="td-info">End Date</td>
										<td><?=date('d/m/Y',strtotime($listDetail['END_DATE']))?></td>
									</tr>
									<tr>
										<td class="td-info">Segmen</td>
										<td><?=$listDetail['SEGMEN']?></td>
									</tr>
									<tr>
										<td class="td-info">Type</td>
										<td><?=$listDetail['TYPE']?></td>
									</tr>
									<tr>
										<td class="td-info">Category</td>
										<td><?=$listDetail['SCALE']?> DEAL</td>
									</tr>

									<?php if(!empty($listDetail['REGIONAL'])&&$listDetail['REGIONAL']!=0) : ?>
									<tr>
										<td class="td-info">Regional</td>
										<td><?=$listDetail['REGIONAL']?></td>
									</tr>
									<?php endif; ?>
									<tr>
										<td class="td-info">Progress Status</td>
										<td><span style="font-weight: bold !important;font-style: bold;"><?=$listDetail['STATUS']?></span> </td>
									</tr>
									<?php if ($listDetail['STATUS'] == 'LAG' || $listDetail['STATUS'] == 'DELAY') : ?>
									<tr>
										<td class="td-info">Symptoms </td>
										<td>
											<select  id="symptomx" class="form-control" style="width:100%;" <?= $this->auth->get_access_value('PROJECT')>2 ? '' : 'disabled'; ?> >
												<option value="" <?= empty($list['REASON_OF_DELAY']) ? 'selected' : ''; ?>>Select Reason Of Delay</option>
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
												<option value="12.Keterbatasan kapabilitas Telkom (Telkom)" <?= $listDetail['REASON_OF_DELAY'] == "12.Keterbatasan kapabilitas Telkom (Telkom)" ? 'selected' : ''; ?> >12.Keterbatasan kapabilitas Telkom (Telkom)</option>
												<option value="13.Kendala Finansial ( Customer )" <?= $listDetail['REASON_OF_DELAY'] == "13.Kendala Finansial ( Customer )" ? 'selected' : ''; ?> >13.Kendala Finansial ( Customer )</option>
											</select>
																					
											 <?php if(($this->session->userdata('nik_sess') == $listDetail['PM_NIK'])||($this->auth->get_access_value('MASTER')>0)) : ?>
											<button type="button" id="update_symtom" class="btn btn-warning btn-addon col-md-4 offset-md-8" data-key="Add"><i class="fa fa-edit"></i> Update SYMTOM
											<?php endif; ?>
											</button>
										</td>
									</tr>
									<?php endif; ?>


									<tr>
										<td class="td-info">Last Updated</td>
										<td><?= $listDetail['UPDATED_DATE2'] ?>
										</td>
									</tr>

									<?php if(!empty($listDetail['ID_LOP_EPIC'])) : ?>
									<tr>
										<td class="td-info">ID LOP</td>
										<td><?=$listDetail['ID_LOP_EPIC']?></td>
									</tr>
									<?php endif; ?>

									<?php if(!empty($listDetail['NO_KB'])) : ?>
									<tr>
										<td class="td-info">No. Kontrak Bersama [KB]</td>
										<td><?=$listDetail['NO_KB']?></td>
									</tr>
									<?php endif; ?>

									<?php 
									if(!empty($listDetail['NO_KL']) && ($listDetail['NO_KL']!= 'null' )) :
									$kl = json_decode($listDetail['NO_KL']);
									?>
									<tr>
										<td class="td-info">No. Kontrak Layanan [KL]</td>
										<td>
										<?php foreach ($kl as $key => $value): ?>
											<?= $value."<br>" ?>
										<?php endforeach; ?>
										</td>
									</tr>
									<?php endif; ?>

							</table>
						</div>
						
						<div class="col-md-3">
						<?php if(!empty($pm)) : ?>
	                      <div style="border:1px #a4b7c1 solid;">
	                      	<div class="d-flex justify-content-between" style="padding: 5px;padding-bottom: 0px;margin">
		                        <h5 class="mb-1">
		                        <a class="text-name" href="<?= base_url()."/user/profile/".$pm['NIK'] ?>">
		                        <span style="color: #000;" class="title-pm">
		                          Project Manager                        
		                      	</span>  
		                        </a>
		                      	</h5>
		                        <small> </small>
		                      </div>
		                      <div style="text-align: center;">
		                      	<img src="https://prime.telkom.co.id/sdv/<?= !empty($pm['PHOTO_URL'])? $pm['PHOTO_URL'] : '../user_picture/default-profile-picture.png' ; ?>" class="img-avatar" alt="<?= $pm['NAMA'] ?>" style="width: 100%;padding: 15px;padding-top: 10px">
		                      	<div class="td-info">
		                      		<span style="color: #000;" class="name-pm"><?= $pm['NAMA'] ?></span><br>
		                      		<span class="sub-name-pm"><?= $pm['NIK'].' - '.$pm['EMAIL'] ?></span>
		                      	</div>
		                      </div>
	                      </div>
	                      <?php endif; ?>

	                      <div class="row" style="margin-top: 10px;">   		
		          				<div class="col-sm-12">
									<div class="card">
									<div class="card-body">
									<div>Total Weight Plan
										<strong class="badge badge-pill badge-primary "><span class="h4"><?=number_format($sum_weight_real['TOTAL_WEIGHT'],2)?> %</span></strong>
									</div>
									<div class="progress progress-xs my-3">
									<div class="progress-bar bg-primary" role="progressbar" style="width: <?=number_format($sum_weight_real['TOTAL_WEIGHT'],2)?>%" aria-valuenow="<?=number_format($sum_weight_real['TOTAL_WEIGHT'])?> %" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="card">
									<div class="card-body">
									<div class="img-circle">Total Achievement
										<strong class="badge badge-pill badge-success "><span class="h4"><?=number_format($sum_weight_real['REAL'],2)?> %</span></strong>
									</div>
									<div class="progress progress-xs my-3">
									<div class="progress-bar bg-success" role="progressbar" style="width: <?=number_format($sum_weight_real['REAL'],2)?>%" aria-valuenow="<?= number_format($sum_weight_real['REAL']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									</div>
									</div>
								</div>
								<div class="col-sm-12">
									<?php if(!empty($listDetail['MANAGE_SERVICE'])) : ?>
										<div class="card">
											<div class="card-body bg-warning" style="border-radius: 9px;">
												<span style="font-size: 12px;color: #fff;" class="">This Project include Manage Service!</span>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>

	                    </div>
	                	
	                    <div class="col-sm-12 col-md-12">
							<div class="row">
								<div></div>
							</div>
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
		<ul class="nav nav-tabs nav-tabs-d" role="tablist">
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
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#acquisition" role="tab" aria-controls="acquisition">
				Acquisition
			</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#historyp" role="tab" aria-controls="historyp">
				history
			</a>
			</li>
		</ul>
			<div class="tab-content">
			<div class="tab-pane active" id="deliverable" role="tabpanel">
				<div class="row">
						<div class="col-sm-2">
							<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
							<button type="button" class="btn btn-success btnAddDeliverable btnGuest btn-addon" data-key="Add"><i class="fa fa-plus"></i> Add Deliverable
							</button>
							<?php endif; ?>
	          			</div>
					
	          			<div class="col-sm-6 offset-md-4">   
	          				
	          			</div>
	          	</div>

		              		 <div class="table-responsive w-xm wrapper">
							       	<table id="dataDeliverable" class="table b-t" style="width:100% !important;">
						                <thead class="thead-bg-blue">
						                <tr style="font-size: 12px;">
						                    <th style="width:8% !important">ID</th>
						                    <th style="width:20% !important">Deliverable</th>
						                    <th style="width:30%">Description</th>
						                    <th style="width:12%">Start</th>
						                    <th style="width:12%">End</th>
						                    <th style="width:5%">Weight</th>
						                    <th style="width:5%">Achievement</th>
						                    <th style="width:5%">File</th>
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
			<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
      		<button type="button" class="col-sm-2 btn btn-success btnAddIssue btnGuest btn-addon" data-key="Add"><i class="fa fa-plus"></i> Add Issue
			</button>
			<?php endif; ?>
							<div id="tableAll" class="table-responsive w-xm wrapper">
							       	<table id="dataIssue" class="table table-striped b-t" style="width:100% !important;">
						                <thead class="thead-bg-blue">
						                <tr style="font-size: 12px;">
						                    <th style="width:30% !important">Issue Name</th>
						                    <th style="width:30%">Impact</th>
						                    <th style="width:20%">Risk Impact</th>
						                    <th style="width:10%">Status</th>
						                    <th style="width:4%">Action</th>
						                </tr>
						                </thead>
						                <tbody style="font-size: 12px;">
						                </tbody>
						            </table>
				            </div> 


			</div>
			<div class="tab-pane" id="action" role="tabpanel">
					<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
					<button type="button" class="col-sm-2 btn btn-success btnAddCheck btnAction btnGuest btn-addon" data-key="Add">
						<i class="fa fa-plus"></i> Add Action Plan
					</button>
					<?php endif;?>


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

			<div class="tab-pane" id="acquisition" role="tabpanel">
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
					                        <button type="button" class="btn circle2 btn-success" id="btn-add-partner"><i class="fa fa-plus"></i></button>
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
					              	<?php if(empty($acquistion) || (!empty($acquisition)&&($acquistion[0]['MONTH'] != date('n'))) ) :  ?>
					              		<tr>
					              			<td><?= date('n'); ?></td>
					              			<td>N/A</td>
					              			<td>N/A</td>
					              			<td>N/A</td>
					              			<td>N/A</td>
					              			<td>N/A</td>
					              			<td>N/A</td>
					              		</tr>
					              	<?php endif; ?>
					                <?php foreach ($acquistion as $key => $value) : ?>
					                  <tr style="font-size:12px;" class="<?= date('n') == $value['MONTH']? 'bg-info' : ''; ?>">
					                      <td><?= $value['MONTH']; ?></td>
					                      <td><?= $value['TOP']; ?></td>
					                      <td style="text-align: center;"><?= !empty($value['PROGRESS']) ? $value['PROGRESS1'].'%' : ''; ?> <?php if($value['TOP']=='TERMIN'){ echo "TERMIN KE - ".$value['TERMIN'];}  ?>   <?= empty($value['PROGRESS']) && empty($value['TERMIN']) ? '0' :''; ?>  </td>
					                      <td class="rupiah"><?= !empty($value['ACQ']) ? $value['ACQ'] : '0'; ?></td>
					                      <td style="text-align: center;"><?= !empty($value['C_PROGRESS']) ?  $value['C_PROGRESS'].'%' : ''; ?><?= !empty($value['C_PROGRESS']) && !empty($value['TERMIN']) ? '<br>' : '';$value['TERMIN'] ?></td>
					                      <td class="rupiah"><?= !empty($value['C_ACQ']) ?  $value['C_ACQ'] : '0'; ?></td>
					                      <td><?= $value['NOTE']; ?></td>
					                  </tr>
					                <?php endforeach; ?>
					              </tbody>
					          </table>
					        </div>
					        <button type="button" class="btn btn-success col-md-2 offset-md-5 btn-addon" id="btn-add-acq"><i class="fa fa-plus"></i>Update Acquisition</button>
					    </div>





			</div>


			<div class="tab-pane" id="historyp" role="tabpanel">
					<div id="" class="table table-responsive w-xm wrapper">
						       	<table id="dataAcq" class="table table-striped b-t" style="max-width:100% !important;">
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
                        <div class="col-md-12 bg-info text-white>"  style="text-align: center;padding:5px;margin-bottom: 5px;">
                          <span><h3>Estimated Acquisition BAST <?= date('F');?>  </h3></span>
                        </div>
                        <input type="hidden"  id="month" name="month" value="<?= date('n'); ?>">
                        <input type="hidden"  id="id_project" name="id_project" value="<?= $id_project; ?>">
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc" name="otc" data-val="otc" class="topselect" <?= !empty($acq['OTC']['ACQ']) ? 'checked' : '' ?>>
                            <label for="otc">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq['OTC']['ACQ'])  ? '' : 'hidden' ?>" id="con_otc">
                        <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-6" >
                              <div class="form-group">
                                <label>Value</label>
                                <input type="text" id="otc_value" name="otc_value" class="form-control c_otc rupiah" 
                                value="<?= !empty($acq['OTC']['ACQ'])  ? $acq['OTC']['ACQ'] : '0'; ?>">
                              </div>

                              <div class="form-group">
                                <label>Percentage (%)</label>
                                <input min="0" max="100" type="number" id="otc_percent" name="otc_percent" class="form-control c_otc" value="<?= !empty($acq['OTC']['PROGRESS']) ? $acq['OTC']['PROGRESS'] : '0' ?>">
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
		                                <label>Percentage (%)</label>
		                                <input  min="0" max="100" type="number" id="termin_percent" name="termin_percent" class="form-control c_termin"  value="<?= !empty($acq['TERMIN']['PROGRESS']) ? $acq['TERMIN']['PROGRESS'] : '0' ?>">
		                              </div>

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
                                  <input type="text" id="progress_value" name="progress_value" class="form-control c_progress rupiah"  value="<?= !empty($acq['PROGRESS']['ACQ']) ? $acq['PROGRESS']['ACQ'] : '0' ?>">
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
                          <span><h3>Actual Acquisition <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?></h3></span>
                        </div>
                        <div class="form-group">
                          <div class="boxes">
                            <input type="checkbox" id="otc_lm" name="otc_lm" data-val="otc_lm" class="topselect" <?= !empty($acq_lm['OTC']['ACQ']) ? 'checked' : '' ?>>
                            <label for="otc_lm">OTC</label>
                          </div>
                        </div>
                        <div class="col-md-12 bg-grey <?= !empty($acq_lm['OTC']['ACQ'])  ? '' : 'hidden' ?>" id="con_otc_lm">
                          <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-6" >
                                  <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" id="otc_value_lm" name="otc_value_lm" class="form-control c_otc_lm rupiah"  value="<?= !empty($acq_lm['OTC']['ACQ']) ? $acq_lm['OTC']['ACQ'] : '0' ?>">
                                  </div>
                                  <div class="form-group">
                                    <label>Percentage (%)</label>
                                    <input  min="0" max="100" type="number" id="otc_percent_lm" name="otc_percent_lm" class="form-control c_otc_lm" value="<?= !empty($acq_lm['OTC']['PROGRESS']) ? $acq_lm['OTC']['PROGRESS'] : '0' ?>">
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
                                <label>Percentage (%)</label>
                                <input  min="0" max="100" type="number" id="termin_percent_lm" name="termin_percent_lm" class="form-control c_termin_lm"   value="<?= !empty($acq_lm['TERMIN']['PROGRESS']) ? $acq_lm['TERMIN']['PROGRESS'] : '0' ?>">
                              </div>
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
                                  <input  min="0" max="100" type="number" name="dp_percent_lm" id="dp_percent_lm" class="form-control c_dp_lm"   value="<?= !empty($acq_lm['DP']['PROGRESS']) ? $acq_lm['DP']['PROGRESS'] : '0' ?>">
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
                        	<div class="col-md-6 offset-md-6">
                        		<span>Gunakan klausul pada Kontrak Berlangganan (KB) antara Telkom dengan Customer (nilai sebelum PPN10%)</span>
                        	</div>
                        
                  <div class="modal-footer" id="footerAcq1">
                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btnvalidacq" class="btn btn-primary">Validate Acquisition <?= date('F', mktime(0, 0, 0, (date('m')-1) , 10));?></button>
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
                    	<input type="hidden" name="id_project" id="id_project" value="<?= $id_project ?>">
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
                        	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
		                    <button type="button" class="btn btn-danger z-index-top" data-dismiss="modal">Cancel</button>
		                    <button type="button" id="saveDeliverable" class="btn btn-primary btnTab" data-tab="deliverables">Save Deliverables</button>
		                	<?php endif; ?>

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
                                    <input type="email" name="pic_email[]" id="issue_picemail1" class="form-control picClass" placeholder="PIC Email 1" style="width: 135px;flex: none;" required>
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
                                    <input type="email" name="pic_email[]" id="issue_picemail2" class="form-control picClass" placeholder="PIC Email 2" style="width: 135px;flex: none;">
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
                        	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
		                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
		                    <button type="button" class="btn btn-primary"  id="saveIssue" data-tab="issue">Save Issue</button>
		                	<?php endif; ?>
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
                                <select name="assignto" class="form-control assignto"  id="assignto" required>
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
		                    <?php if($this->auth->get_access_value('PROJECT')>2) : ?>
		                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		                    <button type="button" class="btn btn-SAP btn-primary btnTab" id="saveAction" data-tab="action_plan">
		                    	Save Action Plan
		                    </button>
		                	<?php endif; ?>
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


<!-- Acquisition Modal -->
<!-- Issue modals -->
	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-acquistion">
	  <div class="modal-dialog modal-primary modal-lg">
	    <div class="modal-content">
	      	<div class="modal-header">
				<h4 class="modal-title" id="modal-title-acq">Update Acquisition BAST <?= date('F') ?></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
			</div>
			 <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="frmAcquisition">
                    	<input type="hidden" name="idPro" value="<?=$listDetail['ID_PROJECT']?>">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Total Actual Acquisition<br>Last Month</label>
                            </div>
                            <div class="col-md-9">
                            	<label>OTC</label>
                                <input type="text" class="form-control rupiah" name="total_acquisition_lm" id="total_acquisition_lm" value="0">
                            </div>

                            <div class="col-md-3">
                            </div>
                            <div class="col-md-5">
                            	<label>Reccuring</label>
                                <input type="text" class="form-control rupiah" name="total_acquisition_re_lm" id="total_acquisition_re_lm" value="0">
                            </div>
                            <div class="col-md-2">
                            	<label>Start date</label>
                                <input type="text" class="form-control date-picker" name="total_acquisition_re_lm_start" id="total_acquisition_re_lm_start" value="" placeholder="start date" readOnly>
                            </div>

                            <div class="col-md-2">
                            	<label>End date</label>
                                <input type="text" class="form-control date-picker" name="total_acquisition_re_lm_end" id="total_acquisition_re_lm_end" value="" placeholder="end date" readOnly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Estimated acquisition <br>of the current month</label>
                            </div>
                            <div class="col-md-9">
                            	<label>OTC</label>
                                <input type="text" class="form-control rupiah" name="estimated_acquisition" id="estimated_acquisition" value="0">
                            </div>

                            <div class="col-md-3"> 
                            </div>
                            <div class="col-md-5">
                            	<label>Reccuring</label>
                                <input type="text" class="form-control rupiah" name="estimated_acquisition_re" id="estimated_acquisition_re" value="0">
                            </div>
                            <div class="col-md-2">
                            	<label>Start date</label>
                                <input type="text" class="form-control date-picker" name="estimated_acquisition_re_start" id="estimated_acquisition_re_end" value="" placeholder="start date" readOnly>
                            </div>

                            <div class="col-md-2">
                            	<label>End date</label>
                                <input type="text" class="form-control date-picker" name="estimated_acquisitio_re_end" id="estimated_acquisition_re_end" value="" placeholder="end date" readOnly>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label class="form-control-label">Note</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="note_acquisition" id="note_acquisition"></textarea>
                            </div>
                        </div>
                        

                        <div class="modal-footer">
                        	<div id="issue_last_update"  style="position: fixed;left:0%;margin-left: 5%;"></div>
                        	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
		                    <button type="button" class="btn btn-danger " data-dismiss="modal">Cancel</button>
		                    <button type="button" class="btn btn-primary"  id="saveAcquisition" >Update Acquisition</button>
		                	<?php endif; ?>
		                </div>
                    </form>
                </div>
	    </div>
	  </div>
	</div>



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
                         </div>
                         

                    </form>
                </div>
    </div>
  </div>
</div>


<script type="text/javascript">  
$('#partners_field').text($('#partners_field').text().replace('()',''));

var id_project = "<?= $id_project; ?>";
var weight 			= '<?=$deliv_weight['WEIGHT']?>';
var total_weight 	= '<?=$sum_weight_real['TOTAL_WEIGHT']?>'; 
var start_week_1	= '<?=$listDetail['START_WEEK_1']?>';
var value_project	= '<?=$listDetail['VALUE']?>';
var tacquisition 	= 0;
var tacquisition_re = 0;

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
						  	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
							<?php endif; ?>
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
			              showRemove:false,
		});   
		$('#attachment_issue').fileinput({
							<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
						  	<?php endif; ?>
						  autoReplace: true,
				          maxFileCount: 1,                   
				          dropZoneEnabled: false,
			              mainClass: "input-group",
			              showUpload:false,
						  showRemove:false, 		
		});	
		$('#attachment_action').fileinput({
							<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
						  	<?php endif; ?>
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
                { mData: 'START1' },
                { mData: 'END1' },
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
                            if(obj.ATTACHMENT != null){
                               return "<a href='https://prime.telkom.co.id/_files/"+id_project+"/deliverable/"+obj.ATTACHMENT+"' target='_blank' download> <i class='fa fa-download text-success'></i></a>"
                            }else{
                            	return "";
                            }


                    }            
                            
                },
                <?php if($this->auth->get_access_value('PROJECT')>2) : ?>
                {
                    'mRender': function(data, type, obj){

                           return   "<span style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success BtnUpdateDeliverable  circle2 \' data-id='"+obj.ID_DELIVERABLE+"' ><i class='fa fa-cloud-upload-alt'></i></span> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteDeliverable circle2  \' data-id='"+obj.ID_DELIVERABLE+"' data-url="+base_url+"projects/deleteDeliverable?id_deliverable="+obj.ID_DELIVERABLE+"&id_project="+id_project+"  ><i class='fa fa-trash'></i></a> ";
                    }

                }
                <?php else :  ?>
                {
                    'mRender': function(data, type, obj){

                           return   "<span style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success BtnUpdateDeliverable  circle2 \' data-id='"+obj.ID_DELIVERABLE+"' ><i class='fa fa-cloud-upload-alt'></i></span> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-disabled  circle2  \' ><i class='fa fa-trash'></i></a> ";
                    }

                }	
               	<?php endif; ?>
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
                <?php if($this->auth->get_access_value('PROJECT')>2) : ?>
                {
                    'mRender': function(data, type, obj){
                    	if(obj.ACTION_NAME == null){
                                return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateIssue circle2  \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteIssue circle2 \' data-id='"+obj.ID_ISSUE+"' data-url='"+base_url+"projects/deleteIssue?&id_issue="+obj.ID_ISSUE+"&id_project="+id_project+"'  ><i class='fa fa-trash'></i></a> ";
                            }else{
                                return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateIssue circle2  \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-disabled  circle2 \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-trash'></i></a> ";
                            } 
                    }

                }
                <?php else :  ?>
                {
                    'mRender': function(data, type, obj){

                           return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateIssue circle2  \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-disabled  circle2 \' data-id='"+obj.ID_ISSUE+"' ><i class='fa fa-trash'></i></a> ";
                    }

                }
                <?php endif; ?>
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

		                <?php if($this->auth->get_access_value('PROJECT')>2) : ?>
		                {
		                    'mRender': function(data, type, obj){

		                           return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateActionPlan  \' data-id='"+obj.ID_ACTION_PLAN+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
		                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-danger  btnDeleteActionPlan  \' data-id='"+obj.ID_ACTION_PLAN+"' data-url='"+base_url+"projects/delete_action_plan/"+obj.ID_ACTION_PLAN+"/"+obj.ID_PROJECT+"'  ><i class='fa fa-trash'></i></a> ";
		                    }

		                }
		                <?php else : ?>
		                {
		                    'mRender': function(data, type, obj){

		                           return   "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-success btnUpdateActionPlan  \' data-id='"+obj.ID_ACTION_PLAN+"' ><i class='fa fa-cloud-upload-alt'></i></a> "+  
		                                    "<a style='width:45%;color:#000 !important;' class=\'btn  btn-xs btn-disabled  \' data-id='"+obj.ID_ACTION_PLAN+"' ><i class='fa fa-trash'></i></a> ";
		                    }

		                }
		                <?php endif; ?>
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
                var url = base_url+"projects/view/<?= $id_project ?>";
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
          	tableDeliverable();
          	tableIssue();
          	tableActionPlan();
          	tableHistory();

          	$(document).on('change','#otc_percent',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#otc_value').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#otc_percent_lm',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#otc_value_lm').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#termin_percent',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#termin_value').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#termin_percent_lm',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#termin_value_lm').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#progress_percent',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#progress_value').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#progress_percent_lm',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#progress_value_lm').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#dp_percent',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#dp_value').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','#dp_percent_lm',function(e){            
              	var percent = $(this).val();
              	var val 	= (value_project*percent)/100;
              	$('#dp_value_lm').val(Math.ceil(val));
              	$('.rupiah').priceFormat({
				      prefix: 'Rp. ',
				      centsSeparator: ',',
				      thousandsSeparator: '.',
				      centsLimit: 0
				  });
              });

          	$(document).on('change','.topselect',function(e){
                var top   = $(this).data().val;
                var check = 0;
                if ($(this).is(':checked')) {
                  $('#con_'+top).removeClass('hidden');                
                  /*$('.c_'+top).attr('',false);*/                 
                }else{
                  $('#con_'+top).addClass('hidden');                
                  /*$('.c_'+top).attr('',true);*/    
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
                    $("#weight").removeAttr('readonly');
                    $("#weight").attr('readonly',false);
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

                    $('#issue_picname1').val('');
	        			$('#issue_picemail1').val('');
	        			$('#issue_picname2').val('');
	        			$('#issue_picemail2').val('');

                    $('#attachment_deliverable_value').val('');
                    $('#attachment_deliverable').fileinput('clear');
                    $('#attachment_deliverable').fileinput('destroy');

                    $('#attachment_deliverable').fileinput({
                    		<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
						  	<?php endif; ?>
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
	                            if (Number(total_weight)==100) {
	                                $("#weight").val(Number(data['WEIGHT']));
	                                $("#weight").removeAttr('max');
	                            }else{
	                                $("#weight").val(Number(data['WEIGHT']));
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
						                  	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						                  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
						              		<?php endif; ?>
										  autoReplace: true,
								          maxFileCount: 1,                   
								          dropZoneEnabled: false,
							              mainClass: "input-group"
						              });
	                            }else{
	                            	$("#attachment_deliverable").fileinput('destroy');
	                            	$('#attachment_deliverable').fileinput({
									  	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
									  uploadUrl : base_url + 'projects/upload_file_deliverable/'+id_project,
										<?php endif; ?>
									  autoReplace: true,
							          maxFileCount: 1,                   
							          dropZoneEnabled: false,
						              mainClass: "input-group",
						              showUpload:false,
						              showRemove:false,
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
	        			$('#issue_picname1').val('');
	        			$('#issue_picemail1').val('');
	        			$('#issue_picname2').val('');
	        			$('#issue_picemail2').val('');
	        			$('#impact').text('');
	        			$('#impact').val('');
	                    $("#frmIssue").attr('action','projects/add_issue/'+id_project);
	                    $("#modal-title-issue").html("Add New Issue");
	                    $(".editInput").hide();
	         			$("#issue_last_update").html('');
	                    $('#attachment_issue_value').val('');
	                    $('#attachment_issue').fileinput('clear'); 
	                    $('#attachment_issue').fileinput('destroy'); 
	                    $('#attachment_issue').fileinput({
	                    		<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
							  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
							  	<?php endif; ?>
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
						                  	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						                  uploadUrl : base_url + 'projects/upload_file_issue/'+id_project,
						                  	<?php endif; ?>
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
								<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
							  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
							  	<?php endif; ?>
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
                    $(".linkAttc a").attr('');
                    $(".linkAttc a").text('');
                    $(".linkAttc").hide();
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
	                    /*$(".assignto_detail").html("");
	                    $('.assignto_detail option[value=FMS]').attr('selected','selected');*/
	                    var x = document.getElementById("assignto");
	                    var option = document.createElement("option");
	                    option.value = data['ASSIGN_TO_DETAIL'];
	                    option.text = data['ASSIGN_TO_DETAIL'];
	                    x.add(option, 0);

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
						                  	<?php if($this->auth->get_access_value('PROJECT')>2) : ?>
						                  uploadUrl : base_url + 'projects/upload_file_action/'+id_project,
						                  	<?php endif; ?>
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

	        $(document).on('change','#assignto', function (e) {
	        	e.stopImmediatePropagation();
	        	$('#assignto_detail').prop('selectedIndex',0);
	        	$('#assignto_detail').removeClass('hidden');
	        	$('.assigntodetailselect').addClass('hidden');
	        	var assign = $('#assignto').val();
	        	console.log('assign = '+assign);
	        	switch(assign) {
				    case 'SEGMEN':
				    	$('.assigntodetailselect_segmen').removeClass('hidden');
				    	$('#assignto_detail').val('BMS-1');
				        break;
				    case 'BDM':
				    	$('.assigntodetailselect_bdm').removeClass('hidden');
				    	$('#assignto_detail').val('BDM');
				        break;
				    case 'PJM':
				    	$('.assigntodetailselect_sdv').removeClass('hidden');
				    	$('#assignto_detail').val('SDV');
				        break;
				    case 'SDV':
				    	$('.assigntodetailselect_sdv').removeClass('hidden');
				    	$('#assignto_detail').val('SDV');
				        break;
				    case 'DSS':
				    	$('.assigntodetailselect_dss').removeClass('hidden');
				    	$('#assignto_detail').val('DSS');
				        break; 
				    case 'TREG':
				    	$('.assigntodetailselect_treg').removeClass('hidden');
				    	$('#assignto_detail').val('TREG 1');
				        break;
				    case 'MITRA':
				    	$('.assigntodetailselect_partner').removeClass('hidden');
				        break;           
				    default: 
				        console.log('failure');
				}
				console.log($('#assignto_detail').val());

	        });

	        $(document).on('click','#btnAcquisition', function () {
	                    $("#frmAcquisition").attr('action','projects/saveAcquisition/'+id_project);
	                    $(".editInput").hide();  
						$('#modal-acquistion').modal('show');
	            });

	        $("body").on('click','#saveAcquisition', function (e) {
				e.stopImmediatePropagation();
				/*$('#total_acquisition').val($('#total_acquisition').unmask());
				$('#total_acquisition_re').val($('#total_acquisition_re').unmask());*/
				$('#total_acquisition_lm').val($('#total_acquisition_lm').unmask());
				$('#total_acquisition_re_lm').val($('#total_acquisition_re_lm').unmask());
				$('#estimated_acquisition').val($('#estimated_acquisition').unmask());
				$('#estimated_acquisition_re').val($('#estimated_acquisition_re').unmask());
				var dataForm  = $('#frmAcquisition').serialize();
				var url = base_url + $("#frmAcquisition").attr('action');
				$('#modal-acquistion').modal('hide');
				$('#pre-load-background').fadeIn();
				$.ajax({
	                    url: url,
	                    type:'POST',
	                    data:  dataForm ,
	                    success:function(result){
	                    	tableIssue();
	                    	tableHistory();
	                    	$('#pre-load-background').fadeOut();
			                 if(result.data == 'success'){
			                 	location.reload();
			                 } 
	                         return result;
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
					            color: '#20a8d8',
					            data: [0,<?php echo implode(",", $kurva['PLAN'])?>]
					        }, {
					            name: 'Achievement',
					            color: '#4dbd74',
					            data: [0,<?php echo implode(",", $kurva['REAL'])?>]
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



			/*Chart Deliverable*/
				var name_deliverable = <?= json_encode($name_deliverable) ?>;
	        	var description_deliverable = <?= json_encode($desc_deliverable) ?>;
				Highcharts.chart('container_deliverable', {
				    chart: {
				        type: 'columnrange',
				        inverted: true
				    },

				    title: {
				        text: ''
				    },

				    subtitle: {
				        text: ''
				    },

				    xAxis: {
				        categories: name_deliverable
				    },

				    yAxis: {
				        title: {
				            text: 'Weeks'
				        },
				        min: 0
				    },

				    tooltip: {
				        headerFormat: '<span style="font-size:11px">Range {series.name}</span><br>',
				    },

				    plotOptions: {
				        columnrange: {
				            dataLabels: {
				                enabled: true,
				                format: 'Week {y}'
				            }
				        }
				    },

				    legend: {
				        enabled: false
				    },
				    credits: {
								enabled: false
							},
				    series: [{
				        name: ['Week'],
				        colorByPoint: true,
				        data: <?= json_encode($d_ws_we) ?>,
				        colors: <?= json_encode($color_deliverable) ?>,
				    	}]

				});
     

          }
      };

  }();

  jQuery(document).ready(function() {
      Page.init(event);
  }); 

</script>