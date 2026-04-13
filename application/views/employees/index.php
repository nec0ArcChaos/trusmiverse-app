<main class="main mainheight">
    <div class="container-fluid mb-4">
        <div class="row align-items-center page-title">
            <div class="col-12 col-md mb-2 mb-sm-0">
                <h5 class="mb-0"><?= $pageTitle; ?></h5>
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

    <div class="m-3">
        <div class="col-12 col-lg-12 col-xl-12 col-xxl-12 position-relative column-set">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" style="padding: 10px;">
                        <table id="dt_employees" class="table table-striped text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th style="min-width: 200px;">Employee</th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<div class="modal fade" id="modal_details" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0">Details Information</h6>
                    <p class="text-secondary small" id="detail"></p>
                </div>
                <div class="col-auto ps-0">
                    <div class="dropdown d-inline-block">
                        <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="card border-0 mb-4">

                    <div class="card-body p-0">
                        <div class="inner-sidebar-wrap">
                            <div class="inner-sidebar">
                                <ul class="nav nav-pills mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link tab-link" href="#" data-target2="basic-info2">
                                            <div class="avatar avatar-40 icon"><i class="bi bi-person"></i></div>
                                            <div class="col">Basic Info</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab-link" href="#" data-target2="family2">
                                            <div class="avatar avatar-40 icon"><i class="bi bi-archive"></i></div>
                                            <div class="col">Family</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab-link" href="#" data-target2="qualification2">
                                            <div class="avatar avatar-40 icon"><i class="bi bi-mortarboard"></i></div>
                                            <div class="col">Qualification</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab-link" href="#" data-target2="work-experience2">
                                            <div class="avatar avatar-40 icon"><i class="bi bi-file-earmark-person"></i></div>
                                            <div class="col">Work Experience</div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tab-link" href="#" data-target2="contract2">
                                            <div class="avatar avatar-40 icon"><i class="bi bi-file-earmark-post"></i></div>
                                            <div class="col">Contract</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="inner-sidebar-content p-3">
                                <div id="basic-info2" class="content-section active">
                                    <h5 class="title">Basic Info</h5>
                                    <form action="<?= base_url('employees/update_basic_info'); ?>" id="form_basic_info">
                                        <input type="hidden" class="user_id" name="user_id" value="">
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">First Name</label>
                                                <input type="text" class="form-control border-custom" id="first_name" name="first_name">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Last Name</label>
                                                <input type="text" class="form-control border-custom" id="last_name" name="last_name">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Employee ID</label>
                                                <input type="text" class="form-control border-custom" id="employee_id" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Username</label>
                                                <input type="text" class="form-control border-custom" id="username" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Email</label>
                                                <input type="text" class="form-control border-custom" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="company_name">Company</label>
                                                <input type="text" class="form-control border-custom" id="company_name" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Location</label>
                                                <input type="text" class="form-control border-custom" id="location" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Department</label>
                                                <input type="text" class="form-control border-custom" id="departement" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="designation_name">Designation</label>
                                                <input type="text" class="form-control border-custom" id="designation_name" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="data_of_joining">Date Of Joining</label>
                                                <input type="text" class="form-control border-custom" id="date_of_joining" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_of_leaving">Date of Leaving</label>
                                                <input type="text" class="form-control border-custom" id="date_of_leaving" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_offering">Date Offering</label>
                                                <input type="text" class="form-control border-custom" id="date_offering" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="role_name">Role</label>
                                                <input type="text" class="form-control border-custom" id="role_name" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="posisi">Posisi</label>
                                                <input type="text" class="form-control border-custom" id="posisi" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="gender">Gender</label>
                                                <input type="text" class="form-control border-custom" id="gender" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="marital_status">Marital Status</label>
                                                <!-- <input type="text" class="form-control border-custom" id="marital_status"> -->
                                                <select name="marital_status" id="marital_status" class="form-control border-custom">
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="contact">Contact Number</label>
                                                <input type="text" class="form-control border-custom" name="contact" id="contact">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="status_active">Status</label>
                                                <input type="text" class="form-control border-custom" id="status_active" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="office_shif">Office Shift</label>
                                                <select name="office_shift" id="office_shift" class="form-control border-custom">
                                                    <?php foreach ($shift as $item) : ?>
                                                        <option value="<?= $item->office_shift_id ?>"><?= $item->shift_name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_of_birth">Date Of Birth</label>
                                                <input type="date" class="form-control border-custom" id="date_of_birth" name="date_of_birth">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="provinsi">Provinsi</label>
                                                <input type="text" class="form-control border-custom" id="provinsi" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="city">City</label>
                                                <input type="text" class="form-control border-custom" id="city" name="city">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="zipcode">Zip Code</label>
                                                <input type="text" class="form-control border-custom" id="zipcode" name="zipcode">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-4">
                                                <label class="form-label-custom required small" for="agama">Agama</label>
                                                <!-- <input type="text" class="form-control border-custom" id="agama"> -->
                                                <select name="agama" id="agama" class="form-control border-custom">
                                                    <?php foreach ($agama as $item) : ?>

                                                        <option value="<?= $item->ethnicity_type_id ?>"><?= $item->type ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="address">Alamat KTP</label>
                                                <input type="text" name="address" class="form-control border-custom" id="address">
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="place_birth">Place of Birth</label>
                                                <input type="text" name="place_birth" class="form-control border-custom" id="place_birth">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="ayah">Ayah</label>
                                                <input type="text" name="ayah" class="form-control border-custom" id="ayah">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="ibu">Ibu</label>
                                                <input type="text" name="ibu" class="form-control border-custom" id="ibu">
                                            </div>

                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="no_kk">No KK</label>
                                                <input type="text" name="no_kk" class="form-control border-custom" id="no_kk">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="no_ktp">No KTP</label>
                                                <input type="text" name="no_ktp" class="form-control border-custom" id="no_ktp">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="no_npwp">No NPWP</label>
                                                <input type="text" name="no_npwp" class="form-control border-custom" id="no_npwp">
                                            </div>
                                        </div>
                                        <div class="row bg-light-blue py-2">
                                            <div class="col">
                                                <hr>
                                            </div>
                                            <div class="col-auto">

                                                <button type="submit" class="btn btn-primary text-white"><i class="bi bi-save text-white"></i> Save Change</button>
                                            </div>


                                        </div>
                                    </form>

                                </div>
                                <div id="family2" class="content-section">
                                    <h5 class="title">Family</h5>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="table-responsive">

                                                <table class="table table-stiped table-hover" id="data_family">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Status</th>
                                                            <th>Nama</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Tempat Lahir</th>
                                                            <th>Pendidikan</th>
                                                            <th>Pekerjaan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="qualification2" class="content-section">
                                    <h5 class="title">Qualification</h5>
                                    <table class="table table-stiped table-hover table-responsive" id="data_qualify" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Level</td>
                                                <td>Nama</td>
                                                <td>Tahun</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div id="work-experience2" class="content-section">
                                    <h5 class="title">Work Experience</h5>
                                    <table class="table table-stiped table-hover table-responsive" id="data_work_exp" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Nama Perusahaan</td>
                                                <td>Lokasi</td>
                                                <td>Posisi</td>
                                                <td>Tahun</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div id="contract2" class="content-section">
                                    <h5 class="title">Contract</h5>
                                    <table class="table table-stiped table-hover table-responsive" id="data_contract" style="width:100%">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Judul</td>
                                                <td>Deskripsi</td>
                                                <td>Range</td>
                                                <td>Status</td>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <!-- <button type="button" class="btn btn-md btn-primary" id="btn_save" onclick="save()">Update
                    <i class="bi bi-card-checklist"></i></button> -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_form" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_add_pembelajar">
                <div class="modal-header row align-items-center">
                    <div class="col-auto">
                        <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                    </div>
                    <div class="col">
                        <h6 class="fw-medium mb-0" id="title_form">Tambah Family</h6>
                    </div>
                    <div class="col-auto ps-0">
                        <div class="dropdown d-inline-block">
                            <a class="btn btn-link btn-square text-secondary dd-arrow-none dropdown-toggle" role="button" aria-expanded="false" data-bs-dismiss="modal" aria-label="Close">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('employees/insert_family'); ?>" id="form_family">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label-custom required small" for="no_kk">Status</label>
                                <select class="form-control" name="family_status" required>
                                    <option disabled selected>-- Pilih --</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Anak ke-1">Anak ke-1</option>
                                    <option value="Anak ke-2">Anak ke-2</option>
                                    <option value="Anak ke-3">Anak ke-3</option>
                                    <option value="Anak ke-4">Anak ke-4</option>
                                    <option value="Anak ke-5">Anak ke-5</option>
                                    <option value="Anak ke-6">Anak ke-6</option>
                                    <option value="Anak ke-7">Anak ke-7</option>
                                    <option value="Anak ke-8">Anak ke-8</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label-custom required small" for="no_ktp">Nama</label>
                                <input type="text" class="form-control border-custom" name="family_nama" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label-custom required small" for="no_kk">Jenis Kelamin</label>
                                <select class="form-control" name="family_gender">
                                    <option disabled selected>-- Pilih --</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label-custom required small" for="no_ktp">Tempat Lahir</label>
                                <input type="text" class="form-control border-custom" name="family_tempat_lahir">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label-custom required small" for="no_kk">Pendidikan</label>
                                <select class="form-control" name="family_pendidikan">
                                    <option disabled selected>-- Pilih --</option>
                                    <option value="1">SD</option>
                                    <option value="2">SMP</option>
                                    <option value="3">SMA/SMK</option>
                                    <option value="4">D1</option>
                                    <option value="5">D2</option>
                                    <option value="6">D3</option>
                                    <option value="7">D4</option>
                                    <option value="8">S1</option>
                                    <option value="9">S2</option>
                                    <option value="10">S3</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label-custom required small" for="no_ktp">Pekerjaan</label>
                                <input type="text" class="form-control border-custom" name="family_pekerjaan">
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-md btn-primary">Save
                        <i class="bi bi-card-checklist"></i></button>
            </form>
        </div>
        </form>
    </div>
</div>
</div>