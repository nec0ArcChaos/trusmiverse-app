<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_renewal_contract extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function data_renewal($id)
    {
        $query = "SELECT
                    trusmi_renewal_contract.id,
                    trusmi_renewal_contract.employee_id,
                    CONCAT(xin_employees.first_name, ' ', xin_employees.last_name) AS nama,
                    REPLACE(REPLACE(REPLACE(xin_employees.contact_no,'-',''),' ',''),'+','') AS no_hp,
                    xin_designations.designation_name AS jabatan,
                    xin_departments.department_name AS departemen,
                    xin_companies.`name` AS company,
                    CONCAT(
                        FLOOR(DATEDIFF(DATE(NOW()), xin_employees.date_of_joining) / 365), 
                        '.',
                        FLOOR((DATEDIFF(DATE(NOW()), xin_employees.date_of_joining) % 365) / 30)
                    ) AS masa_kerja,
                    employee_contract.to_date AS habis_kontrak,
                    DATEDIFF(employee_contract.to_date,CURRENT_DATE)+1 AS sisa_kontrak,
                    COALESCE(trusmi_renewal_contract.status, '') AS status,
                    COALESCE(trusmi_renewal_contract.feedback, '') AS feedback,
                    COALESCE(trusmi_renewal_contract.renewal, '') AS renewal,
                    xin_companies.company_id, -- addnew
                    COALESCE(trusmi_renewal_contract.appropriate, '') AS masih_sesuai,
                    -- trusmi_renewal_contract.appropriate AS masih_sesuai,
                    COALESCE(trusmi_renewal_contract.file_kpi, '') AS file_kpi
                FROM trusmi_renewal_contract 
                LEFT JOIN xin_employees ON xin_employees.user_id = trusmi_renewal_contract.employee_id
                LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
                LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
                LEFT JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id
                LEFT JOIN (SELECT
                            max_id.employee_id,
                            hris.xin_employee_contract.to_date 
                    FROM
                            (
                                SELECT
                                    hris.xin_employee_contract.employee_id,
                                    MAX( CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date END ) AS max_date 
                                FROM
                                    hris.xin_employee_contract 
                                WHERE  hris.xin_employee_contract.is_active = 1
                                GROUP BY
                                        hris.xin_employee_contract.employee_id 
                            ) AS max_id
                            JOIN hris.xin_employee_contract ON max_id.employee_id = hris.xin_employee_contract.employee_id 
                            AND max_id.max_date = CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date 
                            END 
                    GROUP BY
                            max_id.employee_id
                ) AS employee_contract ON hris.xin_employees.user_id = employee_contract.employee_id
                WHERE trusmi_renewal_contract.id = $id LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    function data_penilaian_subjektif($id_renewal)
    {
        $query = "SELECT * FROM t_penilaian_subjektif_renewal WHERE id_renewal = '$id_renewal'";
        return $this->db->query($query)->row_array();
    }


    function list_renewal()
    {
        $user_id = $this->session->userdata('user_id');
        if ($user_id == 1 || $user_id == 979 || $user_id == 778) {
            $kondisi = "";
        } else {
            // $list_pm = [
            //     1293, // Rizky Ginanjar
            //     1637, // Tedi Yanuar
            //     3529, // Yoggi Rishandi
            // ];

            if ($user_id == 1293 || $user_id == '1637' || $user_id == '3529') {
                $kondisi = "AND c.dept_head = 1186"; // 1186 idham
            } else {
                // $kondisi = "AND c.dept_head = $user_id";
                $kondisi = "AND c.dept_head = $user_id";
            }
        }
        $query = "SELECT
                        c.id,
                        e.user_id,
                        CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                        e.username,
                        e.date_of_birth,
                         COALESCE(ct.contract_end, c.contract_end) as contract_end,
                        -- c.deadline,
                        (DATE(COALESCE(ct.contract_end, c.contract_end)) - INTERVAL 21 DAY) AS deadline,
                        c.dept_head,
                        c.created_at,
                        c.status,
                        c.feedback,
                        c.renewal,
                        CONCAT(h.first_name, ' ', h.last_name) AS head_name,
                        DATEDIFF(ct.contract_end, CURRENT_DATE) AS sisa_hari,
                        IF(DATEDIFF(ct.contract_end, CURRENT_DATE) <= 21, 1, 0) AS wajib_feedback,
                        h.contact_no AS head_contact,
                        ROUND((TIMESTAMPDIFF(MONTH, e.date_of_joining, CURDATE()) / 12), 1) AS masa_kerja,
                        d.department_name,
                        ds.designation_name,
                        -- addnew
                        c.appropriate AS masih_sesuai
                FROM (SELECT * FROM trusmi_renewal_contract WHERE status IS NULL GROUP BY employee_id) c
                JOIN xin_employees e ON e.user_id = c.employee_id
                LEFT JOIN xin_employees h ON h.user_id = c.dept_head
                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                LEFT JOIN xin_employee_contract contract ON (contract.employee_id = e.user_id AND contract.is_active = 1)
                LEFT JOIN (
                       SELECT
                        employee_id,
                        MAX(to_date) AS contract_end
                        FROM
                        `xin_employee_contract`
                        WHERE
                        title != 'Karyawan Tetap'
                        GROUP BY
                        employee_id
                    )ct on ct.employee_id = c.employee_id
                WHERE c.status IS NULL 
                AND deadline IS NOT NULL
                AND e.is_active = 1
                AND COALESCE(contract.contract_type_id,'') <> 1
                -- AND c.contract_end >= CURRENT_DATE
                $kondisi
                AND e.user_id != $user_id
                GROUP BY c.employee_id
                ORDER BY c.deadline DESC";
        $data['query'] = $query;
        $data['data'] = $this->db->query($query)->result();
        return $data;
    }


    function detail_renewal($id)
    {
        $query = "SELECT
                    renewal.id AS id_renewal,
                    hris.xin_employees.user_id,
                    hris.xin_employees.company_id,
                    -- hris.xin_companies.company_id,
                    -- user_rsp.id_divisi,
                    -- hris.xin_departments.head_id department_ID,
                    -- user_rsp.head_id,
                    CASE 
                        WHEN hris.xin_employees.user_id = hris.xin_departments.head_id -- kondisi head 
                            THEN
                                CASE WHEN hris.xin_companies.company_id IN (1,2)
                                    THEN (SELECT user_id FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra: 082009300907
                                    ELSE (SELECT user_id FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                                END
                        ELSE 
                            CASE WHEN user_rsp.id_divisi = 2
                                THEN                                                             
                                    CASE WHEN hris.xin_departments.head_id = 786 -- Jika 786 (pak Gofar), arahkan ke masing2 MM nya 
                                            THEN IF(user_rsp.head_id = hris.xin_employees.user_id, hris.xin_departments.head_id, user_rsp.head_id)
                                            ELSE hris.xin_departments.head_id
                                    END
                                ELSE hris.xin_departments.head_id
                            END
                    END AS head_id,
                                            
                                            
                    CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS nama,
                    hris.xin_employees.date_of_joining AS tgl_gabung,
                    hris.xin_companies.`name` AS company,
                    hris.xin_departments.department_name AS department,
                    hris.xin_designations.designation_name AS designation,
                                            
                                            
                    CASE
                        WHEN hris.xin_departments.department_id = 120 -- 120 : Marketing
                            THEN 
                                CASE 
                                    WHEN hris.xin_employees.user_id = hris.xin_departments.head_id -- kondisi head marketing ke pak hendra
                                        THEN (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra  082009300907
                                    WHEN user_rsp.id_divisi = 2 
                                                                                    THEN                                                             
                                                                                            CASE WHEN hris.xin_departments.head_id = 786 -- Jika 786 (pak Gofar), arahkan ke masing2 MM nya 
                                                                                                            THEN IF(user_rsp.head_id = hris.xin_employees.user_id, REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+',''), REPLACE(REPLACE(REPLACE(user_rsp.head_contact,'-',''),' ',''),'+',''))
                                                                                                    ELSE REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
                                                                                            END
                                                                                    
                                    ELSE  REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
                                END
                            
                        WHEN hris.xin_employees.user_id = hris.xin_departments.head_id
                            THEN
                            CASE WHEN hris.xin_companies.company_id IN (1,2) -- 2 : RSP
                                THEN (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra 082009300907
                                ELSE (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                            END
                        ELSE REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
                    END AS head_contact,
                                            
                                            CASE 
                        WHEN hris.xin_employees.user_id = hris.xin_departments.head_id
                            THEN
                                CASE WHEN hris.xin_companies.company_id IN (1,2)
                                    THEN (SELECT username FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra: 082009300907
                                    ELSE (SELECT username FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                                END
                        ELSE 
                            CASE WHEN user_rsp.id_divisi = 2
                                THEN                                                             
                                    CASE WHEN hris.xin_departments.head_id = 786 -- Jika 786 (pak Gofar), arahkan ke masing2 MM nya 
--                                                 THEN user_rsp.username
                                                                                            THEN IF(user_rsp.head_id = hris.xin_employees.user_id, head.username, user_rsp.username)
                                            ELSE head.username
                                    END
                                ELSE head.username
                            END
                    END AS head,
                                            
                                            
                    employee_contract.to_date AS habis_kontrak,
                                        renewal.contract_end,
                    DATE_SUB(employee_contract.to_date, INTERVAL 9 DAY) AS deadline,
                    COALESCE(TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1, 0) AS total_day,
                    ROUND( ( TIMESTAMPDIFF( MONTH, hris.xin_employees.date_of_joining, CURDATE( ) ) / 12 ), 1 ) AS masa_kerja,
                    hris.xin_contract_type.`name` AS status_kontrak,
                    -- CONCAT(ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date)) / 30), ' Month ', 
                    -- ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1) % 30), ' Days') AS remaining,
                    IF(FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30)=0,
                        -- CONCAT(ROUND(( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1 ) % 30 ),' Days'),
                        CONCAT((DATEDIFF(employee_contract.to_date, CURDATE()) % 30)+1,' Days'),
                        CONCAT(
                            FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30),
                            ' Month ',
                            ROUND(( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1 ) % 30 ),
                            ' Days' 
                        )
                    ) AS remaining,
                    DATEDIFF(employee_contract.to_date,CURRENT_DATE)+1 AS sisa_kontrak,
                    IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=45,1,0) AS notif_45,
                    IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=30,1,0) AS notif_30,
                    -- IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=16 OR DATEDIFF(employee_contract.to_date, CURRENT_DATE) < 1,1,0) AS notif_16,
                    IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=16,1,0) AS notif_16,
                    
                    
                    location.location_name AS lokasi,
                    renewal.status
                FROM hris.xin_employees
                LEFT JOIN hris.xin_companies ON hris.xin_employees.company_id = hris.xin_companies.company_id
                LEFT JOIN hris.xin_departments ON hris.xin_employees.department_id = hris.xin_departments.department_id
                LEFT JOIN hris.xin_designations ON hris.xin_employees.designation_id = hris.xin_designations.designation_id
                                
                JOIN 
                                (
                                    SELECT
                                        max_id.contract_id,
                                        max_id.employee_id,
                                        max_id.max_date,
                                        hris.xin_employee_contract.contract_type_id,
                                        hris.xin_employee_contract.to_date 
                                    FROM
                                    (
                                        SELECT
                                            MAX(hris.xin_employee_contract.contract_id) AS contract_id,
                                            hris.xin_employee_contract.employee_id,
                                            MAX( CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date END ) AS max_date 
                                        FROM hris.xin_employee_contract 
                                        GROUP BY hris.xin_employee_contract.employee_id 
                                    ) AS max_id
                                    JOIN hris.xin_employee_contract ON max_id.employee_id = hris.xin_employee_contract.employee_id 
                                    AND max_id.max_date = CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date END 
                                    GROUP BY max_id.employee_id
                                ) AS employee_contract ON hris.xin_employees.user_id = employee_contract.employee_id
                LEFT JOIN hris.xin_contract_type ON employee_contract.contract_type_id = hris.xin_contract_type.contract_type_id 
                JOIN hris.xin_employees head ON head.user_id = hris.xin_departments.head_id
                LEFT JOIN hris.xin_office_location location ON location.location_id = hris.xin_employees.location_id
                LEFT JOIN hris.trusmi_renewal_contract renewal ON (renewal.employee_id = hris.xin_employees.user_id AND renewal.contract_end =  employee_contract.to_date)
                
                LEFT JOIN (
                    SELECT 
                        rsp_project_live.user.id_user,
                        rsp_project_live.user.employee_name,
                        IF(mm.id_manager = 2029, gm.username, mm.username) AS username, 
                        rsp_project_live.user.id_divisi,
                        mm.id_manager, 
                        COALESCE(
                                COALESCE(hris.xin_employees.contact_no, mm.contact), 
                                COALESCE(hris.xin_employees.contact_no, gm.contact)
                        ) AS head_contact, 
                        COALESCE(mm.id_hr, gm.id_hr) AS head_id,
                        rsp_project_live.user.join_hr AS id_hr
                    FROM rsp_project_live.user
                    LEFT JOIN (
                            SELECT username, contact, id_manager, join_hr AS id_hr
                            FROM rsp_project_live.user
                            WHERE id_user = id_manager
                            -- AND isActive = 1
                    ) mm ON mm.id_manager = rsp_project_live.user.id_manager
                    LEFT JOIN (
                            SELECT username, contact, id_gm, join_hr AS id_hr
                            FROM rsp_project_live.user
                            WHERE id_user = id_gm
                            -- AND isActive = 1
                    ) gm ON gm.id_gm = rsp_project_live.user.id_gm
                    LEFT JOIN hris.xin_employees ON user_id = COALESCE(mm.id_hr, gm.id_hr)
                    WHERE rsp_project_live.user.id_divisi = 2
                    AND rsp_project_live.user.join_hr IS NOT NULL
                    -- AND rsp_project_live.user.isActive = 1
                    GROUP BY rsp_project_live.user.id_user
                ) user_rsp ON user_rsp.id_hr = hris.xin_employees.user_id  
            WHERE renewal.id = $id
            GROUP BY hris.xin_employees.user_id
            LIMIT 1
            ";

        return $this->db->query($query);
    }





    // OLD
    // public function dt_trusmi_resignation($start, $end)
    // {
    //     $user_id = $this->session->userdata("user_id");
    //     $department_id = $this->session->userdata("department_id");
    //     if ($department_id == 68 || $user_id == 1 || $user_id == 323 || $user_id == 6486) {
    //         $cond = "";
    //     } else {
    //         $cond = "AND r.added_by = '$user_id'";
    //     }
    //     $query = "SELECT
    //                 r.resignation_id,
    //                 r.company_id,
    //                 c.`name` AS company_name,
    //                 e.department_id,
    //                 d.department_name,
    //                 r.designation_id,
    //                 ds.designation_name,
    //                 r.employee_id,
    //                 CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
    //                 r.notice_date,
    //                 r.resignation_date,
    //                 r.reason,
    //                 r.note,
    //                 r.added_by,
    //                 CASE WHEN r.`status` = 0 THEN 'Not Approved' 
    //                 WHEN r.`status` = 1 THEN 'Approve MM' 
    //                 WHEN r.`status` = 2 THEN 'Approve HRD' 
    //                 WHEN r.`status` = 3 THEN 'Approve GM'
    //                 ELSE  'Not Approved' END AS status_resignation,
    //                 r.created_at,
    //                 r.pernyataan_1,
    //                 r.pernyataan_2,
    //                 r.pernyataan_3,
    //                 r.pernyataan_4,
    //                 r.pernyataan_5,
    //                 r.pernyataan_6,
    //                 r.pernyataan_7,
    //                 r.pernyataan_8,
    //                 r.pernyataan_9,
    //                 r.pernyataan_10 
    //             FROM
    //                 xin_employee_resignations r
    //                 JOIN xin_employees e ON r.employee_id = e.user_id
    //                 LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
    //                 AND ds.department_id = e.department_id 
    //                 AND ds.company_id = e.company_id
    //                 LEFT JOIN xin_departments d ON d.company_id = e.company_id 
    //                 AND d.department_id = e.department_id
    //                 LEFT JOIN xin_companies c ON c.company_id = e.company_id
    //             WHERE
    //                 resignation_date BETWEEN '$start' AND '$end' $cond";
    //     return $this->db->query($query);
    // }

    // public function get_profile($user_id)
    // {
    //     $query = "SELECT
    //                     user_id,
    //                     CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
    //                     e.company_id,
    //                     c.`name` AS company_name,
    //                     e.department_id,
    //                     d.department_name,
    //                     e.designation_id,
    //                     ds.designation_name
    //                 FROM
    //                     xin_employees e
    //                     left JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND e.company_id = ds.company_id
    //                     left JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
    //                     left JOIN xin_companies c ON c.company_id = e.company_id
    //                 WHERE user_id = '$user_id'";
    //     return $this->db->query($query);
    // }

    // public function get_profile_resignation($id_resignation)
    // {
    //     $query = "SELECT
    //                     user_id,
    //                     CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
    //                     e.company_id,
    //                     c.`name` AS company_name,
    //                     e.department_id,
    //                     d.department_name,
    //                     e.designation_id,
    //                     ds.designation_name,
    //                     e.date_of_joining,
    //                     timestampdiff(YEAR,`e`.`date_of_joining`,curdate()) AS `Tahun`,
    //                     timestampdiff(MONTH,`e`.`date_of_joining`,curdate()) AS `Bulan`,
    //                     timestampdiff(DAY,`e`.`date_of_joining`,curdate()) AS `Hari`,
    //                     concat(
    //                         timestampdiff(YEAR,`e`.`date_of_joining`,curdate()),' tahun ',(timestampdiff(MONTH,`e`.`date_of_joining`,curdate()) 
    //                         - (12 * timestampdiff(YEAR,`e`.`date_of_joining`,curdate()))),' bulan' ) AS masa_kerja,
    //                     e.contact_no,
    //                     e.address,
    //                     er.reason,
    //                     er.note,
    //                     e.profile_picture
    //                 FROM
    //                     xin_employees e
    //                     JOIN (SELECT karyawan FROM trusmi_exit_clearance WHERE id_resignation='$id_resignation' GROUP BY id_resignation) AS ec ON ec.karyawan = e.user_id
    //                     JOIN xin_employee_resignations er ON er.resignation_id = '$id_resignation'
    //                     left JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND e.company_id = ds.company_id
    //                     left JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
    //                     left JOIN xin_companies c ON c.company_id = e.company_id";
    //     return $this->db->query($query);
    // }

    // public function store($data)
    // {
    //     $this->db->insert('xin_employee_resignations', $data);
    //     if ($this->db->affected_rows() > 0) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    // public function get_last_id_resignation_by_user_id($user_id)
    // {
    //     $query = "SELECT MAX(resignation_id) AS resignation_id FROM `xin_employee_resignations` WHERE employee_id = '$user_id'";
    //     $data = $this->db->query($query)->row();
    //     $resignation_id = 0;
    //     if ($data) {
    //         $resignation_id = $data->resignation_id;
    //     }
    //     return $resignation_id;
    // }

    // public function get_contact_no($id_resignation)
    // {
    //     $query = "SELECT
    //                 ec.pic,
    //                 CONCAT(e.first_name, ' ' ,e.last_name) AS employee_name,
    //                 e.contact_no,
    //                 e.username
    //             FROM
    //                 `trusmi_exit_clearance` ec
    //                 LEFT JOIN xin_employees e ON e.user_id = ec.pic
    //             WHERE
    //                 id_resignation = '$id_resignation' 
    //             GROUP BY
    //                 pic";
    //     $data = $this->db->query($query)->result_array();
    //     return $data;
    // }

    // public function get_subclearance()
    // {
    //     $query = "SELECT
    //     trusmi_subclearance.id,
    //     pic 
    // FROM
    //     trusmi_subclearance
    //     LEFT JOIN trusmi_clearance ON trusmi_subclearance.id_clearance = trusmi_clearance.id";
    //     return $this->db->query($query)->result();
    // }

    // public function get_trusmi_resignation_by_id($id_resignation)
    // {
    //     $user_id = $this->session->userdata("user_id");
    //     $query = "SELECT
    //                 ec.id_resignation,
    //                 ec.karyawan as employee_id,
    //                 CONCAT(e.first_name,' ',last_name) AS employee_name,
    //                 sc.subclearance,
    //                 ec.`status` AS id_status_resignation,
    //                 ec.note,
    //                 CASE WHEN ec.`status` = 0 THEN 'Not Approved' 
    //                 WHEN ec.`status` = 1 THEN 'Approve MM' 
    //                 WHEN ec.`status` = 2 THEN 'Approve HRD' 
    //                 WHEN ec.`status` = 3 THEN 'Approve GM'
    //                 WHEN ec.`status` = 4 THEN 'Reject MM'
    //                 ELSE  'Not Approved' END AS status_resignation,
    //                 ec.id AS id_exit_clearance,
    //                 ec.pic
    //             FROM
    //                 trusmi_exit_clearance ec
    //                 LEFT JOIN xin_employees e ON e.user_id = ec.karyawan
    //                 LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
    //             WHERE
    //                 id_resignation = '$id_resignation' 
    //                 AND pic = '$user_id'";
    //     return $this->db->query($query)->result();
    // }

    function data_perpanjangan_kontrak($user_id)
    {
        $kondisi = " AND hris.xin_employees.user_id IN ($user_id)";
        $query = "SELECT
                        hris.xin_employees.user_id,
                        -- hris.xin_companies.company_id,
                        -- user_rsp.id_divisi,
                        -- hris.xin_departments.head_id department_ID,
                        -- user_rsp.head_id,
                        CASE 
                            WHEN hris.xin_employees.user_id = hris.xin_departments.head_id -- kondisi head 
                                THEN
                                    CASE WHEN hris.xin_companies.company_id IN (1,2)
                                        THEN (SELECT user_id FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra: 082009300907
                                        ELSE (SELECT user_id FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                                    END
                            ELSE 
                                CASE WHEN user_rsp.id_divisi = 2
                                    THEN                                                             
                                        CASE WHEN hris.xin_departments.head_id IN (786,323) -- Jika 786 (pak Gofar / pak hendra), arahkan ke masing2 MM nya 
                                                THEN IF(user_rsp.head_id = hris.xin_employees.user_id, hris.xin_departments.head_id, user_rsp.head_id)
                                                ELSE hris.xin_departments.head_id
                                        END
                                    ELSE hris.xin_departments.head_id
                                END
                        END AS head_id,
                                                
                                                
                        CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS nama,
                        hris.xin_employees.date_of_joining AS tgl_gabung,
                        hris.xin_companies.`name` AS company,
                        hris.xin_departments.department_name AS department,
                        hris.xin_designations.designation_name AS designation,
                                                
                                                
                        CASE
                            WHEN hris.xin_departments.department_id = 120 -- 120 : Marketing
                                THEN 
                                    CASE 
                                        WHEN hris.xin_employees.user_id = hris.xin_departments.head_id -- kondisi head marketing ke pak hendra
                                            THEN (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra  082009300907
                                        WHEN user_rsp.id_divisi = 2 
																						THEN                                                             
																								CASE WHEN hris.xin_departments.head_id IN (786,323) -- Jika 786 (pak Gofar / pak hendra), arahkan ke masing2 MM nya 
																												THEN IF(user_rsp.head_id = hris.xin_employees.user_id, REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+',''), REPLACE(REPLACE(REPLACE(user_rsp.head_contact,'-',''),' ',''),'+',''))
																										ELSE REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
																								END
																						
                                        ELSE  REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
                                    END
                                
                            WHEN hris.xin_employees.user_id = hris.xin_departments.head_id
                                THEN
                                CASE WHEN hris.xin_companies.company_id IN (1,2) -- 2 : RSP
                                    THEN (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra 082009300907
                                    ELSE (SELECT REPLACE(REPLACE(REPLACE(contact_no,'-',''),' ',''),'+','') FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                                END
                            ELSE REPLACE(REPLACE(REPLACE(head.contact_no,'-',''),' ',''),'+','')
                        END AS head_contact,
                                                
												CASE 
                            WHEN hris.xin_employees.user_id = hris.xin_departments.head_id
                                THEN
                                    CASE WHEN hris.xin_companies.company_id IN (1,2)
                                        THEN (SELECT username FROM hris.xin_employees WHERE user_id = 323 LIMIT 1) -- pak hendra: 082009300907
                                        ELSE (SELECT username FROM hris.xin_employees WHERE user_id = 118 LIMIT 1) -- pak andyka: 089660108022
                                    END
                            ELSE 
                                CASE WHEN user_rsp.id_divisi = 2
                                    THEN                                                             
                                        CASE WHEN hris.xin_departments.head_id IN (786,323)-- Jika 786 (pak Gofar/pak hendra), arahkan ke masing2 MM nya 
--                                                 THEN user_rsp.username
																								THEN IF(user_rsp.head_id = hris.xin_employees.user_id, head.username, user_rsp.username)
                                                ELSE head.username
                                        END
                                    ELSE head.username
                                END
                        END AS head,
                                                
                                                
                        employee_contract.to_date AS habis_kontrak,
                                            renewal.contract_end,
                        DATE_SUB(employee_contract.to_date, INTERVAL 16 DAY) AS deadline,
                        COALESCE(TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1, 0) AS total_day,
                        ROUND( ( TIMESTAMPDIFF( MONTH, hris.xin_employees.date_of_joining, CURDATE( ) ) / 12 ), 1 ) AS masa_kerja,
                        hris.xin_contract_type.`name` AS status_kontrak,
                        -- CONCAT(ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date)) / 30), ' Month ', 
                        -- ROUND((TIMESTAMPDIFF(DAY, CURDATE(), employee_contract.to_date) + 1) % 30), ' Days') AS remaining,
                        IF(FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30)=0,
                            -- CONCAT(ROUND(( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1 ) % 30 ),' Days'),
                            CONCAT((DATEDIFF(employee_contract.to_date, CURDATE()) % 30)+1,' Days'),
                            CONCAT(
                                FLOOR(DATEDIFF(employee_contract.to_date, CURDATE()) / 30),
                                ' Month ',
                                ROUND(( TIMESTAMPDIFF( DAY, CURDATE(), employee_contract.to_date ) + 1 ) % 30 ),
                                ' Days' 
                            )
                        ) AS remaining,
                        DATEDIFF(employee_contract.to_date,CURRENT_DATE)+1 AS sisa_kontrak,
                        IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=45,1,0) AS notif_45,
                        IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=30,1,0) AS notif_30,
                        -- IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=16 OR DATEDIFF(employee_contract.to_date, CURRENT_DATE) < 1,1,0) AS notif_16,
                        IF(DATEDIFF(employee_contract.to_date, CURRENT_DATE) + 1=16,1,0) AS notif_16,
                        
                        
                        location.location_name AS lokasi,
                        renewal.status
                    FROM hris.xin_employees
                    LEFT JOIN hris.xin_companies ON hris.xin_employees.company_id = hris.xin_companies.company_id
                    LEFT JOIN hris.xin_departments ON hris.xin_employees.department_id = hris.xin_departments.department_id
                    LEFT JOIN hris.xin_designations ON hris.xin_employees.designation_id = hris.xin_designations.designation_id
                                    
                    JOIN 
                                    (
                                        SELECT
                                            max_id.contract_id,
                                            max_id.employee_id,
                                            max_id.max_date,
                                            hris.xin_employee_contract.contract_type_id,
                                            hris.xin_employee_contract.to_date 
                                        FROM
                                        (
                                            SELECT
                                                MAX(hris.xin_employee_contract.contract_id) AS contract_id,
                                                hris.xin_employee_contract.employee_id,
                                                MAX( CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date END ) AS max_date 
                                            FROM hris.xin_employee_contract
											WHERE hris.xin_employee_contract.is_active = 1
                                            GROUP BY hris.xin_employee_contract.employee_id 
                                        ) AS max_id
                                        JOIN hris.xin_employee_contract ON max_id.employee_id = hris.xin_employee_contract.employee_id 
                                        AND max_id.max_date = CASE WHEN hris.xin_employee_contract.to_date = '' THEN DATE_ADD( CURDATE( ), INTERVAL 10 YEAR ) ELSE hris.xin_employee_contract.to_date END 
                                        GROUP BY max_id.employee_id
                                    ) AS employee_contract ON hris.xin_employees.user_id = employee_contract.employee_id
                    LEFT JOIN hris.xin_contract_type ON employee_contract.contract_type_id = hris.xin_contract_type.contract_type_id 
                    JOIN hris.xin_employees head ON head.user_id = hris.xin_departments.head_id
                    LEFT JOIN hris.xin_office_location location ON location.location_id = hris.xin_employees.location_id
                                    LEFT JOIN hris.trusmi_renewal_contract renewal ON (renewal.employee_id = hris.xin_employees.user_id AND renewal.contract_end =  employee_contract.to_date)
                    
                    LEFT JOIN (
                        SELECT 
                            rsp_project_live.user.id_user,
                            rsp_project_live.user.employee_name,
                            IF(mm.id_manager = 2029, gm.username, mm.username) AS username, 
                            rsp_project_live.user.id_divisi,
                            mm.id_manager, 
                            COALESCE(
                                    COALESCE(hris.xin_employees.contact_no, mm.contact), 
                                    COALESCE(hris.xin_employees.contact_no, gm.contact)
                            ) AS head_contact, 
                            COALESCE(mm.id_hr, gm.id_hr) AS head_id,
                            rsp_project_live.user.join_hr AS id_hr
                        FROM rsp_project_live.user
                        LEFT JOIN (
                                SELECT username, contact, id_manager, join_hr AS id_hr
                                FROM rsp_project_live.user
                                WHERE id_user = id_manager
                                -- AND isActive = 1
                        ) mm ON mm.id_manager = rsp_project_live.user.id_manager
                        LEFT JOIN (
                                SELECT username, contact, id_gm, join_hr AS id_hr
                                FROM rsp_project_live.user
                                WHERE id_user = id_gm
                                -- AND isActive = 1
                        ) gm ON gm.id_gm = rsp_project_live.user.id_gm
                        LEFT JOIN hris.xin_employees ON user_id = COALESCE(mm.id_hr, gm.id_hr)
                        WHERE rsp_project_live.user.id_divisi = 2
                        AND rsp_project_live.user.join_hr IS NOT NULL
                        -- AND rsp_project_live.user.isActive = 1
                        GROUP BY rsp_project_live.user.id_user
                    ) user_rsp ON user_rsp.id_hr = hris.xin_employees.user_id  
                WHERE (hris.xin_employees.is_active != 0
                AND renewal.`status` IS NULL -- disable Faisal (karena renewal tidak bisa insert untuk Kontrak Kedua dst)
                $kondisi
								)
                GROUP BY hris.xin_employees.user_id;";
        return $this->db->query($query)->row();
    }

    function dt_contract_new()
    {
        $user_id = $this->session->userdata('user_id');
        if ($user_id == 1 || $user_id == 979 || $user_id == 778) {
            $kondisi = "";
        } else {
            // $list_pm = [
            //     1293, // Rizky Ginanjar
            //     1637, // Tedi Yanuar
            //     3529, // Yoggi Rishandi
            // ];

            if ($user_id == 1293 || $user_id == '1637' || $user_id == '3529') {
                $kondisi = "AND c.dept_head = 1186"; // 1186 idham
            } else {
                // $kondisi = "AND c.dept_head = $user_id";
                $kondisi = "AND c.dept_head = $user_id";
            }
        }
        $query = "SELECT
                    c.id,
                    e.user_id,
                    CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                    e.username,
                    c.contract_end,
                    c.dept_head,
                    c.created_at,
                    c.`status`,
                    c.renewal,
                    CONCAT( h.first_name, ' ', h.last_name ) AS head_name,
                    h.contact_no AS head_contact,
                    ROUND( ( TIMESTAMPDIFF( MONTH, e.date_of_joining, CURDATE( ) ) / 12 ), 1 ) AS masa_kerja,
                    d.department_name,
                    ds.designation_name,
                    IF(c.`status` = 1, 'Perpanjang', 'Tidak Perpanjang') AS status_perpanjang,
                    c.renewal AS lama_perpanjang,
                    c.feedback,
                    c.feedback_at,
                    CONCAT( fb.first_name, ' ', fb.last_name ) AS perpanjang_oleh,
                    c.appropriate,
                    CASE
                        WHEN c.appropriate = 1 THEN 'Ya'
                        WHEN c.appropriate = 2 THEN 'Tidak'
                    END AS masih_sesuai,
                    c.file_kpi,
                    p.proaktif_belajar,
                    p.proaktif_adaptasi,
                    p.proaktif_evaluasi,
                    p.pembelajar_berani,
                    p.pembelajar_berjuang,
                    p.pembelajar_melakukan,
                    p.energi_harmonis,
                    p.energi_motivasi,
                    p.energi_tauladan,
                    p.internal_disiplin,
                    p.internal_percepatan
                FROM
                    `trusmi_renewal_contract` c
                    JOIN xin_employees e ON e.user_id = c.employee_id
                    LEFT JOIN xin_employees h ON h.user_id = c.dept_head
                    LEFT JOIN xin_departments d ON d.department_id = e.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                    LEFT JOIN xin_employees fb ON fb.user_id = c.feedback_by
                    LEFT JOIN t_penilaian_subjektif_renewal p ON p.id_renewal = c.id
                WHERE
                    c.`status` IS NOT NULL
                    AND date(c.created_at) > '2024-11-30'
                    AND c.feedback_by IS NOT NULL AND c.feedback_at IS NOT NULL -- revnew
                -- 	AND c.employee_id = 5840
                ORDER BY date(c.feedback_at) DESC
                ";
        $data['query'] = $query;
        $data['data'] = $this->db->query($query)->result();
        return $data;
    }
}
