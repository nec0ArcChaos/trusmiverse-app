<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Minutes of Meeting</title>
</head>
<body>

  <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=export_detail_new.xls");
  ?>

  <header>
    <div style="width: 100%;">
      <center>
        <div style="margin-left: 26px; display: flex; justify-content: center;" align="center">
          <span class="header-logo">Minutes of Meeting</span>
        </div>
      </center>
    </div>
  </header>

  <main>
    <section class="content" style="padding-left: 0px; padding-right: 0px;">
      <div class="meeting-info">
        <?php foreach ($issue as $key) : ?>
          <table width="100%" class="table table-striped" style="margin-top: 8px;">
            <tr style="background-color: #337ab7; color: #fff;">
              <td width="15%"><span class="info-label">Id MoM</span></td>
              <td width="15%"><span class="info-label">Judul MoM</span></td>
              <td width="15%"><span class="info-label">HASIL / TOPIK / JUDUL</span></td>
              <td width="7%"><span class="info-label">ISSUE</span></td>
              <td width="3%" align="center"><span class="info-label"></span></td>
              <td width="15%"><span class="info-label">ACTION</span></td>
              <td width="12%" align="center"><span class="info-label">KATEGORISASI</span></td>
              <td width="10%" align="center"><span class="info-label">DEADLINE</span></td>
              <td width="7%" align="center"><span class="info-label">LEVEL</span></td>
              <td width="11%" align="center"><span class="info-label">PIC</span></td>
              <td width="8%" align="center"><span class="info-label">STATUS</span></td>
              <td width="12%" align="center"><span class="info-label">EVALUATION</span></td>
            </tr>
            <?php $issue_item = $this->model->print_issue_item($key->id_mom,$key->id_issue); ?>
            <?php $i = 1;?>
            <?php foreach ($issue_item as $item) : ?>
            <tr>
              <td><span class="info-data"><?= $key->id_mom; ?></span></td>
              <td><span class="info-data"><?= $key->judul; ?></span></td>
              <td><span class="info-data"><?= $item->topik; ?></span></td>
              <td><span class="info-data"><?= $item->issue; ?></span></td>
              <td align="center"><span class="info-data"><?= $i++; ?></span></td>
              <td><span class="info-data"><?= $item->action; ?></span></td>
              <?php if ($item->id_kategori == 1 || $item->id_kategori == 5 || $item->id_kategori == 6 || $item->id_kategori == 8 || $item->id_kategori == 9 || $item->id_kategori == 10) { ?>
                <td align="center"><span class="info-data"><span class="label label-warning"><?= $item->kategori; ?></span></span></td>
              <?php } else if ($item->id_kategori == 2) { ?>
                <td align="center"><span class="info-data"><span class="label label-danger"><?= $item->kategori; ?></span></span></td>
              <?php } else { ?>
                <td align="center"><span class="info-data"><span class="label label-primary"><?= $item->kategori; ?></span></span></td>
              <?php } ?>
              <td align="center"><span class="info-data"><span class="<?= $item->color; ?>"><?= $item->level; ?></span></span></td>
              <td align="center"><span class="info-data"><?= $item->deadline; ?></span></td>
              <td align="center"><span class="info-data"><?= $item->pic; ?></span></td>
              <td align="center">
                <span class="info-data">
                  <?php if ( $item->id_status == 1 && ($item->id_kategori == 1 || $item->id_kategori == 5 || $item->id_kategori == 6 || $item->id_kategori == 8 || $item->id_kategori == 9 || $item->id_kategori == 10) ) { ?>
                    <a href="https://trusmiverse.com/apps/monday" target="_blank" class="label label-<?= $item->label;?>" style="text-decoration:none;"><?= $item->status; ?></a>
                  <?php } else if ( $item->id_status == 2 && ($item->id_kategori == 1 || $item->id_kategori == 5 || $item->id_kategori == 6 || $item->id_kategori == 8 || $item->id_kategori == 9 || $item->id_kategori == 10) ) { ?>
                    <a href="https://trusmiverse.com/apps/ibr_update?id=<?= $item->id_sub_task; ?>&u=<?= $_SESSION['user_id']; ?>" target="_blank" class="label label-<?= $item->label;?>" style="text-decoration:none;"><?= $item->status; ?></a>
                  <?php } else if($item->id_kategori == 1 || $item->id_kategori == 5 || $item->id_kategori == 6 || $item->id_kategori == 8 || $item->id_kategori == 9 || $item->id_kategori == 10) { ?>
                    <span class="label label-<?= $item->label;?>" style="text-decoration:none;"><?= $item->status; ?></span>
                  <?php } else { ?>
                    <span></span>
                  <?php } ?>
                </span>
              </td>
              <td align="center"><span class="info-data"><?= $item->evaluasi; ?></span></td>
            </tr>
            <?php endforeach; ?>
          </table>
        <?php endforeach; ?>
      </div>
    </section>


    <!-- <span class="label label-primary">Primary</span>
    <span class="label label-success">Success</span>
    <span class="label label-danger">Danger</span>
    <span class="label label-warning">Warning</span>
    <span class="label label-info">Info</span>



    <span class="label label-outline-primary">Primary</span>
    <span class="label label-outline-secondary">Secondary</span>
    <span class="label label-outline-success">Success</span>
    <span class="label label-outline-danger">Danger</span>
    <span class="label label-outline-warning">Warning</span>
    <span class="label label-outline-info">Info</span>
    <span class="label label-outline-light">Light</span>
    <span class="label label-outline-dark">Dark</span> -->



  </main>
  <!-- Jquery Confirm -->
  <script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      console.log("Berhasil");
    });
  </script>

</body>
</html>