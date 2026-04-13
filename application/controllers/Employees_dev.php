<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employees_dev extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_auth', 'auth');
        $this->load->model('Model_employees_dev', 'model');
        if ($this->session->userdata('user_id') != "") {
            // $user_id = $this->session->userdata('user_id');
            // $check_hak_akses = $this->auth->check_hak_akses('employees', $user_id);
            // if ($check_hak_akses != 'allowed') {
            //     redirect('dashboard', 'refresh');
            // }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Employees";
        $data['css']              = "employees/css";
        $data['js']               = "employees/employees/js_dev_ade";
        $data['content']          = "employees/employees/index_dev_ade";
        $data['agama'] = $this->db->query("SELECT * FROM xin_ethnicity_type")->result();
        $data['education'] = $this->db->query("SELECT * FROM xin_qualification_education_level")->result();
        $data['skill'] = $this->db->query("SELECT * FROM m_soft_skill")->result();
        $data['language'] = $this->db->query("SELECT * FROM xin_languages")->result();
        $data['contract'] = $this->db->query("SELECT * FROM xin_contract_type")->result();
        $this->load->view('layout/main', $data);
    }

    function dt_employees()
    {
        $data['data'] = $this->model->dt_employees();
        echo json_encode($data);
    }
    function get_detail_employee()
    {
        $user_id = $this->input->post('user_id');
        $data = [
            'basic' => $this->model->detail_employee($user_id, 1),
            'family' => $this->model->detail_employee($user_id, 2),
            'qualifi' => $this->model->detail_employee($user_id, 3),
            'work_exp' => $this->model->detail_employee($user_id, 4),
            'contract' => $this->model->detail_employee($user_id, 5),
        ];
        echo json_encode($data);
    }

    function reset_password()
    {
        $reset_password = $this->model->reset_password();
        echo json_encode($reset_password);
    }

    function insert_family()
    {
        echo json_encode($_POST);
    }
    function update_basic_info()
    {
        $data = [
            'office_shift_id' => $this->input->post('office_shift'),
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'martial_status' => $this->input->post('martial_status'),
            'city' => $this->input->post('city'),
            'zipcode' => $this->input->post('zipcode'),
            'ethnicity_type' => $this->input->post('agama'),
            'ctm_ayah' => $this->input->post('ayah'),
            'ctm_ibu' => $this->input->post('ibu'),
            'contact_no' => $this->input->post('contact'),
            'address' => $this->input->post('address'),
            'ctm_tempat_lahir' => $this->input->post('place_birth'),
            'ctm_nokk' => $this->input->post('no_kk'),
            'ctm_ktp' => $this->input->post('no_ktp'),
            'ctm_npwp' => $this->input->post('no_npwp'),
        ];
        $this->db->where('user_id', $this->input->post('user_id'));
        // $test = $this->db->set($data)->get_compiled_update('xin_employees');
        $this->db->limit(1);
        $hasil = $this->db->update('xin_employees', $data);
        echo json_encode($hasil);
    }

    function get_company()
    {
        $id_company = $_POST['id_company'];
        $data['company'] = $this->db->query("SELECT company_id,`name`,IF(company_id = '$id_company',1,0) as selected FROM xin_companies")->result();
        echo json_encode($data);
    }
    function get_company_data()
    {
        $id_company = $_POST['id_company'];
        $data['company'] = $this->db->query("SELECT company_id,`name`,IF(FIND_IN_SET(company_id,'$id_company') > 0,1,0) as selected FROM xin_companies")->result();
        echo json_encode($data);
    }

    function get_role()
    {
        $id_role = $_POST['id_role'];
        $data['role'] = $this->db->query("SELECT role_id,`role_name`,IF(role_id = '$id_role',1,0) as selected FROM xin_user_roles")->result();
        echo json_encode($data);
    }

    function get_posisi()
    {
        $id_posisi = $_POST['id_posisi'];
        $data['posisi'] = $this->db->query("SELECT role_id,`role_name`,IF(role_name = '$id_posisi',1,0) as selected FROM xin_user_roles WHERE role_id NOT IN (1,11,12)")->result();
        echo json_encode($data);
    }

    function get_location()
    {
        $company = $_POST['company'];
        $location = $_POST['location'];
        $data['location'] = $this->db->query("SELECT location_id, location_name, IF(location_id = '$location',1,0) as selected FROM xin_office_location WHERE company_id = $company")->result();
        echo json_encode($data);
    }

    function get_department()
    {
        $company = $_POST['company'];
        $id_department = $_POST['id_department'];
        $data['department'] = $this->db->query("SELECT department_id, department_name, IF(department_id = '$id_department',1,0) as selected FROM xin_departments WHERE company_id = $company")->result();
        echo json_encode($data);
    }

    function get_designation()
    {
        $company = $_POST['company'];
        $department = $_POST['department'];
        $designation = $_POST['designation'];
        $data['designation'] = $this->db->query("SELECT designation_name, designation_id, IF(designation_id = '$designation',1,0) as selected FROM xin_designations WHERE company_id = $company AND department_id = $department")->result();
        echo json_encode($data);
    }

    function get_office_shift()
    {
        $id_office_shift = $_POST['id_office_shift'];
        $data['office'] = $this->db->query("SELECT office_shift_id,shift_name,IF(office_shift_id = '$id_office_shift',1,0) as selected FROM xin_office_shift")->result();
        echo json_encode($data);
    }

    function get_leave_category()
    {
        $id_leave = $_POST['id_leave'];
        $data['leave'] = $this->db->query("SELECT leave_type_id,type_name,IF(FIND_IN_SET(leave_type_id,'$id_leave') > 0,1,0) as selected FROM xin_leave_type")->result();
        echo json_encode($data);
    }

    function get_affiliate_pt()
    {
        $id_pt = $_POST['id_pt'];
        $data['affiliate'] = $this->db->query("SELECT id_pt, CONCAT(kode_pt,' | ',nama_pt) as nama_pt,IF(id_pt = '$id_pt',1,0) as selected FROM trusmi_m_pt")->result();
        echo json_encode($data);
    }

    function check_employee_id()
    {
        $employee_id    = $_POST['employee_id'];
        $user_id    = $_POST['user_id'];
        if ($user_id != '' && $user_id != null) {
            $check_id       = $this->db->query("SELECT * FROM xin_employees WHERE employee_id = '$employee_id' AND user_id != '$user_id'")->num_rows();
        } else {
            $check_id       = $this->db->query("SELECT * FROM xin_employees WHERE employee_id = '$employee_id'")->num_rows();
        }
        if ($check_id > 0) {
            $data['valid'] = 0;
        } else {
            $data['valid'] = 1;
        }
        echo json_encode($data);
    }
    function check_employee_username()
    {
        $username    = $_POST['username'];
        $user_id    = $_POST['user_id'];
        if ($user_id != '' && $user_id != null) {
            $check_id       = $this->db->query("SELECT * FROM xin_employees WHERE username = '$username' AND user_id != '$user_id'")->num_rows();
        } else {
            $check_id       = $this->db->query("SELECT * FROM xin_employees WHERE username = '$username'")->num_rows();
        }
        if ($check_id > 0) {
            $data['valid'] = 0;
        } else {
            $data['valid'] = 1;
        }
        echo json_encode($data);
    }

    function save_employee()
    {

        $default_password = $_POST['add_password'];
        $options = array('cost' => 12);
        $password_hash = password_hash($default_password, PASSWORD_BCRYPT, $options);
        $date_of_joining = date('Y-m-d');
        $get_employee_id = $this->db->query("SELECT CONCAT(DATE_FORMAT('$date_of_joining', '%y%m%d'),',',((SUBSTRING_INDEX(employee_id, ',', -1)) + 1)) AS employee_id, ((SUBSTRING_INDEX(employee_id, ',', -1)) + 1) max_id FROM xin_employees ORDER BY date_of_joining DESC, SUBSTRING_INDEX(employee_id, ', ',-1) DESC LIMIT 1")->row_array();
        $dt_employees = [
            'employee_id'               => $get_employee_id['employee_id'] ?? null,
            'office_shift_id'           => $_POST['add_office_shift'] ?? null,
            'first_name'                => $_POST['add_first_name'] ?? null,
            'last_name'                 => $_POST['add_last_name'] ?? null,
            'username'                  => $_POST['add_username'].$get_employee_id['max_id'] ?? null,
            'company_id'                 => $_POST['add_company'] ?? null,
            'location_id'                 => $_POST['add_location'] ?? null,
            'email'                     => $_POST['add_email'] ?? null,
            'date_of_birth'             => $_POST['add_date_birth'] ?? null,
            'gender'                     => $_POST['add_gender'] ?? null,
            'user_role_id'                 => $_POST['add_role'] ?? null,
            'department_id'             => $_POST['add_department'] ?? null,
            'password'                  => $password_hash,
            // 'sub_department_id' 		=> $_POST['subdepartment_id'] ?? null,
            'designation_id'             => $_POST['add_designation'] ?? null,
            'date_of_joining'             => $_POST['add_joining'],
            'contact_no'                 => $_POST['add_contact_number'] ?? null,
            'address'                     => $_POST['add_alamat_ktp'] ?? null,
            'ethnicity_type'             => $_POST['add_agama'] ?? null,
            'leave_categories'             => $_POST['add_leave_category_hidden'] ?? null,
            'marital_status'             => $_POST['add_marial_status'] ?? null,
            'ctm_tempat_lahir'            => $_POST['add_place_of_birth'] ?? null,
            'ctm_ayah'                    => $_POST['add_ayah'] ?? null,
            'ctm_ibu'                    => $_POST['add_ibu'] ?? null,
            'ctm_nohp'                    => $_POST['add_contact_number_2'] ?? null,
            'ctm_nokk'                    => $_POST['add_no_kk'] ?? null,
            'ctm_noktp'                    => $_POST['add_no_ktp'] ?? null,
            'ctm_domisili'                => $_POST['add_place'] ?? null,
            'ctm_pin'                    => $_POST['add_mbti'] ?? null,
            'ctm_mt'                    => $_POST['add_mt'] ?? null,
            'ctm_faskes_tingkat_pertama' => $_POST['add_jkn'] ?? null,
            'ctm_faskes_dokter_gigi'    => $_POST['add_kpj'] ?? null,
            'ctm_iq'                    => $_POST['add_iq'] ?? null,
            'ctm_disc'                    => $_POST['add_disc'] ?? null,
            'ctm_attitude'                => $_POST['add_attitude'] ?? null,
            'ctm_performance'            => $_POST['add_performance'] ?? null,
            'ctm_jabatan'                => $_POST['add_jabatan'] ?? null,
            'ctm_alasan_resign'            => $_POST['add_a_resign'] ?? null,
            'ctm_offering'                => $_POST['add_offering'] ?? null,
            'ctm_posisi'                => $_POST['add_posisi'] ?? null,
            'ctm_pt'                    => $_POST['add_affiliate_pt'] ?? null,
            'ctm_cutoff'                    => $_POST['add_cutoff'] ?? null, // addnew
            'ctm_password'                => md5($_POST['add_password']),
            'is_active'                 => 1,
            'created_at'                 => date('Y-m-d H:i:s'),
        ];
        $data['result'] = $this->db->insert('xin_employees', $dt_employees);
        echo json_encode($data);
    }

    function update_employee()
    {
        $user_id = $_POST['user_id'];
        $dt_employees = [
            'employee_id'               => $_POST['employee_id'] ?? null,
            'office_shift_id'           => $_POST['office_shift'] ?? null,
            'first_name'                => $_POST['first_name'] ?? null,
            'last_name'                 => $_POST['last_name'] ?? null,
            'username'                  => $_POST['username'] ?? null,
            'company_id'                 => $_POST['company_edit'] ?? null,
            'location_id'                 => $_POST['location_edit'] ?? null,
            'email'                     => $_POST['email'] ?? null,
            'date_of_birth'             => $_POST['date_of_birth'] ?? null,
            'date_of_leaving'             => $_POST['date_of_leaving'] ?? null,
            'gender'                     => $_POST['gender_edit'] ?? null,
            'user_role_id'                 => $_POST['role_edit'] ?? null,
            'department_id'             => $_POST['department_edit'] ?? null,
            'designation_id'             => $_POST['designation_edit'] ?? null,
            'date_of_joining'             => $_POST['date_of_joining'],
            'contact_no'                 => $_POST['contact'] ?? null,
            'address'                     => $_POST['address'] ?? null,
            'ethnicity_type'             => $_POST['agama'] ?? null,
            'leave_categories'             => $_POST['leave_category_hidden'] ?? null,
            'marital_status'             => $_POST['marital_status'] ?? null,
            'ctm_tempat_lahir'            => $_POST['place_birth'] ?? null,
            'ctm_ayah'                    => $_POST['ayah'] ?? null,
            'ctm_ibu'                    => $_POST['ibu'] ?? null,
            'ctm_nohp'                    => $_POST['no_kontak'] ?? null,
            'ctm_nokk'                    => $_POST['no_kk'] ?? null,
            'ctm_noktp'                    => $_POST['no_ktp'] ?? null,
            'ctm_domisili'                => $_POST['domisili'] ?? null,
            'ctm_pin'                    => $_POST['mbti'] ?? null,
            'ctm_mt'                    => $_POST['management_talent'] ?? null,
            'ctm_faskes_tingkat_pertama' => $_POST['jkn'] ?? null,
            'ctm_faskes_dokter_gigi'    => $_POST['kpj'] ?? null,
            'ctm_iq'                    => $_POST['iq'] ?? null,
            'ctm_disc'                    => $_POST['disc'] ?? null,
            'ctm_attitude'                => $_POST['attitude'] ?? null,
            'ctm_performance'            => $_POST['performance'] ?? null,
            'ctm_jabatan'                => $_POST['jabatan'] ?? null,
            'ctm_alasan_resign'            => $_POST['a_resign'] ?? null,
            'ctm_offering'                => $_POST['date_offering'] ?? null,
            'ctm_posisi'                => $_POST['posisi'] ?? null,
            'ctm_pt'                    => $_POST['affiliate_pt'] ?? null,
            'is_active'                 => $_POST['status_active'] ?? null,
            'updated_at'                 => date('Y-m-d H:i:s'),
            'updated_by'                 => $this->session->userdata('user_id'),
            'state'                      => $_POST['provinsi'] ?? null,
            'city'                      => $_POST['city'] ?? null,
            'zipcode'                      => $_POST['zipcode'] ?? null,
            'view_companies_id'         => $_POST['company_data_hidden'] ?? null,
            'ctm_cutoff'                      => $_POST['cutoff'] ?? null, // addnew
        ];
        $this->db->where('user_id', $user_id);
        $data['result'] = $this->db->update('xin_employees', $dt_employees);
        echo json_encode($data);
    }

    function save_family()
    {
        $user_id = $_POST['family_user_id'];
        $dt_family = [
            'employee_id'   => $user_id,
            'status'        => $_POST['family_status'] ?? null,
            'nama'          => $_POST['nama_family'] ?? null,
            'jenis_kelamin' => $_POST['family_gender'] ?? null,
            'tempat_lahir'  => $_POST['family_tempat_lahir'] ?? null,
            'pendidikan'    => $_POST['family_pendidikan'] ?? null,
            'pekerjaan'     => $_POST['family_pekerjaan'] ?? null,
            'tgl_lahir'     => $_POST['family_tgl_lahir'] ?? null,
            'no_hp'         => $_POST['family_no_hp'] ?? null,
            'created_at'    => date("Y-m-d H:i:s")
        ];
        $data['result'] = $this->db->insert('fack_families', $dt_family);
        echo json_encode($data);
    }

    function update_family()
    {
        $fam_id = $_POST['family_id'];
        $dt_family = [
            'status'        => $_POST['family_status'] ?? null,
            'nama'          => $_POST['nama_family'] ?? null,
            'jenis_kelamin' => $_POST['family_gender'] ?? null,
            'tempat_lahir'  => $_POST['family_tempat_lahir'] ?? null,
            'pendidikan'    => $_POST['family_pendidikan'] ?? null,
            'pekerjaan'     => $_POST['family_pekerjaan'] ?? null,
            'tgl_lahir'     => $_POST['family_tgl_lahir'] ?? null,
            'no_hp'         => $_POST['family_no_hp'] ?? null,
        ];
        $this->db->where('id', $fam_id);
        $data['result'] = $this->db->update('fack_families', $dt_family);
        echo json_encode($data);
    }
    function delete_family()
    {
        $fam_id = $_POST['fam_id'];
        $this->db->where('id', $fam_id);
        $data['result'] = $this->db->delete('fack_families');
        echo json_encode($data);
    }

    function save_education()
    {
        $dt_education = [
            'employee_id' => $_POST['education_user_id'] ?? null,
            'education_level_id' => $_POST['level_education'] ?? null,
            'name' => $_POST['nama_education'] ?? null,
            'from_year' => $_POST['education_masuk'] ?? null,
            'to_year' => $_POST['education_lulus'] ?? null,
            'language_id' => $_POST['education_language'] ?? null,
            'skill_id' => $_POST['education_skill'] ?? null,
            'description' => $_POST['education_description'] ?? null,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $data['result'] = $this->db->insert('xin_employee_qualification', $dt_education);
        echo json_encode($data);
    }

    function update_education()
    {
        $id = $_POST['education_id'];
        $dt_education = [
            'education_level_id' => $_POST['level_education'] ?? null,
            'name' => $_POST['nama_education'] ?? null,
            'from_year' => $_POST['education_masuk'] ?? null,
            'to_year' => $_POST['education_lulus'] ?? null,
            'language_id' => $_POST['education_language'] ?? null,
            'skill_id' => $_POST['education_skill'] ?? null,
            'description' => $_POST['education_description'] ?? null,
        ];
        $this->db->where('qualification_id', $id);
        $data['result'] = $this->db->update('xin_employee_qualification', $dt_education);
        echo json_encode($data);
    }

    function delete_education()
    {
        $edu_id = $_POST['edu_id'];
        $this->db->where('qualification_id', $edu_id);
        $data['result'] = $this->db->delete('xin_employee_qualification');
        echo json_encode($data);
    }

    function save_work()
    {
        $dt_work = [
            'employee_id' => $_POST['work_user_id'] ?? null,
            'nama_perusahaan' => $_POST['nama_work'] ?? null,
            'lokasi'    => $_POST['lokasi_work'] ?? null,
            'posisi' => $_POST['posisi_work'] ?? null,
            'tahun_masuk' => $_POST['masuk_work'] ?? null,
            'tahun_keluar' => $_POST['keluar_work'] ?? null,
            'salary_awal' => $_POST['salary_awal'] ?? null,
            'salary_akhir'  => $_POST['salary_akhir'] ?? null,
            'alasan_keluar' => $_POST['a_resign_work'] ?? null,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $data['result'] = $this->db->insert('fack_work_experience', $dt_work);
        echo json_encode($data);
    }

    function update_work()
    {
        $dt_work = [
            'nama_perusahaan' => $_POST['nama_work'] ?? null,
            'lokasi'    => $_POST['lokasi_work'] ?? null,
            'posisi' => $_POST['posisi_work'] ?? null,
            'tahun_masuk' => $_POST['masuk_work'] ?? null,
            'tahun_keluar' => $_POST['keluar_work'] ?? null,
            'salary_awal' => $_POST['salary_awal'] ?? null,
            'salary_akhir'  => $_POST['salary_akhir'] ?? null,
            'alasan_keluar' => $_POST['a_resign_work'] ?? null,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $this->db->where('id', $_POST['work_id']);
        $data['result'] = $this->db->update('fack_work_experience', $dt_work);
        echo json_encode($data);
    }

    function delete_work()
    {
        $work_id = $_POST['work_id'];
        $this->db->where('id', $work_id);
        $data['result'] = $this->db->delete('fack_work_experience');
        echo json_encode($data);
    }

    function save_contract()
    {
        $user_id = $_POST['contract_user_id'];
        $dt_employees = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $user_id")->row_array();
        $designation = $dt_employees['designation_id'];
        $dt_contract = [
            'employee_id' => $_POST['contract_user_id'] ?? null,
            'contract_type_id' => $_POST['type_contract'] ?? null,
            'from_date' => $_POST['awal_contract'] ?? null,
            'designation_id' => $designation ?? null,
            'title' => $_POST['title_contract'] ?? null,
            'to_date' => $_POST['akhir_contract'] ?? null,
            'description' => $_POST['description_contract'] ?? null,
            'is_active' => $_POST['status_contract'] ?? null,
            'created_at' => date("Y-m-d H:i:s")
        ];
        $data['result'] = $this->db->insert('xin_employee_contract', $dt_contract);
        echo json_encode($data);
    }

    function update_contract()
    {
        $dt_contract = [
            'contract_type_id' => $_POST['type_contract'] ?? null,
            'from_date' => $_POST['awal_contract'] ?? null,
            'title' => $_POST['title_contract'] ?? null,
            'to_date' => $_POST['akhir_contract'] ?? null,
            'description' => $_POST['description_contract'] ?? null,
            'is_active' => $_POST['status_contract'] ?? null
        ];
        $this->db->where('contract_id', $_POST['contract_id']);
        $data['result'] = $this->db->update('xin_employee_contract', $dt_contract);
        echo json_encode($data);
    }

    function delete_contract()
    {
        $contract_id = $_POST['contract_id'];
        $this->db->where('contract_id', $contract_id);
        $data['result'] = $this->db->delete('xin_employee_contract');
        echo json_encode($data);
    }

    function company()
    {
        $data['pageTitle']        = "Company";
        $data['css']              = "employees/css";
        $data['js']               = "employees/company/js_dev";
        $data['content']          = "employees/company/index_dev";
        $data['company_type']     = $this->db->query("SELECT * FROM xin_company_type")->result();
        $data['countries']     = $this->db->query("SELECT * FROM xin_countries")->result();

        $this->load->view('layout/main', $data);
    }
    function dt_company()
    {
        $data['data'] = $this->db->query("SELECT xin_companies.*,xin_countries.country_name,TRIM(CONCAT(xe.first_name,' ',xe.last_name)) as user_added FROM xin_companies LEFT JOIN xin_countries ON xin_countries.country_id = xin_companies.country LEFT JOIN xin_employees xe ON xe.user_id = xin_companies.added_by")->result();
        echo json_encode($data);
    }

    function save_company()
    {
        if (!empty($_FILES['company_logo']['tmp_name'])) {
            if (is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
                //checking file type
                $allowed =  array('png', 'jpg', 'jpeg');
                $filename = $_FILES['company_logo']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["company_logo"]["tmp_name"];
                    $profile = "/var/www/trusmiverse/apps/assets/img/";
                    $newfilename = 'logo_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        $latest_id = $this->db->query("SELECT company_id FROM xin_companies ORDER BY company_id DESC LIMIT 1")->row_array();
        $company_id = (int) $latest_id['company_id'] + 1;
        $dt_company = [
            'company_id'    => $company_id,
            'type_id'       => $_POST['company_type'] ?? null,
            'name'          => $_POST['company_name'] ?? null,
            'trading_name'    => $_POST['legal'] ?? null,
            'username'    => $_POST['username'] ?? null,
            'password'    => $_POST['password'] ?? null,
            'registration_no'    => $_POST['registration_number'] ?? null,
            'government_tax'    => $_POST['tax_number'] ?? null,
            'email'    => $_POST['email'] ?? null,
            'logo'    => $fname,
            'contact_number'    => $_POST['contact'] ?? null,
            'website_url'    => $_POST['website'] ?? null,
            'address_1'    => $_POST['address_1'] ?? null,
            'address_2'    => $_POST['address_2'] ?? null,
            'city'    => $_POST['city'] ?? null,
            'state'    => $_POST['state'] ?? null,
            'zipcode'    => $_POST['zipcode'] ?? null,
            'country'    => $_POST['country'] ?? null,
            'is_active'    => 0,
            'added_by'    => $this->session->userdata('user_id'),
            'created_at'    => date("Y-m-d H:i:s"),
        ];
        $data['result'] = $this->db->insert('xin_companies', $dt_company);
        echo json_encode($data);
    }

    function get_detail_company()
    {
        $id = $_POST['id'];
        $data['company'] = $this->db->query("SELECT * FROM xin_companies WHERE company_id = $id")->row_array();
        echo json_encode($data);
    }

    function update_company()
    {
        if (!empty($_FILES['company_logo']['tmp_name'])) {
            if (is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
                //checking file type
                $allowed =  array('png', 'jpg', 'jpeg');
                $filename = $_FILES['company_logo']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["company_logo"]["tmp_name"];
                    $profile = "/var/www/trusmiverse/apps/assets/img/";
                    $newfilename = 'logo_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        $company_id = $_POST['company_id'];
        $dt_company = [
            'type_id'       => $_POST['company_type'] ?? null,
            'name'          => $_POST['company_name'] ?? null,
            'trading_name'    => $_POST['legal'] ?? null,
            'username'    => $_POST['username'] ?? null,
            'password'    => $_POST['password'] ?? null,
            'registration_no'    => $_POST['registration_number'] ?? null,
            'government_tax'    => $_POST['tax_number'] ?? null,
            'email'    => $_POST['email'] ?? null,
            'logo'    => $fname,
            'contact_number'    => $_POST['contact'] ?? null,
            'website_url'    => $_POST['website'] ?? null,
            'address_1'    => $_POST['address_1'] ?? null,
            'address_2'    => $_POST['address_2'] ?? null,
            'city'    => $_POST['city'] ?? null,
            'state'    => $_POST['state'] ?? null,
            'zipcode'    => $_POST['zipcode'] ?? null,
            'country'    => $_POST['country'] ?? null,
            'is_active'    => 0,
            'added_by'    => $this->session->userdata('user_id')
        ];
        $this->db->where('company_id', $company_id);
        $data['result'] = $this->db->update('xin_companies', $dt_company);
        echo json_encode($data);
    }

    function delete_company()
    {
        $id = $_POST['id'];
        $this->db->where('company_id', $id);
        $data['result'] = $this->db->delete('xin_companies');
        echo json_encode($data);
    }

    function location()
    {
        $data['pageTitle']        = "Location";
        $data['css']              = "employees/css";
        $data['js']               = "employees/location/js_dev";
        $data['content']          = "employees/location/index_dev";
        $data['companies']        = $this->db->query("SELECT * FROM xin_companies")->result();
        $data['user']             = $this->db->query("SELECT user_id, TRIM(CONCAT(first_name, ' ', last_name)) as employee_name FROM xin_employees WHERE is_active = 1")->result();
        $data['countries']     = $this->db->query("SELECT * FROM xin_countries")->result();

        $this->load->view('layout/main', $data);
    }

    function dt_location()
    {
        $data['data'] = $this->db->query("SELECT xin_office_location.*,xin_countries.country_name,TRIM(CONCAT(xe.first_name,' ',xe.last_name)) as user_added,TRIM(CONCAT(COALESCE(xe1.first_name,''),' ',COALESCE(xe1.last_name,''))) as user_head FROM xin_office_location LEFT JOIN xin_countries ON xin_countries.country_id = xin_office_location.country LEFT JOIN xin_employees xe ON xe.user_id = xin_office_location.added_by LEFT JOIN xin_employees xe1 ON xe1.user_id = xin_office_location.location_head")->result();
        echo json_encode($data);
    }

    function save_location()
    {
        $dt_location = [
            'company_id'    => $_POST['company'],
            'location_head'       => $_POST['location_head'] ?? null,
            'location_name'          => $_POST['location'] ?? null,
            'phone'    => $_POST['phone'] ?? null,
            'fax'    => $_POST['fax_number'] ?? null,
            'email'    => $_POST['email'] ?? null,
            'address_1'    => $_POST['address_1'] ?? null,
            'address_2'    => $_POST['address_2'] ?? null,
            'city'    => $_POST['city'] ?? null,
            'state'    => $_POST['state'] ?? null,
            'zipcode'    => $_POST['zip_code'] ?? null,
            'country'    => $_POST['country'] ?? null,
            'status'    => 1,
            'added_by'    => $this->session->userdata('user_id'),
            'created_at'    => date("Y-m-d H:i:s"),
        ];
        $data['result'] = $this->db->insert('xin_office_location', $dt_location);
        echo json_encode($data);
    }

    function get_detail_location()
    {
        $id = $_POST['id'];
        $data['location'] = $this->db->query("SELECT * FROM xin_office_location WHERE location_id = $id")->row_array();
        echo json_encode($data);
    }

    function update_location()
    {
        $location_id = $_POST['location_id'];
        $dt_location = [
            'company_id'    => $_POST['company'],
            'location_head'       => $_POST['location_head'] ?? null,
            'location_name'          => $_POST['location'] ?? null,
            'phone'    => $_POST['phone'] ?? null,
            'fax'    => $_POST['fax_number'] ?? null,
            'email'    => $_POST['email'] ?? null,
            'address_1'    => $_POST['address_1'] ?? null,
            'address_2'    => $_POST['address_2'] ?? null,
            'city'    => $_POST['city'] ?? null,
            'state'    => $_POST['state'] ?? null,
            'zipcode'    => $_POST['zip_code'] ?? null,
            'country'    => $_POST['country'] ?? null,
        ];
        $this->db->where('location_id', $location_id);
        $data['result'] = $this->db->update('xin_office_location', $dt_location);
        echo json_encode($data);
    }

    function delete_location()
    {
        $id = $_POST['id'];
        $this->db->where('location_id', $id);
        $data['result'] = $this->db->delete('xin_office_location');
        echo json_encode($data);
    }

    function department()
    {
        $data['pageTitle']        = "Department";
        $data['css']              = "employees/department/css";
        $data['js']               = "employees/department/js_dev";
        $data['content']          = "employees/department/index_dev";
        $data['companies']        = $this->db->query("SELECT * FROM xin_companies")->result();
        $data['user']             = $this->db->query("SELECT user_id, TRIM(CONCAT(first_name, ' ', last_name)) as employee_name FROM xin_employees WHERE is_active = 1")->result();
        $data['countries']     = $this->db->query("SELECT * FROM xin_countries")->result();
        $data['working_locations'] = $this->db->get('m_working_location')->result();

        $this->load->view('layout/main', $data);
    }

    function dt_department()
    {
        $data['data'] = $this->db->query("SELECT
                xin_departments.department_id,
                xin_departments.department_name,
                xin_departments.location_id,
                xin_departments.company_id,
                xin_departments.head_id,
                xin_departments.break,
                xin_departments.work_location_id,
                COALESCE(m_working_location.lokasi, '-') AS working_location_name,
                xin_companies.NAME AS company_name,
                xin_office_location.location_name,
                TRIM(CONCAT(xin_employees.first_name, ' ', xin_employees.last_name)) AS head,
                COALESCE(total.total,0) AS total_emp
            FROM
                xin_departments
                LEFT JOIN xin_companies ON xin_companies.company_id = xin_departments.company_id
                LEFT JOIN xin_office_location ON xin_office_location.location_id = xin_departments.location_id
                LEFT JOIN xin_employees ON xin_departments.head_id = xin_employees.user_id
                LEFT JOIN m_working_location ON m_working_location.id = xin_departments.work_location_id
                LEFT JOIN (SELECT department_id, COUNT(user_id) AS total FROM xin_employees WHERE is_active = 1 GROUP BY department_id) AS total ON total.department_id = xin_departments.department_id
            WHERE
                xin_departments.hide != 1")->result();
        echo json_encode($data);
    }

    function get_employee()
    {
        $company = $_POST['company_id'];
        $id = $_POST['id'];
        // $data['employee'] = $this->db->query("SELECT user_id,TRIM(CONCAT(first_name,' ', last_name)) as employee_name, IF(user_id = '$id',1,0) as selected FROM xin_employees WHERE company_id = $company")->result();
        $data['employee'] = $this->db->query("SELECT user_id,TRIM(CONCAT(first_name,' ', last_name)) as employee_name, IF(user_id = '$id',1,0) as selected FROM xin_employees WHERE is_active = 1")->result();
        echo json_encode($data);
    }

    function save_department()
    {
        $dt_location = [
            'department_name' =>  $_POST['name'] ?? null,
            'company_id' => $_POST['company'] ?? null,
            'location_id' => $_POST['location'] ?? null,
            'work_location_id' => $_POST['work_location'] ?? null,
            'added_by' => $this->session->userdata('user_id'),
            'created_at' => date("Y-m-d H:i:s"),
            'status' => 1,
            'break' => $_POST['break'] ?? null,
            'head_id' => $_POST['department_head'] ?? null,
            'hide' => 0
        ];
        $data['result'] = $this->db->insert('xin_departments', $dt_location);
        echo json_encode($data);
    }

    function update_department()
    {
        $id = $_POST['department_id'];
        $dt_location = [
            'department_name' =>  $_POST['name'] ?? null,
            'company_id' => $_POST['company'] ?? null,
            'location_id' => $_POST['location'] ?? null,
            'work_location_id' => $_POST['work_location'] ?? null,
            'break' => $_POST['break'] ?? null,
            'head_id' => $_POST['department_head'] ?? null,
        ];
        $this->db->where('department_id', $id);
        $data['result'] = $this->db->update('xin_departments', $dt_location);
        echo json_encode($data);
    }

    function delete_department()
    {
        $id = $_POST['id'];
        $this->db->where('department_id', $id);
        $data['result'] = $this->db->delete('xin_departments');
        echo json_encode($data);
    }

    // TAMBAHAN: Simpan Working Location via AJAX Modal
    function save_working_location_ajax()
    {
        // Validasi sederhana
        $lokasi = $this->input->post('lokasi');
        $is_public = $this->input->post('is_public');

        if (empty($lokasi)) {
            echo json_encode(['status' => false, 'message' => 'Nama lokasi tidak boleh kosong']);
            return;
        }

        $data = [
            'lokasi' => $lokasi,
            'is_public' => $is_public,
            // 'created_at' => date('Y-m-d H:i:s') // Jika ada kolom timestamp
        ];

        $insert = $this->db->insert('m_working_location', $data);

        if ($insert) {
            $response = [
                'status' => true,
                'data' => [
                    'id' => $this->db->insert_id(),
                    'lokasi' => $lokasi
                ]
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal menyimpan ke database'
            ];
        }

        echo json_encode($response);
    }

    function designation()
    {
        $data['pageTitle']        = "Designation";
        $data['css']              = "employees/css";
        $data['js']               = "employees/designation/js_dev";
        $data['content']          = "employees/designation/index_dev";
        $data['companies']        = $this->db->query("SELECT * FROM xin_companies")->result();
        $data['shift']            = $this->db->query("SELECT * FROM trusmi_shift")->result();

        $this->load->view('layout/main', $data);
    }

    function dt_designation()
    {
        $data['data'] = $this->db->query("SELECT xds.designation_name,xds.designation_id,xds.department_id,xds.company_id,xds.trusmi_shift,xde.department_name,xc.name as company_name FROM xin_designations xds LEFT JOIN xin_departments xde ON xde.department_id = xds.department_id LEFT JOIN xin_companies xc ON xc.company_id = xds.company_id WHERE xds.hide = 0;")->result();
        echo json_encode($data);
    }

    function save_designation()
    {
        $dt_desigation = [
            'designation_name' =>  $_POST['name'] ?? null,
            'company_id' => $_POST['company'] ?? null,
            'department_id' => $_POST['department'] ?? null,
            'trusmi_shift' => $_POST['shift'] ?? null,
            'added_by' => $this->session->userdata('user_id'),
            'created_at' => date("Y-m-d H:i:s"),
            'status' => 1,
            'hide' => 0
        ];
        $data['result'] = $this->db->insert('xin_designations', $dt_desigation);
        echo json_encode($data);
    }

    function update_designation()
    {
        $id = $_POST['designation_id'];
        $dt_desigation = [
            'designation_name' =>  $_POST['name'] ?? null,
            'company_id' => $_POST['company'] ?? null,
            'department_id' => $_POST['department'] ?? null,
            'trusmi_shift' => $_POST['shift'] ?? null,
        ];
        $this->db->where('designation_id', $id);
        $data['result'] = $this->db->update('xin_designations', $dt_desigation);
        echo json_encode($data);
    }

    function delete_designation()
    {
        $id = $_POST['id'];
        $this->db->where('designation_id', $id);
        $data['result'] = $this->db->delete('xin_designations');
        echo json_encode($data);
    }

    function reports()
    {
        $data['pageTitle']        = "Reports";
        $data['css']              = "employees/css";
        $data['js']               = "employees/reports/js_dev";
        $data['content']          = "employees/reports/index_dev";
        $data['companies']        = $this->db->query("SELECT company_id,`name` FROM xin_companies")->result();
        $this->load->view('layout/main', $data);
    }

    function dt_employees_report()
    {
        $company = $_POST['company'] ?? null;
        $department = $_POST['department'] ?? null;
        $designation = $_POST['designation'] ?? null;

        // Fetch employees report
        $dt = $this->model->dt_employees_report($company, $department, $designation);
        $datas = [];

        foreach ($dt as $data) {
            // Fetch additional details
            $pdk = $this->model->get_pendidikan($data->user_id);
            $wrk = $this->model->get_work($data->user_id);
            $atd = $this->model->get_last_attendance($data->user_id);

            // Build data arrays
            $contract = array_pad(explode(', ', $data->contract), 5, null);
            $pendidikan = array_pad(array_column($pdk, 'pend'), 5, null);
            $working = array_pad(array_column($wrk, 'wrk'), 5, null);

            // Merge all data
            $datas[] = array_merge((array) $data, [
                'attendance_date' => $atd,
                'contract_1' => $contract[0],
                'contract_2' => $contract[1],
                'contract_3' => $contract[2],
                'contract_4' => $contract[3],
                'contract_5' => $contract[4],
                'pendidikan_1' => $pendidikan[0],
                'pendidikan_2' => $pendidikan[1],
                'pendidikan_3' => $pendidikan[2],
                'pendidikan_4' => $pendidikan[3],
                'pendidikan_5' => $pendidikan[4],
                'wrk_1' => $working[0],
                'wrk_2' => $working[1],
                'wrk_3' => $working[2],
                'wrk_4' => $working[3],
                'wrk_5' => $working[4],
            ]);
        }
        echo json_encode([
            "data" => $datas
        ]);
    }
    function dt_employees_report_new()
    {
        $company = $_POST['company'] ?? null;
        $department = $_POST['department'] ?? null;
        $designation = $_POST['designation'] ?? null;

        // Fetch employees report
        $dt = $this->model->dt_employees_report_new($company, $department, $designation);
        
        echo json_encode([
            "data" => $dt
        ]);
    }

    public function report_export_excel()
    {
        $company = $_REQUEST['company'] ?? null;
        $department = $_REQUEST['department'] ?? null;
        $designation = $_REQUEST['designation'] ?? null;

        // Fetch employees report
        $dt = $this->model->dt_employees_report($company, $department, $designation);
        $datas = [];

        foreach ($dt as $data) {
            // Fetch additional details
            $pdk = $this->model->get_pendidikan($data->user_id);
            $wrk = $this->model->get_work($data->user_id);
            $atd = $this->model->get_last_attendance($data->user_id);

            // Build data arrays
            $contract = array_pad(explode(', ', $data->contract), 5, null);
            $pendidikan = array_pad(array_column($pdk, 'pend'), 5, null);
            $working = array_pad(array_column($wrk, 'wrk'), 5, null);

            // Merge all data
            $datas[] = array_merge((array) $data, [
                'attendance_date' => $atd,
                'contract_1' => $contract[0],
                'contract_2' => $contract[1],
                'contract_3' => $contract[2],
                'contract_4' => $contract[3],
                'contract_5' => $contract[4],
                'pendidikan_1' => $pendidikan[0],
                'pendidikan_2' => $pendidikan[1],
                'pendidikan_3' => $pendidikan[2],
                'pendidikan_4' => $pendidikan[3],
                'pendidikan_5' => $pendidikan[4],
                'wrk_1' => $working[0],
                'wrk_2' => $working[1],
                'wrk_3' => $working[2],
                'wrk_4' => $working[3],
                'wrk_5' => $working[4],
            ]);
        }

        if (ob_get_length()) {
            ob_end_clean();
        }
        ob_start();

        $namafile = 'Report Employeess';
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=Report_Employees.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo "<th>NIP</th>";
        echo "<th>Nama Karyawan</th>";
        echo "<th>Nama Pengguna</th>";
        echo "<th>Perusahaan</th>";
        echo "<th>Departemen</th>";
        echo "<th>Designation</th>";
        echo "<th>Role</th>";
        echo "<th>Posisi</th>";
        echo "<th>Shift</th>";
        echo "<th>Masa Kerja</th>";
        echo "<th>Status</th>";
        echo "<th>Status Pernikahan</th>";
        echo "<th>Email</th>";
        echo "<th>Tgl Bergabung</th>";
        echo "<th>Tgl Terakhir Absen</th>";
        echo "<th>Tgl Resign</th>";
        echo "<th>Gender</th>";
        echo "<th>No Kontak</th>";
        echo "<th>Alamat</th>";
        echo "<th>Kota</th>";
        echo "<th>Provinsi</th>";
        echo "<th>Kode Pos</th>";
        echo "<th>Tempat Lahir</th>";
        echo "<th>Tgl Lahir</th>";
        echo "<th>Ayah</th>";
        echo "<th>Ibu</th>";
        echo "<th>Suami</th>";
        echo "<th>Istri</th>";
        echo "<th>Jumlah Anak</th>";
        echo "<th>Anak</th>";
        echo "<th>No. KK</th>";
        echo "<th>No. KTP</th>";
        echo "<th>Agama</th>";
        echo "<th>No. JKN</th>";
        echo "<th>No. KPJ</th>";
        echo "<th>No. NPWP</th>";
        echo "<th>No. Rekening</th>";
        echo "<th>Kontrak 1</th>";
        echo "<th>Kontrak 2</th>";
        echo "<th>Kontrak 3</th>";
        echo "<th>Kontrak 4</th>";
        echo "<th>Kontrak 5</th>";
        echo "<th>Pendidikan 1</th>";
        echo "<th>Pendidikan 2</th>";
        echo "<th>Pendidikan 3</th>";
        echo "<th>Pendidikan 4</th>";
        echo "<th>Pendidikan 5</th>";
        echo "<th>Pengalaman Kerja 1</th>";
        echo "<th>Pengalaman Kerja 2</th>";
        echo "<th>Pengalaman Kerja 3</th>";
        echo "<th>Pengalaman Kerja 4</th>";
        echo "<th>Pengalaman Kerja 5</th>";
        echo "<th>Dokumen</th>";
        echo "<th>Lokasi Karyawan</th>";
        echo "<th>Atasan</th>";
        echo "<th>MT</th>";
        echo "<th>IQ</th>";
        echo "<th>DISC</th>";
        echo "<th>Attitude</th>";
        echo "<th>Performance</th>";
        echo "<th>Affiliate PT</th>";
        echo "<th>Status Nomer</th>";
        echo '</tr>';
        echo '</thead><tbody>';
        foreach ($datas as $data) {
            echo '<tr>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['NIP'] . '</td>';
            echo '<td>' . $data['nama_karyawan'] . '</td>';
            echo '<td>' . $data['nama_pengguna'] . '</td>';
            echo '<td>' . $data['perusahaan'] . '</td>';
            echo '<td>' . $data['departement'] . '</td>';
            echo '<td>' . $data['penunjukan'] . '</td>';
            echo '<td>' . $data['role_name_old'] . '</td>';
            echo '<td>' . $data['role_name'] . '</td>';
            echo '<td>' . $data['shift'] . '</td>';
            echo '<td>' . $data['masa_kerja'] . '</td>';
            echo '<td>' . $data['status'] . '</td>';
            echo '<td>' . $data['marital_status'] . '</td>';
            echo '<td>' . $data['email'] . '</td>';
            echo '<td>' . $data['tgl_gabung'] . '</td>';
            echo '<td>' . $data['attendance_date'] . '</td>';
            echo '<td>' . $data['tgl_resign'] . '</td>';
            echo '<td>' . $data['jenis_kelamin'] . '</td>';
            echo '<td>' . $data['no_kontak'] . '</td>';
            echo '<td>' . $data['alamat'] . '</td>';
            echo '<td>' . $data['kota'] . '</td>';
            echo '<td>' . $data['provinsi'] . '</td>';
            echo '<td>' . $data['kodepos'] . '</td>';
            echo '<td>' . $data['ctm_tempat_lahir'] . '</td>';
            echo '<td>' . $data['date_of_birth'] . '</td>';
            echo '<td>' . $data['ayah'] . '</td>';
            echo '<td>' . $data['ibu'] . '</td>';
            echo '<td>' . $data['suami'] . '</td>';
            echo '<td>' . $data['istri'] . '</td>';
            echo '<td>' . $data['banyak_anak'] . '</td>';
            echo '<td>' . $data['nama_anak'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['no_kk'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['no_ktp'] . '</td>';
            echo '<td>' . $data['agama'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['no_jkn'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['no_kpj'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['npwp'] . '</td>';
            echo '<td style="mso-number-format:\@;">' . (string)$data['bank_account'] . '</td>';
            echo '<td>' . $data['contract_1'] . '</td>';
            echo '<td>' . $data['contract_2'] . '</td>';
            echo '<td>' . $data['contract_3'] . '</td>';
            echo '<td>' . $data['contract_4'] . '</td>';
            echo '<td>' . $data['contract_5'] . '</td>';
            echo '<td>' . $data['pendidikan_1'] . '</td>';
            echo '<td>' . $data['pendidikan_2'] . '</td>';
            echo '<td>' . $data['pendidikan_3'] . '</td>';
            echo '<td>' . $data['pendidikan_4'] . '</td>';
            echo '<td>' . $data['pendidikan_5'] . '</td>';
            echo '<td>' . $data['wrk_1'] . '</td>';
            echo '<td>' . $data['wrk_2'] . '</td>';
            echo '<td>' . $data['wrk_3'] . '</td>';
            echo '<td>' . $data['wrk_4'] . '</td>';
            echo '<td>' . $data['wrk_5'] . '</td>';
            echo '<td>' . $data['dokumen'] . '</td>';
            echo '<td>' . $data['lokasi_karyawan'] . '</td>';
            echo '<td>' . $data['nama_atasan'] . '</td>';
            echo '<td>' . $data['mt'] . '</td>';
            echo '<td>' . $data['iq'] . '</td>';
            echo '<td>' . $data['disc'] . '</td>';
            echo '<td>' . $data['attitude'] . '</td>';
            echo '<td>' . $data['performance'] . '</td>';
            echo '<td>' . $data['nama_pt'] . '</td>';
            $status_nomer = ($data['status_nomor'] == 1) ? 'Sudah terdaftar' : 'Belum terdaftar';
            echo '<td>' . $status_nomer . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}
