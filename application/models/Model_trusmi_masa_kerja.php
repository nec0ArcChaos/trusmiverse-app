<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_masa_kerja extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function dt_list_masa_kerja($type, $start, $end)
    {

        $list_head = $this->db->query(
            "SELECT 
                            xin_departments.head_id
                        FROM xin_departments 
                        JOIN xin_employees ON xin_employees.user_id = xin_departments.head_id
                        WHERE xin_employees.is_active = 1
                        AND xin_employees.user_id != 323
                        GROUP BY xin_departments.head_id"
        )->result();



        // Kondisi Baru Pak Idham : Tgl 4 Febuari 2025
        // 76	Outsourcing
        // 80	Estate & MEP
        // 106	Project
        // 158	Purchasing & Perencana
        // 161	After Sales & Estate (N/A)
        // 183	Research & Development
        // 199	Konveksi
        // 204	Research Development & Quality Control
        // 205	Fabrikasi
        // 206	Infrastructure 
        // 207	Land Clearing
        $array_dept = [];
        $where_dept = "";
        if ($_SESSION['user_id'] == 1186) {
            $array_dept = [
                106,
                158,
                80,
                28,
                76,
                204,
                161,
                207,
                183,
                205,
                206,
                199,
                204
            ];
            $where_dept = "AND xin_employees.department_id IN ('" . implode("','", $array_dept) . "')";
        }
        $array_head = [];
        foreach ($list_head as $key => $value) {
            array_push($array_head, $value->head_id);
        }


        $user_id = $_SESSION['user_id'];
        $super_user = ['1', '979', '323', '2951', '3388', '778', '6486', '1139'];
        if (in_array($user_id, $super_user) == 1) { // 979 : personalia, 323 : pak hendra
            $kondisi_user = "";
        } else if (in_array($user_id, $array_head) == 1) {
            $kondisi_user = "AND head.user_id = $user_id $where_dept";
        } else {
            $kondisi_user = "AND xin_employees.user_id = $user_id";
        }


        if ($type == 1) {
            if ($start == 0 && $end == 0) {
                $kondisi = "";
            } else {
                $start = ($start == 1) ? 0 : $start;
                $kondisi = "AND TIMESTAMPDIFF( MONTH, employee_contract.to_date, CURDATE( ) ) >= $start 
				AND TIMESTAMPDIFF( MONTH, employee_contract.to_date, CURDATE( ) ) <= $end";
            }
        } else {
            $kondisi = "AND employee_contract.to_date BETWEEN '" . date('Y-m-d', strtotime($start)) . "' AND '" . date('Y-m-d', strtotime($end)) . "'";
        }
        //         $query = "SELECT
        //                     xin_employees.employee_id,
        //                     xin_employees.user_id,
        //                     CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS nama,
        //                     xin_employees.date_of_joining AS tgl_gabung,
        //                     xin_companies.`name` AS company,
        //                     xin_departments.department_name AS department,
        //                     xin_designations.designation_name AS designation,
        //                     employee_contract.to_date AS habis_kontrak,
        //                     -- IF(DATE_ADD(CURDATE(),INTERVAL 2 MONTH) >= employee_contract.to_date,'show','hide') AS hide_kontrak,
        //                     COALESCE(TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1, 0) AS total_day,
        //                     ROUND( ( TIMESTAMPDIFF( MONTH, xin_employees.date_of_joining, CURDATE( ) ) / 12 ), 1 ) AS masa_kerja,
        //                     xin_contract_type.`name` AS status_kontrak,
        //                     CONCAT(ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1) / 30), ' Month ', ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1) % 30), ' Days') AS remaining,
        //                     CONCAT( head.first_name, ' ', head.last_name ) AS head,
        //                     xin_departments.head_id,
        //                     -- COALESCE(trusmi_renewal_contract.id,'') AS id_renewal,
        //                     -- COALESCE(trusmi_renewal_contract.`status`,'') AS status_renewal,
        //                     -- COALESCE(trusmi_renewal_contract.`renewal`,'') AS renewal,
        //                     -- COALESCE(trusmi_renewal_contract.`feedback`,'') AS feedback,
        //                     COALESCE ( new.id,'' ) AS id_renewal,
        //                     IF(new.id IS NOT NULL, '', trusmi_renewal_contract.`status`) AS status_renewal,
        //                     IF(new.id IS NOT NULL, '', trusmi_renewal_contract.`renewal`) AS renewal,
        //                     IF(new.id IS NOT NULL, '', trusmi_renewal_contract.`feedback`) AS feedback,
        //                     IF(CURDATE() > IF(new.id IS NOT NULL, '', trusmi_renewal_contract.contract_end),'',IF(new.id IS NOT NULL, '', trusmi_renewal_contract.contract_end)) AS hide_kontrak 
        //                 FROM xin_employees
        //                 LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        //                 LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
        //                 LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        //                 LEFT JOIN (SELECT
        //                     max_id.contract_id,
        //                     max_id.employee_id,
        //                     max_id.max_date,
        //                     xin_employee_contract.contract_type_id,
        //                     xin_employee_contract.to_date 
        //                 FROM
        //                 (SELECT
        //                     xin_employee_contract.contract_id,
        //                     xin_employee_contract.employee_id,
        //                     MAX( CASE 
        //                             WHEN xin_employee_contract.to_date = '' 
        //                                 THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) 
        //                             ELSE xin_employee_contract.to_date 
        //                         END
        //                     ) AS max_date 
        //                     FROM xin_employee_contract 
        //                     GROUP BY xin_employee_contract.employee_id 
        //                 ) AS max_id
        //                 JOIN xin_employee_contract ON max_id.employee_id = xin_employee_contract.employee_id 
        //                     AND max_id.max_date = CASE 
        //                                             WHEN xin_employee_contract.to_date = '' 
        //                                                 THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) 
        //                                             ELSE xin_employee_contract.to_date 
        //                                         END 
        //                     GROUP BY max_id.employee_id
        //                 ) AS employee_contract ON xin_employees.user_id = employee_contract.employee_id
        //                 LEFT JOIN xin_contract_type ON employee_contract.contract_type_id = xin_contract_type.contract_type_id 
        //                 -- Head yg dipakai di OD
        //                 -- LEFT JOIN xin_employees head ON head.user_id = xin_employees.ctm_report_to 
        //                 -- Head yg dipakai di trusmiverse
        //                 LEFT JOIN xin_employees head ON head.user_id = xin_departments.head_id
        //                 LEFT JOIN trusmi_renewal_contract ON trusmi_renewal_contract.employee_id = xin_employees.user_id                
        //                 LEFT JOIN trusmi_renewal_contract AS new ON new.employee_id = xin_employees.user_id AND new.`status` IS NULL
        //                 WHERE xin_employees.is_active != 0
        // -- 										AND trusmi_renewal_contract.id IS NOT NULL
        // -- 										AND trusmi_renewal_contract.`status` IS NULL
        //                 $kondisi
        //                 $kondisi_user
        //             GROUP BY xin_employees.employee_id";

        $query = "SELECT
                        xin_employees.employee_id,
                        xin_employees.user_id,
                        CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS nama,
                        xin_employees.date_of_birth,
                        xin_employees.date_of_joining AS tgl_gabung,
                        xin_companies.`name` AS company,
                        xin_departments.department_name AS department,
                        xin_designations.designation_name AS designation,
                        employee_contract.to_date AS habis_kontrak,
                    -- IF(DATE_ADD(CURDATE(),INTERVAL 2 MONTH) >= employee_contract.to_date,'show','hide') AS hide_kontrak,
                        COALESCE ( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1, 0 ) AS total_day,
                        ROUND( ( TIMESTAMPDIFF( MONTH, xin_employees.date_of_joining, CURDATE( ) ) / 12 ), 1 ) AS masa_kerja,
                        xin_contract_type.`name` AS status_kontrak,
                        IF(FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30)=0,
                            CONCAT((DATEDIFF(employee_contract.to_date, CURDATE()) % 30)+1,' Days'),
                            CONCAT(
                                FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30),
                                ' Month ',
                                ROUND(( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1 ) % 30 ),
                                ' Days' 
                            )
                        ) AS remaining,
                        CONCAT( head.first_name, ' ', head.last_name ) AS head,
                        xin_departments.head_id,
                        IF(employee_contract.contract_type_id = 1, '', COALESCE ( renewal_new.id, '' )) AS id_renewal,
                    IF ( renewal_new.id IS NOT NULL, '', IF(CURDATE() > DATE_ADD(renewal_old.contract_end,INTERVAL 3 MONTH),'', renewal_old.`status`) ) AS status_renewal,
                    IF ( renewal_new.id IS NOT NULL, '', IF(CURDATE() > DATE_ADD(renewal_old.contract_end,INTERVAL 3 MONTH),'', renewal_old.`renewal`) ) AS renewal,
                    IF ( renewal_new.id IS NOT NULL, '', IF(CURDATE() > DATE_ADD(renewal_old.contract_end,INTERVAL 3 MONTH),'', renewal_old.`feedback`) ) AS feedback,
                    CASE 
                        WHEN employee_contract.contract_type_id = 1 THEN
                            ''
                        WHEN renewal_new.id IS NOT NULL THEN
                            ''
                        -- WHEN CURDATE() >= DATE_ADD(renewal_old.contract_end,INTERVAL 1 MONTH) THEN
                        --     ''
                        ELSE
                            renewal_old.contract_end
                    END AS hide_kontrak,
                    -- IF ( CURDATE() > IF ( renewal_new.id IS NOT NULL, '', renewal_old.contract_end ),
                    --         '', IF ( renewal_new.id IS NOT NULL, '', renewal_old.contract_end )) AS hide_kontrak 
                    COALESCE(renewal_old.feedback_by,'') AS feedback_by
                    FROM
                        xin_employees
                        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
                        LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
                        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
                        LEFT JOIN xin_employee_contract AS employee_contract ON xin_employees.user_id = employee_contract.employee_id AND employee_contract.is_active = 1 AND employee_contract.contract_type_id != 5
                            LEFT JOIN xin_contract_type ON employee_contract.contract_type_id = xin_contract_type.contract_type_id 
                    -- Head yg dipakai di OD
                    -- LEFT JOIN xin_employees head ON head.user_id = xin_employees.ctm_report_to
                    -- Head yg dipakai di trusmiverse
                            LEFT JOIN xin_employees head ON head.user_id = xin_departments.head_id
                            LEFT JOIN (
                            SELECT
                                new.id,
                                new.employee_id,
                                new.contract_end,
                                new.deadline,
                                new.`status`,
                                new.feedback,
                                new.renewal,
                                COALESCE(CONCAT(xe.first_name, ' ', xe.last_name), '') AS feedback_by
                            FROM
                                trusmi_renewal_contract AS new
                                JOIN ( SELECT MAX( ID ) AS id, employee_id FROM trusmi_renewal_contract WHERE `status` IS NOT NULL GROUP BY employee_id ) AS max ON max.id = new.id
                                LEFT JOIN xin_employees xe ON xe.user_id = new.feedback_by 
                            ) AS renewal_old ON renewal_old.employee_id = xin_employees.user_id
                            LEFT JOIN ( SELECT id, employee_id, `status` FROM trusmi_renewal_contract WHERE `status` IS NULL GROUP BY employee_id ) AS renewal_new ON renewal_new.employee_id = xin_employees.user_id 
                        WHERE
                        xin_employees.is_active != 0 
                        
                    -- 										AND trusmi_renewal_contract.id IS NOT NULL
                    -- 										AND trusmi_renewal_contract.`status` IS NULL
                    $kondisi
                    $kondisi_user
                    GROUP BY xin_employees.employee_id";

        return $this->db->query($query)->result();
    }


    // OLD

    public function dt_trusmi_resignation($start, $end)
    {
        $user_id = $this->session->userdata("user_id");
        $department_id = $this->session->userdata("department_id");
        $super_user = ['1', '979', '323', '2951', '3388', '6486', '1139'];
        if ($department_id == 68 || in_array($user_id, $super_user) == 1) {
            $cond = "";
        } else {
            $cond = "AND r.added_by = '$user_id'";
        }
        $query = "SELECT
                    r.resignation_id,
                    r.company_id,
                    c.`name` AS company_name,
                    e.department_id,
                    d.department_name,
                    r.designation_id,
                    ds.designation_name,
                    r.employee_id,
                    CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                    r.notice_date,
                    r.resignation_date,
                    r.reason,
                    r.note,
                    r.added_by,
                    CASE WHEN r.`status` = 0 THEN 'Not Approved' 
                    WHEN r.`status` = 1 THEN 'Approve MM' 
                    WHEN r.`status` = 2 THEN 'Approve HRD' 
                    WHEN r.`status` = 3 THEN 'Approve GM'
                    ELSE  'Not Approved' END AS status_resignation,
                    r.created_at,
                    r.pernyataan_1,
                    r.pernyataan_2,
                    r.pernyataan_3,
                    r.pernyataan_4,
                    r.pernyataan_5,
                    r.pernyataan_6,
                    r.pernyataan_7,
                    r.pernyataan_8,
                    r.pernyataan_9,
                    r.pernyataan_10 
                FROM
                    xin_employee_resignations r
                    JOIN xin_employees e ON r.employee_id = e.user_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    AND ds.department_id = e.department_id 
                    AND ds.company_id = e.company_id
                    LEFT JOIN xin_departments d ON d.company_id = e.company_id 
                    AND d.department_id = e.department_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id
                WHERE
                    resignation_date BETWEEN '$start' AND '$end' $cond";
        return $this->db->query($query);
    }

    public function get_profile($user_id)
    {
        $query = "SELECT
                        user_id,
                        CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                        e.company_id,
                        c.`name` AS company_name,
                        e.department_id,
                        d.department_name,
                        e.designation_id,
                        ds.designation_name
                    FROM
                        xin_employees e
                        left JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND e.company_id = ds.company_id
                        left JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
                        left JOIN xin_companies c ON c.company_id = e.company_id
                    WHERE user_id = '$user_id'";
        return $this->db->query($query);
    }

    public function get_profile_resignation($id_resignation)
    {
        $query = "SELECT
                        user_id,
                        CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                        e.company_id,
                        c.`name` AS company_name,
                        e.department_id,
                        d.department_name,
                        e.designation_id,
                        ds.designation_name,
                        e.contact_no,
                        e.address
                    FROM
                        xin_employees e
                        JOIN (SELECT karyawan FROM trusmi_exit_clearance WHERE id_resignation='$id_resignation' GROUP BY id_resignation) AS ec ON ec.karyawan = e.user_id
                        left JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND e.company_id = ds.company_id
                        left JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
                        left JOIN xin_companies c ON c.company_id = e.company_id";
        return $this->db->query($query);
    }

    public function store($data)
    {
        $this->db->insert('xin_employee_resignations', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_last_id_resignation_by_user_id($user_id)
    {
        $query = "SELECT resignation_id FROM `xin_employee_resignations` WHERE employee_id = '$user_id'";
        $data = $this->db->query($query)->row();
        $resignation_id = 0;
        if ($data) {
            $resignation_id = $data->resignation_id;
        }
        return $resignation_id;
    }

    public function get_subclearance()
    {
        $query = "SELECT
        trusmi_subclearance.id,
        pic 
    FROM
        trusmi_subclearance
        LEFT JOIN trusmi_clearance ON trusmi_subclearance.id_clearance = trusmi_clearance.id";
        return $this->db->query($query)->result();
    }

    public function get_trusmi_resignation_by_id($id_resignation)
    {
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT
                    ec.id_resignation,
                    ec.karyawan as employee_id,
                    CONCAT(e.first_name,' ',last_name) AS employee_name,
                    sc.subclearance,
                    ec.`status`,
                    CASE WHEN ec.`status` = 0 THEN 'Not Approved' 
                    WHEN ec.`status` = 1 THEN 'Approve MM' 
                    WHEN ec.`status` = 2 THEN 'Approve HRD' 
                    WHEN ec.`status` = 3 THEN 'Approve GM'
                    ELSE  'Not Approved' END AS status_resignation
                FROM
                    trusmi_exit_clearance ec
                    LEFT JOIN xin_employees e ON e.user_id = ec.karyawan
                    LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
                WHERE
                    id_resignation = '173' 
                    AND pic = '61'";
        return $this->db->query($query)->result();
    }
}
