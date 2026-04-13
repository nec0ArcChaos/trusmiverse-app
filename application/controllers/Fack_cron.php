<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fack_cron extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // cron job function
    public function auto_aktif_user()
    {
        $this->load->database();
        $kry = $this->db->query("SELECT user_id FROM xin_employees WHERE date_of_joining = CURRENT_DATE AND is_active = 0 AND date_of_leaving = ''");
        $response['jumlah_data'] = $kry->num_rows();
        $response['cron_text'] = 'Aktifkan Karyawan';
        if ($kry->num_rows() > 0) {
            foreach ($kry->result() as $k) {
                $user_id = $k->user_id;
                $data_status = [
                    'is_active' => 1
                ];
                $response['update'] = $this->db->where('user_id', $user_id)->update('xin_employees', $data_status);
            }
        }
        echo json_encode($response);
    }
}
