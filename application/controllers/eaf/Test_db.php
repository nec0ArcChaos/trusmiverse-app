<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Test_db extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->model('Model_auth', 'auth');
		$this->load->library("session");

		if ($this->session->userdata('user_id') != "") {
			$user_id = $this->session->userdata('user_id');
			$check_hak_akses = $this->auth->check_hak_akses('eaf/pengajuan', $user_id);
			if ($check_hak_akses != 'allowed') {
				redirect('forbidden_access', 'refresh');
			}
		} else {
			redirect('login', 'refresh');
		}
	}

    public function index()
    {
        $default_details = $this->_get_db_details($this->db);

        $data = array(
            "status" => true,
            "message" => "Database connection test",
            "connections" => array(
                "default" => $default_details
            )
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    private function _get_db_details($db)
    {
        $details = array(
            "connected" => false,
            "driver"    => null,
            "database"  => null,
            "mysql_version" => null,
        );

        try {
            // Cek koneksi
            $db->query("SELECT 1");
            $details["connected"] = true;

            $details["driver"]   = $db->dbdriver;
            $details["database"] = $db->database;

            $version_query = $db->query("SELECT VERSION() as version")->row();
            $details["mysql_version"] = $version_query ? $version_query->version : null;

        } catch (Exception $e) {
            // Jika error, biarkan default values
        }

        return $details;
    }
}
