<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Interview extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        // $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_interview', 'model');
        $this->load->model('Model_fack', 'model_fack');
        $this->load->model("model_profile");

		if ($this->session->userdata('user_id') != "") {
        } else {
			$application_id = $this->uri->segment(4);
			$link = array(
				'previus_link'	=> 'recruitment/interview/detail/' . $application_id,
			);

			// echo json_encode($link);
			// die();

			$this->session->set_userdata($link);

            redirect('login', 'refresh');
        }

    }

	function test(){
		echo $this->session->userdata('user_id');
	}

    function index()
    {
        $user = $this->session->userdata('user_id');

        $data['pageTitle']        = "Interview";
        $data['css']              = "recruitment/interview/css";
        $data['js']               = "recruitment/interview/js";
        $data['content']          = "recruitment/interview/index";

        $data['data_karyawan'] 		= $this->model->data_karyawan();
        $data['alasan']          	= $this->model->get_alasan('Interview HR');

        $this->load->view('layout/main', $data);
    }

    function get_candidates()
    {
        $start = isset($_POST['start']) ? $_POST['start'] : null;
        $end = isset($_POST['end']) ? $_POST['end'] : null;
        $id = $_POST['id'];
		$job_id = isset($_POST['job_id']) ? $_POST['job_id'] : null;

		$data['id'] = $id;
		$data['job_id'] = $job_id;
        $data['data'] = $this->model->get_candidates($start, $end, $id, $job_id);
        echo json_encode($data);
    }

	function get_loker()
    {
        $data['loker'] = $this->model->get_loker();
        echo json_encode($data);
    }

    function save_status()
    {
        $data1 = array(
			'application_id' 		=> $_POST['application_id'],
			'application_status' 	=> $_POST['status_hasil'],
			'id_user_interview' 	=> $_POST['id_user_interview'],
			'keterangan' 			=> $_POST['keterangan'],
			'created_by' 			=> $this->session->userdata('user_id'),
			'created_at' 			=> date('Y-m-d H:i:s')
		);

		// $query = $this->db->get_where('trusmi_interview', array('application_id' => $_POST['application_id']));

		// if ($query->num_rows() > 0) {
		// 	$this->db->where('application_id', $_POST['application_id']);
		// 	$this->db->update('trusmi_interview', $data1);
		// } else {
		// 	$this->db->insert('trusmi_interview', $data1);
		// }		     

        if ($_POST['status_hasil'] == 6) {
            $alasan = $_POST['select_alasan'];
        } else {
            $alasan = null;
        }

		if ($_POST['sales'] == 1) {
			echo "disini";
			$data2 = array(
				'application_status' 	=> $_POST['status_hasil'],
				'alasan_gagal_join' 	=> $alasan,
				'job_id' 				=> $_POST['job_id'],
				'job_id_before' 		=> $_POST['job_id_before'],
				'type' 					=> $_POST['type'],
				'grade' 				=> $_POST['grade'],
			);
		} else {
			$data2 = array(
				'application_status' 	=> $_POST['status_hasil'],
				'alasan_gagal_join' 	=> $alasan,
				'job_id' 				=> $_POST['job_id'],
				'job_id_before' 		=> $_POST['job_id_before'],
			);
		}


		$this->db->where('application_id', $_POST['application_id']);
		$result = $this->db->update('xin_job_applications', $data2);

		// if ($this->session->userdata('user_id') != 1) {
			if ($_POST['status_hasil'] == '5') {
				$this->send_wa_interview_result($_POST['application_id']);
			}

			$this->post_fack($_POST['application_id'], $this->session->userdata('user_id'));
		// }

        return $result;
    }

    // Faisal 11/11/2023
	public function send_wa_interview_result($application_id)
	{
		$result_text['wa_api'] = "";
		$interview       = $this->model->get_send_interview_result($application_id);

		// $kontak[] 	= '628993036965';
		// $kontak[] 	= '6285860428016';
		// $kontak[] 	= '6285353625600';
		// $kontak[] 	= '6282316041423'; // mas ari
		$kontak[]	= $interview['contact_request'];

		$str = $interview['jobdesk'];
		$deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
		$deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

		// Jika ada Datanya maka dibuat melalui Permintaan Karyawan, jika tidak ada datanya maka langsung dari Job Post
		if ($interview['company']) {
			foreach ($kontak as $key => $value) {
				$url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

				$data_text = array(
					"channelID" => "2225082380",
					"phone" => $value,
					"messageType" => "text",
					"body" => "👤Alert!!! 

*Interview Result*

🏣Company : " . $interview['company'] . "
🗃️Department : " . $interview['department'] . "
📍Position : *" . $interview['position'] . "*
📍Location : " . $interview['location_name'] . "
👤User FPK : " . $interview['requester'] . "
🏆Level : " . $interview['level'] . "
📝Need : " . $interview['need'] . "
🔒Status : " . $interview['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

Terdapat pengajuan rekomendasi interview dengan detail informasi sbb : 

👤Nama Kandidat : " . $interview['full_name'] . "
📝Keterangan Rekomedasi HR : " . $interview['keterangan'] . "",
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
		}

		return $result_text;
	}

    // Kebutuhan Fack - Aris
	function post_fack($application_id, $hr_by)
	{
		$hr_by = $this->hashApplicantId($hr_by);
		$hash_application_id = $this->hashApplicantId($application_id);

		// Konfigurasi endpoint REST API
		$url = 'https://trusmiverse.com/apps/fack/generate_fack/' . $hash_application_id . '/' . $hr_by;

		$options_text = array(
			'http' => array(
				"method"  => 'GET',
				"header" =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n"
			)
		);

		$context_text   = stream_context_create($options_text);
		$result_text    = @file_get_contents($url, false, $context_text);

		// echo json_encode($result_text);
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
	// End - Fack

    public function detail($ciphertext = null)
    {
        // if ($this->session->userdata('user_id') != "") {
            if (isset($ciphertext)) {
                $application_id             = preg_replace('/[^0-9.]+/', '', $ciphertext);
                $calon_karyawan             = $this->model_fack->get_data_calon_karyawan_by_id($application_id);
                $m_pendidikan               = $this->model_fack->get_pendidikan();
                $agama                      = $this->model_fack->get_agama();
                $data['pageTitle']          = "Interview";
                $data['ck']                 = $calon_karyawan;
                $data['agama']              = $agama;
                $data['m_pendidikan']       = $m_pendidikan;

				$his = $this->model->get_history($calon_karyawan['full_name']);
				$data['jml_lamar'] 			= count($his);
				// var_dump($data['jml_lamar']); // Inspect the structure of $his
				// die();


                $this->load->view('recruitment/interview/detail', $data);
            } else {
                $response['status'] = 400;
                $response['msg'] = "Bad Request";
                echo json_encode($response);
            }
        // } else {
            // redirect('login', 'refresh');
        // }
    }

	public function get_history(){

		$name = $_POST['name'];

		$data = $this->model->get_history($name);

		echo json_encode($data);
	}

    public function approve_status(){
        $recruiter_id = $this->session->userdata('user_id');

		$data = $this->model->approve_status($recruiter_id);

		echo json_encode($data);
	}

    public function reject_status(){

		$recruiter_id = $this->session->userdata('user_id');

		$data = $this->model->reject_status($recruiter_id);

		echo json_encode($data);
	}

	function hasil_status()
    {
		$application_id = $_POST['application_id_e'];

        $data = array(
			'is_lolos' 			=> $_POST['is_lolos'],
			'hasil_interview' 	=> $_POST['alasan_hasil'],
		);

		$this->db->where('application_id', $application_id);
		$result = $this->db->update('xin_job_applications', $data);

        return $result;
    }

	// addnew
	function get_candidates_for_feedback()
    {
        $start = isset($_POST['start']) ? $_POST['start'] : null;
        $end = isset($_POST['end']) ? $_POST['end'] : null;
        $id = $_POST['id'];
		$job_id = isset($_POST['job_id']) ? $_POST['job_id'] : null;

		$user_id = $this->session->userdata('user_id');

		$data['id'] = $id;
		$data['job_id'] = $job_id;
        $data['data'] = $this->model->get_candidates_for_feedback($start, $end, $id, $job_id, $user_id);
        echo json_encode($data);
    }
}
