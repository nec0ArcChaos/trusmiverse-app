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
            <div class="row d-flex justify-content-end mb-2">
                <div class="col-8 d-flex justify-content-end">
                    <div class="col-3 mr-1">
                        <button class="btn btn-primary" id="btn_modal_add_employee">Add Employee</button>
                    </div>
                </div>
            </div>
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
                                    <form id="update_employee_form">
                                        <input type="hidden" class="user_id" name="user_id" value="" id="user_id">
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
                                                <input type="text" class="form-control border-custom" id="employee_id" name="employee_id">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Username</label>
                                                <input type="text" class="form-control border-custom" id="username" name="username">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="tgl_masuk">Email</label>
                                                <input type="text" class="form-control border-custom" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="company_edit">Company</label>
                                                <select name="company_edit" id="company_edit" class="slim-select form-control border-custom">
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="location_edit">Location</label>
                                                <select name="location_edit" id="location_edit" class="slim-select form-control border-custom">
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="department_edit">Department</label>
                                                <select name="department_edit" id="department_edit" class="slim-select form-control border-custom">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="designation_edit">Designation</label>
                                                <select name="designation_edit" id="designation_edit" class="slim-select form-control border-custom">
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="data_of_joining">Date Of Joining</label>
                                                <input type="date" class="form-control border-custom" id="date_of_joining" name="date_of_joining">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_of_leaving">Date of Leaving</label>
                                                <input type="date" class="form-control border-custom" id="date_of_leaving">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_offering">Date Offering</label>
                                                <input type="date" class="form-control border-custom" id="date_offering" name="date_offering">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="role_edit">Role</label>
                                                <select name="role_edit" id="role_edit" class="slim-select form-control border-custom">

                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="posisi">Posisi</label>
                                                <select name="posisi" id="posisi" class="form-control border-custom">
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="gender_edit">Gender</label>
                                                <select name="gender_edit" id="gender_edit" class="form-control border-custom">
                                                    <option value="Male">Laki - Laki</option>
                                                    <option value="Female">Perempuan</option>
                                                </select>
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
                                                <select name="status_active" id="status_active" class="form-control border-custom">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="office_shif">Office Shift</label>
                                                <select name="office_shift" id="office_shift" class="form-control border-custom slim-select">

                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="date_of_birth">Date Of Birth</label>
                                                <input type="date" class="form-control border-custom" id="date_of_birth" name="date_of_birth">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="leave_category">Leave Category</label>
                                                <select id="leave_category" class="form-control border-custom slim-select" multiple>
                                                </select>
                                                <input type="hidden" id="leave_category_hidden" name="leave_category_hidden" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="title">Companies Data</h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="company_data">Company</label>
                                                <select name="company_data" id="company_data" class="slim-select form-control border-custom" multiple>
                                                </select>
                                                <input type="hidden" id="company_data_hidden" name="company_data_hidden" readonly>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="provinsi">Provinsi</label>
                                                <input type="text" class="form-control border-custom" id="provinsi" name="provinsi">
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
                                            <div class="col-4">
                                                <label class="form-label-custom required small" for="no_kontak">No Kontak</label>
                                                <input type="text" name="no_kontak" class="form-control border-custom" id="no_kontak">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="domisili">Alamat Saat Ini</label>
                                                <input type="text" name="domisili" class="form-control border-custom" id="domisili">
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
                                        <div class="row mb-2">
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
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="management_talent">Management Talent</label>
                                                <select name="management_talent" id="management_talent" class="form-control border-custom">
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="jkn">JKN</label>
                                                <input type="text" name="jkn" class="form-control border-custom" id="jkn">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="kpj">KPJ</label>
                                                <input type="text" name="kpj" class="form-control border-custom" id="kpj">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="mbti">MBTI</label>
                                                <input type="text" name="mbti" class="form-control border-custom" id="mbti">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="iq">IQ</label>
                                                <input type="text" name="iq" class="form-control border-custom" id="iq">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="disc">DISC</label>
                                                <input type="text" name="disc" class="form-control border-custom" id="disc">
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="title">Referensi</h5>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="attitude">Attitude</label>
                                                <input type="text" name="attitude" class="form-control border-custom" id="attitude">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="performance">Performance</label>
                                                <input type="text" name="performance" class="form-control border-custom" id="performance">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="jabatan">Jabatan</label>
                                                <input type="text" name="jabatan" class="form-control border-custom" id="jabatan">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label-custom required small" for="a_resign">Alasan Resign</label>
                                                <input type="text" name="a_resign" class="form-control border-custom" id="a_resign">
                                            </div>
                                            <div class="col">
                                                <label class="form-label-custom required small" for="affiliate_pt">Affiliate PT</label>
                                                <select name="affiliate_pt" id="affiliate_pt" class="slim-select form-control border-custom">
                                                </select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row bg-light-blue py-2">
                                            <div class="col">
                                                <hr>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-primary text-white" id="btn_update_employee" onclick="update_employee()"><i class="bi bi-save text-white"></i> Save Change</button>
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
<div class="modal fade" id="modal_form_family" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_family">Tambah Family</h6>
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
                <form id="form_add_family">
                    <input type="hidden" name="family_user_id" id="family_user_id" class="user_id">
                    <input type="hidden" name="family_id" id="family_id">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_status">Status</label>
                            <select class="form-control slim-select border-custom" name="family_status" id="family_status">
                                <option value="#" selected disabled>-- Pilih --</option>
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
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="nama_family">Nama</label>
                            <input type="text" class="form-control border-custom" id="nama_family" name="nama_family">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_gender">Jenis Kelamin</label>
                            <select class="form-control slim-select border-custom" name="family_gender" id="family_gender">
                                <option value="#" disabled selected>-- Pilih --</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control border-custom" name="family_tempat_lahir" id="family_tempat_lahir">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_pendidikan">Pendidikan</label>
                            <select class="form-control slim-select border-custom" name="family_pendidikan" id="family_pendidikan">
                                <option value="#" selected disabled>-- Pilih Pendidikan --</option>
                                <?php foreach ($education as $row) : ?>
                                    <option value="<?= $row->education_level_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control border-custom" name="family_pekerjaan" id="family_pekerjaan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control border-custom" name="family_tgl_lahir" id="family_tgl_lahir">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="family_no_hp">Nomor Hp</label>
                            <input type="number" class="form-control border-custom" name="family_no_hp" id="family_no_hp">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_family" onclick="save_family()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_family" onclick="update_family()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_employee" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form">Add Employee</h6>
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
                <div class="inner-sidebar-content">
                    <div id="basic-info">
                        <form id="add_employee_form">
                            <h5 class="title">Basic Info</h5>
                            <div class="row mb-2">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label-custom required small" for="add_first_name">First Name</label>
                                    <input type="text" class="form-control border-custom" id="add_first_name" name="add_first_name">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label-custom required small" for="add_last_name">Last Name</label>
                                    <input type="text" class="form-control border-custom" id="add_last_name" name="add_last_name">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_employee_id">Employee ID</label>
                                    <input type="text" class="form-control border-custom" id="add_employee_id" name="add_employee_id">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_company">Company</label>
                                    <select name="add_company" id="add_company" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_offering">Date of Offering</label>
                                    <input type="date" class="form-control border-custom" id="add_offering" name="add_offering">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_joining">Date of Joining</label>
                                    <input type="date" class="form-control border-custom" id="add_joining" name="add_joining">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_location">Location</label>
                                    <select name="add_location" id="add_location" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_department">Department</label>
                                    <select name="add_department" id="add_department" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_designation">Designation</label>
                                    <select name="add_designation" id="add_designation" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_username">Username</label>
                                    <input type="text" class="form-control border-custom" id="add_username" name="add_username">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_email">Email</label>
                                    <input type="text" class="form-control border-custom" id="add_email" name="add_email">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_gender">Gender</label>
                                    <select name="add_gender" id="add_gender" class="slim-select form-control border-custom">
                                        <option value="Male">Laki - Laki</option>
                                        <option value="Female">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_office_shift">Office Shift Up</label>
                                    <select name="add_office_shift" id="add_office_shift" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_date_birth">Date of Birth</label>
                                    <input type="date" class="form-control border-custom" id="add_date_birth" name="add_date_birth">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_contact_number">Contact Number</label>
                                    <input type="number" class="form-control border-custom" id="add_contact_number" name="add_contact_number">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_password">Password</label>
                                    <input type="text" class="form-control border-custom" id="add_password" name="add_password">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_confirm_password">Confirm Password</label>
                                    <input type="text" class="form-control border-custom" id="add_confirm_password" name="add_confirm_password">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_role">Role</label>
                                    <select name="add_role" id="add_role" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_posisi">Posisi</label>
                                    <select name="add_posisi" id="add_posisi" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_agama">Agama</label>
                                    <select name="add_agama" id="add_agama" class="slim-select form-control border-custom">
                                        <?php foreach ($agama as $item) : ?>

                                            <option value="<?= $item->ethnicity_type_id ?>"><?= $item->type ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label-custom required small" for="add_alamat_ktp">Alamat KTP</label>
                                    <input type="text" class="form-control border-custom" id="add_alamat_ktp" name="add_alamat_ktp">
                                </div>
                            </div>
                            <div class="row mb-2 p-2">
                                <label class="form-label-custom required small" for="add_leave_category">Leave Category</label>
                                <select id="add_leave_category" class="slim-select form-control border-custom" multiple>
                                </select>
                                <input type="hidden" name="add_leave_category_hidden" id="add_leave_category_hidden" readonly>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_marial_status">Marial Status</label>
                                    <select name="add_marial_status" id="add_marial_status" class="slim-select form-control border-custom">
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced or Separated">Divorced or Separated</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_contact_number_2">Contact Number 2</label>
                                    <input type="text" class="form-control border-custom" id="add_contact_number_2" name="add_contact_number_2">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_ayah">Ayah</label>
                                    <input type="text" class="form-control border-custom" id="add_ayah" name="add_ayah">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_ibu">Ibu</label>
                                    <input type="text" class="form-control border-custom" id="add_ibu" name="add_ibu">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_no_kk">No KK</label>
                                    <input type="text" class="form-control border-custom" id="add_no_kk" name="add_no_kk">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_no_ktp">No KTP</label>
                                    <input type="text" class="form-control border-custom" id="add_no_ktp" name="add_no_ktp">
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label-custom required small" for="add_place_of_birth">Place of Birth</label>
                                    <input type="text" class="form-control border-custom" id="add_place_of_birth" name="add_place_of_birth">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label-custom required small" for="add_place">Place</label>
                                    <input type="text" class="form-control border-custom" id="add_place" name="add_place">
                                </div>
                                <div class="col-lg-5 col-sm-12">
                                    <label class="form-label-custom required small" for="add_mt">Management Talent</label>
                                    <select name="add_mt" id="add_mt" class="slim-select form-control border-custom">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <label class="form-label-custom required small" for="add_jkn">JKN</label>
                                    <input type="text" class="form-control border-custom" id="add_jkn" name="add_jkn">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_mbti">MBTI</label>
                                    <input type="text" class="form-control border-custom" id="add_mbti" name="add_mbti">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_kpj">KPJ</label>
                                    <input type="text" class="form-control border-custom" id="add_kpj" name="add_kpj">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_iq">IQ</label>
                                    <input type="text" class="form-control border-custom" id="add_iq" name="add_iq">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_disc">DISC</label>
                                    <input type="text" class="form-control border-custom" id="add_disc" name="add_disc">
                                </div>
                            </div>
                            <hr>
                            <h5 class="title">Referensi</h5>
                            <div class="row mb-2">
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_attitude">Attitude</label>
                                    <input type="text" class="form-control border-custom" id="add_attitude" name="add_attitude">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_performance">Performance</label>
                                    <input type="text" class="form-control border-custom" id="add_performance" name="add_performance">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_jabatan">Jabatan</label>
                                    <input type="text" class="form-control border-custom" id="add_jabatan" name="add_jabatan">
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <label class="form-label-custom required small" for="add_a_resign">Alasan Resign</label>
                                    <input type="text" class="form-control border-custom" id="add_a_resign" name="add_a_resign">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6 col-sm-12">
                                    <label class="form-label-custom required small" for="add_affiliate_pt">Affiliate PT</label>
                                    <select name="add_affiliate_pt" id="add_affiliate_pt" class="slim-select form-control border-custom">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-md btn-primary" id="btn_save_employee" onclick="save_employee()">Save
                    <i class="bi bi-card-checklist"></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_education" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_education">Tambah Pendidikan</h6>
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
                <form id="form_add_education">
                    <input type="hidden" name="education_user_id" id="education_user_id" class="user_id">
                    <input type="hidden" name="education_id" id="education_id">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="nama_education">Nama Instansi</label>
                            <input type="text" class="form-control border-custom" id="nama_education" name="nama_education">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="level_education">Tingkat Pendidikan</label>
                            <select class="form-control slim-select border-custom" name="level_education" id="level_education">
                                <option value="#" selected disabled>-- Pilih Pendidikan --</option>
                                <?php foreach ($education as $row) : ?>
                                    <option value="<?= $row->education_level_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="education_masuk">Tahun Masuk</label>
                            <input type="number" class="form-control border-custom" name="education_masuk" id="education_masuk">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="education_lulus">Tahun Lulus</label>
                            <input type="number" class="form-control border-custom" name="education_lulus" id="education_lulus">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="education_skill">Soft Skill</label>
                            <select class="form-control slim-select border-custom" name="education_skill" id="education_skill">
                                <option value="#" disabled selected>-- Pilih --</option>
                                <?php foreach ($skill as $row) : ?>
                                    <option value="<?= $row->id ?>"><?= $row->soft_skill ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="education_language">Bahasa</label>
                            <select class="form-control slim-select border-custom" name="education_language" id="education_language">
                                <option value="#" disabled selected>-- Pilih --</option>
                                <?php foreach ($language as $row) : ?>
                                    <option value="<?= $row->language_id ?>"><?= $row->language_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label-custom required small" for="education_description">Description</label>
                            <textarea name="education_description" id="education_description" class="form-control border-custom" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_education" onclick="save_education()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_education" onclick="update_education()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_work" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_work">Tambah Pendidikan</h6>
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
                <form id="form_add_work">
                    <input type="hidden" name="work_user_id" id="work_user_id" class="user_id">
                    <input type="hidden" name="work_id" id="work_id">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="nama_work">Nama Perusahaan</label>
                            <input type="text" class="form-control border-custom" id="nama_work" name="nama_work">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="lokasi_work">Lokasi</label>
                            <input type="text" class="form-control border-custom" id="lokasi_work" name="lokasi_work">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="posisi_work">Posisi</label>
                            <input type="text" class="form-control border-custom" name="posisi_work" id="posisi_work">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="masuk_work">Tahun Masuk</label>
                            <input type="number" class="form-control border-custom" name="masuk_work" id="masuk_work">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="keluar_work">Tahun Keluar</label>
                            <input type="number" class="form-control border-custom" name="keluar_work" id="keluar_work">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="salary_awal">Salary Awal</label>
                            <input type="number" class="form-control border-custom" name="salary_awal" id="salary_awal">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="salary_akhir">Salary Akhir</label>
                            <input type="number" class="form-control border-custom" name="salary_akhir" id="salary_akhir">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label-custom required small" for="a_resign_work">Alasan Keluar</label>
                            <textarea name="a_resign_work" id="a_resign_work" class="form-control border-custom" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_work" onclick="save_work()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_work" onclick="update_work()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_contract" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-card-checklist h5 avatar avatar-40 bg-light-blue text-blue rounded"></i>
                </div>
                <div class="col">
                    <h6 class="fw-medium mb-0" id="title_form_contract">Tambah Kontrak</h6>
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
                <form id="form_add_contract">
                    <input type="hidden" name="contract_user_id" id="contract_user_id" class="user_id">
                    <input type="hidden" name="contract_id" id="contract_id">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="title_contract">Title</label>
                            <input type="text" class="form-control border-custom" id="title_contract" name="title_contract">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label class="form-label-custom required small" for="status_contract">Status</label>
                            <select class="form-control slim-select border-custom" name="status_contract" id="status_contract">
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="type_contract">Tipe Kontrak</label>
                            <select class="form-control slim-select border-custom" name="type_contract" id="type_contract">
                                <option value=" " selected disabled>-- Pilih Kontrak --</option>
                                <?php foreach ($contract as $row) : ?>
                                    <option value="<?= $row->contract_type_id ?>"><?= $row->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="awal_contract">Tahun Awal</label>
                            <input type="date" class="form-control border-custom" name="awal_contract" id="awal_contract">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="form-label-custom required small" for="akhir_contract">Tahun Akhir</label>
                            <input type="date" class="form-control border-custom" name="akhir_contract" id="akhir_contract">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label class="form-label-custom required small" for="description_contract">Deskripsi</label>
                            <textarea name="description_contract" id="description_contract" class="form-control border-custom" rows="5"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-secondary" style="margin-right: 10px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btn_save_contract" onclick="save_contract()" class="btn btn-md btn-primary">Save
                    <i class="bi bi-card-checklist"></i>
                </button>
                <button type="button" id="btn_update_contract" onclick="update_contract()" class="btn btn-md btn-primary d-none">Update
                    <i class="bi bi-card-checklist"></i>
                </button>
            </div>
        </div>
    </div>
</div>