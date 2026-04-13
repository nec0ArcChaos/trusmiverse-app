<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_resignation_cron extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // cron job function
    public function auto_non_aktif_user()
    {
        $this->load->database();
        $kry = $this->db->query("SELECT user_id, is_active FROM xin_employees WHERE date_of_leaving BETWEEN '2023-05-01' AND SUBDATE(CURRENT_DATE,INTERVAL 1 DAY) AND is_active = 1 UNION 
        SELECT user_id, is_active FROM xin_employees JOIN rsp_project_live.`user` rsp_user ON rsp_user.join_hr = xin_employees.user_id WHERE date_of_leaving BETWEEN '2023-05-01' AND SUBDATE(CURRENT_DATE,INTERVAL 1 DAY) AND is_active = 0 AND rsp_user.isActive = 1");
        $response['jumlah_data'] = $kry->num_rows();
        $response['cron_text'] = 'Non Aktifkan Karyawan';
        if ($kry->num_rows() > 0) {
            foreach ($kry->result() as $k) {
                $user_id = $k->user_id;
                $data_kry = array(
                    'user_id' => $user_id,
                    'is_active' => $k->is_active
                );
                $d[] = $data_kry;
                $response['data'] = $d;
                $data_status = [
                    'is_active' => 0
                ];
                $update = $this->db->where('user_id', $user_id)->update('xin_employees', $data_status);
                $apakah_ada_akun_rsp = $this->db->query("SELECT * FROM rsp_project_live.`user` WHERE join_hr = '$user_id' AND isActive = 1")->num_rows();
                if ($apakah_ada_akun_rsp > 0) {
                    $data_status_rsp = [
                        'isActive' => 0,
                        'nonactive_at' => date("Y-m-d H:i:s"),
                        'nonactive_by' => 'Auto Non Aktif Cron'
                    ];
                    $update = $this->db->where('join_hr', $user_id)->update('rsp_project_live.`user`', $data_status_rsp);
                }

                $response['update'] = $update;
            }
        }
        $response = '';
        echo json_encode($response);
    }
}
