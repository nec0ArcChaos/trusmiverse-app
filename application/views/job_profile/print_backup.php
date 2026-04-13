<!DOCTYPE html>
<html>

<head>
  <title>Job Description</title>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>assets/images/favicon.png" />
  <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet">
  <style>
    @page {
      size: A4
    }

    @media print {
      .header_row {
        background-color: #000 !important;
        color: #f4f401;
        font-weight: 600;
        -webkit-print-color-adjust: exact;
      }
    }

    .header_row {
      background-color: #000;
      color: #f4f401;
      font-weight: 600;
    }

    li {
      list-style: inherit;
    }

    ul {
      padding: 0;
      margin: 1rem;
    }


    .table {
      border-color: #393939 !important;
    }

    .table tbody tr td {
      border-color: #393939 !important;
    }

    @media print {
      .pagebreak {
        page-break-before: always;
      }

      /* page-break-after works, as well */
    }
  </style>

</head>

<body class="A4" style="background-color: transparent;">
  <table class="table table-bordered">
    <tr>
      <td width=30%><img src="<?php echo base_url('assets/icons/logo_rsp.jpg') ?>" height="50" width="200"></td>
      <td class="text-center" style="font-size: 24px;"><strong>JOB PROFILE</strong></td>
      <td>
        <table class="table table-bordered">
          <tr>
            <td>No. Doc : <?= $jp['no_dok'] ?></td>
          </tr>
          <tr>
            <td>Tanggal Terbit : 09 Maret 2022</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr>
        <td width="35%"></td>
        <td width="5%"></td>
        <td width="60%"></td>
      </tr>
    </thead>
    <tbody>
      <tr class="header_row">
        <td colspan="3" style="font-size: 16px;">1. IDENTITAS JABATAN</td>
      </tr>
      <tr>
        <td>Nama Jabatan</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['jabatan'] ?></strong></td>
      </tr>
      <tr>
        <td>Divisi / Department</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['department_name'] ?></strong></td>
      </tr>
      <tr>
        <td>Golongan</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['level_romawi'] ?></strong></td>
      </tr>
      <tr>
        <td>Melapor Kepada</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['report_name'] ?></strong></td>
      </tr>
      <tr>
        <td>Lokasi kerja</td>
        <td class="text-center"></td>
        <td><strong>Cirebon</strong></td>
      </tr>

      <tr class="header_row">
        <td colspan="3" style="font-size: 16px;">2. TUJUAN JABATAN</td>
      </tr>
      <tr>
        <td colspan="3"><?= $jp['tujuan'] ?></td>
      </tr>

      <tr class="header_row">
        <td colspan="3" style="font-size: 16px;">3. DIMENSI JABATAN</td>
      </tr>
      <!-- <tr>
        <td>Pengeluaran Investasi (CAPEX)</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['capex'] ?></strong></td>
      </tr>
      <tr>
        <td>Pengeluaran Operasional (OPEX)</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['opex'] ?></strong></td>
      </tr> -->
      <tr>
        <td>Jumlah Bawahan</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['bawahan'] ?></strong></td>
      </tr>
      <tr>
        <td>Area Coverage</td>
        <td class="text-center"></td>
        <td><strong><?= $jp['area'] ?></strong></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered pagebreak">
    <thead>
      <tr class="header_row">
        <th colspan="3">4. TANGGUNG JAWAB UTAMA</th>
      </tr>
      <tr style="background: #d9d6d6a3;">
        <td class="text-center"><strong>Tugas Pokok</strong></td>
        <td class="text-center" colspan=2 width="60%"><strong>Aktifitas</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($jt as $row) { ?>
        <tr>
          <td><strong><?= $row->tugas ?></strong></td>
          <td colspan=2><?= $row->aktifitas ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">5. KEY PERFORMANCE INDICATOR</th>
      </tr>
      <tr style="background: #d9d6d6a3;">
        <td class="text-center"><strong>Nama KPI</strong></td>
        <td class="text-center" colspan=2 width="10%"><strong>Bobot</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($jt as $row) { ?>
        <tr>
          <td><strong><?= $row->tugas ?></strong></td>
          <td colspan=2><?= $row->aktifitas ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">6. HUBUNGAN KERJA</th>
      </tr>
      <tr style="background: #d9d6d6a3;">
        <td class="text-center" width="5%"><strong>NO</strong></td>
        <td class="text-center" width="30%"><strong>HUBUNGAN INTERNAL</strong></td>
        <td class="text-center"><strong>TUJUAN</strong></td>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td><strong>1</strong></td>
          <td>All department</td>
          <td>Testing</td>
        </tr>
    </tbody>
    <thead>
      <tr style="background: #d9d6d6a3;">
        <td class="text-center" width="5%"><strong>NO</strong></td>
        <td class="text-center" width="30%"><strong>HUBUNGAN EKSTERNAL</strong></td>
        <td class="text-center"><strong>TUJUAN</strong></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($jt as $row) { ?>
        <tr>
          <td><strong><?= $row->tugas ?></strong></td>
          <td><?= $row->aktifitas ?></td>
          <td><?= $row->aktifitas ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">7. KUALIFIKASI</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="3"><strong>1. <u>Pendidikan Formal Minimal: </u></strong></td>
      </tr>
      <tr>
        <td colspan="3">- <?= $jp['pendidikan'] ?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>2. <u>Pengalaman Bekerja:</u></strong></td>
      </tr>
      <tr>
        <td colspan="3"><?= html_entity_decode($jp['pengalaman']) ?></td>
      </tr>
      <tr>
        <td colspan="3"><strong>3. <u>Kompetensi:</u></strong></td>
      </tr>
      <tr>
        <td colspan="3"><?= html_entity_decode($jp['kompetensi']) ?></td>
      </tr>
      <!-- <tr class="pagebreak">
        <td colspan="3"><strong>4. <u>Soft Competency:</u></strong></td>
      </tr>
      <tr>
        <td colspan="3" style="padding: 0;">
          <table class="table table-bordered pagebreak">
            <thead>
              <tr style="background: #d9d6d6a3;">
                <td class="text-center"><strong>Core Competency</strong></td>
                <td class="text-center"><strong>Std</strong></td>
                <td class="text-center"><strong>Managerial Competency</strong></td>
                <td class="text-center"><strong>Std</strong></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($softcomp as $row) { ?>
                <tr>
                  <td><strong><?= $row->core_comp ?></strong>
                    <p><?= $row->core_desc ?></p>
                  </td>
                  <td class="text-center"><strong><?= $row->core_std ?></strong></td>
                  <td><strong><?= $row->mng_comp ?></strong>
                    <p><?= $row->mng_desc ?></p>
                  </td>
                  <td class="text-center"><strong><?= $row->mng_std ?></strong></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </td> -->
      </tr>
    </tbody>
  </table>

  <!-- <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">TANTANGAN</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="3"><?= html_entity_decode($jp['challenge']) ?></td>
      </tr>
    </tbody>
  </table> -->

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">8. KEWENANGAN</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="3"><?= html_entity_decode($jp['authority']) ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">9. STRUKTUR ORGANISASI</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="3"><?= html_entity_decode($jp['authority']) ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table table-bordered">
    <thead>
      <tr class="header_row">
        <th colspan="3">10. PERSETUJUAN</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="text-center"> Disiapkan Oleh :</td>
        <td colspan="2" class="text-center"> Disetujui Oleh :</td>
      </tr>
      <tr>
        <td class="text-center" style="padding-bottom: 100px;">&nbsp;</td>
        <td class="text-center">&nbsp;</td>
        <td class="text-center">&nbsp;</td>
      </tr>
      <tr>
        <td class="text-center"><strong>Nurjaen</strong></td>
        <td class="text-center"><strong>Ali Yasin</strong></td>
        <td class="text-center"><strong>Abdul Gofur</strong></td>
      </tr>
      <tr>
        <td class="text-center">Organization Development </td>
        <td class="text-center" width="30%">HR Div.Head </td>
        <td class="text-center" width="30%">GM Marketing and Analyst</td>
      </tr>
    </tbody>
  </table>



</body>

</html>
<script>
  window.print();
  // window.close();
</script>