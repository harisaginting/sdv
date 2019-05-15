<script src="<?= base_url(); ?>assets/plugin/gantt/codebase/dhtmlxgantt.js?v=6.0.7"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/plugin/gantt/codebase/dhtmlxgantt.css?v=6.0.7">

<style>
  .sidebar-fixed .main, .sidebar-fixed .app-footer{
  	margin-left: 0px;
  }


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



/*.gantt_task_content{
	display: none;  
}*/
</style>

<ol class="breadcrumb" style="margin-top: 40px;"> 
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
</ol>


<div class="container-content">
	<div class="row">

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

		<div class="row">
		<div class="col-md-2 col-md-push-10">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Gantt info</h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked" id="gantt_info">
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-10 col-md-pull-2">
			<div class="gantt_wrapper panel" id="gantt_here"></div>
		</div>
	</div>

	</div>
</div>


<script>
	// GANTT CHART
			var urlTask		= "<?= base_url() ?>projects/apiTask/<?= $id_project ?>";
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
			gantt.config.grid_width = 400;
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

</script>