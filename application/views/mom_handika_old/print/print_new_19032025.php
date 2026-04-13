<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Minutes of Meeting</title>
  <!-- Favicons -->
  <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="180x180">
  <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="32x32" type="image/png">
  <link rel="icon" href="<?= base_url(); ?>assets/img/logo_trusmiverse.png" sizes="16x16" type="image/png">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Jquery Confirm -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.css" />
  <link href="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.min.css" />
  <style>
    <?= $this->load->view('mom_handika/print/styles.css', '', TRUE); ?>
    textarea.excel {
        display: block;
        word-wrap: break-word;
        text-wrap: unrestricted;
        font: 13px Tahoma, cursive;
        width: 100%;
        overflow: hidden;
        min-height: 40px;
        line-height: 20px;
    }

    .padding_0 {
        padding: 0px;
    }

    .kolom_modif {
        cursor: pointer;
        word-wrap: break-word
    }
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
          <span class="header-logo">Minutes of Meeting</span><br>       
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

            <?php 
            $issue_item = $this->model->print_issue_item($key->id_mom, $key->id_issue); 
            $issue_eskalasi_item = $this->model->print_issue_eskalasi_item($key->id_mom, $key->id_issue); 
            print_r($issue_eskalasi_item);
            ?>
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
              $rowspan_topik[$item->topik] += count($issue_eskalasi_item)+1;
              $rowspan_issue[$item->issue] += count($issue_eskalasi_item)+1;
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
                <td>
                  <span class="info-data">
                    <?= $item->action; ?><br>
                    <?php if (count($issue_eskalasi_item) < 1) : ?>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_mom" onclick="init_issue('<?=$item->deadline_e?>')">Eskalasi</button>
                    <?php endif; ?>
                  </span>
                </td>
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
                        <input type="hidden" name="tipe_mom" value="<?= $header['meeting'] ?>">
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
            <?php
            $current_issue_eskalasi = null; // To track the current issue
            ?>
            <tr>
              <th colspan="2">ISSUE</th>
              <th colspan="2">ACTION</th>
              <th>DEADLINE</th>
              <th>STATUS</th>
              <th>EVALUATION</th>
              <th>PIC</th>
            </tr>
            <?php $no_es = 1; ?>
            <?php foreach ($issue_eskalasi_item as $eskalasi) : ?>
              <tr>
                <?php if ($eskalasi->issue !== $current_issue_eskalasi) : ?>
                <td rowspan="<?=count($issue_eskalasi_item)?>">
                  <span class="info-data"><?= $no_es; ?></span>
                </td>    
                <td colspan="1" rowspan="<?=count($issue_eskalasi_item)?>">
                  <span class="info-data"><?= $eskalasi->issue; ?></span>
                </td>
                <?php $current_issue_eskalasi = $eskalasi->issue; ?>
                <?php endif; ?>    
                <td colspan="2"><?= $eskalasi->action; ?></td>
                <td><?= $eskalasi->deadline; ?></td>
                <td>
                    <?php if ($item->id_status == 1) : ?>
                      <a href="https://trusmiverse.com/apps/monday" target="_blank" class="label label-<?= $item->label; ?>" style="text-decoration:none;"><?= $item->status; ?></a>
                    <?php elseif ($item->id_status == 2) : ?>
                      <a href="https://trusmiverse.com/apps/ibr_update?id=<?= $item->id_sub_task; ?>&u=<?= $_SESSION['user_id']; ?>" target="_blank" class="label label-<?= $item->label; ?>" style="text-decoration:none;"><?= $item->status; ?></a>
                      <?php else : ?>
                      <span></span>
                    <?php endif; ?>
                </td>
                <td><?= $eskalasi->evaluasi; ?></td>
                <td><?= $eskalasi->pic; ?></td>
              </tr>
              <?php $no_es++; ?>
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


<!-- Modal Add -->
<div class="modal fade" id="modal_add_mom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" data-bs-focus="false" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Eskalasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="form_detail">
                <input type="hidden" id="id_mom_global" name="id_mom_global" value="<?= $header['id_mom'] ?>">
                <div class="row">
                    <div class="col-lg-12">
                    <input type="hidden" id="total_issue" name="total_issue" value="1">
                        <table id="dt_mom_result" class="table table-bordered" style="width:100%">
                          <thead>
                              <tr>
                                  <th width="15%">Issue</th>                                                            
                                  <th width="20%" colspan="2">Strategy</th>
                                  <th width="10%">Deadline</th>
                                  <th width="10%">PIC</th>
                              </tr>
                          </thead>
                          <tbody id="data_issue">
                              
                          </tbody>
                      </table>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-success" style="margin-right:10px;" id="btn_finish" onclick="finish()">Finish</button>
                <button type="button" class="btn btn-md btn-outline-danger" id="btn_cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->

  </main>
  <!-- Jquery Confirm -->
  <script src="<?= base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?= base_url(); ?>assets/vendor/bootstrap-5/dist/js/bootstrap.bundle.js"></script>
  <script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
  <script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
  <script type="text/javascript" src="<?= base_url(); ?>assets/vendor/datetimepicker/jquery.datetimepicker.full.min.js"></script>
  <script type="text/javascript">
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

    $('#dt_mom_result').on('click', '.kolom_modif', function() {
      id = $(this).data("id");
      input = id.split('_');
      $('#td_' + id).addClass('padding_0');
      $('#' + id).hide();
      $('#val_' + id).show().focus();
      $('#val_date_' + id).hide();
    });

    function expandTextarea(id) {
      document.getElementById(id).addEventListener('keyup', function() {
        this.style.overflow = 'hidden';
        this.style.height = 0;
        this.style.height = this.scrollHeight + 'px';
      }, false);
    }

    function init_issue(deadline) {
      $('#total_issue').val(1);
      html = `<tr id="div_issue_1">
                    <input type="hidden" id="val_deadline" name="deadline" value="${deadline}">
                    <input type="hidden" id="total_action_1" value="1">
                    <td class="kolom_modif" id="td_issue_1" data-id="issue_1_1" rowspan="2">
                        <span id="issue_1_1">&nbsp;</span>
                        <textarea id="val_issue_1_1" name="val_issue_1" class="excel" style="display:none;" rows="1" onfocusin="expandTextarea('val_issue_1_1')"></textarea>
                    </td>
                    <td width="1%" id="no_1_1">1.</td>
                    <td class="kolom_modif" id="td_action_1_1" data-id="action_1_1">
                        <span id="action_1_1">&nbsp;</span>
                        <textarea id="val_action_1_1" name="val_action_1_1" class="excel" style="display:none;" rows="1" onfocusin="expandTextarea('val_action_1_1')"></textarea>
                    </td>
                    <td class="kolom_modif" id="td_deadline_1_1" data-id="deadline_1_1">
                        <span id="deadline_1_1">&nbsp;</span>
                        ${deadline}
                    </td>
                    <td id="td_pic_1_1">
                        <select id="val_pic_1_1" name="val_pic_1_1[]" class="form-control pic" multiple>
                            <option data-placeholder="true">-- Choose Employee --</option>
                            <?php foreach ($pic as $row) : ?>
                                <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr id="div_issue_action_1">
                    <td style="cursor: pointer;" colspan="6">
                        <span class="btn btn-md btn-outline-success" onclick="add_action(1)"><i class="bi bi-plus-square"></i> Strategy</span>
                        <span class="btn btn-md btn-outline-danger" id="btn_remove_action_1" onclick="remove_action(1)" style="display: none;"><i class="bi bi-dash-square"></i> Strategy</span>
                    </td>
                </tr>
                <tr id="div_issue">
                    <td style="cursor: pointer;" colspan="7">
                        <span class="btn btn-md btn-outline-success" onclick="add_issue(1)"><i class="bi bi-plus-square"></i> </i> Add Issue</span>
                        <span class="btn btn-md btn-outline-danger btn_remove_issue" onclick="remove_issue(1)" style="display: none;"><i class="bi bi-dash-square"></i> Issue</span>
                    </td>
                </tr>
                <div id="div_custom"></div>`;

          $('#data_issue').html(html);
          new SlimSelect({
            select: "#val_pic_1_1"
          });
    }
    
    function add_action(issue_no) {
      no = $('#total_action_' + issue_no).val();
      next_no = parseInt(no) + 1;
      rowspan = next_no + 1;

      deadline = $('#val_deadline').val();
      data_action = `<tr>
      <td width="1%" id="no_${issue_no}_${next_no}">${next_no}.</td>
      <td class="kolom_modif" id="td_action_${issue_no}_${next_no}" data-id="action_${issue_no}_${next_no}">
        <span id="action_${issue_no}_${next_no}">&nbsp;</span>
        <textarea id="val_action_${issue_no}_${next_no}" name="val_action_${issue_no}_${next_no}" class="excel" style="display:none;" rows="1" onfocusin="expandTextarea('val_action_${issue_no}_${next_no}')"></textarea>
      </td>
      <td class="kolom_modif" id="td_deadline_${issue_no}_${next_no}" data-id="deadline_${issue_no}_${next_no}">
        <span id="deadline_${issue_no}_${next_no}">&nbsp;</span>
        ${deadline}
      </td>
      <td id="td_pic_${issue_no}_${next_no}">
        <select id="val_pic_${issue_no}_${next_no}" name="val_pic_${issue_no}_${next_no}[]" class="form-control pic" multiple>
        <option data-placeholder="true">-- Choose Employee --</option>
        <?php foreach ($pic as $row) : ?>
          <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
        <?php endforeach; ?>
        </select>
      </td>
    </tr>`;

      $('#td_topik_' + issue_no).attr('rowspan', rowspan);
      $('#td_issue_' + issue_no).attr('rowspan', rowspan);
      // console.log(rowspan);
      $('#div_issue_action_' + issue_no).before(data_action);
      $('#total_action_' + issue_no).val(next_no);

      $('.tanggal').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
        minDate: 0,
      });

      pic = new SlimSelect({
        select: "#val_pic_" + issue_no + "_" + next_no
      });

      $(`#btn_remove_action_${issue_no}`).show();

      total = $("#total_issue").val();
      console.log(issue_no, total);
      if (issue_no > 1 && issue_no == total) {
        $(".btn_remove_issue").hide();
      }
  }

  function remove_action(issue_no) {
    // console.log(no, issue_no);
    no = $('#total_action_' + issue_no).val();
    if (no > 1) {
      next_no = parseInt(no) - 1;
      rowspan = no;

      $('#td_topik_' + issue_no).attr('rowspan', rowspan);
      $('#td_issue_' + issue_no).attr('rowspan', rowspan);
      $('#div_issue_action_' + issue_no).prev().remove();
      $('#total_action_' + issue_no).val(next_no);

      if (no == 2) {
        $(`#btn_remove_action_${issue_no}`).hide();

        total = $("#total_issue").val();
        if (issue_no > 1 && issue_no == total) {
          $(".btn_remove_issue").show();
        }
      }

      id_mom = $("#id_mom_global").val();
      id_issue = issue_no;
      id_issue_item = no;
      console.log('-Remove Action-');
      console.log(id_mom, id_issue, id_issue_item);
    }
  }

  function add_issue() {
    no = $('#total_issue').val();
    let tipe_meeting = $('#meeting').val();
    // console.log('Jumlah Issue : ', no);
    next_no = parseInt(no) + 1;
    // let showEkspektasi = (tipe_meeting === 'Owner') ? '' : 'style="display: none;"';
    let showEkspektasi = '';

    deadline = $('#val_deadline').val();
    data_action = `
    <tr id="div_issue_${next_no}">
      <td class="kolom_modif" id="td_issue_${next_no}" data-id="issue_${next_no}_1" rowspan="2">
        <input type="hidden" id="total_action_${next_no}" value="1">
        <span id="issue_${next_no}_1">&nbsp;</span>
        <textarea id="val_issue_${next_no}_1" name="val_issue_${next_no}" class="excel" style="display:none;" rows="${next_no}_1" onfocusin="expandTextarea('val_issue_${next_no}_1')"></textarea>
      </td>
      <td width="${next_no}_1%" id="no_${next_no}_1">1.</td>
      <td class="kolom_modif" id="td_action_${next_no}_1" data-id="action_${next_no}_1">
        <span id="action_${next_no}_1">&nbsp;</span>
        <textarea id="val_action_${next_no}_1" name="val_action_${next_no}_1" class="excel" style="display:none;" rows="${next_no}_1" onfocusin="expandTextarea('val_action_${next_no}_1')"></textarea>
      </td>
      <td class="kolom_modif" id="td_deadline_${next_no}_1" data-id="deadline_${next_no}_1">
        <span id="deadline_${next_no}_1">&nbsp;</span>
        ${deadline}
      </td>
      <td id="td_pic_${next_no}_1">
        <select id="val_pic_${next_no}_1" name="val_pic_${next_no}_1[]" class="form-control pic" multiple>
        <option data-placeholder="true">-- Choose Employee --</option>
        <?php foreach ($pic as $row) : ?>
          <option value="<?= $row->user_id ?>"><?= $row->employee_name ?></option>
        <?php endforeach; ?>
        </select>
      </td>
    </tr>
    <tr id="div_issue_action_${next_no}">
      <td style="cursor: pointer;" colspan="8">
        <span class="btn btn-md btn-outline-success" onclick="add_action(${next_no})"><i class="bi bi-plus-square"></i> Strategy</span>
        <span class="btn btn-md btn-outline-danger" id="btn_remove_action_${next_no}" style="display:none;" onclick="remove_action(${next_no})"><i class="bi bi-dash-square"></i> Strategy</span>
      </td>
    </tr>`;

    $('#div_issue').before(data_action);
    $('#total_issue').val(next_no);

    $('.tanggal').datetimepicker({
      format: 'Y-m-d',
      timepicker: false,
      minDate: 0,
    });

    pic = new SlimSelect({
      select: "#val_pic_" + next_no + '_1'
    });

    $('.btn_remove_issue').show();
  }

  function remove_issue() {
    no = $('#total_issue').val();
    if (no > 1) {
      next_no = parseInt(no) - 1;

      tot_action_before = $(`#total_action_${next_no}`).val();

      $('#div_issue_' + no).remove();
      $('#div_issue_action_' + no).remove();
      $('#total_issue').val(next_no);
      if (no == 2 || tot_action_before > 1) {
        $('.btn_remove_issue').hide();
      }

      id_mom = $("#id_mom_global").val();
      id_issue = no;
      console.log('-Remove Issue-');
      console.log(id_mom, id_issue);
    }
  }

  function finish() {
    // Start
    $.confirm({
        icon: 'fa fa-spinner fa-spin',
        title: 'Please wait!',
        theme: 'material',
        type: 'blue',
        content: 'Processing...',
        buttons: {
          close: {
            isHidden: true,
            actions: function() {}
          },
        },
        onOpen: function() {
          // Start
          $.ajax({
            url: "<?= base_url('mom_handika/save_eskalasi'); ?>",
            type: "POST",
            data: $('#form_detail').serialize(),
            dataType: "JSON",
            beforeSend: function(res) {
              $('#btn_finish').attr("disabled", true);
            },
            success: function(res) {
              $('#btn_finish').removeAttr("disabled");
              $("#modal_add_mom").modal("hide");
              $.confirm({
                icon: 'fa fa-check',
                title: 'Success',
                theme: 'material',
                type: 'green',
                content: 'Data has been saved!',
                buttons: {
                  close: function() {
                    window.location.reload();
                  },
                },
              });
              jconfirm.instances[0].close();
              return true;
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
              jconfirm.instances[0].close();
            }
          });
          // End
        }
      });
      // End 
  }
  </script>

</body>

</html>