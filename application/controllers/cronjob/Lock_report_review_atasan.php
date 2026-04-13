<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_report_review_atasan extends CI_Controller
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

    // Insert weekly on every tuesday
    function insert_ev_tuesday()
    {
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_review_pa = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('review PA', $user, 'Silahkan melakukan review Personal Assitant dan dapat mengirim hasilnya kepada pak Ibnu - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_review_pa;
    }

    function insert_lock()
    {
        $created_by = 1; // Fafrycony

        $users = [5840];
        // $users = [2,17,61,64,68,70,76,77,78,90,97,116,118,168,177,183,290,321,323,331,340,341,360,365,368,369,476,477,637,757,767,807,840,847,867,998,1040,1139,1161,1181,1186,1203,1207,1287,1293,1339,1369,1524,1576,1584,1610,1614,1633,1637,1709,1729,1784,1844,1897,1898,1948,1997,2108,2195,2212,2296,2397,2407,2521,2526,2535,2625,2685,2733,2768,2842,2896,2951,2975,3013,3070,3288,3388,3501,3529,3961,4134,4138,4215,4251,4405,4498,5121,5214,5264,5286,5504,5505,5534,5647,5666,5768,5941,6030,6466,7041,7072,7343,7492,7761,7804,8066,8079,8138,8206,8229,8480,8688,8796,8887,8888,8889,8890,9095,9484,9979,10068,10113,10133,10231,10257,10278,10458,10908,10943,11000,11199,11210,11212,11264,11374,11417];

        foreach ($users as $user) {
            $insert = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`, `activity`) 
                                        VALUES 
                                        ('other', $user, 'Silahkan mengumpulkan Report Review Kinerja Atasan terhadap Tim mingguan - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL, 'Report Review Kinerja Atasan - By Fafricony Ristiara Devi')");
        }

    }

    function insert_lock_batch()
    {
        $created_by = 78; // Fafrycony

        // $users = [5840, 1161];
        // $users = [2,17,61,64,68,70,76,77,78,90,97,116,118,168,177,183,290,321,323,331,340,341,360,365,368,369,476,477,637,757,767,807,840,847,867,998,1040,1139,1161,1181,1186,1203,1207,1287,1293,1339,1369,1524,1576,1584,1610,1614,1633,1637,1709,1729,1784,1844,1897,1898,1948,1997,2108,2195,2212,2296,2397,2407,2521,2526,2535,2625,2685,2733,2768,2842,2896,2951,2975,3013,3070,3288,3388,3501,3529,3961,4134,4138,4215,4251,4405,4498,5121,5214,5264,5286,5504,5505,5534,5647,5666,5768,5941,6030,6466,7041,7072,7343,7492,7761,7804,8066,8079,8138,8206,8229,8480,8688,8796,8887,8888,8889,8890,9095,9484,9979,10068,10113,10133,10231,10257,10278,10458,10908,10943,11000,11199,11210,11212,11264,11374,11417,355];

        // By ctm_posisi
        // $users = [2,17,61,64,68,70,76,77,78,90,97,116,168,177,183,290,321,323,331,340,341,355,360,365,368,369,476,477,637,757,767,778,807,840,847,867,998,1040,1139,1161,1181,1186,1203,1207,1287,1293,1339,1369,1524,1576,1584,1610,1614,1633,1637,1709,1729,1784,1826,1844,1897,1898,1948,1997,2108,2195,2212,2296,2397,2407,2521,2526,2535,2625,2685,2733,2768,2842,2896,2951,2975,3013,3070,3288,3325,3388,3501,3529,3961,4134,4138,4215,4405,4498,4831,5121,5214,5264,5286,5504,5505,5533,5534,5647,5666,5768,6030,6466,7041,7072,7343,7492,7731,7761,7804,8066,8079,8138,8229,8480,8688,8796,8887,8888,8889,8890,9095,9484,9621,9979,10068,10113,10133,10231,10257,10278,10458,10908,10943,11000,11199,11210,11212,11264,11374,11417,11523];

        // By ctm_posisi NEW
        // $users = [2,17,61,64,68,70,76,77,78,90,97,116,168,177,183,290,321,323,331,340,341,355,360,365,368,369,476,477,637,757,767,778,807,840,847,867,998,1040,1139,1161,1181,1186,1203,1207,1287,1293,1339,1369,1524,1576,1584,1610,1614,1633,1637,1709,1729,1784,1826,1844,1897,1898,1948,1997,2108,2195,2212,2296,2397,2407,2521,2526,2535,2625,2685,2733,2768,2842,2896,2951,3013,3070,3288,3325,3388,3501,3529,3961,4134,4138,4405,4498,4831,5121,5214,5264,5286,5505,5533,5534,5647,5666,5768,6030,6466,7041,7492,7731,7761,7804,8066,8079,8138,8229,8480,8688,8796,8887,8888,8889,8890,9095,9484,9520,9621,9633,9979,10068,10113,10133,10231,10257,10278,10908,10943,11000,11199,11210,11212,11264,11374,11417,11523,11594,11621,11797,11811];

        $arr_users = [];

        $sql = "SELECT
                    user_id,
                    first_name,
                    ctm_posisi,
                    role_name
                FROM
                    xin_employees 
                    JOIN xin_user_roles ON xin_user_roles.role_id = xin_employees.user_role_id
                WHERE
                    ctm_posisi IN ( 'Supervisor', 'Manager', 'Assistent Manager', 'Head', 'Direktur' ) 
                    AND is_active = 1
                    AND user_id NOT IN (803,118,5504)
                    AND xin_employees.company_id <> 3";

        // $sql_test = "SELECT
        //                 user_id,
        //                 first_name,
        //                 ctm_posisi
        //             FROM
        //                 xin_employees
        //             WHERE
        //                 user_id IN (1,5840)";

        $query = $this->db->query($sql)->result_array();

        foreach ($query as $row) {
            $arr_users[] = $row['user_id'];
        }

        // foreach ($arr_users as $user_id) {
        //     echo $user_id . "<br>";
        // }
        // die();

        $data = [];

        foreach ($arr_users as $user) {
            $data[] = [
                'type_lock'   => 'other',
                'employee_id'=> $user,
                'alasan_lock'=> 'Pengumpulan Report Review Kinerja Tim ke Comben - By Fafricony Ristiara Devi',
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $created_by,
                'activity'   => 'Silahkan mengumpulkan Report Review Kinerja Tim ke Comben - By Fafricony Ristiara Devi'
            ];
        }

        $this->db->insert_batch('trusmi_lock_absen_manual', $data);

        echo "Total berhasil insert: ".$this->db->affected_rows();

    }

}
