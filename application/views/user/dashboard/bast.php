<div class="col-md-12"> 
  <table class="table table-responsive-sm table-striped" style="width: 100% !important;">
            <thead>
              <tr>
                  <th style="width: 30% !important">PARTNERS</th>
                  <?php foreach ($segmen as $key => $value) : ?>
                    <th style="width: 5% !important"><?= $segmen[$key]['SEGMEN'] ?></th>
                  <?php endforeach; ?>                        
              </tr>
            </thead>
    </table> 
  </div>     
  <div class="col-md-12" style="max-height: 540px;overflow-y: scroll !important;overflow-x: hidden;"> 
        <table class="table table-responsive-sm table-striped" style="width: 100% !important;">
            <tbody>
                  <?php foreach ($partners as $key => $value) : ?>
                    <tr>
                    <td style="width: 30% !important"><?= $partners[$key]['NAMA_PARTNER']; ?></td>
                      <?php foreach ($segmen as $key2 => $value2) : ?>
                        
                        <?= !empty($segmen_partners[$partners[$key]['KODE_PARTNER']][$segmen[$key2]['SEGMEN']]) ? "<td class='bg-success text-center' style='width: 5% !important'>".$segmen_partners[$partners[$key]['KODE_PARTNER']][$segmen[$key2]['SEGMEN']] : "<td style='width: 5% !important' class='text-center'>0"; ?>
                          
                        </td>
                      <?php endforeach; ?> 
                    </tr>
                  <?php endforeach; ?> 
            </tbody>
        </table>                                                    
        
  </div> 