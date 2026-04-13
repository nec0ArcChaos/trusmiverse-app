<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sop extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model('model_sop');
        $this->load->model('model_designation');
        $this->load->library("session");
        $this->load->model('model_review', 'review');

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['pageTitle'] = "INVENTORY";
        $data['css']       = "sop/css";
        $data['js']        = "sop/js";
        $data['content']   = "sop/index";

        $data['dd']        = $this->model_sop->getDd()->result();
        $user = $this->model_sop->data_user($this->session->userdata('user_id'));

        $data['user'] = [];
        foreach ($user as $items) {
            $value = [
                'user_id'       => $this->hashApplicantId($items->user_id),
                'employee_name' => $items->employee,
                'contact_no'    => $items->contact_no
            ];
            $data['user'] = $value;
        }
        $data['no_jp']    = $this->model_sop->no_jp();
        $data['golongan'] = $this->model_sop->get_golongan_jp();

        $data['companies'] = $this->db->query("SELECT company_id, name FROM xin_companies")->result();
        $data['employees'] = $this->db->query("SELECT REPLACE(REPLACE(REPLACE(IF(SUBSTR(xin_employees.contact_no, 1, 2) != '62', CONCAT('62', SUBSTR(xin_employees.contact_no, 2, LENGTH(xin_employees.contact_no))), xin_employees.contact_no), '-', ''), '+', ''), ' ', '') AS no_hp, TRIM(CONCAT(xin_employees.first_name, ' ', xin_employees.last_name)) AS employee_name FROM xin_employees WHERE is_Active = 1")->result();

        $this->load->view('layout/main', $data);
    }

    function get_pic()
    {
        $user = $this->model_sop->get_pic($this->input->post('id'));
        $data = [];
        foreach ($user as $items) {
            $value = [
                'user_id'       => $this->hashApplicantId($items->user_id),
                'employee_name' => $items->employee_name,
                'contact_no'    => $items->contact_no
            ];
            $data[] = $value;
        }
        echo json_encode($data);
    }

    function get_companies()
    {
        $data = $this->db->query("SELECT company_id, name FROM xin_companies")->result();
        echo json_encode($data);
    }

    function get_review($no_jp)
    {
        $data['data'] = $this->review->get_review($no_jp);
        echo json_encode($data);
    }

    function get_departments()
    {
        $company_id = $_POST['id'];
        if ($company_id == 0) {
            $sort = "";
        } else {
            $sort = "WHERE xin_departments.company_id = $company_id";
        }
        $data = $this->db->query("SELECT department_id, department_name FROM xin_departments $sort")->result();
        echo json_encode($data);
    }

    function save_request()
    {
        if ($_POST['pilih_dokumen'] == 1) { // SOP
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $config['file_name']     = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $file_upload = $files['raw_name'] . $files['file_ext'];
            }

            $jenis_doc = 'SOP';
            $department = $_POST['department'];
            $id_user = $this->session->userdata('user_id');
            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $_POST['designation'],
                'jenis_doc'      => $jenis_doc,
                'nama_dokumen'   => $_POST['nama_dokumen'],
                'draft'          => $file_upload,
                'created_at'     => date("Y-m-d H:i:s"),
                'created_by'     => $id_user,
                'penjelasan'     => $_POST['penjelasan'],
                'jadwal_diskusi' => $_POST['jadwal_diskusi']
            );
            $hasil = $this->model_sop->save_request($data);
            echo json_encode($hasil);

        } else if ($_POST['pilih_dokumen'] == 2) { // Job Profile
            $data = [
                'no_jp'          => $_POST['no_jp'],
                'no_dok'         => $_POST['no_doc'],
                'doc_type_id'    => $_POST['doc_type_id'],
                'div_id'         => $_POST['div_id'],
                'designation_id' => $_POST['designation'],
                'departement_id' => $_POST['department'],
                'golongan'       => $_POST['grade'],
                'tujuan'         => $_POST['tujuan'],
                'bawahan'        => $_POST['jumlah_bawahan'],
                'area'           => $_POST['area'],
                'pendidikan'     => $_POST['pendidikan'],
                'pengalaman'     => $_POST['pengalaman'],
                'kompetensi'     => $_POST['kompetensi'],
                'authority'      => $_POST['authority'],
                'status'         => 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'created_by'     => $this->session->userdata('user_id'),
                'penjelasan'     => $_POST['penjelasan'],
                'jadwal_diskusi' => $_POST['jadwal_diskusi'],
            ];
            $this->db->insert('trusmi_job_profile', $data);

        } else { // Intruksi Kerja
            $config['upload_path']   = './assets/files/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 0;
            $config['file_name']     = time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file')) {
                echo $this->upload->display_errors();
            } else {
                $files = $this->upload->data();
                $file_upload = $files['raw_name'] . $files['file_ext'];
            }

            $jenis_doc = 'Intruksi Kerja';
            $department = $_POST['department'];
            if ($_POST['designation'] == null || $_POST['designation'] == '') {
                $designation = 0;
            } else {
                $designation = $_POST['designation'];
            }
            $id_user = $this->session->userdata('user_id');
            $data = array(
                'company'        => $_POST['company'],
                'type_department'=> $_POST['type_department'],
                'department'     => $department,
                'designation'    => $designation,
                'jenis_doc'      => $jenis_doc,
                'nama_dokumen'   => $_POST['nama_dokumen'],
                'draft'          => $file_upload,
                'created_at'     => date("Y-m-d H:i:s"),
                'created_by'     => $id_user,
                'penjelasan'     => $_POST['penjelasan'],
                'jadwal_diskusi' => $_POST['jadwal_diskusi']
            );
            $hasil = $this->model_sop->save_request($data);
            echo json_encode($hasil);
        }
    }

    function get_designations()
    {
        $department_id = $_POST['id'];
        $data = $this->db->query("SELECT designation_id, designation_name FROM xin_designations WHERE department_id = $department_id")->result();
        echo json_encode($data);
    }

    function get_designations_multi_dept()
    {
        $department_ids_array = $_POST['ids'];
        $ids_string = implode(',', $department_ids_array);
        $data = $this->db->query("SELECT designation_id, designation_name FROM xin_designations WHERE department_id IN ($ids_string) ORDER BY department_id")->result();
        echo json_encode($data);
    }

    function sub_divisi()
    {
        $id_divisi = $this->input->post('id', TRUE);
        $data = $this->model_sop->getSubDivisi($id_divisi)->result();
        echo json_encode($data);
    }

    function sub_sub_divisi()
    {
        $id_sub_divisi = $this->input->post('id', TRUE);
        $data = $this->model_sop->getSubSubDivisi($id_sub_divisi)->result();
        echo json_encode($data);
    }

    function data_sop()
    {
        $data = $this->model_sop->getSOP();
        echo json_encode($data);
    }

    function get_sop_review()
    {
        $id_sop = $this->input->post('id_sop');
        $data = $this->model_sop->get_sop_review($id_sop);
        echo json_encode($data);
    }

    function insert()
    {
        $data = $this->model_sop->insert();
        echo json_encode($data);
    }

    function update()
    {
        $data = $this->model_sop->update();
        echo json_encode($data);
    }

    function detail()
    {
        $id_sop = $_POST['id_sop'];
        $data = $this->model_sop->getDetail($id_sop);
        echo json_encode($data);
    }

    function add_link()
    {
        $id_sop = $_POST['id_sop'];
        $nd = $_POST['nama_dokumen_link'];

        $result = array();
        foreach ($nd as $key => $val) {
            $result[] = array(
                'id_parent' => $id_sop,
                'id_child'  => $_POST['nama_dokumen_link'][$key]
            );
        }

        $data = $this->db->insert_batch('trusmi_relasi', $result);
        echo json_encode($data);
    }

    function delete_relasi()
    {
        $idp = $_POST['idp'];
        $idc = $_POST['idc'];

        $this->db->where('id_parent', $idp);
        $this->db->where('id_child', $idc);
        $data = $this->db->delete('trusmi_relasi');

        echo json_encode($data);
    }

    function delete_sop()
    {
        $id = $_POST['id'];
        $this->db->where('id_sop', $id);
        $data = $this->db->delete('trusmi_sop');
        echo json_encode($data);
    }

    function menu()
    {
        $d = $this->model_sop->d();
        foreach ($d as $d) {
            echo $d->nama_divisi . "<br>";
            $sd = $this->model_sop->sd($d->id_divisi);
            foreach ($sd as $sd) {
                echo "&emsp;&emsp;" . $sd->nama_sub_divisi . "<br>";
                $ssd = $this->model_sop->ssd($sd->id_sub_divisi);
                foreach ($ssd as $ssd) {
                    echo "&emsp;&emsp;&emsp;&emsp;" . $ssd->nama_sub_sub_divisi . "<br>";
                }
            }
        }
    }

    public function hashApplicantId($applicant_id)
    {
        $arr_applicant_id = str_split($applicant_id, 1);
        $hash = $this->generateRandomString();
        for ($i = 0; $i < COUNT($arr_applicant_id); $i++) {
            $hash .= $arr_applicant_id[$i];
            $hash .= $this->generateRandomString();
        }
        return $hash;
    }

    function generateRandomString($length = 2)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function blast()
    {
        $no_hp = $_POST['no_hp'];
        $message = "⚠⚠ *Notifikasi Dokumen OD* ⚠⚠ \r\n\n" . $_POST['message'] . "\r\n\n" . $_POST['nama_dokument'] . " : " . $_POST['link_dokument'] . "\r\n\nDokumen SOP JP IK dapat diakses melalui link sistem https://trusmicorp.com/od atau https://trusmicorp.com/e-training dengan *user* dan *password* sesuai dengan akun trusmiverse dengan search sesuai dengan nama dokumen. \r\n\nDengan menerima notifikasi ini artinya menyetujui untuk membaca, memahami dan menjalankan setiap isi yang ada didalam dokumen.\r\n\n\n\nThanks & Regards,\r\nOrganization Development";

        foreach ($no_hp as $hp) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID"   => "2225082380",
                "phone"       => $hp,
                "messageType" => "text",
                "body"        => $message,
                "withCase"    => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header"  => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 5ada255e91b7be8b730b9c4b2913b4af75debbc2aef4f1454f5983587d27190f"
                )
            );

            $context_text = stream_context_create($options_text);
            $result_text['wa_api'] = file_get_contents($url, false, $context_text);
        }
    }
}
