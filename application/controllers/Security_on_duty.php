<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Security_on_duty extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_security_on_duty', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    // Update new
    public function index()
    {
        $data['pageTitle']        = "Security On Duty";
        $data['css']              = "security_on_duty/css";
        $data['js']               = "security_on_duty/js";
        $data['content']          = "security_on_duty/index";

        $this->load->view('layout/main', $data);
    }

    public function dt_resume_tasklist()
    {
        $datestart = $_POST['start'];
        $dateend = $_POST['end'];

        $res['data'] = $this->model->dt_resume_tasklist($datestart, $dateend)->result();

        echo json_encode($res);
    }

    public function dt_list_detail_task()
    {
        $datestart = $_POST['start'];
        $dateend = $_POST['end'];

        $res['data'] = $this->model->dt_list_detail_task($datestart, $dateend)->result();

        echo json_encode($res);
    }

public function detail_modal()
{
    $id_task = $this->input->post("id_task");

    $res['data'] = $this->model->detail_modal($id_task)->result();

    echo json_encode($res);
}



    // Update new
    public function add_task()
    {
        $data['pageTitle']        = "Security On Duty";
        $data['css']              = "security_on_duty/css";
        $data['js']               = "security_on_duty/js";
        $data['content']          = "security_on_duty/add_task";
        // $data_level_sto           = $this->model->get_level_sto();
        // $data['level_sto']        = $data_level_sto['level_sto'];
        // $data['list_head'] = $this->model->list_head();

        // $data['projects'] = $this->db->query("SELECT id_project,project FROM rsp_project_live.`m_project`")->result();

        $data['projects'] = $this->db->query("SELECT
                                                sc_m_site.id_project,
                                                m_project.project 
                                            FROM
                                                sc_m_site
                                                JOIN rsp_project_live.m_project AS m_project ON sc_m_site.id_project = m_project.id_project
                                            GROUP BY sc_m_site.id_project")->result();

        // $data['shifts'] = $this->db->query("SELECT * FROM `xin_office_shift` WHERE shift_name LIKE '%security%'")->result();

        $this->load->view('layout/main', $data);
    }

    public function data_shift()
    {
        $id_project = $_POST['id_project'];

        $sql = "SELECT
                    sc_m_shift.id_shift,
                    sc_m_shift.shift,
                    sc_m_site.id_site,
                    sc_m_site.id_project
                FROM
                    sc_m_site
                    JOIN sc_m_shift ON sc_m_site.id_shift = sc_m_shift.id_shift
                WHERE sc_m_site.id_project = $id_project";
        $res['data'] = $this->db->query($sql)->result();

        echo json_encode($res);
    }

    // public function cek_task() {}

    public function cek_insert_task()
    {
        $id_project = $_POST['id_project'];
        $id_shift = $_POST['id_shift'];

        $id_user = $this->session->userdata('user_id');

        $get_id_site = "SELECT
                        id_site 
                    FROM
                        `sc_m_site`
                    WHERE
                        id_project = $id_project
                        AND id_shift = $id_shift";

        $id_site = $this->db->query($get_id_site)->row()->id_site;

        $cek_task = $this->model->cek_task($id_site, $id_shift, $id_user);

        if ($cek_task->num_rows() > 0) {
            // Redirect tanpa insert
            $dt_task = $cek_task->row();
            $res['message'] = 'Just redirect';
            $res['id_task'] = $dt_task->id_task;
        } else {
            // Insert kemudian redirect
            $id_task = $this->model->generate_id_security_task();
            // INSERT to sc_t_task
            $data = [
                'id_task' => $id_task,
                'id_site' => $id_site,
                'id_project' => $id_project,
                'id_shift' => $id_shift,
                'created_by' => $this->session->userdata('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $res['insert_task'] = $this->db->insert('sc_t_task', $data);

            // Insert to sc_t_task_item
            $get_dt_site_item = $this->db->query("SELECT * FROM `sc_m_site_item` WHERE id_site = '$id_site'");

            if ($get_dt_site_item->num_rows() > 0) {

                foreach ($get_dt_site_item->result() as $item) {

                    $data_item = [
                        'id_task' => $id_task,
                        'id_site_item' => $item->id_site_item,
                        'time_start' => $item->time_start,
                        'time_end' => $item->time_end,
                        'tasklist' => $item->tasklist,
                        'is_photo' => $item->is_photo,
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                    ];

                    $insert_item = $this->db->insert('sc_t_task_item', $data_item);
                }

                $res['insert_item'] = $insert_item;
            }

            $res['id_task'] = $id_task;
        }


        echo json_encode($res);
    }

    public function list_task()
    {
        $data['pageTitle']        = "List Tasklist";
        $data['css']              = "security_on_duty/css";
        $data['js']               = "security_on_duty/js";
        $data['content']          = "security_on_duty/list_task";

        $id_task = $this->input->get('id_task');

        $data['dt_list_task'] = $this->model->dt_list_task_item($id_task)->result();

        $this->load->view('layout/main', $data);
    }

    public function list_task_dev()
    {
        $data['pageTitle']        = "List Tasklist";
        $data['css']              = "security_on_duty/css";
        $data['js']               = "security_on_duty/js_dev";
        $data['content']          = "security_on_duty/list_task_dev";

        $id_task = $this->input->get('id_task');

        $data['dt_list_task'] = $this->model->dt_list_task_item($id_task)->result();

        $this->load->view('layout/main', $data);
    }

    public function detail_task_item()
    {
        $id_task_item = $_POST['id_task_item'];

        $res['data'] = $this->model->detail_task_item($id_task_item)->row();

        echo json_encode($res);
    }

    public function update_task_item()
    {
        $id_task = $_POST['id_task'];

        $id_task_item = $_POST['id_task_item'];
        $status = $_POST['status'];
        $note = $_POST['note'];
        $photo = '';
        $time_actual = date('H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        if (!empty($_FILES['photo']['name'])) {
            // Proses unggah file
            // $config['upload_path']   = './uploads/security/';
            $config['upload_path']   = '/var/www/trusmiverse/files/security/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = 'sc_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $photo = $this->upload->display_errors();
            } else {
                $data = array('upload_data' => $this->upload->data());
                $photo = $data['upload_data']['file_name'];
            }
        } else {

            $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        }


        $data_item = [
            'status' => $status,
            'note' => $note,
            'photo' => $photo,
            'time_actual' => $time_actual,
            'updated_at' => $updated_at
        ];
        $this->db->where('id', $id_task_item);
        $update_item = $this->db->update('sc_t_task_item', $data_item);

        // Update juga task di sc_t_task nya
        $data_total = $this->db->query("SELECT
                                            COUNT(item.id) AS total_item,
                                            (
                                                SELECT
                                                    COUNT(id) AS total
                                                FROM
                                                    sc_t_task_item
                                                WHERE
                                                id_task = '$id_task' AND `status` = 1
                                            ) AS total_item_done 
                                        FROM
                                            `sc_t_task_item` item
                                        WHERE
                                            item.id_task = '$id_task'")->row();

        $achievement = ($data_total->total_item_done / $data_total->total_item) * 100;

        $data_task = [
            'achievement' => $achievement,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->db->where('id_task', $id_task);
        $update_task = $this->db->update('sc_t_task', $data_task);

        echo json_encode([
            'update_item' => $update_item,
            'update_task' => $update_task
        ]);
    }

    public function update_task_item_new()
    {
        $id_task = $_POST['id_task'];

        $id_task_item = $_POST['id_task_item'];
        $status = $_POST['status'];
        $note = $_POST['note'];
        $photo = '';
        $time_actual = date('H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        // if (!empty($_FILES['photo']['name'])) {
        //     $config['upload_path']   = '/var/www/trusmiverse/files/security/';
        //     $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
        //     // $config['allowed_types'] = '*';
        //     $new_name = 'sc_' . time();
        //     $config['file_name']     = $new_name;
        //     $this->load->library('upload', $config);

        //     if (!$this->upload->do_upload('photo')) {
        //         $response['error'] = array('error' => $this->upload->display_errors());
        //         $photo = $this->upload->display_errors();
        //     } else {
        //         $data = array('upload_data' => $this->upload->data());
        //         $photo = $data['upload_data']['file_name'];
        //     }
        // } else {
        //     $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        // }

        // sudah ditambahkan fitur compress
        if (!empty($_FILES['photo']['name'])) {
            // 1. Konfigurasi Upload
            $config['upload_path']   = '/var/www/trusmiverse/files/security/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; // Perbaikan: png tidak perlu ditulis dua kali
            $new_name = 'sc_' . time();
            $config['file_name']     = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $photo = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $photo = $upload_data['file_name'];

                // 2. Fitur Kompresi (Hanya jika file adalah gambar)
                if ($upload_data['is_image']) {
                    $this->load->library('image_lib');
                    
                    $config_resize['image_library']  = 'gd2';
                    $config_resize['source_image']   = $upload_data['full_path']; // Lokasi file asli
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['width']          = 1280; // Maksimal lebar (opsional)
                    $config_resize['height']         = 1280;  // Maksimal tinggi (opsional)
                    $config_resize['quality']        = '60%'; // Kunci kompresi (turunkan angka untuk ukuran lebih kecil)

                    $this->image_lib->initialize($config_resize);

                    if (!$this->image_lib->resize()) {
                        // Opsional: tangani jika kompresi gagal
                        $error_compress = $this->image_lib->display_errors();
                    }
                    
                    $this->image_lib->clear(); // Bersihkan memori setelah proses
                }
            }
        } else {
            $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        }


        $data_item = [
            'status' => $status,
            'note' => $note,
            'photo' => $photo,
            'time_actual' => $time_actual,
            'updated_at' => $updated_at
        ];
        $this->db->where('id', $id_task_item);
        $update_item = $this->db->update('sc_t_task_item', $data_item);

        // Update juga task di sc_t_task nya
        $data_total = $this->db->query("SELECT
                                            COUNT(item.id) AS total_item,
                                            (
                                                SELECT
                                                    COUNT(id) AS total
                                                FROM
                                                    sc_t_task_item
                                                WHERE
                                                id_task = '$id_task' AND `status` = 1
                                            ) AS total_item_done 
                                        FROM
                                            `sc_t_task_item` item
                                        WHERE
                                            item.id_task = '$id_task'")->row();

        $achievement = ($data_total->total_item_done / $data_total->total_item) * 100;

        $data_task = [
            'achievement' => $achievement,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->db->where('id_task', $id_task);
        $update_task = $this->db->update('sc_t_task', $data_task);

        echo json_encode([
            'update_item' => $update_item,
            'update_task' => $update_task
        ]);
    }

    public function update_task_item_new_dev()
    {
        $id_task = $_POST['id_task'];

        $id_task_item = $_POST['id_task_item'];
        $status = $_POST['status'];
        $note = $_POST['note'];
        $photo = '';
        $time_actual = date('H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('user_id');

        // if (!empty($_FILES['photo']['name'])) {
        //     $config['upload_path']   = '/var/www/trusmiverse/files/security/';
        //     $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
        //     // $config['allowed_types'] = '*';
        //     $new_name = 'sc_' . time();
        //     $config['file_name']     = $new_name;
        //     $this->load->library('upload', $config);

        //     if (!$this->upload->do_upload('photo')) {
        //         $response['error'] = array('error' => $this->upload->display_errors());
        //         $photo = $this->upload->display_errors();
        //     } else {
        //         $data = array('upload_data' => $this->upload->data());
        //         $photo = $data['upload_data']['file_name'];
        //     }
        // } else {
        //     $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        // }

        // sudah ditambahkan fitur compress
        if (!empty($_FILES['photo']['name'])) {
            // 1. Konfigurasi Upload
            $config['upload_path']   = '/var/www/trusmiverse/files/security_dev/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; // Perbaikan: png tidak perlu ditulis dua kali
            $new_name = 'sc_' . time();
            $config['file_name']     = $new_name;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $response['error'] = array('error' => $this->upload->display_errors());
                $photo = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $photo = $upload_data['file_name'];

                // 2. Fitur Kompresi (Hanya jika file adalah gambar)
                if ($upload_data['is_image']) {
                    $this->load->library('image_lib');
                    
                    $config_resize['image_library']  = 'gd2';
                    $config_resize['source_image']   = $upload_data['full_path']; // Lokasi file asli
                    $config_resize['maintain_ratio'] = TRUE;
                    $config_resize['width']          = 1280; // Maksimal lebar (opsional)
                    $config_resize['height']         = 1280;  // Maksimal tinggi (opsional)
                    $config_resize['quality']        = '60%'; // Kunci kompresi (turunkan angka untuk ukuran lebih kecil)
                    $config_compress['rotation_angle'] = 'auto';

                    $this->image_lib->initialize($config_resize);

                    if (!$this->image_lib->resize()) {
                        // Opsional: tangani jika kompresi gagal
                        $error_compress = $this->image_lib->display_errors();
                    }
                    
                    $this->image_lib->clear(); // Bersihkan memori setelah proses
                }
            }
        } else {
            $photo = (isset($_POST['old_photo'])) ? $_POST['old_photo'] : '';
        }


        $data_item = [
            'status' => $status,
            'note' => $note,
            'photo' => $photo,
            'time_actual' => $time_actual,
            'updated_at' => $updated_at
        ];
        $this->db->where('id', $id_task_item);
        $update_item = $this->db->update('sc_t_task_item', $data_item);

        // Update juga task di sc_t_task nya
        $data_total = $this->db->query("SELECT
                                            COUNT(item.id) AS total_item,
                                            (
                                                SELECT
                                                    COUNT(id) AS total
                                                FROM
                                                    sc_t_task_item
                                                WHERE
                                                id_task = '$id_task' AND `status` = 1
                                            ) AS total_item_done 
                                        FROM
                                            `sc_t_task_item` item
                                        WHERE
                                            item.id_task = '$id_task'")->row();

        $achievement = ($data_total->total_item_done / $data_total->total_item) * 100;

        $data_task = [
            'achievement' => $achievement,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by
        ];
        $this->db->where('id_task', $id_task);
        $update_task = $this->db->update('sc_t_task', $data_task);

        echo json_encode([
            'update_item' => $update_item,
            'update_task' => $update_task
        ]);
    }

     // updev | Belum dipakai
     function upload_foto_task()
     {
 
         // $date = date('Y-m-d');
         // $date = '2024-12-29';
         $date = (isset($_POST['dir'])) ? $_POST['dir'] : date('Y-m-d');
         $direktori = './uploads/security/' . $date . '/';
         if (!is_dir('uploads/security/' . $date)) {
             mkdir('./uploads/security/' . $date, 0777, TRUE);
         }
 
         $string = $_POST['file'];
 
         define('UPLOAD_DIR', $direktori);
 
         $string     = explode(',', $string);
         $img        = str_replace(' ', '+', $string[1]);
         $data       = base64_decode($img);
         $name       = uniqid() . '.' . $string[0];
        //  $name       = '675119be300b5.' . $string[0];
         $file       = UPLOAD_DIR . $name;
         $success    = file_put_contents($file, $data);
 
         $text = date('Y-m-d H:i') . '-6.5,108';
 
 
         if (!$success) {
             echo $this->upload->display_errors();
         } else {
 
             $configwm['image_library'] = 'gd2';
 
             $configwm['source_image']        = $file;
             $configwm['width']                = "150";
             $configwm['height']                = "300";
             $configwm['wm_text']            = $text;
             $configwm['wm_type']            = 'text';
            //  $configwm['wm_font_path']        = './assets/fonts/SEGOEUI.ttf';
             $configwm['wm_font_size']        = '14';
             $configwm['wm_font_color']        = '000000';
             // $configwm['wm_shadow_color']	= 'ffffff';
             $configwm['wm_vrt_alignment']    = 'center';
             $configwm['wm_hor_alignment']    = 'left';
             $configwm['wm_padding']            = '12';
 
             $this->load->library('image_lib', $configwm);
             $this->image_lib->initialize($configwm);
 
             if (!$this->image_lib->watermark()) {
                 echo $this->image_lib->display_errors();
             } else {
                 echo $name;
             }
         }
     }

    //  MASTER SC ON DUTY addnew
    public function master_sc()
    {
        $data['pageTitle']        = "Master Security On Duty"; 
        $data['css']              = "security_on_duty/css";
        $data['js']               = "security_on_duty/js_master_sc";
        $data['content']          = "security_on_duty/master_sc";

        // $data['projects'] = $this->db->query("SELECT
        //                                         sc_m_site.id_project,
        //                                         m_project.project 
        //                                     FROM
        //                                         sc_m_site
        //                                         JOIN rsp_project_live.m_project AS m_project ON sc_m_site.id_project = m_project.id_project
        //                                     GROUP BY sc_m_site.id_project")->result();
        
        $data['projects'] = $this->db->query("SELECT
                                                id_project,
                                                project 
                                            FROM
                                                rsp_project_live.m_project")->result();
        // var_dump($data['projects']); die();

        $data['shifts'] = $this->db->query("SELECT
                                                id_shift, shift, time_start, time_end
                                            FROM
                                                `sc_m_shift`")->result();

        $this->load->view('layout/main', $data);
    }

    public function add_site()
    {
        $id_site = $this->model->generate_id_site();

        $id_project = $_POST['id_project'];
        $id_shift = $_POST['id_shift'];

        $created_by = $this->session->userdata('user_id');

        // INSERT to sc_m_site
        $data = [
            'id_site' => $id_site,
            'id_project' => $id_project,
            'id_shift' => $id_shift,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $created_by,
        ];

        $res['insert_site'] = $this->db->insert('sc_m_site', $data);

        $res['id_site'] = $id_site;

        echo json_encode($res);
    }

    // ----------------------------------------------------------



    public function dt_overtime_request()
    {
        if (isset($_POST['time_request_id'])) {
            $start = null;
            $end = null;
            $time_request_id = $_POST['time_request_id'];
            // $status = null;
            // }else if(isset($_POST['status'])){
            //     $start = null;
            //     $end = null;
            //     $time_request_id = null;
            // $status = $_POST['status'];

        } else {
            $start = $_POST['start'];
            $end = $_POST['end'];
            $time_request_id = null;
            // $status = null;
        }

        if (isset($_POST['status'])) {
            $status = $_POST['status'];
        } else {
            $status = null;
        }


        $data['data'] = $this->model->dt_overtime_request($start, $end, $time_request_id, $status);
        echo json_encode($data);
    }

    // add by Ade
    public function get_overtime_request()
    {
        $time_request_id = $_POST['time_request_id'];
        $query = "SELECT
                    request_date AS date,
                    TIME_FORMAT(request_clock_in, '%H:%i') AS in_time,
                    TIME_FORMAT(request_clock_out, '%H:%i') AS out_time,
                    request_reason AS reason
                FROM
                    `xin_attendance_time_request` 
                WHERE
                    time_request_id = $time_request_id";
        $data = $this->db->query($query)->row();

        echo json_encode($data);
    }

    // add by Ade
    public function update_request_new()
    {
        $request_clock_in = $_POST['edit_request_date'] . ' ' . $_POST['edit_in_time'] . ':00';
        $request_clock_out = $_POST['edit_request_date'] . ' ' . $_POST['edit_out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $data = array(
            'request_date' => $_POST['edit_request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['edit_reason'],
        );

        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['update'] = $this->db->update('xin_attendance_time_request', $data);

        echo json_encode($response);
    }


    public function save_request()
    {


        $user_id = $_SESSION['user_id'];
        $data_employee = $this->db->query("SELECT user_id, company_id, department_id, designation_id, user_role_id FROM xin_employees WHERE user_id = '$user_id' LIMIT 1")->row_array();


        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        // if $total_work_cout < $total_work_cin then add 1 day to $total_work_cout
        if ($total_work_cout < $total_work_cin) {
            $total_work_cout->modify('+1 day');
            // add 1 day to $_POST['request_date']
            $clock_out_date = date('Y-m-d', strtotime('+1 day', strtotime($_POST['request_date'])));
            $request_clock_out = $clock_out_date . ' ' . $_POST['out_time'] . ':00';
        }

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $data = array(
            'company_id' => $data_employee['company_id'],
            'department_id' => $data_employee['department_id'],
            'employee_id' => $data_employee['user_id'],
            'request_date' => $_POST['request_date'],
            'request_date_request' => substr($_POST['request_date'], 0, 7),
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
            'created_at' => date('Y-m-d H:i:s'),
            'is_approved' => 1
        );

        $response['insert'] = $this->db->insert('xin_attendance_time_request', $data);

        echo json_encode($response);
    }

    public function update_request()
    {


        $user_id = $_SESSION['user_id'];
        $data_employee = $this->db->query("SELECT user_id, company_id, department_id, designation_id, user_role_id FROM xin_employees WHERE user_id = '$user_id' LIMIT 1")->row_array();


        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        //total work
        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $data = array(
            'request_date' => $_POST['request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
        );


        // if ($data_employee['user_role_id'] == 3 || ( $data_employee['user_role_id'] == 5 &&  $data_employee['user_id'] == 1844) || $data_employee['user_role_id'] == 1) {
        //     $data = array(
        //         'company_id' => $this->input->post('company_id'),
        //         'employee_id' => $this->input->post('employee_id'),
        //         'request_date' => $_POST['request_date'],
        //         'request_clock_in' => $request_clock_in,
        //         'request_clock_out' => $request_clock_out,
        //         'total_hours' => $total_work,
        //         'request_reason' => $_POST['reason'],
        //         'is_approved' => $this->input->post('status'),
        //         'approve_gm' => $data_employee['user_id'],
        //         'gm_at' => date('Y-m-d'),
        //     );
        // } else if ($data_employee['user_role_id'] == 10) {
        //     $data = array(
        //         'company_id' => $this->input->post('company_id'),
        //         'employee_id' => $this->input->post('employee_id'),
        //         'request_date' => $_POST['request_date'],
        //         'request_clock_in' => $request_clock_in,
        //         'request_clock_out' => $request_clock_out,
        //         'total_hours' => $total_work,
        //         'request_reason' => $_POST['reason'],
        //         'is_approved' => $this->input->post('status'),
        //         'approve_dirut' => $data_employee['user_id'],
        //         'dirut_at' => date('Y-m-d'),
        //     );
        // } else {
        $data = array(
            'request_date' => $_POST['request_date'],
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'total_hours' => $total_work,
            'request_reason' => $_POST['reason'],
        );
        // }

        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['update'] = $this->db->update('xin_attendance_time_request', $data);

        echo json_encode($response);
    }


    public function delete_request()
    {
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['delete'] = $this->db->delete('xin_attendance_time_request');

        echo json_encode($response);
    }

    function approve_request()
    {
        // add by Ade
        //total work
        $request_clock_in = $_POST['request_date'] . ' ' . $_POST['in_time'] . ':00';
        $request_clock_out = $_POST['request_date'] . ' ' . $_POST['out_time'] . ':00';

        $total_work_cin =  new DateTime($request_clock_in);
        $total_work_cout =  new DateTime($request_clock_out);

        $interval_cin = $total_work_cout->diff($total_work_cin);
        $hours_in   = $interval_cin->format('%h');
        $minutes_in = $interval_cin->format('%i');
        $total_work = $hours_in . ":" . $minutes_in;

        $approval = array(
            // add by Ade
            'request_clock_in' => $request_clock_in,
            'request_clock_out' => $request_clock_out,
            'request_reason' => $_POST['reason'],
            'total_hours' => $total_work,
            // end
            'is_approved' => $_POST['status'],
            'approve_gm' => $_SESSION['user_id'],
            'gm_at' => date('Y-m-d H:i:s'),
        );
        $this->db->where('time_request_id', $_POST['time_request_id']);
        $response['approve'] = $this->db->update('xin_attendance_time_request', $approval);
        echo json_encode($response);
    }
}
