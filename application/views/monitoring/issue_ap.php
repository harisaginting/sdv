<ol class="breadcrumb col-md-12">
<li class="breadcrumb-item nav-link-hgn col-md-4" data-url="<?= base_url(); ?>monitoring/issueAp"> Monitoring Issue & Action Plan</li>
<div class="col-md-8">  
  <div style="" class="pull-right">
      <a href="<?= base_url(); ?>monitoring/download_list_monitoring_issueAp" class="btn btn-primary btn-addon"><i class="fa fa-download"></i>
        <span class="float-left"> &nbsp; Download &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
      </a>
  </div>
</div>
</ol>
<div class="container-fluid container-content">

<div class="row">
  <div class="col-md-12">
  <div class="card">

    <div class="card-body">                                                                
        <!-- <div class="row">
              <div class="col-md-6 col-sm-6 nav-link-hgn" >
                  <div class="social-box social-box-4 linkedin">
                  <i class="fa fa-exclamation-triangle bg-warning"> Issue</i>
                    <ul>
                      <li>
                        <strong><?= !empty($issue['active_action']) ? $issue['active_action'] : 0 ?></strong>
                        <span>Active With Action Plan</span>
                      </li>
                      <li>
                        <strong><?= !empty($issue['active_not_action']) ? $issue['active_not_action']: 0 ?></strong>
                        <span>Active Without Action Plan</span>
                      </li>
                      <li>
                        <strong><?= !empty($issue['closed']) ? $issue['closed'] : 0 ?></strong>
                        <span>Closed</span>
                      </li>
                  </ul>
                  </div>
                </div>


              <div class="col-md-6 col-sm-6  nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate">
                <div class="social-box twitter">
                <i class="fa fa-briefcase"> Action Plan</i>
                  <ul>
                    <li>
                      <strong><?= !empty($project['LOP'] )? $project['LOP']  : 0 ?></strong>
                      <span>Active</span>
                      </li>
                      <li>
                      <strong><?= !empty($project['NONLOP'])? $project['NONLOP'] : '0' ?></strong>
                      <span>Closed</span>
                    </li>
                  </ul>
                </div>
              </div>
  
        </div>   -->

        <div class="row">
            <div class="col-md-12">                                                                 
                <table id="dataMonitoringIssueAp" class="table table-responsive-sm" style="width: 100% !important;">
                    <thead>
                      <tr>
                        <th style="width: 20%;">Name</th> 
                        <th style="width: 20%;">Issue</th>
                        <th style="width: 20%;">Action Plan</th>
                        <th style="width: 8%;">Plan</th>
                        <th style="width: 8%;">Ach.</th>
                        <th style="width: 15%;">PM</th>
                        <th style="width: 15%;">Last Update</th>
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
</div>


<div class="row">
  <div class="col-md-12">
  <div class="card">

  <div class="card-body">
        </div>
  </div>
  </div>
</div>

</div>

<script type="text/javascript">    
var Form = function () {    
    var TableInitialize = function() {                  
        var table = $('#dataMonitoringIssueAp').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: { 'url':base_url+'monitoring/get_list_IssueAp', 'type':'POST'},
            aoColumns: [    
                {
                   'mRender': function(data, type, obj){
                    return "<a style='font-size:12px;width:48%;margin-right:1px;' class='text-primary' href='"+base_url+"projects/view/"+obj.ID_PROJECT+"' >"+obj.NAME+"</a>"; 
                  }

                },
                { mData: 'ISSUE_NAME' },
                {
                   'mRender': function(data, type, obj){
                    var ACTION_DUE_DATE = "";
                    var ACTION_NAME = "";

                    if(obj.ACTION_DUE_DATE != null){ACTION_DUE_DATE = "DUE DATE : "+ obj.ACTION_DUE_DATE;}
                    if(obj.ACTION_NAME != null){ACTION_NAME = obj.ACTION_NAME;}
                        return "<span style='color:#f42020;'>"+ACTION_DUE_DATE+"</span><br>"+ACTION_NAME; 
                    /*}else{
                         return "<div style='width:100%;' class='text-success bg-success'>"+obj.RNUM+"</div>"; 
                    }*/
                  }

                },
                { mData: 'PLAN' },
                { mData: 'ACH' }, 
                { mData: 'PM_NAME' }, 
                { mData: 'LAST_UPDATED' },
               ],           
        });         
    };

    var MergeGridCells = function() {
           
        }

    return {
        init: function() {
            TableInitialize();
            MergeGridCells();
         }
    };

}();

jQuery(document).ready(function() {
    Form.init();
});        


$(document).bind("ajaxSend", function(){
             }).bind("ajaxComplete", function(){
                
                MergeCommonRows($('#dataAll'));
          
    });  


function MergeCommonRows(table) {
    var firstColumnBrakes = [];
    // iterate through the columns instead of passing each column as function parameter:
    for(var i=1; i<=table.find('th').length; i++){
        var previous = null, cellToExtend = null, rowspan = 1;
        table.find("td:nth-child(" + i + ")").each(function(index, e){
            var jthis = $(this), content = jthis.text();
            // check if current row "break" exist in the array. If not, then extend rowspan:
            if (previous == content && content !== "" && $.inArray(index, firstColumnBrakes) === -1) {
                // hide the row instead of remove(), so the DOM index won't "move" inside loop.
                jthis.addClass('hidden');
                cellToExtend.attr("rowspan", (rowspan = rowspan+1));
            }else{
                // store row breaks only for the first column:
                if(i === 1) firstColumnBrakes.push(index);
                rowspan = 1;
                previous = content;
                cellToExtend = jthis;
            }
        });
    }
    // now remove hidden td's (or leave them hidden if you wish):
    $('td.hidden').remove();
}
     
           
</script>