<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Minutes of Meeting | DEV</title>
  <!-- Favicons -->
  <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
  <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
  <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
  <!-- Jquery Confirm -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
  <style>
    <?= $this->load->view('mom/print/styles.css'); ?>
  </style>
</head>

<body>

  <header>
    <div style="width: 100%;">
      <center>
        <div style="margin-left: 26px; display: flex; justify-content: center;" align="center">
          <img src="<?= base_url('assets/img/icon_trusmi_group.png'); ?>" alt="Gambar" width="50">
          &nbsp;
          &nbsp;
          <span class="header-logo">Minutes of Meeting DEV</span><br>
        </div>
      </center>
    </div>
  </header>

  <main>
    <section class="content">
      <div class="meeting-info">
        <table width="100%" border="0" cellpadding="4px">
          <?php if ($header['meeting'] != "") { ?>
            <tr align="center">
              <td colspan="7">
                <span class="info-label"><u><?= $header['meeting'] ?></u></span><br>
                <span class="info-data"><?= $header['department'] ?></span>
              </td>
            </tr>
            <tr align="center">
              <td colspan="5">
                <div style="background-color: #fff; height: 2px; width: 90%; border-radius: 7px;">&nbsp;</div>
                <br>
              </td>
            </tr>
          <?php } ?>
          <tr align="center">
            <td width="25%">
              <div class="info-label">Nomor MOM</div>
            </td>
            <td width="1%" rowspan="2">
              <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="25%">
              <div class="info-label">TANGGAL</div>
            </td>
            <td width="1%" rowspan="2">
              <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="25%">
              <div class="info-label">TEMPAT</div>
            </td>
            <td width="1%" rowspan="2">
              <div style="background-color: #9E9E9E; height: 50px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="25%">
              <div class="info-label">WAKTU</div>
            </td>
          </tr>
          <tr align="center">
            <td class="info-data">
              <?= $header['id_mom'] ?>
            </td>
            <td class="info-data">
              <?= $header['hari'] . ', ' . $header['tgl'] ?>
            </td>
            <td class="info-data">
              <?= $header['tempat'] ?>
            </td>
            <td class="info-data">
              <span class="label label-outline-primary"><?= $header['waktu'] ?></span>
            </td>
          </tr>
        </table>
      </div>
    </section>

    <section class="content">
      <div class="meeting-info">
        <table width="100%" border="0" cellpadding="4px">
          <tr align="center">
            <td colspan="5">
              <span class="info-label">AGENDA RAPAT</span><br>
              <span class="info-data"><?= $header['agenda'] ?></span>
            </td>
          </tr>
          <tr align="center">
            <td colspan="5">
              <div style="background-color: #9E9E9E; height: 2px; width: 90%; border-radius: 7px;">&nbsp;</div>
              <br>
            </td>
          </tr>
          <tr align="left">
            <td width="6%"></td>
            <td width="44%">
              <span class="info-label">PEMBAHASAN</span><br>
              <span class="info-data">
                <?= $header['pembahasan'] ?>
              </span>
            </td>
            <td width="4%">
              <div style="background-color: #9E9E9E; height: 90px; border-radius: 7px; width: 2px;">&nbsp;</div>
            </td>
            <td width="46%">
              <span class="info-label">PESERTA</span><br>

              <ul class="list-group">
                <?php foreach ($peserta as $key) : ?>
                  <li class="list-group-item">
                    <div class="media">
                      <?php if ($key->profile_picture == "" && $key->gender == "Male") { ?>
                        <img src="https://trusmiverse.com/hr/uploads/profile/default_male.jpg" style="margin-right:5px !important;" class="rounded-circle" alt="Gambar 1" width="50">
                      <?php } else if ($key->profile_picture == "" && $key->gender == "Female") { ?>
                        <img src="https://trusmiverse.com/hr/uploads/profile/default_female.jpg" style="margin-right:5px !important;" class="rounded-circle" alt="Gambar 1" width="50">
                      <?php } else { ?>
                        <img src="https://trusmiverse.com/hr/uploads/profile/<?= $key->profile_picture; ?>" style="margin-right:5px !important;" class="rounded-circle" alt="Gambar 1" width="50">
                      <?php } ?>
                      <span class="info-data" style="padding-top: 5px"><?= $key->employee_name; ?></span>
                    </div>
                  </li>
                <?php endforeach; ?>
              </ul>

            </td>
          </tr>
        </table>
      </div>
    </section>

    <section class="content" style="padding-left: 0px; padding-right: 0px;">
      <div class="meeting-info">
        <?php $no = 1; ?>
        <?php foreach ($issue as $key) : ?>
          <table width="100%" class="table table-striped" style="margin-top: 8px;">
            <!-- <tr align="center">
              <th colspan="5" style="background-color: #337ab7; color: #fff;"><span class="info-label"><?= $key->issue; ?></span></th>
            </tr> -->
            <?php
            // Tentukan lebar untuk kolom 'EKSPEKTASI' berdasarkan kondisi meeting owner
            $ekspektasiWidth = ($header['meeting'] == 'MEETING OWNER') ? '12%' : '24%';
            ?>
            <tr style="background-color: #337ab7; color: #fff;">
              <td width="2%" align="center"><span class="info-label"></span></td>
              <td width="13%"><span class="info-label">HASIL / TOPIK / JUDUL</span></td>
              <td width="10%"><span class="info-label">ISSUE</span></td>
              <td width="1%" align="center"><span class="info-label"></span></td>
              <td width="15%"><span class="info-label">ACTION</span></td>
              <td width="8%" align="center"><span class="info-label">KATEGORISASI</span></td>
              <td width="7%" align="center"><span class="info-label">DEADLINE</span></td>
              <td width="11%" align="center"><span class="info-label">PIC</span></td>
              <td width="8%" align="center"><span class="info-label">STATUS</span></td>
              <td width="12%" align="center"><span class="info-label">EVALUATION</span></td>
              <td width="<?php echo $ekspektasiWidth; ?>" align="center"><span class="info-label">EKSPEKTASI</span></td>
              <?php if ($header['meeting'] == 'MEETING OWNER') : ?>
                <td width="12%" align="center" nowrap><span class="info-label">VERIFY OWNER</span></td>
              <?php endif; ?>
            </tr>

            <?php $issue_item = $this->model->print_issue_item($key->id_mom, $key->id_issue); ?>
            <?php $i = 1; ?>
            <?php
            $current_topik = null; // To track the current topik
            $current_issue = null; // To track the current issue
            $rowspan_topik = []; // Store rowspan count for topik
            $rowspan_issue = []; // Store rowspan count for issue

            // Calculate rowspan for topik and issue
            foreach ($issue_item as $item) {
              $rowspan_topik[$item->topik] = isset($rowspan_topik[$item->topik]) ? $rowspan_topik[$item->topik] + 1 : 1;
              $rowspan_issue[$item->issue] = isset($rowspan_issue[$item->issue]) ? $rowspan_issue[$item->issue] + 1 : 1;
            }

            ?>

            <?php foreach ($issue_item as $item) : ?>
              <tr>
                <!-- Topik Column with Rowspan -->
                <?php if ($item->topik !== $current_topik) : ?>
                  <td rowspan="<?= $rowspan_topik[$item->topik]; ?>">
                    <span class="info-data"><?= $no; ?></span>
                  </td>
                  <td rowspan="<?= $rowspan_topik[$item->topik]; ?>">
                    <span class="info-data"><?= $item->topik; ?></span>
                  </td>
                  <?php $current_topik = $item->topik; ?>
                <?php endif; ?>

                <!-- Issue Column with Rowspan -->
                <?php if ($item->issue !== $current_issue) : ?>
                  <td rowspan="<?= $rowspan_issue[$item->issue]; ?>">
                    <span class="info-data"><?= $item->issue; ?></span>
                  </td>
                  <?php $current_issue = $item->issue; ?>
                <?php endif; ?>

                <td align="center"><span class="info-data"><?= chr(64 + $i++); ?></span></td>
                <td><span class="info-data"><?= $item->action; ?></span></td>
                <td align="center">
                  <?php if (in_array($item->id_kategori, [1, 5, 6, 8, 9, 10, 11])) : ?>
                    <span class="info-data"><span class="label label-warning"><?= $item->kategori; ?></span></span>
                  <?php elseif ($item->id_kategori == 2) : ?>
                    <span class="info-data"><span class="label label-danger"><?= $item->kategori; ?></span></span>
                  <?php else : ?>
                    <span class="info-data"><span class="label label-primary"><?= $item->kategori; ?></span></span>
                  <?php endif; ?><br>
                  <span class="info-data"><span class="<?= $item->color; ?>"><?= $item->level; ?></span>
                </td>
                <td align="center"><span class="info-data"><?= $item->deadline; ?></span></td>
                <td align="center"><span class="info-data"><?= $item->pic; ?></span></td>
                <td align="center">
                  <!-- Status and Actions -->
                  <span class="info-data">
                    <?php if ($item->id_status == 1 && in_array($item->id_kategori, [1, 5, 6, 8, 9, 10, 11])) : ?>
                      <a href="https://trusmiverse.com/apps/monday" target="_blank" class="label label-<?= $item->label; ?>" style="text-decoration:none;"><?= $item->status; ?></a>
                    <?php elseif ($item->id_status == 2 && in_array($item->id_kategori, [1, 5, 6, 8, 9, 10, 11])) : ?>
                      <a href="https://trusmiverse.com/apps/ibr_update?id=<?= $item->id_sub_task; ?>&u=<?= $_SESSION['user_id']; ?>" target="_blank" class="label label-<?= $item->label; ?>" style="text-decoration:none;"><?= $item->status; ?></a>
                    <?php elseif (in_array($item->id_kategori, [1, 5, 6, 8, 9, 10, 11])) : ?>
                      <span class="label label-<?= $item->label; ?>" style="text-decoration:none;"><?= $item->status; ?></span>
                      <?php if ($item->id_status_verified == 2 || $item->id_owner_verified_status == 2) : ?>
                        <a href="https://trusmiverse.com/apps/ibr_update?id=<?= $item->id_sub_task; ?>&u=<?= $_SESSION['user_id']; ?>" target="_blank" class="label label-danger" style="text-decoration:none;">🔁 Revisi</a>
                        <?php elseif ($item->id_status_verified == 1 && $item->id_owner_verified_status == 1) : ?>
                            <span class="label label-outline-success">✔ Verified by : <?= $item->verified_by ?></span>
                            <span class="label label-outline-primary">✔✔ Verified Owner</span>
                        <?php elseif ($item->id_status_verified == 1) : ?>
                          <span class="label label-outline-success">✔ Verified by : <?= $item->verified_by ?></span>
                        
                        
                      <?php else : ?>
                      <?php endif; ?>

                    <?php else : ?>
                      <span></span>
                    <?php endif; ?>
                    <br>
                    <?php if ($item->id_status_strategy == '1') {
                      $strategy_color = "label label-success";
                    } else if ($item->id_status_strategy == '2') {
                      $strategy_color = "label label-warning";
                    } else if ($item->id_status_strategy == '3') {
                      $strategy_color = "label label-danger";
                    } else {
                      $strategy_color = "label label-primary";
                    }
                    ?>
                    <?php if ($item->id_status_strategy) : ?>
                      <span class="<?= $strategy_color ?>"><?= $item->status_strategy ?></span>
                    <?php endif; ?>
                    <br>
                    <?php if ($item->freq_revisi > 0) : ?>
                      <span class="info-data" style="color:brown">Revisi : <?= $item->freq_revisi ?>x</span>
                    <?php else : ?>
                    <?php endif; ?>
                    <?php if ($item->status_approval) : ?>
                      <a href="https://trusmiverse.com/apps/trusmi_approval" target="_blank" class="<?= $item->color_status_approval; ?>" style="text-decoration:none;"><?= $item->status_approval; ?></a>
                    <?php endif; ?>
                    <br>

                  </span>

                </td>
                <td align="center">
                  <span class="info-data"><?= $item->evaluasi; ?></span>
                  <br>
                  <?php if ($item->file) : ?>
                    <a href="https://trusmiverse.com/apps/uploads/monday/history_sub_task/<?= $item->file; ?>" target="_blank" class="text-success label label-success" style="text-decoration:none;">File </a>
                  <?php endif; ?>
                  <?php if ($item->link) : ?>
                    <a href="<?= $item->link; ?>" target="_blank" class="text-success label label-primary" style="text-decoration:none;">Link</a>
                  <?php endif; ?>
                </td>

                <td align="center">
                  <span class="info-data"><?= $item->ekspektasi ?></span><br>
                  <div id="form_verif_<?= $item->id ?>" style="display: none;">
                    <form class="verif-form" data-id="<?= $item->id ?>">
                      <input type="hidden" name="id_item_issue" value="<?= $item->id ?>">
                      <input type="hidden" name="id_task" value="<?= $item->id_task ?>">
                      <input type="hidden" name="id_sub_task" value="<?= $item->id_sub_task ?>">
                      <select class="custom-input" name="verified_status" style="margin-bottom: 3px;" required>
                        <option value="" selected disabled>- Pilih Status -</option>
                        <option value="1">Oke</option>
                        <option value="2">Not Oke</option>
                      </select>
                      <textarea class="custom-input" name="verified_note" id="" rows="3" placeholder="Note Here.." required></textarea>
                      <button class="text-success label label-primary" id="save_<?= $item->id ?>" onclick="save('<?= $item->id ?>')">Save</button>
                    </form>
                  </div>
                  <?php if (!in_array($item->id_kategori, [1, 5, 6, 8, 9, 10, 11])) : ?>
                  <?php elseif ($item->verified_status == null) : ?>
                    <button class="text-success label label-primary" id="verify_<?= $item->id ?>" onclick="verif('<?= $item->id ?>')">📌Verify</button>
                  <?php else : ?>
                    <small>Status : <?= $item->verified_status ?></small><br>
                    <small>Note : <?= $item->verified_note ?></small>
                  <?php endif; ?>
                </td>
                <?php if ($header['meeting'] == 'MEETING OWNER' ) : ?>
                  <td>
                    <?php if($item->id_owner_verified_status == null) :?>
                      <small>Waiting Verify</small>
                    <?php endif; ?>
                  <span class="info-data"><?= $item->owner_verified_status; ?></span><br>
                  <span class="info-data"><?= $item->owner_verified_note; ?></span>
                    <!-- <div id="form_verif_owner_<?= $item->id ?>">
                      <form class="verif-form-owner" data-id="<?= $item->id ?>">
                        <input type="hidden" name="id_item_issue" value="<?= $item->id ?>">
                        <input type="hidden" name="id_task" value="<?= $item->id_task ?>">
                        <input type="hidden" name="id_sub_task" value="<?= $item->id_sub_task ?>">
                        <select class="custom-input" name="verified_status" style="margin-bottom: 3px;" required>
                          <option value="" selected disabled>- Status -</option>
                          <option value="1">Oke</option>
                          <option value="2">Not Oke</option>
                        </select>
                        <textarea class="custom-input" name="verified_note" id="" rows="3" placeholder="Note Here.." required></textarea>
                        <button class="text-success label label-primary" id="save_<?= $item->id ?>" onclick="save('<?= $item->id ?>')">Save</button>
                      </form>
                    </div> -->
                  </td>
                <?php endif; ?>

              </tr>
            <?php endforeach; ?>
            <?php $no++; ?>
          </table>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="content">
      <div class="meeting-info">
        <table width="100%" border="0" cellpadding="4px">
          <tr align="left">
            <td width="1%"></td>
            <td width="33%">
              <div class="info-label">CLOSING STATEMENT</div>
            </td>
          </tr>
          <tr align="left">
            <td width="1%"></td>
            <td class="info-data">
              <?= $header['closing_statement']; ?>
            </td>
          </tr>
        </table>
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
  <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      console.log("Berhasil");
    });

    function verif(id) {
      $('#verify_' + id).hide();
      $('#form_verif_' + id).show();
    }
    $(".verif-form").submit(function(event) {
      event.preventDefault(); // Mencegah reload halaman

      let form = $(this);
      let itemId = form.data("id"); // Ambil item ID dari data-id
      let formData = form.serialize(); // Ambil data form

      $.ajax({
        url: "<?= base_url('mom/save_verified'); ?>", // Ganti dengan URL untuk proses backend
        type: "POST",
        data: formData,
        success: function(response) {
          // alert("Data berhasil disimpan!"); // Ganti dengan notifikasi lain jika perlu
          location.reload();
          // $("#form_verif_" + itemId).hide(); // Sembunyikan form setelah submit
        },
        error: function() {
          alert("Terjadi kesalahan, coba lagi.");
        }
      });
    });
    
  </script>

</body>

</html>