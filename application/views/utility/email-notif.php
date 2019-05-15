<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notifikasi Prime</title>
<style type="text/css">
  *, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: arial, sans-serif;
  color: #384047;
  font-size: 12px !important;
  max-width: 100%;
  min-width: 100%;
  margin: auto;
}

table {
  max-width: 100%;
  min-width: 100%;
  margin: auto;
}

caption {
  /*font-size: 0.8em;*/
  /*font-weight: bold;*/
  padding: 10px 0;
  background-color: #00f;
}

.headcaption {
  /*font-size: 1em;*/
  font-weight: bold;
  padding: 10px 0;
  background-color: #00f;
}

thead th {
  /*font-weight: bold;*/
  background: #d32f2f;
  color: #FFF;
}

tr {
  background: #f4f7f8;
  border-bottom: 1px solid #FFF;
  margin-bottom: 5px;
}

tr:nth-child(even) {
  background: #e8eeef;
}

th, td {
  text-align: left;
  padding: 10px;
  /*font-size: 14px;*/
  font-weight: 300;
}

td {
  text-align: left;
  padding: 10px;
  font-size: 10px;
  font-weight: 1;
}


tfoot tr {
  background: none;
}

tfoot td {
  padding: 10px 2px;
  /*font-size: 1em;*/
  font-style: italic;
  color: #f00;
}

</style>
</head>
  <body style="background-color: #eee;max-width: 97%;min-width: 97%;">

      <header>
        <div style="max-width: 97%;min-width: 97%; padding: 20px;margin:10px auto;background-color: #fff;">
            <a href="telkom.co.id"><img height="47" src="https://beta.telkom.co.id/servlet/Telkom/img/logo.png" alt="BAST"></a>
         </div>     
      </header>
      <div class="headcaption" style="max-width: 97%;min-width: 97%; padding: 10px;margin:10px auto;background-color: #aaa; color:000;">
        Laporan Harian Dokumen BAST (Berita Acara Serah terima) <?= $nama_mitra ?>
      </div>
<?php if(count($bast)>0) : ?>      
    <table style="padding:5px;max-width: 97%;min-width: 97%;">
      <caption style="color:#fff">DALAM PROSES</caption>
      <thead>
        <tr>
          <th style="width:3%;" scope="col">NO.</th>
          <th style="width:33%;"scope="col">NAMA PEKERJAAN</th>
          <th style="width:15%;"scope="col">NAMA CC</th>
          <th style="width:15%;" scope="col">NO. SPK</th>
          <th style="width:15%;" text-align: center;' scope="col">STATUS</th>
          <th style="width:20%;" scope="col">NOTE</th>
        </tr> 
      </thead>
      <tbody>
        <?php foreach($bast as $key=>$value) : ?>
        <tr>
          <th scope="row"><?= $key+1; ?>.</th>
          <td><?= $bast[$key]['PROJECT_NAME']; ?></td>
          <td><?= $bast[$key]['NAMACC']; ?></td>
          <td><?= $bast[$key]['NO_SPK']; ?></td>
          <td style="color:#11f;text-align: center;"><?= $bast[$key]['STATUS']; ?><br><?= $bast[$key]['TIME']; ?></td>
          <td><?= $bast[$key]['NOTE']; ?></td>
        </tr>
        <?php endforeach; ?> 
      </tbody>
    </table>
<?php endif; ?>


<?php if(count($bast_done)>0) : ?>
    <table style="padding:5px;max-width: 97%;min-width: 97%;">
      <caption style="color:#fff">DONE / TAKE OUT HARI INI <?= date('d-m-Y') ?></caption>
      <thead>
        <tr>
          <th style="width:3%;" scope="col">NO.</th>
          <th style="width:33%;"scope="col">NAMA PEKERJAAN</th>
          <th style="width:15%;"scope="col">NAMA CC</th>
          <th style="width:15%;" scope="col">NO. SPK</th>
          <th style="width:15%;" text-align: center;' scope="col">STATUS</th>
          <th style="width:20%;" scope="col">NOTE</th>
      </thead>
      <tbody>
        <?php foreach($bast_done as $key=>$value) : ?>
        <tr>
          <th scope="row"><?= $key+1; ?>.</th>
          <td><?= $bast_done[$key]['PROJECT_NAME']; ?></td>
          <td><?= $bast_done[$key]['NAMACC']; ?></td>
          <td><?= $bast_done[$key]['NO_SPK']; ?></td>
          <td style="color:#11f;text-align: center;"><?= $bast_done[$key]['STATUS']; ?><br><?= $bast_done[$key]['TIME']; ?> </td>
          <td><?= $bast_done[$key]['NOTE']; ?></td>
        </tr>
        <?php endforeach; ?> 
      </tbody>
      <tfoot>
      </tfoot>
    </table>
<?php endif; ?>    

      <div class="" style="max-width: 97%;min-width: 97%; padding: 5px;margin:5px auto;background-color: #aaa; color:000;">
        Note : Jika ada pertanyaan lebih lanjut, silakan balas email ini atau hubungi Admin BAST SDV - DES.
      </div>
  </body>
</html>
