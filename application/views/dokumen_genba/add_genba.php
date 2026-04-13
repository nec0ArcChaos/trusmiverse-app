<main class="main mainheight">
<div class="container-fluid">
<div class="row" style="margin-top: 10px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col-6">
                    <h4 class="card-title">Add Dokumen Genba</h4>
                </div>
            </div>

            <div class="card-body">
                <form id="form_add_genba" class="mb-2">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <input type="text" value="<?= $this->session->userdata('user_id'); ?>" name="created_by" hidden>
                            <label class="me-sm-2">PIC</label>
                            <select class="form-control" name="pic" id="pic" required>
                                <option value="" disabled selected>Select PIC</option>
                                <?php foreach ($pic as $key) { ?>
                                    <option value="<?= $key->user_id ?>"><?= $key->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Divisi</label>
                            <select class="form-control" name="divisi" id="divisi" required>
                                <option value="" disabled selected>Select Divisi</option>
                                <option value="Operasional">Operasional</option>
                                <option value="Support">Support</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Tanggal Pelaksanaan</label>
                            <input type="text" name="tanggal" id="tanggal" class="form-control input-default" placeholder="Tanggal Pelaksanaan" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Company</label>
                            <select class="form-control" name="company_id" id="company_id" required>
                                <option value="" disabled selected>Select Company</option>
                                <?php foreach ($company as $key) { ?>
                                    <option value="<?= $key->company_id ?>"><?= $key->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Departemen</label>
                            <select class="form-control" name="department_id" id="department_id" required>
                                <option value="" disabled selected>Select Departemen</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Narasumber</label>
                            <select class="form-control select2" name="narasumber[]" id="select_narasumber" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Dokumen</label>
                            <select class="form-control" name="id_dokumen" id="id_dokumen" required>
                                <option value="" disabled selected>Select Dokumen</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Temuan</label>
                            <textarea id="temuan" name="temuan" class="form-control" placeholder="Temuan...." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Analisa</label>
                            <textarea id="analisa" name="analisa" class="form-control" placeholder="Analisa...." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Solusi</label>
                            <textarea id="solusi" name="solusi" class="form-control" placeholder="Solusi...." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Rekomendasi</label>
                            <select class="form-control" name="rekomendasi" id="rekomendasi" required>
                                <option value="" disabled selected>Select Rekomendasi</option>
                                <?php foreach ($rekomendasi as $key) { ?>
                                    <option value="<?= $key->id ?>"><?= $key->rekomendasi ?></option>
                                <?php } ?>
                                <option value="">Other</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Other Rekomendasi</label>
                            <input type="text" class="form-control" name="other" id="other" value="" placeholder="Isi jika rekomendasi other" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Akar Masalah</label>
                            <select class="form-control" name="masalah" id="masalah" required>
                                <option value="" disabled selected>Select Akar Masalah</option>
                                <?php foreach ($masalah as $key) { ?>
                                    <option value="<?= $key->id ?>"><?= $key->masalah ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Keluhan</label>
                            <textarea id="keluhan" name="keluhan" class="form-control" placeholder="Keluhan Narasumber..." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Keinginan</label>
                            <textarea id="keinginan" name="keinginan" class="form-control" placeholder="Keinginan Narasumber..." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="me-sm-2">Bukti Pelaksanaan</label>
                            <input type="file" class="form-control" name="file" id="file" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <label class="me-sm-2">Evaluasi</label>
                            <textarea id="evaluasi" name="evaluasi" class="form-control" placeholder="Rencana Evaluasi..." rows="3" style="border-width:1.5px; border-color: #D1CCCF; border-radius:20px; height:50px;"></textarea>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-md btn-success" id="submit">Submit</button>
                                </div>
                                <div class="col-sm-6">
                                    <a class="btn btn-md btn-warning" id="cancel" href="<?= base_url('dokumen_genba') ?>">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</main>
