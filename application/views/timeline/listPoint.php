<div class="col-sm-12">
      <?php foreach ($data as $key => $value) : ?>
      <div class="card">
        <div class="card-header">
          <div class="row"> 
            <div class="col-md-2 countPoint">
              <span class="position-credit"><?= !empty($value['TPOINT']) ? $value['TPOINT'] : '0' ?></span>
              <span class="position-credit-sub">Points</span>
          </div>
          <div class="col-md-10 partisipan">
               
              <span class="list-group-item list-group-item-action flex-column align-items-start list_pm collapsed" data-nik_pm="780014" style="" data-toggle="collapse" data-target="#collapseExample<?=$key?>" aria-expanded="false">
                  
                  
                  <div class="row">
                    <div class="col-md-4">
                      <div class="d-flex justify-content-between" style="margin-bottom: 5px;">
                        <h5 class="mb-1">
                        <a class="text-name" href="<?= base_url()."/user/profile/".$value['NIK']?>" >
                        <span style="color: #000;" class="name-pm" >
                          <?= $value['NAMA'] ?>
                        </span>  
                        </a>
                          <br><span class="email-pm"><?= $value['EMAIL'] ?></span></h5>
                        <small> </small>
                      </div>
                      <img src="https://prime.telkom.co.id/sdv/<?= !empty($value['PHOTO_URL'])? $value['PHOTO_URL'] : '../user_picture/default-profile-picture.png' ; ?>" class="img-avatar" alt="AD STEFEN RATU EDA" style="max-height: 120px;">
                    </div>
                    <div class="col-md-8">
                      <table class="cursor-pointer table table-striped">
                        <tbody>
                          <?php foreach ($sum[$value['NIK']] as $key2 => $value2) : ?>
                            <tr>
                              <td>
                                <span class="text-content" style="min-width: 50px;"><?= $value2['CONTENT']  ?> </span>
                              </td>
                              <td class="cpoint">
                                &nbsp;&nbsp; <span><?= $value2['TOTAL']  ?></span>
                              </td>
                              <td style="width: 50% !important;">
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </span>          
          </div>          
          </div>
          
        </div>
      <div class="card-body collapse" id="collapseExample<?=$key?>">

                      <table class="table table-responsive-sm table-striped" style="width: 100%;">
                        <thead>
                          <th style="width: 10% !important;">DATE</th>
                          <th style="width: 15% !important;">OBJECT</th>
                          <th style="width: 15% !important;">OBJECT PROPERTY</th>
                          <th style="width: 15% !important;">ACTION</th>
                          <th style="width: 10% !important;">POINT</th>
                        </thead>
                        <tbody  style="width: 100%">
                          <?php foreach ($detail[$value['NIK']] as $key3 => $value3) : ?>
                            <tr>
                              <td><?= $value3['DATES'] ?></td>
                              <td><?= $value3['TITLE'] ?></td>
                              <td><?= $value3['CATEGORY'] ?></td>
                              <td><?= $value3['CONTENT'] ?></td>
                              <td><?= $value3['POINT'] ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
      </div>
      </div>
      <?php endforeach; ?>
    </div>