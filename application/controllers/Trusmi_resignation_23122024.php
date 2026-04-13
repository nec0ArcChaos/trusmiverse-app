<?php
// Trusmi History Lock Absen
// Created At : 12-05-2023
defined('BASEPATH') or exit('No direct script access allowed');
class Trusmi_resignation extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_resignation', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
        //  User IT
        //  61 Anggi
        //  62 Lutfi
        //  63 Said
        //  64 Lutfiedadi
        //  1161 Fujiyanto
        //  2041 Faisal
        //  2063 Aris
        //  2070 Kania
        //  2969 Ari Fadzri
        // $user_it = array(1, 61, 62, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
        // if (in_array($this->session->userdata('user_id'), $user_it)) {
        // } else {
        //     $this->session->set_flashdata('no_access', 1);
        //     redirect('dashboard', 'refresh');
        // }
    }

    public function index()
    {
        $data['pic']              = $this->model->get_pic_clearance();
        $data['pageTitle']        = "T-Resignation";
        $data['css']              = "trusmi_resignation/css";
        $data['js']               = "trusmi_resignation/js";
        $data['content']          = "trusmi_resignation/index";
        $this->load->view('layout/main', $data);
    }

    public function dt_trusmi_resignation()
    {
        $tanggal = $this->validasi_tanggal();
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        $response['data'] = $this->model->dt_trusmi_resignation($tanggal['start'], $tanggal['end'], $user_role_id, $user_id)->result();
        $response['user_id'] = $user_id;
        $response['user_role_id'] = $user_role_id;
        echo json_encode($response);
    }

    public function validasi_tanggal()
    {
        if ($this->input->post("start")) {
            $data['start'] = $this->input->post("start");
            $data['end']   = $this->input->post("end");
        } else {
            $data['start'] = date("Y-m-01");
            $data['end']   = date("Y-m-t");
        }
        return $data;
    }

    public function get_profile()
    {
        $get_profile = "";
        if ($this->input->post("user_id")) {
            $get_profile = $this->model->get_profile($this->input->post("user_id"))->row();
        }
        echo json_encode($get_profile);
    }

    // add by Ade
    public function get_data_reason()
    {
        $category_id = $_POST['category_id'];

        $data = $this->model->get_data_reason($category_id);
        echo json_encode($data);
    }

    public function check_pengajuan()
    {
        $employee_id = $this->input->post('user_id');
        $check_pengajuan = $this->model->check_double_resignation($employee_id);
        $data_pengajuan = $this->model->check_double_resignation($employee_id)->row();
        if ($check_pengajuan->num_rows() > 0) {
            $data['check_pengajuan'] = true;
        } else {
            $data['check_pengajuan'] = false;
        }
        $data['data_pengajuan'] = $data_pengajuan;
        echo json_encode($data);
    }

    public function list_waiting_resignation()
    {
        $employee_id = $this->input->post('user_id');
        $list_waiting_resignation = $this->model->dt_trusmi_waiting_approval_resignation($employee_id)->result();
        $data['data'] = $list_waiting_resignation;
        echo json_encode($data);
    }

    public function list_waiting_resignation_hrd()
    {
        $list_waiting_resignation = $this->model->dt_trusmi_waiting_approval_resignation_hrd()->result();
        $data['data'] = $list_waiting_resignation;
        echo json_encode($data);
    }

    public function test_get_subclearance_by_employee_id()
    {
        // 1193
        $employee_id = "1193";
        $data = $this->model->get_subclearance_by_employee_id($employee_id);
        echo json_encode($data);
    }

    public function store()
    {
        // add by Ade
        $category = $this->input->post('category_name');
        $qt_category = htmlspecialchars(addslashes($category), ENT_QUOTES);

        // edit by Ade
        $reason = $this->input->post('reason_title');
        $qt_reason = htmlspecialchars(addslashes($reason), ENT_QUOTES);

        $note = $this->input->post('note');
        $qt_note = htmlspecialchars(addslashes($note), ENT_QUOTES);
        $employee_id = $this->session->userdata("user_id");
        $validasi_double_data = $this->model->check_double_resignation($employee_id);
        if ($employee_id == null) {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Sesi Login Anda Habis Silahkan Login Ulang";
            $response['data']   = "";
        } else if ($validasi_double_data->num_rows() > 0) {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Double input, anda sudah pernah mengajukan resignation";
            $response['data']   = "";
        } else {
            $data_resignation = [
                'employee_id'       => $employee_id,
                'company_id'        => $this->input->post('company_id'),
                'designation_id'    => $this->input->post('designation_id'),
                'notice_date'       => $this->input->post('notice_date'),
                'resignation_date'  => $this->input->post('resignation_date') ?? '',
                // add by Ade
                'category'            => $qt_category,
                'reason'            => $qt_reason,
                'note'              => $qt_note,
                'added_by'          => $employee_id,
                'created_at'        => date('d-m-Y'),
                'pernyataan_1'      => $this->input->post('pernyataan_1') ?? '',
                'pernyataan_2'      => $this->input->post('pernyataan_2') ?? '',
                'pernyataan_3'      => $this->input->post('pernyataan_3') ?? '',
                'pernyataan_4'      => $this->input->post('pernyataan_4') ?? '',
                'pernyataan_5'      => $this->input->post('pernyataan_5') ?? '',
                'pernyataan_6'      => $this->input->post('pernyataan_6') ?? '',
                'pernyataan_7'      => $this->input->post('pernyataan_7') ?? '',
                'pernyataan_8'      => $this->input->post('pernyataan_8') ?? '',
                'pernyataan_9'      => $this->input->post('pernyataan_9') ?? '',
                'pernyataan_10'     => $this->input->post('pernyataan_10') ?? ''
            ];
            $store_resignation = $this->model->store($data_resignation);
            $resignation_date = $this->input->post('resignation_date');
            $update_date_of_leaving = $this->model->update_date_of_leaving($employee_id, $resignation_date);
            // $store_resignation = FALSE;
            if ($store_resignation == TRUE && $update_date_of_leaving  == TRUE) {
                $id_resignation = $this->model->get_last_id_resignation_by_user_id($employee_id);
                $data_sub_clearance = $this->model->get_subclearance_by_employee_id($employee_id); // jika company rsp maka ada subclearance peminjaman asset
                $get_atasan = $this->model->get_atasan();
                $get_atasan_rsp = $this->model->get_atasan_rsp($employee_id)->row();
                $company_id = $this->session->userdata("company_id");
                $department_id = $this->session->userdata("department_id");
                $designation_id = $this->session->userdata("designation_id");
                $array_company = ['1', '4', '5'];
                foreach ($data_sub_clearance as $sc) {
                    $pic = $sc->pic;

                    if ($sc->id_clearance == 1) {
                        if ($sc->id == '19') {
                            $pic = 4402; // jika peminjaman rakon maka ke jayanti diganti tgl 25-04-2024 ke ikhsanudin ganti lagi jadi Fahry Miraji
                        } else {
                            if ($company_id == 2 && $department_id == 120) {
                                $pic = $get_atasan_rsp->head_id ?? $get_atasan->head_id;
                                if ($pic == 1 || $pic == 331) {
                                    $pic = $get_atasan->head_id;
                                }
                            } else {
                                $pic = $get_atasan->head_id;
                            }
                        }
                    }

                    if ($sc->id_clearance == 7 || $sc->id_clearance == 3 || $sc->id_clearance == 2 || $sc->id_clearance == 4) {
                        if ($company_id == '3') {
                            $pic = '3648'; // jika perusahaan Keranjang maka ke mas Jejen Zainal Mutaqin
                        } else {
                            $pic = $sc->pic;
                        }
                    }

                    if ($sc->id_clearance == 6) {
                        if ($company_id == '3') {
                            // $pic = '488'; // jika perusahaan Keranjang maka ke mba Ade Novianti Safira
                            $pic = '1709'; // jika perusahaan Keranjang maka ke Sicelia Ingelin
                        } else {
                            $pic = $sc->pic;
                        }
                    }

                    // jika company holding, purchasing, bt maka ke bu fani dirubah ke bu Sicelia Ingelin
                    if ($sc->id_clearance == 6) {
                        if (in_array($company_id, $array_company)) {
                            // $pic = 77; // user_id bu fani
                            $pic = 1709; // user_id bu Sicelia Ingelin
                        } else if ($company_id == '3') {
                            // $pic = '488'; // jika perusahaan Keranjang maka ke mba Ade Novianti Safira
                            $pic = '1709'; // jika perusahaan Keranjang maka ke Sicelia Ingelin
                        } else {
                            $pic = $sc->pic;
                        }
                    }

                    if ($pic == '61') { // jika mas anggi picnya maka auto approve
                        $data_exit_clearance = [
                            'id_resignation' => $id_resignation,
                            'karyawan' =>  $employee_id,
                            'subclearance' => $sc->id,
                            'pic' => $pic,
                            'status' => 1,
                            'created_at' => date("Y-m-d H:i:s"),
                            'approved_at' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (5 * 60)),
                            'approved_by' => $pic
                        ];
                    } else {
                        $data_exit_clearance = [
                            'id_resignation' => $id_resignation,
                            'karyawan' =>  $employee_id,
                            'subclearance' => $sc->id,
                            'pic' => $pic,
                            'status' => 0,
                            'created_at' => date("Y-m-d H:i:s")
                        ];
                    }

                    $this->db->insert("trusmi_exit_clearance", $data_exit_clearance);
                }
                $data_kontak = $this->model->get_contact_no($id_resignation);
                $response['id_resignation'] = $id_resignation;
                $response['contact_no'] = $data_kontak;
                $response['status'] = 200;
                $response['msg']    = "Success";
                $response['data']   = $data_resignation;
            } else {
                $response['status'] = 409; // conflict code
                $response['msg']    = "Failed";
                $response['data']   = $data_resignation;
            }
        }
        echo json_encode($response);
    }

    function send_wa_again()
    {
        $id_resignation = $this->input->post('id_resignation');
        $data_kontak = $this->model->get_contact_no($id_resignation);
        $response['id_resignation'] = $id_resignation;
        $response['contact_no'] = $data_kontak;
        $response['status'] = 200;
        $response['msg']    = "Success";
        echo json_encode($response);
    }

    public function test()
    {
        $contact_no = $this->model->get_contact_no(2065);
        $response['id_resignation'] = 185;
        $response['contact_no'] = $contact_no;
        $response['status'] = 200;
        $response['msg']    = "Success";
        echo json_encode($response);
    }

    function verify_resignation()
    {
        $id_resignation = $_GET['id'];
        // if (isset($_GET['id'])) {
        //     $id_resignation = $_GET['id'];
        //     $query = $this->model->get_trusmi_resignation_by_id($id_resignation);
        //     if ($query) {
        //         $data['data'] = $query;
        //         $data['id_resignation'] = $id_resignation;
        //     }
        // }
        $check_resignation              = $this->check_resignation($id_resignation);
        $data['check_resignation']      = $check_resignation;
        $data['id_resignation']         = $id_resignation;
        $data['pageTitle']              = "T-Resignation";
        $data['css']                    = "trusmi_resignation/css";
        $data['js']                     = "trusmi_resignation/verify_resignation_js";
        $data['content']                = "trusmi_resignation/verify_resignation";
        $this->load->view('layout/main', $data);
    }

    function verify_resignation_umam()
    {
        $id_resignation = $_GET['id'];
        $check_resignation              = $this->check_resignation($id_resignation);
        $data['check_resignation']      = $check_resignation;
        $data['id_resignation']         = $id_resignation;
        $data['pageTitle']              = "T-Resignation";
        $data['css']                    = "trusmi_resignation/css";
        $data['js']                     = "trusmi_resignation/verify_resignation_js_umam";
        $data['content']                = "trusmi_resignation/verify_resignation_umam";
        $this->load->view('layout/main', $data);
    }

    public function check_peminjaman_rakon()
    {
        $id_resignation = $this->input->post('id_resignation');
        $karyawan_resign = $this->db->query("SELECT karyawan AS user_id FROM trusmi_exit_clearance WHERE id_resignation = '$id_resignation' GROUP BY karyawan")->row();
        $user_id = $karyawan_resign->user_id;
        $data_peminjaman['data'] = $this->model->check_peminjaman_rakon($user_id);
        echo json_encode($data_peminjaman);
    }

    function detail_resignation()
    {
        $id_resignation = $_GET['id'];
        // if (isset($_GET['id'])) {
        //     $id_resignation = $_GET['id'];
        //     $query = $this->model->get_trusmi_resignation_by_id($id_resignation);
        //     if ($query) {
        //         $data['data'] = $query;
        //         $data['id_resignation'] = $id_resignation;
        //     }
        // }
        $check_resignation        = $this->check_resignation($id_resignation);
        $data['check_resignation'] = $check_resignation;
        $data['id_resignation']   = $id_resignation;
        $data['pageTitle']        = "T-Resignation";
        $data['css']              = "trusmi_resignation/css";
        $data['content']          = "trusmi_resignation/detail_resignation";
        $data['js']               = "trusmi_resignation/detail_resignation_js";
        $this->load->view('layout/main', $data);
    }

    public function check_resignation($id_resignation)
    {
        return $this->model->check_resignation($id_resignation);
    }

    public function dt_verify_resignation()
    {
        if ($this->input->post("id_resignation")) {
            $id_resignation = $this->input->post("id_resignation");
        }
        $response['data'] = $this->model->get_trusmi_resignation_by_id($id_resignation);
        echo json_encode($response);
    }

    public function dt_my_resignation()
    {
        if ($this->input->post("id_resignation")) {
            $id_resignation = $this->input->post("id_resignation");
        }
        $response['data'] = $this->model->get_my_resignation($id_resignation);
        echo json_encode($response);
    }

    public function get_profile_resignation()
    {
        $get_profile_resignation = "";
        if ($this->input->post("id_resignation")) {
            $get_profile_resignation = $this->model->get_profile_resignation($this->input->post("id_resignation"))->row();
        }
        echo json_encode($get_profile_resignation);
    }

    public function get_atasan_rsp()
    {
        $user_id = $this->input->post('user_id');
        $get_atasan_rsp = "";
        if ($user_id) {
            $get_atasan_rsp = $this->model->get_atasan_rsp($user_id)->row();
        }
        echo json_encode($get_atasan_rsp);
    }

    public function update_approval()
    {
        $id_exit_clearance = $this->input->post("id_exit_clearance");
        $id_resignation = $this->input->post("id_resignation");
        $pic = $this->input->post("pic");
        $status = $this->input->post("status");
        $note = $this->input->post("note");
        $array = array();
        $array = array(
            'status' => $status,
            'note' => $note,
            'approved_at' => date("Y-m-d H:i:s"),
            'approved_by' => $this->session->userdata("user_id")
        );
        $this->db->where('id', $id_exit_clearance);
        $this->db->where('id_resignation', $id_resignation);
        $this->db->where('pic', $pic);
        $update_approval = $this->db->update('trusmi_exit_clearance', $array);
        $data_update[] = [
            'status_update' => $update_approval,
            'data_update' => $array
        ];

        $this->check_aproval_resignation($id_resignation, '6281120012145'); // fafri comben
        $this->check_aproval_resignation($id_resignation, '6285324409384'); // aris

        $response['data'] = $data_update;
        if (count($data_update) > 0) {
            $response['status'] = 200;
            $response['msg']    = "Success";
            $response['data']   = $data_update;
        } else {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Failed";
            $response['data']   = $data_update;
        }
        echo json_encode($response);
    }


    public function update_reason_atasan()
    {
        $resignation_id = $this->input->post("resignation_id");
        $reason_atasan = $this->input->post("reason_atasan");
        $array = array();
        $array = array(
            'reason_atasan' => $reason_atasan,
        );
        $this->db->where('resignation_id', $resignation_id);
        $update_reason_atasan = $this->db->update('xin_employee_resignations', $array);
        // $update_reason_atasan = true;
        $data_update[] = [
            'status_update' => $update_reason_atasan,
            'data_update' => $array
        ];

        $response['data'] = $data_update;
        if ($update_reason_atasan == true) {
            $response['status'] = 200;
            $response['msg']    = "Success";
            $response['data']   = $data_update;
        } else {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Failed";
            $response['data']   = $data_update;
        }
        echo json_encode($response);
    }

    public function check_aproval_resignation($id_resignation, $no_hp)
    {
        $check = $this->model->check_aproval_resignation($id_resignation);
        $id_resignation = $check->id_resignation;
        $nama_atasan = $check->nama_atasan;
        $karyawan = $check->karyawan;
        $company_name = $check->company_name;
        $department_name = $check->department_name;
        $designation_name = $check->designation_name;
        $reason_atasan = $check->reason_atasan;
        $id_user_hrd = 979; //personalia
        $employee_name = $check->employee_name;
        $total_item_clearance = $check->total_clearance ?? 0;
        $total_approved = $check->total_approved ?? 0;
        if ($total_item_clearance == $total_approved) {
            $status = true;
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text = array(
                // "channelID" => "2219204182", // channel BT
                "channelID" => "2225082380", // Channel RSP
                "phone" => $no_hp,
                "messageType" => "text",
                "body" => "📣 Alert!!!
                Notifikasi : Permintaan Pengunduran Diri
                Company : " . $company_name . "
                Department : " . $department_name . "
                Designation : " . $designation_name . "
                Head Name : " . $nama_atasan . "
                Head Reason : " . $reason_atasan . "

                Halo Tim HRD,

                Kami ingin memberitahukan bahwa *" . $employee_name . "* telah mengajukan permintaan pengunduran diri dan telah disetujui oleh atasan terkait. Mohon untuk memproses pengunduran diri ini sesuai dengan prosedur yang telah ditetapkan.

                Terima kasih atas perhatiannya.


                🌐 Link Approve : 

                http://trusmiverse.com/apps/login/verify_resignation_hrd?u=" . $id_user_hrd . "&id=" . $id_resignation . "",
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
            $response['text'] = json_decode($result_text);
            // echo json_encode($response);
        }
    }

    function verify_hrd()
    {
        $id_resignation = $_GET['id'];
        // if (isset($_GET['id'])) {
        //     $id_resignation = $_GET['id'];
        //     $query = $this->model->get_trusmi_resignation_by_id($id_resignation);
        //     if ($query) {
        //         $data['data'] = $query;
        //         $data['id_resignation'] = $id_resignation;
        //     }
        // }
        $check_resignation         = $this->check_resignation($id_resignation);
        $data['check_resignation'] = $check_resignation;
        $data['id_resignation']    = $id_resignation;
        $data['pageTitle']         = "T-Resignation";
        $data['css']               = "trusmi_resignation/css";
        $data['content']           = "trusmi_resignation/verify_hrd";
        $data['js']                = "trusmi_resignation/verify_hrd_js";
        $this->load->view('layout/main', $data);
    }

    function check_status_resignation()
    {
        $id_resignation = $this->input->post("id_resignation");
        $data['status_resignation'] = $this->model->check_status_resignation($id_resignation);
        echo json_encode($data);
    }

    public function update_approval_hrd()
    {
        $id_resignation = $this->input->post("id_resignation");
        $data = array(
            'status' => 2
        );
        $this->db->where('resignation_id', $id_resignation);
        $update_approval_hrd = $this->db->update('xin_employee_resignations', $data);
        $response['data'] =  $update_approval_hrd;
        if ($update_approval_hrd) {
            $response['status'] = 200;
            $response['msg']    = "Success";
            $response['data']   = $data;
        } else {
            $response['status'] = 409; // conflict code
            $response['msg']    = "Failed";
            $response['data']   = $data;
        }
        echo json_encode($response);
    }

    public function print_paklaring($id_resignation)
    {
        // $id_resignation = $this->input->post("id_resignation");
        $data['title_letter'] = 'Surat Keterangan';
        $bulan = date("m");
        if ($bulan == "01") {
            $angka_romawi = "I";
        }
        if ($bulan == "02") {
            $angka_romawi = "II";
        }
        if ($bulan == "03") {
            $angka_romawi = "III";
        }
        if ($bulan == "04") {
            $angka_romawi = "IV";
        }
        if ($bulan == "05") {
            $angka_romawi = "V";
        }
        if ($bulan == "06") {
            $angka_romawi = "VI";
        }
        if ($bulan == "07") {
            $angka_romawi = "VII";
        }
        if ($bulan == "08") {
            $angka_romawi = "VIII";
        }
        if ($bulan == "09") {
            $angka_romawi = "IX";
        }
        if ($bulan == "10") {
            $angka_romawi = "X";
        }
        if ($bulan == "11") {
            $angka_romawi = "XI";
        }
        if ($bulan == "12") {
            $angka_romawi = "XII";
        }
        $data['no_surat'] = $id_resignation . '/HR-RSP/SKPK/' . $angka_romawi . '/' . date("Y");
        $data['data'] = $this->model->print_paklaring($id_resignation);
        $this->load->view('trusmi_resignation/print_paklaring', $data);
    }


    public function get_report_detail()
    {
        $start = $this->input->post('start') == "" ? date("Y-m-01") : $this->input->post('start');
        $end = $this->input->post('end') == "" ? date("Y-m-t") : $this->input->post('end');
        $response['data'] = $this->model->get_report_detail($start, $end);
        echo json_encode($response);
    }

    public function manual_resignation($employee_id, $id_resignation, $company_id)
    {
        $data_sub_clearance = $this->model->get_subclearance_by_employee_id($employee_id);
        $get_atasan = $this->model->get_atasan();
        $array_company = ['1', '4', '5'];
        foreach ($data_sub_clearance as $sc) {
            $pic = $sc->pic;

            if ($sc->id_clearance == 1) {
                if ($sc->id == '19') {
                    $pic = 4402; // jika peminjaman rakon maka ke jayanti diganti tgl 25-04-2024 ke ikhsanudin ganti lagi jadi Fahry Miraji
                } else {
                    $pic = $get_atasan->head_id;
                }
            }

            if ($sc->id_clearance == 7 || $sc->id_clearance == 3 || $sc->id_clearance == 2 || $sc->id_clearance == 4) {
                if ($company_id == '3') {
                    $pic = '3648'; // jika perusahaan Keranjang maka ke mas Jejen Zainal Mutaqin
                } else {
                    $pic = $sc->pic;
                }
            }

            if ($sc->id_clearance == 6) {
                if ($company_id == '3') {
                    $pic = '488'; // jika perusahaan Keranjang maka ke mba Ade Novianti Safira
                } else {
                    $pic = $sc->pic;
                }
            }

            // jika company holding, purchasing, bt maka ke bu fani dirubah ke bu Sicelia Ingelin
            if ($sc->id_clearance == 6) {
                if (in_array($company_id, $array_company)) {
                    // $pic = 77; // user_id bu fani
                    $pic = 1709; // user_id bu Sicelia Ingelin
                } else if ($company_id == '3') {
                    $pic = '488'; // jika perusahaan Keranjang maka ke mba Ade Novianti Safira
                } else {
                    $pic = $sc->pic;
                }
            }

            if ($pic == '61') { // jika mas anggi picnya maka auto approve
                $data_exit_clearance = [
                    'id_resignation' => $id_resignation,
                    'karyawan' =>  $employee_id,
                    'subclearance' => $sc->id,
                    'pic' => $pic,
                    'status' => 1,
                    'created_at' => date("Y-m-d H:i:s"),
                    'approved_at' => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s")) + (5 * 60)),
                    'approved_by' => $pic
                ];
            } else {
                $data_exit_clearance = [
                    'id_resignation' => $id_resignation,
                    'karyawan' =>  $employee_id,
                    'subclearance' => $sc->id,
                    'pic' => $pic,
                    'status' => 0,
                    'created_at' => date("Y-m-d H:i:s")
                ];
            }

            $this->db->insert("trusmi_exit_clearance", $data_exit_clearance);
        }
    }
    function list_inventaris() {
        $user = $this->input->post('user');
        $data['data'] = $this->model->list_inventaris($user);
        echo json_encode($data);
    }
}
