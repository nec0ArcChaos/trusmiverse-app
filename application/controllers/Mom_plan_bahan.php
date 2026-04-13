<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_plan_bahan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_mom', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'bahan_mom/' . $id,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    public function view($id)
    {
        $data['pageTitle']  = "Upload MoM - Plan Bahan";
        $data['id']    = $id;

        $this->load->view('mom/plan_bahan/detail', $data);
    }

    public function get_detail_plan()
    {
        $id = $_POST['id'];

        $result = $this->model->get_detail_plan($id);
        echo json_encode($result);
    }

    public function update_bahan()
    {
        $id_plan    = $_POST['id_plan'];
        $id_pic     = $_POST['id_pic'];
        $link       = $_POST['link_bahan'];
        $note       = $_POST['note_bahan'];

        if (!empty($_FILES['file_bahan']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/mom/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_plan . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_bahan')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $bahan = array(
            'attachment'    => $file_name,
            'link'          => $link,
            'note'          => $note,
            'updated_at'    => date('Y-m-d H:i:s'),
            'updated_by'    => $_SESSION['user_id']
        );

        $this->db->where("id_plan", $id_plan);
        $this->db->where("pic", $id_pic);
        $result['update'] = $this->db->update("mom_plan_bahan", $bahan);

        $this->send_wa_plan($id_plan,$id_pic);

        echo json_encode($result);
    }

    public function send_wa_plan($id_plan,$pic)
	{
		$result_text['wa_api'] 	= "";
		$bahan_mom       			= $this->model->get_bahan_send_wa($id_plan,$pic);

		foreach ($bahan_mom as $bahan) {
			$msg = "📑 *Uploaded File for Meeting*
			
💡 Judul : " . $bahan['judul'] . "
📍 Tempat : " . $bahan['tempat'] . "
📆 Tanggal : " . $bahan['tgl'] . "
🕗 Waktu : " . $bahan['waktu'] . "
👥 Peserta : " . $bahan['peserta'] . "
📝 Note : " . $bahan['note'] . "

📁 File : https://trusmiverse.com/apps/uploads/mom/" . $bahan['file'] . "
🔗 Link : " . $bahan['link'] . "
📝 Note Upload : " . $bahan['note_upload'] . "

👤 Uploaded By : ". $bahan['updated_by'] ."
⏰ Uploaded At : ". $bahan['updated_at'];

			// echo $msg;

			$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

			$data_text = array(
				// "channelID" => "2319536345",
				"channelID" => "2225082380",
				"phone" => $bahan['kontak'],
				// "phone" => "628993036965",
				"messageType" => "text",
				"body" => $msg,
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

			$context_text   = stream_context_create($options_text);
			$result_text['wa_api']    = file_get_contents($url, false, $context_text);
		}

		return $result_text;
	}	
}
