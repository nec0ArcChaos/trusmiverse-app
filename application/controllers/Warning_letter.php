<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warning_letter extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_warning_letter', 'model');
        $this->load->model("model_profile");
        $this->load->library('FormatJson');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function kronologi($id_warning)
    {
        $warning = $this->model->get_data($id_warning);
        $data = [
            'pageTitle' => 'Warning Letter',
            'css' => 'warning_letter/css',
            'warning' => $warning
        ];
        $this->load->view('warning_letter/index', $data);
    }
    function update_kronologi()
    {
        $data = [
            'description' => $this->input->post('kronologi'),
            'kronologis' => $this->input->post('kronologi')
        ];
        $this->db->where('warning_id', $this->input->post('id_warning'));
        $this->db->update('xin_employee_warnings', $data);
        echo json_encode($_POST);
    }

    function index()
    {
        $id_user                  = $this->session->userdata('user_id');
        $data['sto']                      = $this->db->query("SELECT
                                                            level_sto 
                                                        FROM
                                                            xin_employees 
                                                            JOIN xin_user_roles ON xin_employees.user_role_id = xin_user_roles.role_id
                                                        WHERE
                                                            user_id = $id_user")->row_array();

        $data['pageTitle']        = "Warning Letter";
        $data['css']              = "warning_letter/dt_warning/css";
        $data['js']               = "warning_letter/dt_warning/js";
        $data['content']          = "warning_letter/dt_warning/index";
        $data['companies'] = $this->db->query("SELECT company_id,`name` FROM xin_companies")->result();
        $data['warning_type'] = $this->db->query("SELECT * FROM xin_warning_type")->result();

         // addnew
        $dt_head_id = $this->db->query("SELECT
                                                head_id 
                                            FROM
                                                `view_penalty` 
                                            WHERE
                                                head_id IS NOT NULL 
                                            GROUP BY
                                                head_id")->result();
        $arr_head_id = [];
        foreach ($dt_head_id as $row) {
            $arr_head_id[] = $row->head_id;
        }
        // print_r($arr_head_id); die;
        $data['dt_head_id'] = $arr_head_id;


        $this->load->view('layout/main', $data);
    }

    function get_department()
    {
        $company = $_POST['company'];
        $id_department = $_POST['id_department'];
        $data['department'] = $this->db->query("SELECT department_id, department_name, IF(department_id = '$id_department',1,0) as selected FROM xin_departments WHERE company_id = $company")->result();
        echo json_encode($data);
    }

    function get_employees()
    {
        $company = $_POST['company_id'];
        $user_id = $_POST['user_id'];
        $data['employee'] = $this->db->query("SELECT xe.user_id,xe.employee_id,TRIM(CONCAT(xe.first_name,' ', xe.last_name)) as employee_name, IF(xe.user_id = '$user_id',1,0) as selected, xd.department_name FROM xin_employees xe LEFT JOIN xin_departments xd ON xd.department_id = xe.department_id WHERE xe.is_active = 1 AND xe.company_id = $company")->result();
        echo json_encode($data);
    }

    function save_warning()
    {
        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking file type
                $allowed = array('png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx');

                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    $profile = "/var/www/trusmiverse/hr/uploads/warning/";
                    $newfilename = 'warning_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        $user_id = $this->session->userdata('user_id');
        $dt_warning = [
            'company_id' => $_POST['company_form'] ?? null,
            'warning_to' => $_POST['employee'] ?? null,
            'warning_by' => $user_id,
            'warning_date' => $_POST['warning_date'] ?? null,
            'warning_type_id' => $_POST['warning_type'] ?? null,
            'attachment' => $fname,
            'subject' => $_POST['subject'] ?? null,
            'status' => $_POST['status'] ?? null,
            'created_at' => date("Y-m-d H:i:s"),
            'hasil_investigasi' => $_POST['result_investigation'] ?? null,
            'tindakan_perbaikan' => $_POST['corrective'] ?? null,
            'catatan_lain' => $_POST['another_note'] ?? null,
        ];
        $data['result'] = $this->db->insert('xin_employee_warnings', $dt_warning);
        $this->send_notification($_POST['employee'], $user_id);
        echo json_encode($data);
    }
    

    function dt_warning_letter()
    {
        $company = $_POST['company'];
        $department = $_POST['department'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_warning_letter($start, $end, $company, $department);
        echo json_encode($data);
    }

    function delete_warning()
    {
        $id = $_POST['id'];
        $this->db->where('warning_id', $id);
        $data['result'] = $this->db->delete('xin_employee_warnings');
        echo json_encode($data);
    }

    function get_detail_warning()
    {
        $id = $_POST['id'];
        $data['warning'] = $this->db->query("SELECT * FROM xin_employee_warnings WHERE warning_id = $id")->row_array();
        echo json_encode($data);
    }

    function update_warning()
    {
        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking file type
                $allowed = array('png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx');

                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    $profile = "/var/www/trusmiverse/hr/uploads/warning/";
                    $newfilename = 'warning_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        $warning_id = $_POST['warning_id'];
        $warning_to = $_POST['warning_to'];
        $user_id = $this->session->userdata('user_id');
        if ($warning_to == $user_id) {
            $dt_warning = [
                'kronologis' => $_POST['chronological'] ?? null
            ];
        } else {
            if ($fname != '' && $fname != null) {
                $dt_warning = [
                    'warning_date' => $_POST['warning_date'] ?? null,
                    'warning_type_id' => $_POST['warning_type'] ?? null,
                    'attachment' => $fname,
                    'subject' => $_POST['subject'] ?? null,
                    'status' => $_POST['status'] ?? null,
                    'hasil_investigasi' => $_POST['result_investigation'] ?? null,
                    'tindakan_perbaikan' => $_POST['corrective'] ?? null,
                    'catatan_lain' => $_POST['another_note'] ?? null,
                ];
            } else {
                $dt_warning = [
                    'warning_date' => $_POST['warning_date'] ?? null,
                    'warning_type_id' => $_POST['warning_type'] ?? null,
                    'subject' => $_POST['subject'] ?? null,
                    'status' => $_POST['status'] ?? null,
                    'hasil_investigasi' => $_POST['result_investigation'] ?? null,
                    'tindakan_perbaikan' => $_POST['corrective'] ?? null,
                    'catatan_lain' => $_POST['another_note'] ?? null,
                ];
            }
        }
        $this->db->where('warning_id', $warning_id);
        $data['result'] = $this->db->update('xin_employee_warnings', $dt_warning);
        echo json_encode($data);
    }

    function send_notification($warning_to, $warning_by)
    {
        $dt_warning = $this->model->get_data_notification($warning_to, $warning_by);
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => "2507194023", // Channel Trusmi Group
            "phone" => $dt_warning['contact'],
            "messageType" => "text",
            "body" => "🚨 *Warning Letter* 🚨  

Kami ingin memberitahukan bahwa anda mendapatkan _warning letter_ dari *" . $dt_warning['employee_by'] . "* pada " . $dt_warning['warning_date'] . ".

🤵 Nama : " . $dt_warning['employee_to'] . "
🪑 Designation : " . $dt_warning['designation_name'] . "
🏭 Departemen : " . $dt_warning['department_name'] . "
📌 Hasil Investigasi : " . $dt_warning['hasil_investigasi'] . "
‼️ Warning Type : " . $dt_warning['type'] . "

Masa berlaku *" . $dt_warning['masa_berlaku'] . " bulan*. Mohon untuk mengisi kronologi melalui link berikut :
🔗 _https://trusmiverse.com/apps/warning_letter/kronologi/" . $dt_warning['warning_id'] . "_

Mohon untuk dapat dijadikan sebagai bahan perhatian dan instropeksi diri.

Catatan :
⏳ Leadtime pengisian kronologi maksimal isi 2 x 24 jam dari tanggal diberikan warning letter, jika belum mengisi kronologi maka akan *lock absen*.",
            "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_text),
                "header" =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );
        $context_text  = stream_context_create($options_text);
        $result_text = file_get_contents($url, false, $context_text);
        $response['text'][] = json_decode($result_text);
    }

    function dt_rekomendasi_warning()
    {
        $company = @$_REQUEST['company'];
        $department = @$_REQUEST['department'];
        $start = @$_REQUEST['start'];
        $end = @$_REQUEST['end'];
        $data['data'] = $this->model->dt_rekomendasi_warning($start, $end, $company, $department);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function save_warning_rekom()
    {
        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking file type
                $allowed = array('png', 'jpg', 'jpeg', 'pdf', 'xls', 'xlsx');

                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    $profile = "/var/www/trusmiverse/hr/uploads/warning/";
                    $newfilename = 'warning_' . round(microtime(true)) . '.' . $ext;
                    $move = move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }
        if ($_POST['status_penalty'] == '1') {
            $user_id = $this->session->userdata('user_id');
            $dt_penalty = [
                'status' => 1,
            ];
            $this->db->where('id', $_POST['penalty_id']);
            $this->db->update('trusmi_t_penalty', $dt_penalty);
            $dt_warning = [
                'company_id' => $_POST['company_form'] ?? null,
                'warning_to' => $_POST['employee'] ?? null,
                'warning_by' => $user_id,
                'warning_date' => $_POST['warning_date'] ?? null,
                'warning_type_id' => $_POST['warning_type'] ?? null,
                'attachment' => $fname,
                'subject' => $_POST['subject'] ?? null,
                'status' => $_POST['status'] ?? null,
                'created_at' => date("Y-m-d H:i:s"),
                'hasil_investigasi' => $_POST['result_investigation'] ?? null,
                'tindakan_perbaikan' => $_POST['corrective'] ?? null,
                'catatan_lain' => $_POST['another_note'] ?? null,
                'reff_penalty' => $_POST['penalty_id'] ?? null,
            ];
            $data['result'] = $this->db->insert('xin_employee_warnings', $dt_warning);
            $this->send_notification($_POST['employee'], $user_id);
        } elseif ($_POST['status_penalty'] == '2') {
            $dt_penalty = [
                'status' => 2,
                'note' => $_POST['reject_note'] ?? null
            ];
            $this->db->where('id', $_POST['penalty_id']);
            $data['result'] = $this->db->update('trusmi_t_penalty', $dt_penalty);
        }
        echo json_encode($data);
    }
}
