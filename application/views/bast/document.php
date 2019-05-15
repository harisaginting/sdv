      <!-- <img src="<?= base_url(); ?>assets/img/1200px-Telkom_Indonesia_2013.svg.png" 
        style="position: absolute;z-index: 1000 !important;width: 2cm;"> -->

      <p>
        <h3 style="text-align: center;font-size:14px;">BERITA ACARA SERAH TERIMA</h3>
      </p>
      <table style="border-bottom: 5px solid #555;width:100%;padding-bottom: 10px;font-size:12px;">
        <tr>
          <td style="width: 25%;"></td>
          <td style="width: 5%;">Nomor</td>
          <td style="width: 70%;">:</td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td>Nomor</td>
          <td>:</td>
          <td></td>
        </tr>
      </table>


      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:0.5cm;">
        <tr>
          <td style="width: 30%;vertical-align: top;">Pekerjaan</td>
          <td style="width: 1%;vertical-align: top;">:</td>>
          <td style="width: 40%;" colspan="3"><?= !empty($PROJECT_NAME) ? $PROJECT_NAME : 'Nama Pekerjaan' ?></td>
        </tr>
        <tr>
          <td style="width: 30%;">No. Kontrak/SPK/</td>
          <td style="width: 1%;vertical-align: top;">:</td>>
          <td style="width: 40%;"><?= !empty($NO_SPK) ? $NO_SPK : 'TEL.0000-0000/P8/LG.000/DES-A0000000/0000 ' ?></td>
          <td style="width: 5%;">Tanggal</td>
          <td style="width: 20%;">: <?= !empty($TGL_SPK) ? $TGL_SPK : date('d/m/Y'); ?></td>
        </tr>
        <tr>
          <td style="width: 30%;">No. Amandemen (Bila ada)</td>
          <td style="width: 1%;vertical-align: top;">:</td>>
          <td style="width: 40%;"></td>
          <td style="width: 5%;">Tanggal</td>
          <td style="width: 20%;">:</td>
        </tr>
        <tr>
          <td style="width: 30%;">Merujuk pada Dokumen (bila ada)</td>
          <td style="width: 1%;vertical-align: top;">:</td>>
          <td style="width: 40%;"></td>
          <td style="width: 5%;">Tanggal</td>
          <td style="width: 20%;">: </td>
        </tr>
        <tr style="margin bottom: 10px;"></tr>
      </table>

      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:0.5cm;">
        <tr>
          <td>
            <p>Pada Hari ini <?= $HARI; ?>, Tanggal <b><?= $EJA_HARI; ?></b>, Bulan <b><?= $BULAN; ?></b>, Tahun <b><?= $TAHUN." (".$BAST_DATE2.")"; ?></b> 
            kami yang bertanda tangan di bawah ini:</p>
          </td>
        </tr>
      </table>

      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:0.5cm;">
        <tr>
          <td style="width: 2%;"  >1.</td>
          <td colspan="2"><?= $NAMA_MITRA ?>, dalam hal ini diwakili secara sah oleh: </td>
        </tr>
        <tr>
          <td></td>
          <td style="width: 20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
          <td>:</td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
          <td>:</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">Selanjutnya disebut sebagai <b>MITRA</b>, dan</td>
        </tr>
      </table>
      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;"> 
        <tr>
          <td style="width: 2%;">2.</td>
          <td colspan="2">Perusahaan Perseroan (Persero)  PT. Telekomunikasi Indonesia, Tbk</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">dalam hal ini diwakili secara sah oleh: </td>
        </tr>
        <tr>
          <td></td>
          <td style="width: 20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama</td>
          <td>:</td>
        </tr>
        <tr>
          <td></td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan</td>
          <td>:</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="2">Selanjutnya disebut sebagai <b>TELKOM</b>.</td>
        </tr>
      </table>

      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:0.5cm;">
        <tr>
          <td colspan="3">
            <p>Para pihak menyepakati hal-hal sebagai berikut *) :</p>
          </td>
        </tr>
        <tr >
          <td style="width: 2%";>
            <span style="padding-top: 10px;">&nbsp;&bull; &nbsp;&nbsp;</span>
          </td>
          <td>
            Barang dan/atau jasa telah diperiksa dan diterima dalam kondisi baik sesuai spesifikasi
          </td>
        </tr>
        <tr>
          <td>
             <input type="checkbox" class="checkbox-button__input" id="choice1-1" name="choice1">
    <span class="checkbox-button__control"></span>
          </td>
          <td>
            Progress pekerjaan pada Periode/Termin _______ telah mencapai ___% dan secara kumulatif
progress project telah mencapai  _____%.
          </td>
        </tr>

        <tr>
          <td>
            &nbsp;&bull; &nbsp;&nbsp;
          </td>
          <td>
            Lainnya: __________________ (mis: Kesepakatan tentang garansi pemeliharaan, masa retensi, dll)
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <p>Dengan demikian, Berita Acara ini dibuat rangkap 3 (tiga) asli, masing-masing sama bunyinya dan ditandatangani oleh para pihak.</p>
          </td>
        </tr>
      </table>

      <table style="width: 100%;font-size: 10px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:1cm;">
        <tr>
          <td style="width: 42%;text-align: center;"><?= $NAMA_MITRA ?></td>
          <td style="width: 11%;"></td>
          <td style="width: 47%;text-align: center;">PT. Telekomunikasi Indonesia. Tbk</td>
        </tr>
      </table>

      <table style="width: 100%;font-size: 20px;line-height: 15px;padding-left: 0.5cm;padding-right: 0.5cm;margin-top:2cm;">
        <tr>
          <td style="width: 0% !important; "></td>
          <td style="width: 25%;min-height: 100% !important;border-bottom: 1px solid #000;"></td>
          <td style="width: 20%"></td>
          <td style="width: 25%;min-height: 100% !important;border-bottom: 1px solid #000;"></td>
          <td style="width: 0%"></td>
        </tr>
      </table>