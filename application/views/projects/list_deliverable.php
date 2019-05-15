<style type="text/css">
  .chart-view{
    min-width: 100%;
  }
</style>

<div style="padding-left: 10px;padding-right: 10px;padding-top: 45px;">
  <div class="row">
    <div class="card-body collapse show" id="collapseExample" style="min-width: 100% !important; max-height: 600px;">
      <div id="chartArea" class="chart-view"></div>
    </div>
  </div>


  <div class="row nomarginLR" style="margin-top: 10px;">
      <div>PLAN</div>
      <div id="listPlan"></div>
  </div>

  <div class="row">
      <!-- <div class="col-sm-2">
        <a href="<?= base_url().'projects/view'.$id_project; ?>"  class=" btn btn-warning btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>"><i class="fa fa-arrow-left"></i>Back
        </a>
      </div> -->
      <div class="col-sm-2">
        <button type="button" id="saveDetailPlan"  class=" btn btn-success btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>"><i class="fa fa-floppy-o"></i>Save Plan
        </button>
      </div>
  </div>

  <div class="row nomarginLR" style="margin-top: 30px;">
      <div>ACHIEVMENT</div>
      <div id="listDeliverable"></div>
  </div>

  <div class="row">
      <!-- <div class="col-sm-2">
        <a href="<?= base_url().'projects/view'.$id_project; ?>"  class=" btn btn-warning btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>"><i class="fa fa-arrow-left"></i>Back
        </a>
      </div> -->
      <div class="col-sm-2">
        <button type="button" id="saveDetailDeliverable"  class=" btn btn-success btn-addon <?= $this->auth->get_access_value('MASTER')>0? '': 'hidden' ?>"><i class="fa fa-floppy-o"></i>Save Realization
        </button>
      </div>
  </div>

</div>


<script type="text/javascript">  
Highcharts.chart('chartArea', {
        
            chart: {
                height: 400,
                width:1200
            },
            credits: {
              enabled: false
            },
                title: {
                    text: 'S Curve project <?php echo preg_replace("![^a-z0-9]+!i", " ",$listDetail['NAME']);?>',
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
                    color: 'red',
                    data: [0,<?php echo implode(",", $kurva['PLAN'])?>]
                }, {
                    name: 'Realization',
                    data: [0,<?php echo implode(",", $kurva['REAL'])?>]
                }]
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
var hot = new Handsontable(hotElement, hotSettings);

function sendEditDetailDeliverable(){
	var column 	= <?= !empty(count($kurva['WEEK'])) ? count($kurva['WEEK']) : 0; ?> + 3;
	var t_deliverable  = <?= !empty($t_deliverable) ? $t_deliverable : 0  ?>;
	var data = [];

	for (var i = 0; i < t_deliverable; i++) {
		data[i]	= hot.getDataAtRow(i);
		var msg = "Deliverable Success Updated";

		$.ajax({
	        type:"POST",
	        data: {data : data[i]},
	        async : false,
	        url: base_url+'projects/editTableDeliverable/<?= $id_project; ?>',
	        success : function(data){
	            window.setTimeout(function () {
	                Command: toastr["success"](msg);

					toastr.options = {
					  "closeButton": false,
					  "debug": false,
					  "newestOnTop": false,
					  "progressBar": false,
					  "positionClass": "toast-top-center",
					  "preventDuplicates": false,
					  "onclick": null,
					  "showDuration": "300",
					  "hideDuration": "1000",
					  "timeOut": "5000",
					  "extendedTimeOut": "1000",
					  "showEasing": "swing",
					  "hideEasing": "linear",
					  "showMethod": "fadeIn",
					  "hideMethod": "fadeOut"
					}
	            }, 2000);
	        }
	    }); 
	}

	/*var data =  hot.getData();
	var data =  hot.getDataAtRow(1);
	console.log(data);
*/	/*for (var i = 0; i < data.length; i++) {
		
	}*/
	//location.reload();
}


function sendEditDetailPlan(){
  var column         = <?= !empty(count($kurva['WEEK'])) ? count($kurva['WEEK']) : 0; ?> + 3;
  var t_deliverable  = <?= !empty($t_plan) ? $t_plan : 0  ?>;
  var data = [];

  for (var i = 0; i < t_deliverable; i++) {
    data[i] = hot2.getDataAtRow(i);
    var msg = "Deliverable Success Updated";

    $.ajax({
          type:"POST",
          data: {data : data[i]},
          async : false,
          url: base_url+'projects/editTablePlan/<?= $id_project; ?>',
          success : function(data){
              window.setTimeout(function () {
                  Command: toastr["success"](msg);

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
              }, 2000);
          }
      }); 
  }

  /*var data =  hot.getData();
  var data =  hot.getDataAtRow(1);
  console.log(data);
*/  /*for (var i = 0; i < data.length; i++) {
    
  }*/
  //location.reload();
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
var hot2 = new Handsontable(hotElement2, hotSettings2);

$("body").on('click','#saveDetailDeliverable', function (e) {
	e.stopImmediatePropagation();
	//console.log(hot.getData());
	sendEditDetailDeliverable();
	/*$.ajax({
	        type:"POST",
	        data: {data : hot.getData()},
	        url: base_url+'projects/editTableDeliverable',
	        success : function(data){
	            
	        }
	    });*/

}); 


$("body").on('click','#saveDetailPlan', function (e) {
  e.stopImmediatePropagation();
  //console.log(hot.getData());
  sendEditDetailPlan();
  /*$.ajax({
          type:"POST",
          data: {data : hot.getData()},
          url: base_url+'projects/editTableDeliverable',
          success : function(data){
              
          }
      });*/

}); 

</script>