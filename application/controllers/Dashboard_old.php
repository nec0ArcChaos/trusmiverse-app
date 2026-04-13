<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_dashboard");
        $this->load->model("model_dashboard_ibr_pro");
        $this->load->model("Model_dashboard_ibr_pro_calendar");
        $this->load->model("hr/model_rekap_absen", "model_rekap_absen");
        $this->load->model("model_absen", "absen");
        $this->load->model('Model_monday', 'monday');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function test()
    {
        $this->load->library('mobile_detect/Mobile_Detect');
        $detect = new Mobile_Detect();
        $ip = $this->input->ip_address();
        var_dump(md5("12345678"));
        var_dump($ip);
        var_dump($detect->getUserAgent());
    }

    public function index()
    {
        $this->load->library('user_agent');
        $this->load->library('mobile_detect/Mobile_Detect');
        $detect = new Mobile_Detect();
        $ip = $this->input->ip_address();
        $data['ip']               = $detect->getUserAgent();
        $data['user_agent']       = $detect->getUserAgent();
        $data['browser']          = $this->agent->browser() . ' ' . $this->agent->version();
        $data['os']               = $this->agent->platform();
        $data['device']           = $this->agent->mobile();
        $data['team_info']        = $this->model_dashboard->team_info();
        $data['personal_info']    = $this->model_dashboard->personal_info();
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/js_dev";
        $data['css']              = "dashboard/css";
        $data['content']          = "dashboard/index_dev";
        $this->load->view('layout/main', $data);
    }
    public function index_sidiq()
    {
        $this->load->library('user_agent');
        $this->load->library('mobile_detect/Mobile_Detect');
        $detect = new Mobile_Detect();
        $ip = $this->input->ip_address();
        $data['ip']               = $detect->getUserAgent();
        $data['user_agent']       = $detect->getUserAgent();
        $data['browser']          = $this->agent->browser() . ' ' . $this->agent->version();
        $data['os']               = $this->agent->platform();
        $data['device']           = $this->agent->mobile();
        $data['team_info']        = $this->model_dashboard->team_info();
        $data['personal_info']    = $this->model_dashboard->personal_info();
        $data['cek_pin_slip_pass']    = $this->model_dashboard->cek_pin_slip_pass($this->session->userdata('user_id'));
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/js_sidiq";
        $data['css']              = "dashboard/css";
        $data['content']          = "dashboard/index_sidiq";
        $this->load->view('layout/main', $data);
    }

    public function update_password()
    {
        $this->load->library('user_agent');
        $this->load->library('mobile_detect/Mobile_Detect');
        $detect = new Mobile_Detect();
        $ip = $this->input->ip_address();
        $user_agent = $detect->getUserAgent();
        $user_id = strip_tags($this->session->userdata("user_id"));
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $update_password = false;
        $get_password = $this->db->query("SELECT COALESCE(`password`,'') AS `password` FROM xin_employees e WHERE e.user_id = '$user_id'")->row();
        $options = array('cost' => 12);
        if ($get_password->password == "") {
            $hash_password = password_hash($new_password, PASSWORD_BCRYPT, $options);
            $data = [
                'password' => $hash_password,
                'ctm_password'  => md5($new_password),
            ];
            $update_password = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        } else {
            $response['old_password'] = $old_password;
            $response['password'] = $get_password->password;
            $response['password_verify'] = password_verify($old_password,  $get_password->password);
            if (password_verify($old_password,  $get_password->password)) {
                $hash_password = password_hash($new_password, PASSWORD_BCRYPT, $options);
                $data = [
                    'password'      => $hash_password,
                    'ctm_password'  => md5($new_password),
                    'user_agent'  => $user_agent,
                    'last_change_password'  => date("Y-m-d H:i:s"),
                    'ip_change_password'  => $ip,
                ];
                $update_password = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
            }
        }
        if ($update_password) {
            $response['status'] = 'success';
            $response['msg'] = 'password berhasil di update';
        } else {
            $response['status'] = 'failed';
            $response['msg'] = 'password gagal di update (password lama tidak sesuai)';
        }
        echo json_encode($response);
    }

    public function update_ctm_slip()
    {
        $user_id = strip_tags($this->session->userdata("user_id"));
        $old_ctm_pin_slip = $this->input->post('old_ctm_pin_slip');
        $new_ctm_pin_slip = $this->input->post('new_ctm_pin_slip');
        $update_pin_slip = false;
        $get_ctm_pin_slip = $this->db->query("SELECT COALESCE(ctm_pin_slip,'') AS ctm_pin_slip FROM xin_employees e WHERE e.user_id = '$user_id'")->row();
        $options = array('cost' => 12);
        $response['old_ctm_pin_slip'] = $old_ctm_pin_slip;
        $response['ctm_pin_slip'] = $get_ctm_pin_slip->ctm_pin_slip;

        if ($get_ctm_pin_slip->ctm_pin_slip == "") {
            // $hash_ctm_pin_slip = password_hash($new_ctm_pin_slip, PASSWORD_BCRYPT, $options);
            $data = [
                'ctm_pin_slip' => $new_ctm_pin_slip
            ];
            $update_pin_slip = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        } else {
            $response['password_verify'] = $old_ctm_pin_slip == $get_ctm_pin_slip->ctm_pin_slip ? true : false;
            // password_verify($old_ctm_pin_slip,  $get_ctm_pin_slip->ctm_pin_slip)
            if ($old_ctm_pin_slip == $get_ctm_pin_slip->ctm_pin_slip) {
                // $hash_ctm_pin_slip = password_hash($new_ctm_pin_slip, PASSWORD_BCRYPT, $options);
                $data = [
                    'ctm_pin_slip' => $new_ctm_pin_slip
                ];
                $update_pin_slip = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
            }
        }
        if ($update_pin_slip) {
            $response['status'] = 'success';
            $response['msg'] = 'pin slip berhasil di update';
        } else {
            $response['status'] = 'failed';
            $response['msg'] = 'pin slip gagal di update (password lama tidak sesuai)';
        }
        echo json_encode($response);
    }
    public function update_ctm_slip_old()
    {
        $this->load->library('encryption');
        $user_id = strip_tags($this->session->userdata("user_id"));
        $old_ctm_pin_slip = $this->input->post('old_ctm_pin_slip');
        $new_ctm_pin_slip = $this->input->post('new_ctm_pin_slip');
        $update_pin_slip = false;

        $get_ctm_pin_slip = $this->db->query("SELECT COALESCE(ctm_pin_slip,'') AS ctm_pin_slip FROM xin_employees e WHERE e.user_id = '$user_id'")->row();

        if ($get_ctm_pin_slip->ctm_pin_slip == "") {
            $hash_ctm_pin_slip = $this->encryption->encrypt($new_ctm_pin_slip);
            $data = [
                'ctm_pin_slip' => $hash_ctm_pin_slip
            ];
            $update_pin_slip = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        } else {
            $decrypted_pin_slip = $this->encryption->decrypt($get_ctm_pin_slip->ctm_pin_slip);
            if ($old_ctm_pin_slip === $get_ctm_pin_slip->ctm_pin_slip) {
                $hash_ctm_pin_slip = $this->encryption->encrypt($new_ctm_pin_slip);
                $data = [
                    'ctm_pin_slip' => $hash_ctm_pin_slip
                ];
                $update_pin_slip = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
            }
        }

        $response = [];
        if ($update_pin_slip) {
            $response['status'] = 'success';
            $response['msg'] = 'Pin slip berhasil di update';
        } else {
            $response['status'] = 'failed';
            $response['msg'] = 'Pin slip gagal di update (password lama tidak sesuai)';
        }

        echo json_encode($response);
    }

    public function update_personal_info()
    {
        $user_id = strip_tags($this->session->userdata("user_id"));
        $contact_no = strip_tags($this->input->post('contact_no', TRUE));
        $email = strip_tags($this->input->post('email', TRUE));
        $date_of_birth = strip_tags($this->input->post('date_of_birth', TRUE));
        $gender = strip_tags($this->input->post('gender', TRUE));
        $data = [
            'contact_no' => $contact_no,
            'email' => $email,
            'date_of_birth' => $date_of_birth,
            'gender' => $gender,
        ];
        $update = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        if ($update) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'failed';
        }

        echo json_encode($response);
    }

    public function update_profile_picture()
    {
        $user_id = $this->session->userdata("user_id");
        // $user_id = "2063";
        $get_data_profile = $this->model_dashboard->personal_info();
        $old_profile_picture = $get_data_profile->profile_picture;
        if ($old_profile_picture != "") {
            $path_old_profile_picture = $_SERVER["DOCUMENT_ROOT"] . "/hr/uploads/profile/" . $old_profile_picture;
            // echo $old_profile_picture;
            // echo file_exists($path_old_profile_picture);
            if (file_exists($path_old_profile_picture) == 1) {
                // echo "file exist";
                $is_profile_picture_deleted = unlink($path_old_profile_picture);
                if ($is_profile_picture_deleted) {
                    // echo "file berhasil di hapus";
                }
            } else {
                // echo "file doesn't exist";
            }
        }
        if (!empty($_FILES['profile_picture']['name'])) {
            // Proses unggah file
            $config['upload_path']   = $_SERVER["DOCUMENT_ROOT"] . "/hr/uploads/profile/";
            $config['allowed_types'] = 'jpg|png|jpeg|png';
            $new_name = "profile_" . $user_id . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_picture')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = $_SERVER["DOCUMENT_ROOT"] . "/hr/uploads/profile/" . $file_name;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 500;
                $config['height'] = 500;
                $config['new_image'] = $_SERVER["DOCUMENT_ROOT"] . "/hr/uploads/profile/" . $file_name;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
            }
        } else {
            $file_name = "";
        }

        $data_profile_picture = [
            "profile_picture" => $file_name
        ];
        $update_profile_picture = $this->db->where("user_id", $user_id)->update("xin_employees", $data_profile_picture);
        if ($update_profile_picture) {
            $this->session->set_userdata('profile_picture', $file_name);
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
        echo json_encode($response);
    }


    public function update_ttd()
    {
        $user_id = $this->session->userdata("user_id");
        // $user_id = "2063";
        $get_data_profile = $this->model_dashboard->personal_info();
        $old_ttd = $get_data_profile->ttd;
        if ($old_ttd != "") {
            $path_old_ttd = $_SERVER["DOCUMENT_ROOT"] . "/apps/uploads/ttd/" . $old_ttd;
            // echo $old_ttd;
            // echo file_exists($path_old_ttd);
            if (file_exists($path_old_ttd) == 1) {
                // echo "file exist";
                $is_ttd_deleted = unlink($path_old_ttd);
                if ($is_ttd_deleted) {
                    // echo "file berhasil di hapus";
                }
            } else {
                // echo "file doesn't exist";
            }
        }
        if (!empty($_FILES['ttd']['name'])) {
            // Proses unggah file
            $config['upload_path']   = $_SERVER["DOCUMENT_ROOT"] . "/apps/uploads/ttd/";
            $config['allowed_types'] = 'jpg|png|jpeg|png';
            $new_name = "ttd_" . $user_id;
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('ttd')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = $_SERVER["DOCUMENT_ROOT"] . "/apps/uploads/ttd/" . $file_name;
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['quality'] = '60%';
                $config['width'] = 500;
                $config['height'] = 500;
                $config['new_image'] = $_SERVER["DOCUMENT_ROOT"] . "/apps/uploads/ttd/" . $file_name;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
            }
        } else {
            $file_name = "";
        }

        $data_ttd = [
            "ttd" => $file_name
        ];
        $update_ttd = $this->db->where("user_id", $user_id)->update("xin_employees", $data_ttd);
        if ($update_ttd) {
            $this->session->set_userdata('ttd', $file_name);
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
        echo json_encode($response);
    }


    public function update_profile_background()
    {
        $user_id = $this->session->userdata("user_id");
        $profile_background = $this->input->post("profile_background", TRUE);
        $data_profile_background = [
            "profile_background" => $profile_background
        ];
        if ($user_id != "") {
            $update_profile_picture = $this->db->where("user_id", $user_id)->update("xin_employees", $data_profile_background);
        }
        if ($update_profile_picture) {
            $response['status'] = "success";
        } else {
            $response['status'] = "failed";
        }
        echo json_encode($response);
    }


    public function my_dashboard()
    {
        $data['team_info']    = $this->model_dashboard->team_info();
        $data['personal_info']    = $this->model_dashboard->personal_info();
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/js_new";
        $data['css']              = "dashboard/css_new";
        $data['content']          = "dashboard/index_new";
        $this->load->view('layout/main', $data);
    }

    public function mkt()
    {
        $data['pageTitle']        = "Dashboard MKT";
        $data['js']               = "dashboard/mkt/js_new";
        $data['css']              = "dashboard/mkt/css";
        $data['content']          = "dashboard/mkt/index";
        $this->load->view('layout/main', $data);
    }
    public function hr($userid, $periode = null)
    {
        $data['pageTitle']        = "Dashboard Human Resorce";
        $data['js']               = "dashboard/hr/js";
        $data['css']              = "dashboard/hr/css";
        $data['content']          = "dashboard/hr/index";
        $this->load->view('layout/main', $data);
    }

    public function mkt_v1()
    {
        $data['pageTitle']        = "Dashboard MKT";
        $data['js']               = "dashboard/mkt/js";
        $data['css']              = "dashboard/mkt/css";
        $data['content']          = "dashboard/mkt/index_v1";
        $this->load->view('layout/main', $data);
    }

    public function v2()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/v2/js";
        $data['css']              = "dashboard/v2/css";
        $data['content']          = "dashboard/v2/index";
        $this->load->view('layout/main', $data);
    }

    public function mkt_std_event()
    {
        $data['pageTitle']        = "Dashboard MKT";
        $data['js']               = "dashboard/mkt_std_event/js";
        $data['css']              = "dashboard/mkt_std_event/css";
        $data['content']          = "dashboard/mkt_std_event/index";
        $this->load->view('layout/main', $data);
    }

    // By Faisal
    public function dash_dev()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dash_dev/js";
        $data['css']              = "dash_dev/css";
        $data['content']          = "dash_dev/index";
        $this->load->view('layout/main', $data);
    }

    // DASHBOARD IBR PRO
    // BY SAID
    public function ibr_pro()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/ibr_pro/js";
        $data['css']              = "dashboard/ibr_pro/css";
        $data['content']          = "dashboard/ibr_pro/index";
        $this->load->view('layout/main', $data);
    }

    public function ibr_pro_profile()
    {
        if (isset($_POST['user_id'])) {
            if ($_POST['user_id'] != "") {
                $user_id = $_POST['user_id'];
            } else {
                $user_id = $_SESSION['user_id'];
            }
        } else {
            $user_id = $_SESSION['user_id'];
        }

        // $start = $this->input->post('start') ?? date("Y-m-01");
        // $end = $this->input->post('end') ?? date("Y-m-d");

        $data_profile = $this->model_dashboard_ibr_pro->ibr_pro_profile($user_id);
        $id_tasks = explode(",", $data_profile['id_task']);
        $strategy = [];
        $goals_data = [];
        $goals = [];
        $consistency = 0;
        foreach ($id_tasks as $key => $value) {

            $sttg = $this->monday->dt_sub_task($value);

            $data_goals = $this->model_dashboard_ibr_pro->get_goals($value);
            $goals_data = [
                'id_task' => $data_goals['id_task'],
                'goal' => $data_goals['task'],
                'strategy' => $sttg,
                'evaluasi' => $data_goals['evaluasi'],
            ];
            array_push($goals, $goals_data);

            // array_push($strategy,  $this->monday->dt_sub_task($value));
            array_push($strategy,  $sttg);
        }
        // $data_consistency = $this->model_dashboard_ibr_pro->get_consistency($user_id);
        // foreach ($data_consistency as $key => $cns) {
        //     $consistency += $cns->consistency;
        // }
        // if (COUNT($data_consistency) < 1) {
        //     $count_data_cosistency = 1;
        // } else {
        //     $count_data_cosistency = COUNT($data_consistency);
        // }
        // $percent_consistency = $consistency / $count_data_cosistency;

        $data['profile'] = $data_profile;
        $data['cns'] = $consistency;
        // $data['count_data_cosistency'] = $count_data_cosistency;
        // $data['consistency'] = $percent_consistency;
        $data['goals'] = $goals;
        // $data['id_tasks'] = $count_data_cosistency;
        // $data['start'] = $start;
        // $data['end'] = $end;
        echo json_encode($data);
    }

    public function ibr_pro_list()
    {
        $data['pageTitle']        = "IBR Pro List";
        $data['js']               = "dashboard/ibr_pro/list/js";
        $data['css']              = "dashboard/ibr_pro/list/css";
        $data['content']          = "dashboard/ibr_pro/list/index";
        $this->load->view('layout/main', $data);
    }

    public function ibr_pro_list_data()
    {
        $data_profile = $this->model_dashboard_ibr_pro->ibr_pro_list_data();

        $profile_data = [];
        // $consistency = 0;
        foreach ($data_profile as $key => $value) {

            $data_consistency = $this->model_dashboard_ibr_pro->get_consistency($value->user_id);

            $profile = [
                'id_task' => $value->id_task,
                'task' => $value->task,
                'user_id' => $value->user_id,
                'employee_name' => $value->employee_name,
                'jabatan' => $value->jabatan,
                'photo_profile' => $value->photo_profile,
                'logo_perushaan' => $value->logo_perushaan,
                'goal' => $value->goal,
                'strategy' => $value->strategy,
                'consistency' => $data_consistency[0]->consistency,
            ];

            array_push($profile_data, $profile);
        }

        $data['profile'] = $profile_data;

        echo json_encode($data);
    }



    public function ibr_pro_calendar()
    {
        if (isset($_POST['user_id'])) {
            if ($_POST['user_id'] != "") {
                $user_id = $_POST['user_id'];
            } else {
                $user_id = $_SESSION['user_id'];
            }
        } else {
            $user_id = $_SESSION['user_id'];
        }
        $data = $this->Model_dashboard_ibr_pro_calendar->ibr_pro_calendar_v2($user_id);
        echo json_encode($data);
    }

    public function ibr_pro_calendar_detail()
    {
        $id_sub_task = $this->input->post('id_sub_task') ?? "";
        $response['detail'] = "";
        $response['status'] = false;
        if ($id_sub_task != "") {
            $response['detail'] = $this->Model_dashboard_ibr_pro_calendar->ibr_pro_calendar_v2_detail($id_sub_task);
            $response['status'] = true;
        }
        echo json_encode($response);
    }
    // DASHBOARD IBR PRO

    public function mobile()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/mobile/js";
        $data['css']              = "dashboard/mobile/css";
        $data['content']          = "dashboard/mobile/index";
        $this->load->view('layout/main', $data);
    }

    public function update_contact_no()
    {
        $user_id = $this->session->userdata('user_id');
        $contact_no = $this->input->post('contact_no');
        $data = [
            'contact_no' => $contact_no
        ];
        $status_update = $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        $response['status'] = $status_update;
        echo json_encode($response);
    }

    public function dev()
    {
        $data['pageTitle']        = "Dashboard";
        $data['js']               = "dashboard/js_dev";
        $data['css']              = "dashboard/css";
        $data['content']          = "dashboard/index_dev";
        $this->load->view('layout/main', $data);
    }

    public function resume_absen_old()
    {
        $data = $this->model_dashboard->resume_absen_new();
        echo json_encode($data);
    }

    public function resume_absen()
    {

        $periode = $this->input->post('periode');
        $allowed_akses = ['2063', '1', '979'];
        $user_id = $this->session->userdata("user_id");
        if (in_array($user_id, $allowed_akses)) {
            $employee_id = $this->input->post('employee_id');
            $emp = $this->db->query("SELECT company_id, department_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
            $company_id = $emp->company_id;
            $department_id = $emp->department_id;
        } else {
            $employee_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_id");
            $department_id = $this->session->userdata("department_id");
        }
        $month = date("m", strtotime($periode));

        if ($month == date("m") && date("d") <= 20) {
            $end_harus_hadir = date("Y-m-d", strtotime(date("Y-m-d") . " -1 days"));
        } else {
            if ($company_id == 3) {
                $end_harus_hadir = date("Y-m-16", strtotime($periode . "-01"));
            } else {
                $end_harus_hadir = date("Y-m-20", strtotime($periode . "-01"));
            }
        }

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        // if (in_array($this->session->userdata('posisi'), array('Direktur', 'Head', 'Manager'))) {
        //     $posisi = "'Direktur', 'Head', 'Manager', 'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
        //     $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi);
        // } else if (in_array($this->session->userdata('posisi'), array('Assistent Manager', 'Supervisor'))) {
        //     $posisi = "'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
        //     $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi);
        // } else {
        $sub_emp = 0;
        // }


        if ($company_id == 3) {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date($periode . "-15");
        } else {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date($periode . "-20");
        }

        // $response['temp'] = $start . "," . $end . "," . $company_id . "," . $department_id . "," . $employee_id . "," .  $sub_emp;
        $response['data'] = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id,  $sub_emp)->row(0);
        $response['total_hadir'] = $this->model_rekap_absen->get_absensi($start, $end_harus_hadir, $company_id, $department_id, $employee_id,  $sub_emp)->row(0);
        $response['total_warning'] = $this->total_warning();
        $response['month'] =  $month;
        $response['periode'] = $periode;
        $response['today'] = $today;
        $response['start'] = $start;
        $response['end_today'] = $end_harus_hadir;
        echo json_encode($response);
    }

    public function detail_absen()
    {
        if ($this->session->userdata("user_id") == '2063' || $this->session->userdata("user_id") == '1' || $this->session->userdata("user_role_id") == '1') {
            $employee_id = $this->input->post('employee_id');
        } else {
            $employee_id = $this->session->userdata("user_id");
        }
        $data['data'] = $this->model_dashboard->detail_absen($this->input->post('periode') ?? date("Y-m"), $employee_id);
        echo json_encode($data);
    }

    public function get_employee_id()
    {
        $data = $this->model_dashboard->get_employee_id();
        echo json_encode($data);
    }

    public function get_leave_type()
    {
        $response['leave_type'] = $this->model_dashboard->get_leave_type();
        $response['kota'] = $this->model_dashboard->get_kota();
        echo json_encode($response);
    }

    public function add_leave()
    {

        if ($this->input->post('leave_type') != '') {
            /* Define return | here result is used to return user data and error for error message */
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $remarks = $this->input->post('remarks');

            $st_date = strtotime($start_date);
            $ed_date = strtotime($end_date);
            $qt_remarks = htmlspecialchars(addslashes($remarks), ENT_QUOTES);

            $day = date('d', strtotime($start_date));
            if ((int)$day < 21) {
                $start = date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m', $st_date) . '-21')));
                $end = date('Y-m-20');
            } else {
                $start = date('Y-m-21');
                $end = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-20'))));
            }

            $pc_dt = "(10, 11)";
            $total_pc_dt = $this->model_dashboard->cek_leave($this->session->userdata('user_id'), $start, $end, $pc_dt);

            $bersalin = "(8)";
            $total_bersalin = $this->model_dashboard->cek_leave($this->session->userdata('user_id'), $start, $end, $bersalin);

            $sakit_dk = "(21)";
            $total_sakit_dk = $this->model_dashboard->cek_leave($this->session->userdata('user_id'), $start, $end, $sakit_dk);

            $sakit_lk = "(22)";
            $total_sakit_lk = $this->model_dashboard->cek_leave($this->session->userdata('user_id'), $start, $end, $sakit_lk);

            $kematian_kl = "(9)";
            $total_kematian_kl = $this->model_dashboard->cek_leave($this->session->userdata('user_id'), $start, $end, $kematian_kl);

            $driver    = $this->model_dashboard->cek_driver($this->session->userdata('user_id'), $start, $end);


            /* Server side PHP input validation */
            if ($this->input->post('leave_type') === '') {
                $Return['error'] = "Leave Type is Empty";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }

            if (($this->input->post('leave_type') == 10 || $this->input->post('leave_type') == 11) && $total_pc_dt >= 3) {
                $Return['error'] = "Pengajuan Datang Terlambat dan Pulang Cepat Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 8 && $total_bersalin >= 2) {
                $Return['error'] = "Pengajuan Istri Bersalin / Keguguran Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 21 && $total_sakit_dk >= 1) {
                $Return['error'] = "Pengajuan Istri/Suami/Anak Sakit (Dalam Kota) Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 22 && $total_sakit_lk >= 2) {
                $Return['error'] = "Pengajuan Istri/Suami/Anak Sakit (Luar Kota) Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 9 && $total_kematian_kl >= 2) {
                $Return['error'] = "Pengajuan Kematian Keluarga Melebihi Batas Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('leave_type') == 7 && $this->input->post('tgl_ph') == "") {
                $Return['error'] = "Harap Isi Tgl Pergantian Hari Libur.";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            // check libur dan dlk
            if ($this->input->post('leave_type') == 7 && $this->input->post('tgl_ph') != "") {
                $tgl_ph = $this->input->post('tgl_ph');
                $user_id = $this->session->userdata('user_id');
                $check_dlk =  $this->db->query("SELECT COUNT(employee_id) AS libur FROM `xin_leave_applications` WHERE leave_type_id = 13 AND '$tgl_ph' BETWEEN SUBSTR(from_date,1,10) AND SUBSTR(to_date,1,10) AND employee_id = $user_id")->row_array();
                $check_masuk =  $this->db->query("SELECT COUNT(employee_id) AS masuk FROM `xin_attendance_time` WHERE attendance_date = '$tgl_ph' AND employee_id = $user_id AND clock_in IS NOT NULL AND clock_out IS NOT NULL")->row_array();
                if ($check_masuk['masuk'] > 1 || $check_dlk > 1) {
                } else {
                    $Return['error'] = "Maaf anda tidak memenuhi syarat pergantian hari libur.";
                    $Return['status'] = false;
                    echo json_encode($Return);
                    exit();
                }
            }
            if ($this->input->post('leave_type') == 24 && $driver['driver'] == 0) {
                $Return['error'] = "Kelebihan Jam Kerja Belum Mencapai " . $driver['max_work'] . " Jam Per Cut Off " . $start . ' s/d ' . $end;
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('start_date') === '') {
                $Return['error'] = 'start_date';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('end_date') === '') {
                $Return['error'] = 'end_date';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if (($this->input->post('leave_type') == 13 || $this->input->post('leave_type') == 23) && $this->input->post('kota') === "") {
                $Return['error'] = "Harap Pilih Kota Tujuan.";
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($st_date > $ed_date) {
                $Return['error'] = 'start_end_date is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->session->userdata('company_id') === '') {
                $Return['error'] = 'any_field is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->session->userdata('user_id') === '') {
                $Return['error'] = 'employee_id is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }
            if ($this->input->post('reason') === '') {
                $Return['error'] = 'leave_type_reason is empty';
                $Return['status'] = false;
                echo json_encode($Return);
                exit();
            }

            if ($this->input->post('leave_half_day') != 1) {
                $leave_half_day_opt = 0;
            } else {
                $leave_half_day_opt = $this->input->post('leave_half_day');
            }
            if (!empty($_FILES['attachment']['tmp_name'])) {
                if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                    //checking image type
                    $allowed =  array('png', 'jpg', 'jpeg', 'pdf', 'gif');
                    $filename = $_FILES['attachment']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["attachment"]["tmp_name"];
                        $profile = "/opt/lampp/htdocs/hr/uploads/leave/";
                        // $profile = "/uploads/leave/";
                        $set_img = base_url() . "uploads/leave/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $name = basename($_FILES["attachment"]["name"]);
                        $newfilename = 'tv_leave_' . round(microtime(true)) . '.' . $ext;
                        move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                    } else {
                        $Return['error'] = '';
                    }
                }
            } else {
                $fname = '';
            }

            $tgl_ph = (isset($_POST['tgl_ph'])) ? $_POST['tgl_ph'] : NULL;
            $kota = (isset($_POST['kota'])) ? $_POST['kota'] : NULL;

            if ($this->input->post('leave_type') == 13 || $this->input->post('leave_type') == 23 || $this->input->post('leave_type') == 20) {
                $data = array(
                    'employee_id' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'department_id' => $this->session->userdata('department_id'),
                    'leave_type_id' => $this->input->post('leave_type'),
                    'from_date' => substr($this->input->post('start_date'), 0, 10),
                    'start_time' => substr($this->input->post('start_date'), 11, 5),
                    'to_date' => substr($this->input->post('end_date'), 0, 10),
                    'end_time' => substr($this->input->post('end_date'), 11, 5),
                    'applied_on' => date('Y-m-d h:i:s'),
                    'reason' => $this->input->post('reason'),
                    'remarks' => $qt_remarks,
                    'leave_attachment' => $fname,
                    'status' => '1',
                    'is_notify' => '1',
                    'is_half_day' => $leave_half_day_opt,
                    'tgl_ph' => $tgl_ph,
                    'kota' => $kota,
                    'created_at' => date('Y-m-d h:i:s')
                );
            } else {
                $data = array(
                    'employee_id' => $this->session->userdata('user_id'),
                    'company_id' => $this->session->userdata('company_id'),
                    'department_id' => $this->session->userdata('department_id'),
                    'leave_type_id' => $this->input->post('leave_type'),
                    'from_date' => $this->input->post('start_date'),
                    'to_date' => $this->input->post('end_date'),
                    'applied_on' => date('Y-m-d h:i:s'),
                    'reason' => $this->input->post('reason'),
                    'remarks' => $qt_remarks,
                    'leave_attachment' => $fname,
                    'status' => '1',
                    'is_notify' => '1',
                    'is_half_day' => $leave_half_day_opt,
                    'tgl_ph' => $tgl_ph,
                    'created_at' => date('Y-m-d h:i:s')
                );
            }

            $Return['status'] = true;
            $Return['data'] = $data;
            $result = $this->model_dashboard->add_leave_record($data);
            $Return['result'] = $result;
            echo json_encode($Return);
        }
    }

    public function check_lock_absen()
    {
        $user_id = $this->input->post("user_id");
        $this->check_absen($user_id);
    }

    public function resume_izin_leave()
    {
        $user_id = $this->session->userdata("user_id");
        $data = $this->model_dashboard->resume_izin_leave($user_id);
        echo json_encode($data);
    }


    public function index_get($user_id)
    {
        // $user_id	= $this->uri->segment(3);
        $cek_department = $this->absen->cek_department($user_id);
        $last_month = date("Y-m-01", strtotime("-1 month"));
        $date_of_joining = date("Y-m-01", strtotime($cek_department['date_of_joining']));
        $hours = (int)date("H");
        $department_id  = $cek_department['department_id'];
        $company_id     = $cek_department['company_id'];
        $cek             = $this->absen->get_status($user_id);

        // Lock EAF
        $cek_user_approval    = $this->absen->get_user_approval_eaf($user_id);
        $query_lock_user_approval    = $this->absen->get_lock_eaf($user_id);

        // Lock MEP 08-05-2023
        $cek_designation     = $this->absen->cek_designation($user_id);
        $designation_id     = $cek_designation['designation_id'];
        $lock_user_mep        = $this->absen->get_lock_mep($user_id);

        if (($cek_user_approval == true && $query_lock_user_approval == true)) {
            $lock_user_approval = $query_lock_user_approval;
            if ($lock_user_approval['id'] == '0' || $lock_user_approval['id'] == 0) {
                $id_lock = 35; // trusmi lock di tabel trusmi_m_lock
            } else {
                $id_lock = $lock_user_approval['id'];
            }
            return $this->response([
                'status' => false,
                'data' => array(
                    'aktif' => '1',
                    'achive' => false,
                    'message' => $lock_user_approval['warning_lock'],
                    'no' => 1
                )
            ], 200);

            // disable 08-05-2023 Faisal , enable again 22-05-2023
        } else if ($designation_id == 547 && $lock_user_mep == true) {
            return  $this->response([
                'status' => false,
                'data' => array(
                    'aktif' => '1',
                    'achive' => false,
                    'message' => $lock_user_mep['warning_lock'],
                    'no' => 2
                )
            ], 200);
        } else if ($date_of_joining >= $last_month && $company_id == 2 &&  $hours > 12) {
            // Aris
            $query_kry_training = $this->absen->cek_karyawan_basic_training($user_id);
            $count_kry = $query_kry_training->num_rows();
            if ($count_kry > 0) {
                $d_kry_basic = $query_kry_training->row();
                $msg = $d_kry_basic->warning_lock . ", " . $d_kry_basic->ket;
                return $this->response(
                    [
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => false,
                            'message' => $msg,
                            'no' => 3
                        )
                    ],
                    200
                );
            } else if ($company_id == 2 && $department_id == 120 && $hours > 12) {
                $query_kry_training_mkt = $this->absen->cek_karyawan_basic_training_mkt($user_id);
                $count_kry_mkt = $query_kry_training_mkt->num_rows();
                if ($count_kry_mkt > 0) {
                    $d_kry_basic_mkt = $query_kry_training_mkt->row();
                    $msg = $d_kry_basic_mkt->warning_lock . ", " . $d_kry_basic_mkt->ket;
                    return $this->response(
                        [
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $msg,
                                'no' => 4
                            )
                        ],
                        200
                    );
                } else {
                    $this->lock_absen($user_id, $company_id, $department_id, $cek);
                }
            } else {
                $this->lock_absen($user_id, $company_id, $department_id, $cek);
            }
        } else {
            $this->lock_absen($user_id, $company_id, $department_id, $cek);
        }
    }

    function response($data)
    {
        echo json_encode($data);
    }

    public function lock_absen($user_id, $company_id, $department_id, $cek)
    {
        if (
            $department_id == 24 /* marketing */
            || $department_id == 28 /* project */
            || $department_id == 120 /* marketing executive */
            || $department_id == 27 /* Finance */
            || $department_id == 134 /* aftersales */
            || $department_id == 138 /* SCM */
            || $department_id == 147 /* PURCHASING BT */
            || $department_id == 14 /* STORE BT */
            || $department_id == 9 /* STORE WH BT */
            || $department_id == 106 /* Project Housing */
            // || $department_id == 107 /* Project Infrastruktur Area 2 */
            // || $department_id == 111 /* Surveyor */
            || $department_id == 95 /* SCM BT */
        ) {
            if ($cek) { // user is active
                $cek_mkt        = $this->absen->cek_mkt($user_id, $department_id)->row_array();
                if ($cek_mkt['divisi'] == 2) { // 2 : MARKETING
                    if ($cek_mkt['total'] > 4) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 5
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => false,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 6
                            )
                        ], 200);
                    }
                } else if ($cek_mkt['divisi'] == 11) { // 11 : PELAKSANA
                    if ($cek_mkt['total'] > 0 || $cek_mkt['created_at'] == null) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 7
                            )
                        ], 200);
                    } else {
                        // if ($cek_mkt['spv'] == 1) {
                        // 	$id_lock = '3';
                        // 	$msg = 'Anda belum melakukan approval Peringatan Vendor atau Approval Bahan. Harap melakukan approval terlebih dahulu.';
                        // } else {
                        // 	$id_lock = '3';
                        // 	$msg = 'Anda belum mencapai minimum target tasklist, Harap penuhi target tasklist anda.';
                        // }
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                // 'message' => 'Anda belum mengerjakan tasklist, Harap kerjakan tasklist terlebih dahulu.'
                                // 'message' => $msg,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 8
                            )
                        ], 200);
                    }

                    // // 8-5-23
                } else if ($cek_mkt['divisi'] == 1477) { // 1477 : PURCHASING CRB BT
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => 9
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                // 'message' => 'Anda belum mengerjakan tasklist, Harap kerjakan tasklist terlebih dahulu.'
                                'message' => '',
                                'no' => 10
                            )
                        ], 200);
                    }
                } else if ($cek_mkt['divisi'] == 1400) { // 1477 : STORE CRB BT
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock'],
                                'no' => '11'
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => '',
                                'no' => 12
                            )
                        ], 200);
                    }

                    // // 8-5-23
                } else if ($cek_mkt['divisi'] == 9500) { // 1477 : CRB BT SCM
                    if ($cek_mkt['absen'] > 0) {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => false,
                                'message' => $cek_mkt['warning_lock']
                            )
                        ], 200);
                    } else {
                        return $this->response([
                            'status' => true,
                            'data' => array(
                                'aktif' => $cek['is_active'],
                                'achive' => true,
                                'message' => ''
                            )
                        ], 200);
                    }
                } else {
                    // lock absen admin collect
                    // if (in_array($user_id, ['1031', '2915', '2921'])) {
                    // 	// 1031	Herman
                    // 	// 2915	Favian Andre Lukita 
                    // 	// 2921	Danang Budiharjo 
                    // 	$hours = (int)date("H"); // '20'
                    // 	$cek_adm_collect		= $this->absen->cek_adm_collect($user_id)->row();
                    // 	$msg = $cek_adm_collect->warning_lock . " Ach anda " . $cek_adm_collect->total . "%" . " (" . $cek_adm_collect->actual . "/" . $cek_adm_collect->target . ")";
                    // 	if ($cek_adm_collect->total >= 100 && $hours > 11) {
                    // 		return $this->response(
                    // 			[
                    // 				'status' => true,
                    // 				'data' => array(
                    // 					'aktif' => $cek['is_active'],
                    // 					'achive' => true,
                    // 					'message' => ''
                    // 				)
                    // 			],
                    // 			200
                    // 		);
                    // 	} else {
                    // 		// history lock
                    // 		$this->insert_history(
                    // 			[
                    // 				'employee_id' => $user_id,
                    // 				'lock_type'   => $cek_adm_collect->id_lock,
                    // 				'reason'      => $msg,
                    // 				'created_at'  => date("Y-m-d H:i:s"),
                    // 			]
                    // 		);
                    // 		return $this->response(
                    // 			[
                    // 				'status' => true,
                    // 				'data' => array(
                    // 					'aktif' => $cek['is_active'],
                    // 					'achive' => false,
                    // 					'message' => $msg
                    // 				)
                    // 			],
                    // 			200
                    // 		);
                    // 	}
                    // } else {
                    return $this->response([
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => true,
                            'message' => '',
                            'no' => 13
                        )
                    ], 200);
                    // }
                }
            } else {
                return $this->response([
                    'status' => false,
                    'message' => "ID Tidak Ditemukan"
                ], 404);
            }
        } else {


            // cek jam saat ini
            // $dt = date_create("Y-m-d H:i:s", date("Y-m-d H:i:s"));

            // } else if ($query_kry_training->num_rows() > 0 &&  $hours > 14) {
            // 	$d_kry_basic = $query_kry_training->row();
            // 	$msg = $d_kry_basic->warning_lock . ", " . $d_kry_basic->ket;
            // 	$this->response(
            // 		[
            // 			'status' => true,
            // 			'data' => array(
            // 				'aktif' => $cek['is_active'],
            // 				'achive' => false,
            // 				'message' => $msg
            // 			)
            // 		],
            // 		200
            // 	);

            // 08-05-2023 Aris
            // $query_kry_training = $this->absen->cek_karyawan_basic_training($user_id);
            if ($company_id == 2 && in_array($user_id, ['1995', '2535', '2897', '3325']) && in_array($department_id, ['142', '72'])) {
                // Aris
                // 1995	Okawati Nurahma Sari department 72
                // 2535	Nani Handayani department 72
                // 1621	Yan Mugi Satriyo department 142
                // 2897	Riyan Gunawan department 72
                $this->validasi_lock_absen_hr($user_id, $cek);
            } else {
                return $this->response(
                    [
                        'status' => true,
                        'data' => array(
                            'aktif' => $cek['is_active'],
                            'achive' => true,
                            'message' => '',
                            'no' => 14
                        )
                    ],
                    200
                );
            }
            // return $this->response(
            // 	[
            // 		'status' => true,
            // 		'data' => array(
            // 			'aktif' => $cek['is_active'],
            // 			'achive' => true,
            // 			'message' => ''
            // 		)
            // 	],
            // 	200
            // );
        }
    }
    public function validasi_lock_absen_hr($user_id, $cek)
    {
        $dhr = $this->absen->cek_hr($user_id);
        $cek_hr        = $dhr->row();
        $msg = $cek_hr->warning_lock . " Ach anda " . $cek_hr->total . "%" . " (" . $cek_hr->actual . "/" . $cek_hr->target . ")";
        if ($cek_hr->total >= 100) {
            return    $this->response(
                [
                    'status' => true,
                    'data' => array(
                        'aktif' => $cek['is_active'],
                        'achive' => true,
                        'message' => '',
                    )
                ],
                200
            );
        } else {
            return    $this->response(
                [
                    'status' => true,
                    'data' => array(
                        'aktif' => $cek['is_active'],
                        'achive' => false,
                        'message' => $msg
                    )
                ],
                200
            );
        }
    }

    public function check_lock_absen_dev()
    {
        $user_id = $this->input->post("user_id");
        $response = $this->check_absen($user_id);
        echo ($response);
    }

    function check_absen_dev($user_id = null)
    {
        $getProfile = $this->getProfile($user_id);
        $profile = $getProfile->row_array();
        $company_id = $profile['company_id'];
        $department_id = $profile['department_id'];

        $this->isUserValid($getProfile->num_rows());
    }

    public function check_absen($user_id)
    {
        $getProfile = $this->getProfile($user_id);
        $profile = $getProfile->row_array();
        $company_id = $profile['company_id'];
        $department_id = $profile['department_id'];

        $this->isUserValid($getProfile->num_rows());
        $this->isUserActive($profile['is_active']);

        $jam = (int) Date("H");
        $awlBulanLalu = date("Y-m-01", strtotime("-1 month"));
        $dateOfJoining = date("Y-m-01", strtotime($profile['date_of_joining']));
        $isCompanyRsp = in_array($company_id, ['2']) && $jam > 14 && $dateOfJoining >= $awlBulanLalu ? true : false;
        if ($isCompanyRsp) {
            $this->isBasicTrainingKaryawanRsp($user_id);
        }

        // lock basic training mkt rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $this->isBasicTrainingMarketingLock($user_id);
        }

        // lock hr rsp
        $isDepartmentHrRsp = in_array($department_id, ['142', '72']) ? true : false;
        if ($isDepartmentHrRsp) {
            $this->isHrRspLock($user_id);
        }

        // lock pelaksana
        $isDepartmentPelaksana = in_array($department_id, ['106', '107', '111', '28']) ? true : false;
        if ($isDepartmentPelaksana) {
            $this->isPelaksanaLock($user_id);
        }

        // lock purchasing bt
        $isDepartmentPurchasingBt = in_array($department_id, ['147']) ? true : false;
        if ($isDepartmentPurchasingBt) {
            $this->isPurchasingBtLock($user_id);
        }

        // lock store bt
        $isDepartmentStoreBt = in_array($department_id, ['14', '9']) ? true : false;
        if ($isDepartmentStoreBt) {
            $this->isStoreBtLock($user_id);
        }

        // lock crb bt scm
        $isDepartmentScmBt = in_array($department_id, ['95']) ? true : false;
        if ($isDepartmentScmBt) {
            $this->isScmBtLock($user_id);
        }

        // lock marketing rsp
        $isDepartmentMarketing = in_array($department_id, ['120']) ? true : false;
        if ($isDepartmentMarketing) {
            $this->isMarketingLock($user_id);
        }

        echo json_encode(array(
            'aktif' => 1,
            'achieve' => true,
            'message' => ''
        ));
    }

    private function getProfile($user_id = null)
    {
        $profile = $this->absen->getProfile($user_id);
        return $profile;
    }

    private function isUserActive($is_active)
    {
        if ($is_active == 0) {
            $message = "User anda telah di Nonaktifkan";
            echo json_encode(array(
                'aktif' => 0,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isUserValid($num_rows)
    {
        if ($num_rows < 1) {
            $message = "User tidak ditemukan";
            echo json_encode(array(
                'aktif' => 0,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isPelaksanaLock($user_id)
    {
        $pelaksana = $this->absen->isPelaksanaLock($user_id)->row_array();
        if ($pelaksana['total'] < 1 || $pelaksana['created_at'] != null) {
            $message = $pelaksana['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isPurchasingBtLock($user_id)
    {
        $purchasingBt = $this->absen->isPurchasingBtLock($user_id)->row_array();
        if ($purchasingBt['absen'] > 0) {
            $message = $purchasingBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isStoreBtLock($user_id)
    {
        $storeBt = $this->absen->isStoreBtLock($user_id)->row_array();
        if ($storeBt['absen'] > 0) {
            $message = $storeBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isScmBtLock($user_id)
    {
        $storeBt = $this->absen->isScmBtLock($user_id)->row_array();
        if ($storeBt['absen'] > 0) {
            $message = $storeBt['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isMarketingLock($user_id)
    {
        $marketingRsp = $this->absen->isMarketingLock($user_id)->row_array();
        if ($marketingRsp['total'] < 5) {
            $message = $marketingRsp['warning_lock'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isHrRspLock($user_id)
    {
        $result = true;
        $hrRsp = $this->absen->isHrRspLock($user_id);
        if ($hrRsp->num_rows() > 0) {
            if ($hrRsp['total'] < 100) {
                $message = $hrRsp['warning_lock'] . " Ach anda " . $hrRsp['total'] . "%" . " (" . $hrRsp['actual'] . "/" . $hrRsp['target'] . ")" ?? '';
                echo json_encode(array(
                    'aktif' => 1,
                    'achieve' => false,
                    'message' => $message
                ));
                die();
            }
        }
    }

    private function isBasicTrainingKaryawanRsp($user_id)
    {
        $basicTrainingKryRsp = $this->absen->isBasicTrainingKaryawanRsp($user_id);
        if ($basicTrainingKryRsp->num_rows() > 0) {
            $data = $basicTrainingKryRsp->row_array();
            $message = $data['warning_lock'] . ", " . $data['ket'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function isBasicTrainingMarketingLock($user_id)
    {
        $basicTrainingMkt = $this->absen->isBasicTrainingMarketingLock($user_id);
        if ($basicTrainingMkt->num_rows() > 0) {
            $data = $basicTrainingMkt->row_array();
            $message = $data['warning_lock'] . ", " . $data['ket'] ?? '';
            echo json_encode(array(
                'aktif' => 1,
                'achieve' => false,
                'message' => $message
            ));
            die();
        }
    }

    private function getResponseData($status, $is_active, $achieve, $message, $statusCode = 200)
    {
        return $this->response([
            'status' => $status,
            'data' => [
                'aktif' => ($is_active) ? $is_active : 0,
                'achive' => ($achieve) ? $achieve : false,
                'message' => $message,
            ]
        ], $statusCode);
    }

    function get_rekening()
    {
        $employee_id = $this->session->userdata("user_id");
        $getRekening = $this->db->query("SELECT
                                            e.user_id,
                                            COALESCE ( b.account_number, 'Belum Registrasi' ) AS account_number,
                                            COALESCE ( b.bank_name, '-' ) AS bank_name,
                                            COALESCE ( b.account_title, '-' ) AS account_title,
                                            COALESCE ( b.created_at, '-' ) AS created_at
                                        FROM
                                            xin_employees e
                                            LEFT JOIN xin_employee_bankaccount b ON b.employee_id = e.user_id 
                                        WHERE e.user_id = '$employee_id'")->row();
        echo json_encode($getRekening);
    }

    public function update_rekening()
    {
        $store = false;
        $user_id = $this->session->userdata("user_id");
        $getRekening = $this->db->query("SELECT
                        e.employee_id
                    FROM
                        xin_employee_bankaccount e
                    WHERE e.employee_id = '$user_id'");
        $account_title = $this->input->post('account_title');
        $account_number = $this->input->post('account_number');
        $bank_name = $this->input->post('bank_name');
        if ($getRekening->num_rows() > 0) {
            $data = array(
                'account_title' => $account_title,
                'account_number' => $account_number,
                'bank_name' => $bank_name,
                'created_at' => date("Y-m-d")
            );
            $store = $this->db->where('employee_id', $user_id)->update('xin_employee_bankaccount', $data);
        } else {
            $data = array(
                'employee_id' => $user_id,
                'account_title' => $account_title,
                'account_number' => $account_number,
                'bank_name' => $bank_name,
                'created_at' => date("Y-m-d")
            );
            $store = $this->db->insert('xin_employee_bankaccount', $data);
        }
        $response['status'] = $store;
        echo json_encode($response);
    }

    public function get_personal_detail()
    {
        $user_id = $this->input->post('user_id');
        $get_personal_detail = $this->db->query("SELECT
                                    e.user_id,
                                    CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                                    c.`name` as company_name,
                                    d.department_name,
                                    ds.designation_name,
                                    e.email,
                                    e.gender,
                                    e.date_of_joining,
                                    e.address,
                                    e.marital_status,
                                    e.state,
                                    e.city,
                                    e.zipcode,
                                    e.contact_no,
                                    e.instagram_link,
                                    e.linkdedin_link,
                                    e.leave_categories,
                                    e.employee_id,
                                    e.username
                                FROM
                                    xin_employees e
                                LEFT JOIN xin_companies c ON c.company_id = e.company_id
                                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                                WHERE
                                    user_id = '$user_id'")->row();
        echo json_encode($get_personal_detail);
    }


    public function leave_categories()
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT 
                        m.leave_type_id,
                        m.type_name,
                        m.days_per_year,
                        TIMESTAMPDIFF(MONTH,x.date_of_joining,CURRENT_DATE) AS masa_kerja,
	                    CASE WHEN m.leave_type_id IN (1,19) AND TIMESTAMPDIFF(MONTH,x.date_of_joining,CURRENT_DATE) < 12 
                        THEN 0 ELSE IF( m.leave_type_id = x.leave_type_id, 1, 0 ) END AS is_allowed 
                        FROM xin_leave_type m 
                    LEFT JOIN (
                    SELECT
                        t.leave_type_id,
                        t.type_name,
                        t.days_per_year,
                        e.date_of_joining
                    FROM
                        xin_employees e
                        LEFT JOIN `xin_leave_type` t ON FIND_IN_SET( t.leave_type_id, e.leave_categories ) 
                    WHERE
                        user_id = '$user_id'
                        ) AS x ON x.leave_type_id = m.leave_type_id
                        ORDER BY CASE WHEN m.leave_type_id IN (1,19) AND TIMESTAMPDIFF(MONTH,x.date_of_joining,CURRENT_DATE) < 12 
                        THEN 0 ELSE IF( m.leave_type_id = x.leave_type_id, 1, 0 ) END DESC, m.type_name ASC";
        $data_izin = $this->db->query($query)->result();

        echo json_encode($data_izin);
    }

    public function total_warning()
    {
        $periode = $this->input->post('periode');
        $user_id = $this->input->post('user_id');
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        $allowed_akses = ['2063', '1', '979'];
        $user_id = $this->session->userdata("user_id");
        if (in_array($user_id, $allowed_akses)) {
            $employee_id = $this->input->post('employee_id');
        } else {
            $employee_id = $this->session->userdata("user_id");
        }
        $query = "SELECT COUNT(x.reason) AS total_warning FROM (SELECT
                        h.created_at,
                        SUBSTR(h.created_at,1,10) AS tgl_warning,
                        SUBSTR(h.created_at,12,5) AS jam_warning,
                        h.employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        h.reason,
                        COUNT(h.employee_id) AS attempt
                    FROM
                        trusmi_history_lock h
                        LEFT JOIN xin_employees e ON e.user_id = h.employee_id
                    WHERE
                        SUBSTR( h.created_at, 1, 10 ) BETWEEN '$start' 
                        AND '$end' AND h.employee_id = '$employee_id'
                    GROUP BY h.employee_id, SUBSTR( h.created_at, 1, 10 ), h.reason
                    ) AS x GROUP BY x.reason";
        $data = $this->db->query($query)->row();
        return $data->total_warning ?? 0;
    }

    public function history_warning()
    {
        $user_id = $this->session->userdata('user_id');

        $periode = $this->input->post('periode');
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        $query = "SELECT
                        h.created_at,
                        SUBSTR(h.created_at,1,10) AS tgl_warning,
                        SUBSTR(h.created_at,12,5) AS jam_warning,
                        h.employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        h.reason,
                        COUNT(h.employee_id) AS attempt
                    FROM
                        trusmi_history_lock h
                        LEFT JOIN xin_employees e ON e.user_id = h.employee_id
                    WHERE
                        SUBSTR( h.created_at, 1, 10 ) BETWEEN '$start' 
                        AND '$end' AND h.employee_id = '$user_id'
                    GROUP BY h.employee_id, SUBSTR( h.created_at, 1, 10 ), h.reason
                    ORDER BY h.created_at DESC";
        $data_history_warning = $this->db->query($query)->result();

        echo json_encode($data_history_warning);
    }

    public function manage_leave()
    {
        $user_id = $this->session->userdata('user_id');

        $periode = $this->input->post('periode');
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        $query = "SELECT
                    t.type_name,
                    l.from_date,
                    l.to_date,
                    l.reason
                FROM
                    xin_leave_applications l
                LEFT JOIN xin_leave_type t ON t.leave_type_id = l.leave_type_id
                WHERE SUBSTR(l.from_date,1,10) BETWEEN '$start' AND '$end' AND employee_id = '$user_id'
                ORDER BY SUBSTR(l.from_date,1,10) DESC";

        $data_manage_leave = $this->db->query($query)->result();

        echo json_encode($data_manage_leave);
    }
    public function manage_leave_test($periode, $user_id)
    {
        // $user_id = $this->session->userdata('user_id');

        // $periode = $this->input->post('periode');
        $month = date("m", strtotime($periode));

        $today = date("Y-m-d", strtotime($periode));
        $start = date("Y-m-21", strtotime($today . " -1 months"));
        $end = date("Y-m-20", strtotime($periode));

        $query = "SELECT
                    t.type_name,
                    l.from_date,
                    l.to_date,
                    l.reason
                FROM
                    xin_leave_applications l
                LEFT JOIN xin_leave_type t ON t.leave_type_id = l.leave_type_id
                WHERE SUBSTR(l.from_date,1,10) BETWEEN '$start' AND '$end' AND employee_id = '$user_id'
                ORDER BY SUBSTR(l.from_date,1,10) DESC";

        $data_manage_leave = $this->db->query($query)->result();

        echo json_encode($data_manage_leave);
    }

    public function e_training()
    {
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $query = "SELECT
                        m.id AS id_training,
                        m.training,
                        m.image,
                        m.keterangan,
                        m.created_by,
                        m.created_at,
                        CONCAT(e.first_name,' ',e.last_name) AS created_by
                    FROM
                        `trusmi_materi_training` m
                    LEFT JOIN xin_employees e ON e.user_id = m.created_by
                    WHERE
                        (m.company_id IS NULL OR (m.company_id = '$company_id' AND m.department_id = '$department_id'))
                        AND m.training IS NOT NULL";
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }

    function update_got_it()
    {
        if (isset($_POST['banner_index'])) {
            $banner_index = $_POST['banner_index'];
        } else {
            $banner_index = 0;
        }

        $got_it = array(
            'got_it' => 1,
            'got_it_banner' => $banner_index,
        );
        $this->db->where('user_id', $_POST['user_id']);
        $data['got_it'] = $this->db->update('xin_employees', $got_it);
        echo json_encode($data);
    }
}