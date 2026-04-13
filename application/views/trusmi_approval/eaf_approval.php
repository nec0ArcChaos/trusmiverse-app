<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
                <p class="text-secondary">Deskripsi Page</p>
            </div>
            <div class="col col-sm-auto">
            </div>
            <div class="col-auto ps-0">

            </div>
        </div>
        <div class="row">
            <nav aria-label="breadcrumb" class="breadcrumb-theme">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Trusmiverse</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <?php if (isset($_GET['id'])) { ?>
        <?php if ($data->id_status == 2 && $data->kategori == 'Eaf') { ?>
            <div class="m-3">
                <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
                    <div class="card border-0">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-auto">
                                    <i class="bi bi-clock-history h5 avatar avatar-40 bg-light-theme rounded"></i>
                                </div>
                                <div class="col-auto align-self-center">
                                    <h6 class="fw-medium mb-0">Detail Request EAF</h6>
                                </div>
                                <div class="col-auto ms-auto ps-0">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 col-lg-12 col-xl-12 mb-4">
                            <form id="form_keperluan" autocomplete="off">
                                <input type="hidden" name="no_app" value="<?= $_GET['id']; ?>" readonly>
                                <input type="hidden" name="id_hr" value="<?= $id_hr; ?>">
                                <input type="hidden" name="id_approve_by" value="<?= $data->id_approve_by; ?>">
                                <input type="hidden" name="file_1" value="https://trusmiverse.com/apps/uploads/trusmi_approval/<?= $data->file_1; ?>">
                                <input type="hidden" name="file_1_name" value="<?= $data->file_1; ?>">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-2">
                                        <label>Nama Penerima</label>
                                        <input type="text" id="nama_penerima" name="nama_penerima" class="form-control border" placeholder="Nama Penerima"><br>
                                    </div>
                                    <div class="col-lg-4 col-sm-2">
                                        <label>Yang Mengajukan</label>
                                        <select name="pengaju" id="pengaju">
                                            <option data-placeholder="true">-- Pilih Yang Mengajukan --</option>
                                            <?php foreach($pengaju as $row):?>
                                                <option value="<?php echo $row->id_user; ?>" <?php echo ($row->id_user == $this->session->userdata('id_user')) ? "selected" : "" ; ?>><?php echo $row->employee_name;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-2">
                                        <label>Nama Kategori</label>
                                        <select class="form-control border" name="kategori" id="kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach($kategori as $row):?>
                                                <?php if (in_array($this->session->userdata('id_user'), [1,61,495,747]) && $row->id_kategori == 20): ?>
                                                    <option value="<?php echo $row->id_kategori;?>"><?php echo $row->nama_kategori;?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $row->id_kategori;?>"><?php echo $row->nama_kategori;?></option>
                                                <?php endif ?>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-2">
                                        <label>Tipe Pembayaran</label>
                                        <select class="form-control border" id="dd_tipe" name="tipe" required>
                                            <option value="">-- Tipe Pembayaran --</option>									
                                            <option value="Tunai">Tunai</option>
                                            <option value="Transfer Bank">Transfer Bank</option>
                                            <option value="Giro">Giro</option>
                                        </select><br>
                                    </div>
                                    <div class="col-lg-4 col-sm-2">
                                        <label>Nama Bank:</label>
                                        <input class="form-control border" id="txtbank" type="text" name="nama_bank" placeholder="Nama Bank" disabled>
                                    </div>
                                    <div class="col-lg-4 col-sm-2">
                                        <label >Rekening:</label>
                                        <input class="form-control nomer border" id="txtrek" type="number" placeholder="Nomor Rekening"name="rekening" disabled >
                                    </div>			
                                </div>


                                <label><strong>Detail Keperluan</strong></label>
                                <hr>

                                <div class="row">
                                    <div class="col-lg-6 col-sm-2 col-xs-2">
                                        <label>Nama Keperluan</label>
                                        <select name="keperluan" id="keperluan">
                                            <option data-placeholder="true">-- Pilih Keperluan --</option>
                                            <?php foreach ($jenis_biaya as $row): ?>
                                                <option value="<?php echo $row->id_jenis.'|'.$row->id_biaya.'|'.$row->jenis.'|'.$row->id_user_approval.'|'.$row->id_tipe_biaya.'|'.$row->budget.'|'.$row->project.'|'.$row->blok.'|'.$row->id_user_verified.'|'.$row->ba ?>"><?php echo $row->jenis . ' (' . $row->employee . ')' ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-2 col-xs-2">
                                        <label>Total</label>
                                        <input type="text" id="rupiah" onkeyup="nominal($(this).val(), '#rupiah')" class="form-control nominal border" placeholder="Total" name="total" value="<?=$data->nominal?>">
                                        <input type="hidden" id="tipe_budget">
                                        <input type="hidden" id="sisa_budget">
                                        <input type="hidden" name="leave_id" id="leave_id">
                                    </div>
                                    <div class="col-lg-3 col-sm-2 col-xs-2">
                                        <label>Note</label>
                                        <textarea class="form-control border" placeholder="Note" name="note" id="note"></textarea>
                                        <!-- <small class="text-secondary">*Dilarang pakai petik</small> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6 col-sm-2 col-xs-2" id="project_hide" style="display:none;">
                                        <label>Pilih Project</label>
                                        <select name="project" id="project">
                                            <option data-placeholder="true">-- Pilih Project --</option>
                                            <?php foreach ($project as $row):?>
                                                <option value="<?= $row->id_project ?>"><?= $row->project ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <small id="emailHelp" class="form-text text-muted">Jika bukan keperluan perumahan, pilih <b>Holding</b></small>
                                    </div>
                                    <div class="col-lg-6 col-sm-2 col-xs-2" id="pilihan_ba_hide" style="display:none;">
                                        <label>Pilih File/BA</label>
                                        <select class="form-control" name="pilihan_ba" id="pilihan_ba" style="height: 36px;">
                                            <option value="file">File</option>
                                            <option value="ba">BA</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="kondisi_pilihan_ba">
                                    <div class="col-lg-6 col-sm-2 col-xs-2" id="blok_hide" style="display:none;">
                                        <label>Pilih Blok</label>
                                        <select name="blok" multiple id="blok" style="height: 36px;">
                                            <option data-placeholder="true">-- Pilih Blok --</option>
                                        </select>
                                        <input type="hidden" id="type_blok" readonly>
                                        <input type="hidden" id="list_blok" name="list_blok" readonly>
                                        <input type="hidden" id="get_jenis" name="get_jenis" readonly>
                                    </div>
                                </div>	

                                <div class="row">						
                                    <div class="col-lg-2 col-sm-2 col-xs-2 pinjaman_karyawan" style="display:none;">
                                        <label>Jumlah Termin</label>
                                        <select class="form-control border" name="jumlah_termin" id="jumlah_termin" style="height: 36px;" onchange="nominal_per_termin()">
                                            <option value="">-Pilih-</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-sm-2 col-xs-2 pinjaman_karyawan" style="display:none;">
                                        <label>Nominal per Termin</label>
                                        <input type="text" id="nominal_termin" class="form-control border" placeholder="Nominal per Termin" name="nominal_termin" readonly>
                                    </div>
                                    <div class="col-lg-4 col-sm-2 col-xs-2 tgl_hide pilihan_ba_hide" style="display: none;">
                                        <label>Tanggal Nota</label>
                                        <input type="text" id="tanggal" class="form-control tanggal border" placeholder="Tanggal" name="tgl_nota"><input type="hidden" width="20px" id="diff">
                                    </div>
                                    <!-- <div class="col col-sm pilihan_ba_hide">
                                        <label id="attch">Lampiran</label>
                                        <input style="padding: .4rem .75rem;" type="file" id="nota" class="form-control" onchange="compress('#nota', '#string', '.fa_wait', '.fa_done')" accept=".pdf,.jpg,.jpeg,.png">
                                        <small id="emailHelp" class="form-text text-muted">Diperbolehkan : .pdf, .jpg, .jpeg, .png (Jika lampiran lebih dari 1, gabungkan jadi 1 file pdf)</small>
                                        <input type="hidden" class="form-control" name="nota" id="string">
                                        <div class="fa_wait" style="display: none;"><i class="fa fa-spinner fa-pulse"></i> <label>Checking File ...</label></div>
                                        <div class="fa_done" style="display: none;"><i class="fa fa-check-circle" style="color: #689f38;"></i> <label>File Complete.</label></div>
                                    </div> -->
                                </div>
                            </form>

                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-12">
                                            <div class="col-12 pt-2" style="text-align: right;">
                                                <button type="button" class="btn btn-md text-white btn-success" id="btn_approve" onclick="approve()">Kirim</button>
                                            </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
                <script>
                    window.location = 'https://trusmiverse.com/apps/trusmi_approval/verify_approval?id=<?=$_GET['id']?>'
                </script>

        <?php }  ?> 
    <?php } ?>
</main>