<table id="dataku7" class="table table-responsive-sm " style="width: 100% !important;">
    <?php if(!empty($ID_PROJECT)) : ?>
    <tr>
      <th style="width: 25% !important;">ID</th>
      <th style="width: 75% !important;">: LOP [<?= $ID_LOP; ?>] / PRIME [<?= $ID_PROJECT; ?>]</th>
    </tr>
    <?php endif; ?>

    <tr>
      <th style="width: 25% !important;">Name</th>
      <th style="width: 75% !important;">: <?= $NAME; ?></th>
    </tr>
    <tr>
      <th  style="width: 25% !important;">Value</th>
      <th class="rupiah" style="width: 75% !important;" class="rp">: <?= $VALUE; ?> </th>
    </tr>
    <tr>
      <th style="width: 25% !important;">Segmen</th>
      <th style="width: 75% !important;">: <?= $SEGMEN; ?></th>
    </tr>
    <tr>
      <th style="width: 25% !important;">Customer</th>
      <th style="width: 75% !important;">: [<?= $NAMACC; ?>] <?= $NAMACC; ?></th>
    </tr>
    <tr>
      <th style="width: 25% !important;">NAMA MITRA</th>
      <th style="width: 75% !important;">: <?= !empty($NAMA_MITRA) ? $NAMA_MITRA : ''; ?> </th>
    </tr> 
    <input type="hidden" id="no_spk" name="no_spk" value="<?= !empty($NO_SPK) ? $NO_SPK : '';?>">
    <input type="hidden" id="id_row" name="id_row" value="<?= !empty($ID_ROW) ? $ID_ROW : '';?>">
</table> 
