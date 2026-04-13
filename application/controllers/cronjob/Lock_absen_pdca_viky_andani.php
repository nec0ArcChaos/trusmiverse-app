<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_absen_pdca_viky_andani extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function index()
    {
        echo "Cronjob insert to lock manual";
    }

    function insert_lock()
    {
        $pdca = [5121, 4770, 5534, 6806];
        foreach ($pdca as $row) {
            $data[] = [
                'employee_id' => $row,
                'type_lock' => 'kanban',
                'alasan_lock' => 'Segera kirimkan kanban dan Minute meeting direksi/ head untuk di review CEO - By Viky Andani',
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => 1139
            ];
        }
        if (date('w') != 6 && date('w') != 0) {
            $insert = $this->db->insert_batch('trusmi_lock_absen_manual', $data);
        } else {
            $insert = [];
        }
        echo json_encode($insert);
    }
}
