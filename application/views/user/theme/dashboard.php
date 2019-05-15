<style type="text/css">

.timeline {
position: relative;
margin: 0 0 30px 0;
list-style: none;
padding: 0px;
}

.timeline:before {
content:'';position:absolute;top:0;bottom:0;width:4px;background:#ddd;left:31px;margin:0;border-radius:2px;
}
.timeline > li {
position: relative;
margin-right: 10px;
margin-bottom: 15px;
}

.timeline > li:before,
.timeline > li:after {
content: " ";
display: table;
}
.timeline > li:after {
clear: both;
}
.timeline > li > .timeline-item {
-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);border-radius:3px;margin-top:0;background:#fff;color:#444;margin-left:60px;margin-right:15px;padding:0;position:relative
}
.timeline > li > .timeline-item > .time {
color: #999;
float: right;
padding: 10px;
font-size: 12px;
}
.timeline > li > .timeline-item > .timeline-header {
margin:0;color:#555;border-bottom:1px solid #f4f4f4;padding:10px;font-size:16px;line-height:1.1;
}
.timeline > li > .timeline-item > .timeline-header > a {
font-weight: 600;
}
.timeline > li > .timeline-item > .timeline-body,
.timeline > li > .timeline-item > .timeline-footer {
padding: 10px;
}
.timeline > li > .fa,
.timeline > li > .glyphicon,
.timeline > li > .ion {
width:30px;height:30px;font-size:15px;line-height:30px;position:absolute;color:#666;background:#d2d6de;border-radius:50%;text-align:center;left:18px;top:0;
}
.timeline > .time-label > span {
font-weight: 600;
padding: 5px;
border-radius: 4px;
}
.timeline-inverse > li > .timeline-item {
background: #f0f0f0;
border: 1px solid #ddd;
box-shadow: none;
}
.timeline-inverse > li > .timeline-item > .timeline-header {
border-bottom-color: #ddd;
}
</style>
<div class="container-fluid container-content-no-bread">
  <div class="animated fadeIn">

    <div class="row">
           <div class="col-md-6 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>projects" >
              <div class="social-box social-box-4 linkedin">
              <i class="icon-rocket"> Project Active</i>
                <ul>
                  <li>
                    <strong><?= $project['LEAD'] ?></strong>
                    <span>Lead</span>
                  </li>
                  <li>
                    <strong><?= $project['LAG'] ?></strong>
                    <span>Lag</span>
                  </li>
                  <li>
                    <strong><?= $project['DELAY'] ?></strong>
                    <span>Delay</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6  nav-link-hgn" data-url="<?= base_url(); ?>projects/candidate">
              <div class="social-box twitter">
              <i class="icon-vector"> Candidate</i>
                <ul>
                  <li>
                    <strong><?= $project['PROJECT CANDIDATE'] ?></strong>
                    <span>Epic</span>
                    </li>
                    <li>
                    <strong><?= $project['REQUEST'] ?></strong>
                    <span>Prime</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-md-3 col-sm-6 nav-link-hgn" data-url="<?= base_url(); ?>bast">
              <div class="social-box google-plus">
              <i class="fa fa-handshake-o"> BAST</i>
                <ul>
                  <li>
                    <strong><?= $bast['progress'] ?></strong>
                    <span>In Progress</span>
                    </li>
                    <li>
                    <strong><?= $bast['approved'] ?></strong>
                    <span>Approved</span>
                  </li>
                </ul>
              </div>
            </div>

            </div>

        </div>

    <div class="card">
      <div class="card-header">
      Projects Summary
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 col-lg-12" id="diagram1"></div>
        </div>

        <div class="row" style="margin-top: 10px;">
          <div class="col-sm-12 col-lg-12" id="diagram2">
        </div>

        
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
      Latest Activity
      </div>
      <div class="card-body">
          <div class="row">
            <div class="offset-sm-1 col-sm-10">
              <table id="dataAll" class="table b-t" style="width:100% !important;overflow-x:hidden;">
                  <thead class="thead-bg-blue">
                  <tr>
                      <th style="width:15%;font-size: 10px !important;">DATE TIME </th>
                      <th style="width:10%;font-size: 10px !important;">USER ID</th>                  
                      <th style="width:10%;font-size: 10px !important;">NAME</th>                  
                      <th style="width:20%;font-size: 10px !important;">ACTION</th>
                      <th style="width:20%;font-size: 10px !important;">TYPE</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php foreach($history as $key=>$value) :?>
                          <tr>
                              <td style="font-size:10px;"><?= $history[$key]['TIME']; ?></td>
                              <td><?= $history[$key]['ID_USER']; ?></td>
                              <td>
                                  <?php 
                                  $name = explode(" ",$history[$key]['NAME_USER']);
                                  echo $name[0];
                                  ?>
                              </td>
                              <td style="font-size:10px;"><?= $history[$key]['STATUS']; ?></td>
                              <td><?= $history[$key]['TYPE']; ?></td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
            </div>  
          </div>
      </div>
    </div>


</div>

<script type="text/javascript">
  var Form = function () {    

    var ChartInitialize = function(start=null,end=null) {

                    $.ajax({  type:"post",
                        async: false,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/diagram1",
                        success: function(data) {
                            $('#diagram1').empty();
                            $('#diagram1').append(data);
                        }
                    });

                    $.ajax({  type:"post",
                        async: false,
                        data: { d_start : start, d_end : end},
                        url: base_url+"dashboard/diagram2",
                        success: function(data) {
                            $('#diagram2').empty();
                            $('#diagram2').append(data);
                        }
                    });                                 
    };


    return {
        init: function() {
            ChartInitialize();
            $('body').on('click','#diagram_refresh',function(e){
                var start   = $('#d_start').val();  
                var end     = $('#d_end').val();    
                ChartInitialize(start,end);                             
            });

        }
    };

}();

jQuery(document).ready(function() {
    Form.init();
});
</script>