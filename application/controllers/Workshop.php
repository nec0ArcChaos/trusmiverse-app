<?php defined('BASEPATH') or exit('No direct script access allowed');


class Workshop extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_workshop', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Workshop";
        $data['css']              = "workshop/css";
        $data['js']               = "workshop/js";
        $data['content']          = "workshop/index";

        $this->load->view('layout/main', $data);
    }

    function dt_workshop()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_workshop_optimasi($start, $end);
        echo json_encode($data);
    }

    function get_detail_workshop()
    {
        $data['data'] = $this->model->get_detail_workshop();
        echo json_encode($data);
    }

    public function get_workshop_type()
    {
        $data = $this->model->get_workshop_type();
        echo json_encode($data);
    }

    public function get_department()
    {
        $data = $this->model->get_department();
        echo json_encode($data);
    }

    public function get_materi()
    {
        $data = $this->model->get_materi();
        echo json_encode($data);
    }

    public function get_participant()
    {
        $data = $this->model->get_participant();
        echo json_encode($data);
    }

    public function get_trainer()
    {
        $data = $this->model->get_trainer();
        echo json_encode($data);
    }

    public function save_workshop()
    {
        $source = $this->filter->sanitaze_input($this->input->post('source'));
        $trainer_id = NULL;
        if ($source == "Internal") {
            $trainer_id = $this->filter->sanitaze_input($this->input->post('trainer_id'));
        }
        $workshop_id = $this->model->generate_id_workshop();
        $data = array(
            'workshop_id'       => $workshop_id,
            'type_id'           => $this->filter->sanitaze_input($this->input->post('workshop_type')),
            'department_id'     => $this->filter->sanitaze_input($this->input->post('department_id')),
            'participant_plan'  => $this->filter->sanitaze_input($this->input->post('participant_plan')),
            'status'            => 'Plan',
            'source'            => $source,
            'trainer_id'        => $trainer_id,
            'trainer_name'      => $this->filter->sanitaze_input($this->input->post('trainer_name')),
            'title_id'          => $this->filter->sanitaze_input($this->input->post('title_id')),
            'title_name'        => $this->filter->sanitaze_input($this->input->post('title_name')),
            'workshop_place'    => $this->filter->sanitaze_input($this->input->post('workshop_place')),
            'workshop_at'       => $this->filter->sanitaze_input($this->input->post('workshop_at')),
            'workshop_time'     => $this->filter->sanitaze_input($this->input->post('workshop_time')),
            'workshop_end'      => $this->filter->sanitaze_input($this->input->post('workshop_end')),
            'created_at'        => date("Y-m-d H:i:s"),
            'created_by'        => $this->filter->sanitaze_input($_SESSION['user_id']),
        );
        $response['status'] = 'success';
        $response['message'] = 'success';
        $response['insert'] = $this->db->insert('workshop_task', $data);
        $this->send_notif_workshop($workshop_id);
        echo json_encode($response);
    }
    public function update_workshop()
    {
        if (!empty($_FILES['documentation']['name'])) {

            // Proses unggah file
            $config['upload_path']   = './uploads/workshop/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            // $config['allowed_types'] = '*';
            $new_name = time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('documentation')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }
        $data = array(
            'participant_actual' => trim($_POST['participant_actual']),
            'documentation'      => $file_name,
            'commitment'         => trim($_POST['commitment']),
            'status'             => 'Terlaksana',
        );
        $response['status'] = 'success';
        $response['message'] = 'success';
        $response['update'] = $this->db->where('workshop_id', strip_tags($this->input->post('workshop_id')))->update('workshop_task', $data);
        $this->send_notif_workshop_terlaksana(strip_tags($this->input->post('workshop_id')));
        echo json_encode($response);
    }

    public function send_notif_workshop_terlaksana($workshop_id)
    {
        $workshop = $this->model->get_workshop_title($workshop_id);
        $workshop_participant = $this->model->get_workshop_list_participant($workshop_id);
        foreach ($workshop_participant as $row) {
            $msg = "🎉*Congratulations*🎉

Terima kasih *" . $row->only_name . "* telah mengikuti Workshop *" . $workshop->title_name . "*. 

Kami sangat menghargai partisipasi dan antusiasme Anda. Semoga informasi yang Anda dapatkan bermanfaat bagi perkembangan pribadi dan profesional Anda.

Komitmen :
*" . $workshop->commitment . "*

*Note:*
Sertifikat Workshop dapat anda download/print melalui Dashboard E-Training di aplikasi E-Training dengan judul *" . $workshop->title_name . "*.
link aplikasi :
https://trusmicorp.com/e-training";
            $this->whatsapp_lib->send_single_msg('rsp', $row->contact_no, $msg);
        }
    }


    public function send_notif_workshop($workshop_id)
    {
        $workshop = $this->model->get_workshop_title($workshop_id);
        $workshop_participant = $this->model->get_workshop_list_participant($workshop_id);
        $msg = "📌*PENGUMUMAN*📌

*Diberitahukan kepada seluruh Karyawan* yang ada di daftar Nama terlampir dibawah ini untuk dapat mengikuti Workshop *" . $workshop->title_name . "* yang akan diisi oleh *" . $workshop->trainer_name . "* pada

🗓️ Hari: *" . $workshop->tanggal . "* 
⏰ Jam: *" . $workshop->jam . "* 
📍 Tempat: *" . $workshop->tempat . "*

Mengingat pentingnya Workshop kali ini harap Bapak/ibu agar dapat hadir memenuhi undangan ini tepat waktu.

Atas perhatian dan dedikasi Bapak/Ibu  kami ucapkan terimakasih 🙏🙏

*Note:*
Materi Workshop dapat anda akses di aplikasi e-training dengan judul *" . $workshop->title_name . "*.
link aplikasi :
https://trusmicorp.com/e-training/question/exam/" . $workshop->title_id . "/1/" . $workshop->workshop_id . "

*List Karyawan:*
";
        $no = 1;
        foreach ($workshop_participant as $row) {
            $msg .= $no . ". " . $row->participant_name . "\n";
            $no++;
        }

        foreach ($workshop_participant as $participant) {
            $this->whatsapp_lib->send_single_msg('rsp', $participant->contact_no, $msg);
        }
    }


    public function send_notif_workshop_reminder()
    {
        $workshop_id = $this->input->post('workshop_id');
        $workshop = $this->model->get_workshop_title($workshop_id);
        if ($workshop->is_reminder <= 3) {
            $workshop_participant = $this->model->get_workshop_list_participant($workshop_id);
            $msg = "📌*REMINDER*📌

*Mengingatkan kepada seluruh Karyawan* yang ada di daftar Nama terlampir dibawah ini untuk dapat mengikuti Workshop *" . $workshop->title_name . "* yang akan diisi oleh *" . $workshop->trainer_name . "* pada

🗓️ Hari: *" . $workshop->tanggal . "* 
⏰ Jam: *" . $workshop->jam . "* 
📍 Tempat: *" . $workshop->tempat . "*

Mengingat pentingnya Workshop kali ini harap Bapak/ibu agar dapat hadir memenuhi undangan ini tepat waktu.

Atas perhatian dan dedikasi Bapak/Ibu  kami ucapkan terimakasih 🙏🙏

*Note:*
Materi Workshop dapat anda akses di aplikasi e-training dengan judul *" . $workshop->title_name . "*.
link aplikasi :
https://trusmicorp.com/e-training/question/exam/" . $workshop->title_id . "/1/" . $workshop->workshop_id . "

*List Karyawan:*
";
            $no = 1;
            foreach ($workshop_participant as $row) {
                $msg .= $no . ". " . $row->participant_name . "\n";
                $no++;
            }
            foreach ($workshop_participant as $participant) {
                $this->whatsapp_lib->send_single_msg('rsp', $participant->contact_no, $msg);
                $participant = [
                    'participant_name' => $participant->participant_name,
                    'contact_no' => $participant->contact_no
                ];
                $array_participant[] = $participant;
            }
            $this->model->update_reminder($workshop_id);
            $status = true;
        } else {
            $status = false;
            $array_participant = [];
        }

        $data['status'] = $status;
        $data['participant'] = $array_participant;
        echo json_encode($data);
    }
}
