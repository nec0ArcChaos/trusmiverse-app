<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_spv_recruitment extends CI_Controller
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

    function insert_lock2()
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

    function insert_lock()
    {
        $data = [
            'employee_id' => 2535, // Nani handayani
            'type_lock' => 'other',
            'alasan_lock' => 'Mohon untuk segera submit Kandidat untuk LGD Executive Assistant dengan rules 1. Minimal 4 kandidat 2. Kandidat IQ minimal 100 3. Tiu minimal 19 - By Viky Andani',
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1139 // Viky Andani
        ];

        $insert = $this->db->insert('trusmi_lock_absen_manual', $data);
        
        echo json_encode($insert);
    }

    // Autolock untuk HR Batik a.n Nining Sandra setiap hari jum'at (Nonaktif)
    function insert_lock_nining()
    {
        $data = [
            'employee_id' => 70, // Nining sandra aeni
            'type_lock' => 'other',
            'alasan_lock' => 'Mohon untuk segera kirimkan 4 Kandidat R&D Engineering - By Viky Andani',
            'status' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => 1139 // Viky Andani
        ];

        $insert = $this->db->insert('trusmi_lock_absen_manual', $data);
        
        echo json_encode($insert);
    }
}
