      <p>
        <h5 style="border-bottom: 1px solid #000;">Release Date : <?= date('d - M - Y') ?></h5>
      </p>
      <p>
        <h4 style="border-bottom: 1px solid #000;">Detail Project</h4>
      </p>
      <table border="1" cellpadding="2" style="width:100%;border-top:5px solid #FFF;font-size:11px;" border="0">
        <tr>
          <td width="30%"><b>Project Name</b></td>
          <td width="70%">: <?= $project['NAME'] ?></td>
        </tr>
        <tr>
          <td width="30%"><b>Project Status</b></td>
          <td width="70%">: <?= $project['STATUS'] ?></td>
        </tr>
        <tr>
          <td width="30%"><b>Value</b></td>
          <td width="70%">: Rp. <?=  number_format($project['VALUE'], 2, ',', '.'); ?></td>
        </tr>
        <tr>
          <td width="30%"><b>Customer</b></td>
          <td width="70%">: <?= $project['STANDARD_NAME'] ?></td>
        </tr>
        <tr>
          <td width="30%"><b>Segmen</b></td>
          <td width="70%">: <?= $project['SEGMEN'] ?></td>
        </tr>
        <tr>
          <td width="30%"><b>NIK / NAME AM</b></td>
          <td width="70%">: <?= $project['AM_NIK'].' / '.$project['AM_NAME'] ?></td>
        </tr>
        <tr>
          <td width="30%"><b>NIK / NAME PM</b></td>
          <td width="70%">: <?= $project['PM_NIK'].' / '.$project['PM_NAME'] ?></td>
        </tr>
        <tr>
          <td width="30%">Plan </td>
          <td width="70%">: <?= number_format((float)$progress['TOTAL_WEIGHT'], 2, '.', '');?>%</td>
        </tr>
        <tr>
          <td width="30%">Achievement</td>
          <td width="70%">: <?= number_format((float)$progress['TOTAL_WEIGHT'], 2, '.', ''); ?>%</td>
        </tr>
        <tr>
          <td width="30%">Deviasi</td>
          <td width="70%">: <?= number_format((float)($progress['REAL'] - $progress['TOTAL_WEIGHT']), 2, '.', ''); ?>%</td>
        </tr>
        <tr>
          <td width="30%">Start Date</td>
          <td width="70%">: <?= $project['START_DATE']; ?></td>
        </tr>
        <tr>
          <td width="30%">End Date</td>
          <td width="70%">: <?= $project['END_DATE']; ?></td>
        </tr>
        <tr>
          <td width="30%">Description</td>
          <td width="70%">: <?= $project['DESCRIPTION'] ?></td>
        </tr>
      </table>
      <p>
        <h4 style="border-bottom: 1px solid #000;">Graphic</h4>
      </p>
      <img src="<?= $chart; ?>" alt=""> 



      <div  style="page-break-before:always;" >
      <p>
        <h4 style="border-bottom: 1px solid #000;">Deliverables</h4>
      </p>
         <table border="1" cellpadding="2" style="border-top:5px solid #FFF;font-size:11px;width:100%">
              <tr style="background-color: #f42020;">
                <td style="width: 30%;">Name</td>
                <td>Weight</td>
                <td>Plan</td>
                <td>Progress Value</td>
                <td>Start Date</td>
                <td>End Date</td>
                <td>Description</td>
              </tr>
              <?php foreach ($deliverables as $key => $value) : ?>
              <tr>
                <td><?= $deliverables[$key]['NAME']; ?></td>
                <td><?= number_format((float)$deliverables[$key]['WEIGHT'], 2, '.', ''); ?></td>
                <td><?= number_format((float)$deliverables[$key]['PLAN'], 2, '.', ''); ?></td>
                <td><?= number_format((float)$deliverables[$key]['PROGRESS_VALUE'], 2, '.', ''); ?></td>
                <td><?= $deliverables[$key]['START_DATE']; ?></td>
                <td><?= $deliverables[$key]['END_DATE']; ?></td>
                <td><?= $deliverables[$key]['DESCRIPTION']; ?></td>
              </tr>
              <?php endforeach; ?>          
          </table>
      </div>


      <p>
        <h4 style="border-bottom: 1px solid #000;">Issue</h4>
      </p>
          <table border="1" cellpadding="2" style="border-top:5px solid #FFF;font-size:11px;width:100%;">
              <tr style="background-color: #f42020;">
              <td style="width: 30%;">Name</td>
              <td>Risk Impact</td>
              <td>Impact</td>
              <td>Status</td>
              <td>PIC</td>
            </tr>
              <?php foreach ($issue as $key => $value) : ?>
              <tr>
                <td><?= $issue[$key]['ISSUE_NAME']; ?></td>
                <td><?= $issue[$key]['RISK_IMPACT']; ?></td>
                <td><?= $issue[$key]['IMPACT']; ?></td>
                <td><?= $issue[$key]['STATUS_ISSUE']; ?></td>
                <td><?= $issue[$key]['PIC']; ?></td>
              </tr>
              <?php endforeach; ?>       
          </table>

      <div  style="page-break-before:always;" >
          <p>
            <h4 style="border-bottom: 1px solid #000;">Action Plan</h4>
          </p>
          <table border="1" cellpadding="2" style="border-top:5px solid #FFF;font-size:11px;width:100%;">
              <tr style="background-color: #f42020;">
              <td style="width: 30% !important;">Action </td>
              <td>Issue</td>
              <td>Impact</td>
              <td>Due Date</td>
              <td>Remarks</td>
              <td>Status</td>
              <td>Assign To</td>
              <td>PIC</td>
            </tr>
              <?php foreach ($action_plan as $key => $value) : ?>
              <tr>
                <td><?= $action_plan[$key]['ACTION_NAME']; ?></td>
                <td><?= $action_plan[$key]['ISSUE_NAME']; ?></td>
                <td><?= $action_plan[$key]['RISK_IMPACT']; ?></td>
                <td><?= $action_plan[$key]['DUE_DATE']; ?></td>
                <td><?= $action_plan[$key]['ACTION_REMARKS']; ?></td>
                <td><?= $action_plan[$key]['ACTION_STATUS']; ?></td>
                <td><?= $action_plan[$key]['ASSIGN_TO']; ?> <?= !empty($action_plan[$key]['ASSIGN_TO_DETAIL'])? $action_plan[$key]['ASSIGN_TO_DETAIL']:''; ?></td>
                <td><?= $action_plan[$key]['PIC']; ?></td>
              </tr>
              <?php endforeach; ?>       
          </table>
      </div>

      <div  style="page-break-before:always;" >
          <p>
            <h4 style="border-bottom: 1px solid #000;">Issue History</h4>
          </p>
          <table border="1" cellpadding="2" style="border-top:5px solid #FFF;font-size:11px;width:100%;">
              <tr style="background-color: #f42020;">
              <td style="width: 30%;">Name</td>
              <td>Risk Impact</td>
              <td>Impact</td>
              <td>Closed Date</td>
              <td>PIC</td>
            </tr>
              <?php foreach ($issue_history as $key => $value) : ?>
              <tr>
                <td><?= $issue_history[$key]['ISSUE_NAME']; ?></td>
                <td><?= $issue_history[$key]['RISK_IMPACT']; ?></td>
                <td><?= $issue_history[$key]['IMPACT']; ?></td>
                <td><?= $issue_history[$key]['ISSUE_CLOSED_DATE']; ?></td>
                <td><?= $issue_history[$key]['PIC']; ?></td>
              </tr>
              <?php endforeach; ?>       
          </table>

       
          <p>
            <h4 style="border-bottom: 1px solid #000;">Action Plan History</h4>
          </p>
          <table border="1" cellpadding="2" style="border-top:5px solid #FFF;font-size:11px;width:100%;">
              <tr style="background-color: #f42020;">
              <td style="width: 30% !important;">Action </td>
              <td>Issue</td>
              <td>Impact</td>
              <td>Due Date</td>
              <td>Remarks</td>
              <td>Assign To</td>
              <td>PIC</td>
            </tr>
              <?php foreach ($action_history as $key => $value) : ?>
              <tr>
                <td><?= $action_history[$key]['ACTION_NAME']; ?></td>
                <td><?= $action_history[$key]['ISSUE_NAME']; ?></td>
                <td><?= $action_history[$key]['RISK_IMPACT']; ?></td>
                <td><?= $action_history[$key]['DUE_DATE']; ?></td>
                <td><?= $action_history[$key]['ACTION_REMARKS']; ?></td>
                <td><?= $action_history[$key]['ASSIGN_TO']; ?> <?= !empty($action_history[$key]['ASSIGN_TO_DETAIL'])? $action_history[$key]['ASSIGN_TO_DETAIL']:''; ?></td>
                <td><?= $action_history[$key]['PIC']; ?></td>
              </tr>
              <?php endforeach; ?>       
          </table>
      </div>