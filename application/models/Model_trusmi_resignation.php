<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_resignation extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function check_resignation($id_resignation)
    {
        $this->db->where('resignation_id', $id_resignation);
        $query = $this->db->get('xin_employee_resignations');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function check_status_resignation($id_resignation)
    {
        $this->db->where('resignation_id', $id_resignation);
        $this->db->where('status', 2);
        $query = $this->db->get('xin_employee_resignations');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_date_of_leaving($employee_id, $resignation_date)
    {
        $data = [
            'date_of_leaving' => $resignation_date
        ];
        return $this->db->where("user_id", $employee_id)->update("xin_employees", $data);
    }

    function check_double_resignation($employee_id)
    {
        $this->db->where('employee_id', $employee_id);
        return $query = $this->db->get('xin_employee_resignations');
    }


    public function dt_trusmi_resignation($start, $end, $user_role_id, $user_id)
    {
        $user_id = $this->session->userdata('user_id');
        $department_id = $this->session->userdata('department_id');
        $company_id = $this->session->userdata('company_id');
        $cond = "AND r.added_by = $user_id";
        $super_admin = [1, 2063, 61, 2903, 979, 3388, 2951, 778, 321];
        $pdca = ['329'];
        if (in_array($user_id, $super_admin)) {
            $cond = "";
        } else if (in_array($user_id, $pdca)) {
            $cond = " AND e.company_id = '$company_id'";
        }
        $query = "SELECT
                    e.date_of_joining,
                    COALESCE(atasan_rsp.nama_spv,'') AS nama_spv,
	                IF(COALESCE(atasan_rsp.nama_mng,'') = 'IT Trusmi Group', '',COALESCE(atasan_rsp.nama_mng,'')) AS nama_mng,
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
                    r.category, -- add by Ade
                    r.reason,
                    r.note,
                    r.added_by,
                    r.`status` AS id_status_resignation,
                    CASE WHEN r.`status` = 0 THEN 'Not Approved' 
                    WHEN r.`status` = 1 THEN 'Approve MM' 
                    WHEN r.`status` = 2 THEN 'Approve HRD' 
                    WHEN r.`status` = 3 THEN 'Approve GM'
                    ELSE  'Not Approved' END AS status_resignation,
                    r.created_at,
                    COALESCE(r.reason_atasan,'') AS reason_atasan,
                    GROUP_CONCAT(DISTINCT ec.pic ORDER BY ec.pic ASC) AS pic_approve,
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
                    LEFT JOIN trusmi_exit_clearance ec ON ec.id_resignation = r.resignation_id
                    JOIN xin_employees e ON r.employee_id = e.user_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    AND ds.department_id = e.department_id 
                    AND ds.company_id = e.company_id
                    LEFT JOIN xin_departments d ON d.company_id = e.company_id 
                    AND d.department_id = e.department_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id
                    LEFT JOIN (
                            SELECT
                            u.id_hr,
                            u.employee_name,
                            spv.employee_name AS nama_spv,
                            mng.employee_name AS nama_mng 
                        FROM
                            rsp_project_live.`user` u
                            LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                            LEFT JOIN rsp_project_live.`user` mng ON mng.id_user = u.id_manager 
                        WHERE
                            u.id_hr IS NOT NULL AND u.id_user != 1
                    ) AS atasan_rsp ON atasan_rsp.id_hr = r.employee_id
                WHERE
                    resignation_date BETWEEN '$start' AND '$end' $cond
                GROUP BY resignation_id";
        return $this->db->query($query);
    }

    public function dt_trusmi_waiting_approval_resignation($user_id)
    {
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
                    r.`status` AS id_status_resignation,
                    CASE WHEN r.`status` = 0 THEN 'Not Approved' 
                    WHEN r.`status` = 1 THEN 'Approve MM' 
                    WHEN r.`status` = 2 THEN 'Approve HRD' 
                    WHEN r.`status` = 3 THEN 'Approve GM'
                    ELSE  'Not Approved' END AS status_resignation,
                    r.created_at,
                    COALESCE(r.reason_atasan,'') AS reason_atasan,
                    GROUP_CONCAT(DISTINCT ec.pic ORDER BY ec.pic ASC) AS pic_approve
                FROM
                    xin_employee_resignations r
                    LEFT JOIN trusmi_exit_clearance ec ON ec.id_resignation = r.resignation_id
                    JOIN xin_employees e ON r.employee_id = e.user_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                    AND ds.department_id = e.department_id 
                    AND ds.company_id = e.company_id
                    LEFT JOIN xin_departments d ON d.company_id = e.company_id 
                    AND d.department_id = e.department_id
                    LEFT JOIN xin_companies c ON c.company_id = e.company_id
                WHERE
                    resignation_date > '2023-05-01' AND ec.pic = '$user_id' AND ec.approved_at IS NULL
                GROUP BY resignation_id";
        return $this->db->query($query);
    }

    public function dt_trusmi_waiting_approval_resignation_hrd()
    {
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
                        r.`status` AS id_status_resignation,
                        CASE WHEN r.`status` = 0 THEN 'Not Approved' 
                        WHEN r.`status` = 1 THEN 'Approve MM' 
                        WHEN r.`status` = 2 THEN 'Approve HRD' 
                        WHEN r.`status` = 3 THEN 'Approve GM'
                        ELSE  'Not Approved' END AS status_resignation,
                        r.created_at,
                        COALESCE(r.reason_atasan,'') AS reason_atasan,
                        GROUP_CONCAT(DISTINCT ec.pic ORDER BY ec.pic ASC) AS pic_approve
                    FROM
                        xin_employee_resignations r
                        JOIN (
                            SELECT
                                    x.id_resignation 
                                FROM
                                    (
                                    SELECT
                                        id_resignation,
                                        COUNT( id ) AS jml_ec,
                                        SUM(
                                        IF
                                        ( `status` = 1, 1, 0 )) AS jml_aprove 
                                    FROM
                                        trusmi_exit_clearance 
                                    GROUP BY
                                        id_resignation 
                                    ) AS x 
                                WHERE
                                    x.jml_aprove = x.jml_ec
                        ) AS xx ON xx.id_resignation = r.resignation_id
                        LEFT JOIN trusmi_exit_clearance ec ON ec.id_resignation = r.resignation_id
                        JOIN xin_employees e ON r.employee_id = e.user_id
                        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id 
                        AND ds.department_id = e.department_id 
                        AND ds.company_id = e.company_id
                        LEFT JOIN xin_departments d ON d.company_id = e.company_id 
                        AND d.department_id = e.department_id
                        LEFT JOIN xin_companies c ON c.company_id = e.company_id
                    WHERE
                        resignation_date > '2023-05-01'
                    GROUP BY resignation_id";
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

    // add by Ade
    public function get_data_reason($category_id)
    {
        $query = "SELECT
                    id_reason AS `value`,
                    reason AS `text`
                FROM
                    `trusmi_resign_reason` 
                WHERE
                    id_category = $category_id
                    AND oleh = 'Pegawai'";
        return $this->db->query($query)->result();
    }

    public function get_profile_resignation($id_resignation)
    {
        $user_id = $this->session->userdata("user_id");
        $department_id = $this->session->userdata("department_id");
        // if ($department_id == 68 || $user_id == 1 || $user_id == 323 || $user_id == 979) {
        $condition = "";
        // } else {
        //     $condition = "WHERE er.employee_id = '$user_id'";
        // }
        $query = "SELECT
                        user_id,
                        CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
                        e.company_id,
                        c.`name` AS company_name,
                        e.department_id,
                        d.department_name,
                        e.designation_id,
                        ds.designation_name,
                        e.date_of_joining,
                        timestampdiff(YEAR,`e`.`date_of_joining`,curdate()) AS `Tahun`,
                        timestampdiff(MONTH,`e`.`date_of_joining`,curdate()) AS `Bulan`,
                        timestampdiff(DAY,`e`.`date_of_joining`,curdate()) AS `Hari`,
                        concat(
                            timestampdiff(YEAR,`e`.`date_of_joining`,curdate()),' tahun ',(timestampdiff(MONTH,`e`.`date_of_joining`,curdate()) 
                            - (12 * timestampdiff(YEAR,`e`.`date_of_joining`,curdate()))),' bulan' ) AS masa_kerja,
                        e.contact_no,
                        e.address,
                        -- add by ade
                        er.category,
                        er.reason,
                        er.note,
                        e.profile_picture,
                        MAX(to_date) AS habis_kontrak,
                        ac.nama_atasan AS head_name,
                        abs.terakhir_absen
                    FROM
                        xin_employees e
                        JOIN (SELECT karyawan FROM trusmi_exit_clearance WHERE id_resignation='$id_resignation' GROUP BY id_resignation) AS ec ON ec.karyawan = e.user_id
                        JOIN xin_employee_resignations er ON er.resignation_id = '$id_resignation'
                        LEFT JOIN (
                            SELECT ec.pic, ec.karyawan, CONCAT(u.first_name, ' ', u.last_name) AS nama_atasan 
                            FROM trusmi_exit_clearance ec 
                            LEFT JOIN trusmi_subclearance sc ON ec.subclearance = sc.id 
                            LEFT JOIN xin_employees u ON u.user_id = ec.pic 
                            WHERE ec.id_resignation='$id_resignation' AND sc.id_clearance = 1 GROUP BY ec.id_resignation
                        ) AS ac ON ac.karyawan = e.user_id
                        LEFT JOIN xin_employee_contract ON xin_employee_contract.employee_id = e.user_id
                        left JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND e.company_id = ds.company_id
                        left JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
                        left JOIN xin_companies c ON c.company_id = e.company_id
                        LEFT JOIN (SELECT
                                            s.resignation_id,
                                            s.employee_id,
                                            COALESCE(MAX(t.clock_out),MAX(attendance_date)) AS terakhir_absen
                                        FROM
                                            xin_employee_resignations s
                                        JOIN xin_attendance_time t ON s.employee_id = t.employee_id
                                        WHERE
                                            s.resignation_id = '$id_resignation') AS abs ON abs.employee_id = e.user_id
                    $condition";
        return $this->db->query($query);
    }

    function get_atasan_rsp($user_id)
    {
        $query = "SELECT
                        u.employee_name,
                        spv.id_user AS id_user_spv,
                        spv.employee_name AS nama_spv,
                        mng.id_user AS id_user_mng,
                        mng.employee_name AS nama_mng,
                        COALESCE(mng.join_hr, gm.join_hr) AS head_id,
		                gm.employee_name AS nama_gm
                    FROM
                        rsp_project_live.`user` u 
                        LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                        LEFT JOIN rsp_project_live.`user` mng ON mng.id_user = u.id_manager
                        LEFT JOIN rsp_project_live.`user` gm ON gm.id_user = u.id_gm
                    WHERE u.join_hr = '$user_id'";
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
        $query = "SELECT MAX(resignation_id) AS resignation_id FROM `xin_employee_resignations` WHERE employee_id = '$user_id'";
        $data = $this->db->query($query)->row();
        $resignation_id = 0;
        if ($data) {
            $resignation_id = $data->resignation_id;
        }
        return $resignation_id;
    }

    public function get_contact_no($id_resignation)
    {
        $query = "SELECT
                    ec.pic,
                    CONCAT(e.first_name, ' ' ,e.last_name) AS employee_name,
                    e.contact_no,
                    e.username,
                    sc.id_clearance,
                    e.company_id,
                    c.`name` AS company_name,
                    e.department_id,
                    d.department_name,
                    e.designation_id,
                    ds.designation_name,
                    CONCAT(pengaju.first_name, ' ', pengaju.last_name) AS nama_pengaju
                FROM
                    `trusmi_exit_clearance` ec
                    LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
                    LEFT JOIN xin_employees e ON e.user_id = ec.pic
                    LEFT JOIN xin_employees pengaju ON pengaju.user_id = ec.karyawan
                    LEFT JOIN xin_companies c ON c.company_id = pengaju.company_id
                    LEFT JOIN xin_departments d ON d.department_id = pengaju.department_id AND d.company_id = pengaju.company_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = pengaju.designation_id AND ds.department_id = pengaju.department_id AND ds.company_id = pengaju.company_id
                WHERE
                    id_resignation = '$id_resignation' 
                GROUP BY
                    pic";
        $data = $this->db->query($query)->result_array();
        return $data;
    }

    public function get_subclearance()
    {
        $query = "SELECT
        trusmi_subclearance.id,
        trusmi_subclearance.id_clearance,
        pic 
    FROM
        trusmi_subclearance
        LEFT JOIN trusmi_clearance ON trusmi_subclearance.id_clearance = trusmi_clearance.id";
        return $this->db->query($query)->result();
    }

    public function get_subclearance_by_employee_id($employee_id)
    {
        // check company 
        $user_company = $this->db->query("SELECT company_id, department_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
        $cond = "WHERE trusmi_subclearance.id != 19";
        if ($user_company->company_id == 2) {
            $check_pernah_pinjam_rakon = $this->db->query("SELECT
            e.user_id
        FROM
            rsp_project_live.t_adjusment a
            LEFT JOIN xin_employees e ON e.user_id = a.id_hr
            LEFT JOIN xin_departments d ON d.department_id = e.department_id 
        WHERE
            a.id_hr IS NOT NULL AND e.user_id = $employee_id")->num_rows();
            if ($check_pernah_pinjam_rakon > 0) {
                $cond = '';
            }
        }

        if ($user_company->company_id == 3) {
            $cond = "WHERE trusmi_subclearance.id NOT IN (17,19)";
        }

        $query = "SELECT
            trusmi_subclearance.id,
            trusmi_subclearance.id_clearance,
            pic 
        FROM
            trusmi_subclearance
            LEFT JOIN trusmi_clearance ON trusmi_subclearance.id_clearance = trusmi_clearance.id
            $cond ";
        return $this->db->query($query)->result();
    }

    public function get_atasan()
    {
        $department_id = $this->session->userdata('department_id');
        $query = "SELECT
        department_name,
        head_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS atasan_name,
        CASE
                    WHEN LEFT ( e.contact_no, 1 ) = 0 THEN
                        CONCAT( 62, SUBSTR( e.contact_no, 2, LENGTH( e.contact_no ) ) ) 
                    ELSE e.contact_no 
                END AS no_hp
    FROM
        xin_departments
        JOIN xin_employees e ON e.user_id = xin_departments.head_id
    WHERE xin_departments.department_id = '$department_id' GROUP BY head_id";
        return $this->db->query($query)->row();
    }

    public function get_trusmi_resignation_by_id($id_resignation)
    {
        $user_id = $this->session->userdata("user_id");
        $cond = "";
        if ($user_id == 2063 || $user_id == 1) {
        } else {
            $cond = "AND pic = '$user_id'";
        }
        $query = "SELECT
                    sc.id_clearance,
                    ec.id_resignation,
                    ec.karyawan as employee_id,
                    CONCAT(e.first_name,' ',last_name) AS employee_name,
                    ec.subclearance AS id_subclearance,
                    sc.subclearance,
                    ec.`status` AS id_status_resignation,
                    ec.note,
                    CASE WHEN ec.`status` = 0 THEN 'Not Approved' 
                    WHEN ec.`status` = 1 THEN 'Approve MM' 
                    WHEN ec.`status` = 2 THEN 'Approve HRD' 
                    WHEN ec.`status` = 3 THEN 'Approve GM'
                    WHEN ec.`status` = 4 THEN 'Reject MM'
                    ELSE  'Not Approved' END AS status_resignation,
                    ec.id AS id_exit_clearance,
                    ec.pic,
                    er.reason_atasan
                FROM
                    trusmi_exit_clearance ec
                    LEFT JOIN xin_employees e ON e.user_id = ec.karyawan
                    LEFT JOIN xin_employee_resignations er ON er.resignation_id = ec.id_resignation
                    LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
                WHERE
                    id_resignation = '$id_resignation' 
                    $cond ORDER BY CASE WHEN ec.`status` = 0 THEN 1 
                    WHEN ec.`status` = 1 THEN 3 
                    WHEN ec.`status` = 2 THEN 4 
                    WHEN ec.`status` = 3 THEN 5
                    WHEN ec.`status` = 4 THEN 2
                    ELSE 1 END ASC";
        return $this->db->query($query)->result();
    }

    public function get_my_resignation($id_resignation)
    {
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        if ($user_role_id == 1 || $user_id == 2063 || $user_id == 61) {
            $condition = "";
        } else {
            $condition = "AND ec.karyawan = '$user_id'";
        }
        $query = "SELECT
                    ec.id_resignation,
                    ec.karyawan as employee_id,
                    CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                    ec.subclearance AS id_subclearance,
                    sc.subclearance,
                    ec.`status` AS id_status_resignation,
                    ec.note,
                    CASE WHEN ec.`status` = 0 THEN 'Waiting' 
                    WHEN ec.`status` = 1 THEN 'Approve' 
                    WHEN ec.`status` = 2 THEN 'Approve' 
                    WHEN ec.`status` = 3 THEN 'Approve'
                    WHEN ec.`status` = 4 THEN 'Reject'
                    ELSE  'Not Approved' END AS status_resignation,
                    ec.id AS id_exit_clearance,
                    ec.pic,
                    COALESCE(SUBSTR(ec.approved_at,1,10),'') AS approved_at,
                    CONCAT(apr.first_name,' ',apr.last_name) AS diperiksa_oleh,
                    er.reason_atasan
                FROM
                    trusmi_exit_clearance ec
                    LEFT JOIN xin_employees e ON e.user_id = ec.karyawan
                    LEFT JOIN xin_employee_resignations er ON er.resignation_id = ec.id_resignation
                    LEFT JOIN xin_employees apr ON apr.user_id = ec.pic
                    LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
                WHERE
                    id_resignation = '$id_resignation' 
                    $condition
                    ORDER BY CASE WHEN ec.`status` = 0 THEN 1 
                    WHEN ec.`status` = 1 THEN 3 
                    WHEN ec.`status` = 2 THEN 4 
                    WHEN ec.`status` = 3 THEN 5
                    WHEN ec.`status` = 4 THEN 2
                    ELSE 1 END ASC";
        return $this->db->query($query)->result();
    }

    public function get_pic_clearance()
    {
        $department_id  = $this->session->userdata("department_id");
        $query = "SELECT
                CASE    WHEN c.id = 6 AND d.company_id IN (1,5) THEN CONCAT( pic_bt_finance.first_name, ' ', pic_bt_finance.last_name )
                        WHEN c.pic is NULL THEN CONCAT( a.first_name, ' ', a.last_name )
                        ELSE CONCAT( e.first_name, ' ', e.last_name ) END AS pic 
                FROM
                    trusmi_clearance c
                    LEFT JOIN xin_employees e ON e.user_id = c.pic
                    LEFT JOIN xin_departments d ON d.department_id = '$department_id'
                    LEFT JOIN xin_employees a ON a.user_id = d.head_id
                    -- 1709 bu Sicelia
                    LEFT JOIN xin_employees pic_bt_finance ON pic_bt_finance.user_id = 1709
                GROUP BY
                    c.pic";
        return $this->db->query($query)->result();
    }

    public function check_aproval_resignation($id_resignation)
    {
        $query = "SELECT
                    trusmi_exit_clearance.id_resignation,
                    trusmi_exit_clearance.karyawan,
                    x.employee_name AS nama_atasan,
                    c.`name` AS company_name,
                    COALESCE(er.reason_atasan,'') AS reason_atasan,
                    d.department_name,
                    ds.designation_name,
                    TRIM(CONCAT(xin_employees.first_name,' ',xin_employees.last_name)) AS employee_name,
                    COUNT( id ) AS total_clearance,
                    SUM(
                    IF
                    ( trusmi_exit_clearance.`status` = 1, 1, 0 )) AS total_approved 
                FROM
                    `trusmi_exit_clearance`
                LEFT JOIN xin_employee_resignations er ON er.resignation_id = trusmi_exit_clearance.id_resignation
                LEFT JOIN (
                                    SELECT ec.id_resignation, pic, 
                                    CONCAT(u.first_name,' ',u.last_name) AS employee_name 
                                    FROM trusmi_exit_clearance ec 
                                    JOIN trusmi_subclearance sc ON sc.id = ec.subclearance 
                                    LEFT JOIN xin_employees u ON u.user_id = ec.pic 
                                    WHERE sc.id_clearance = 1 AND ec.id_resignation = '$id_resignation' 
                                    GROUP BY ec.id_resignation
                ) AS x ON x.id_resignation = trusmi_exit_clearance.id_resignation
                LEFT JOIN xin_employees ON xin_employees.user_id = trusmi_exit_clearance.karyawan
                LEFT JOIN xin_companies c ON c.company_id = xin_employees.company_id
                LEFT JOIN xin_departments d ON d.department_id = xin_employees.department_id AND d.company_id = xin_employees.company_id
                LEFT JOIN xin_designations ds ON ds.designation_id = xin_employees.designation_id AND ds.department_id = xin_employees.department_id AND ds.company_id = xin_employees.company_id
                WHERE
                    trusmi_exit_clearance.id_resignation = '$id_resignation'";
        return $this->db->query($query)->row();
    }

    public function print_paklaring($id_resignation)
    {
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        if ($user_role_id == 1 || $user_id == 2063 || $user_id == 61) {
            $query = "SELECT
            e.user_id AS employe_id,
            CONCAT(e.first_name,' ',e.last_name) AS employee_name,
            e.address,
            ds.designation_name,
            e.date_of_joining,
			e.date_of_leaving,
            er.notice_date,
            er.resignation_date,
            DATEDIFF(er.resignation_date,er.notice_date) AS diff_date,
            er.reason,
            comp.name AS company_name,
            comp.header_memo
        FROM
            xin_employees e
            LEFT JOIN xin_departments d ON d.department_id = e.department_id AND d.company_id = e.company_id
            LEFT JOIN xin_companies comp ON comp.company_id = e.company_id
            LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id AND ds.department_id = e.department_id AND ds.company_id AND e.company_id
            LEFT JOIN xin_employee_resignations er ON er.employee_id = e.user_id
        WHERE er.resignation_id = '$id_resignation'";
            return $this->db->query($query)->row();
        } else {
            return '';
        }
    }

    public function check_peminjaman_rakon($user_id)
    {
        $query = "SELECT
                        a.no_adj,
                        a.id_hr AS id_peminjam,
                        ai.kode_barang,
                        ai.nama_barang,
                        ABS( ai.quantity * 1 ) AS pinjam,
                        COALESCE ( aik.kembali, 0 ) AS kembali,
                        ABS( ai.quantity * 1 ) - COALESCE ( aik.kembali, 0 ) AS sisa 
                    FROM
                        rsp_project_live.`t_adjusment_item` ai
                        JOIN rsp_project_live.t_adjusment a ON a.no_adj = ai.no_adj
                        LEFT JOIN (
                        SELECT
                            ai.no_peminjaman,
                            a.id_hr AS id_peminjam,
                            ai.kode_barang,
                            SUM(
                            ABS( ai.quantity * 1 )) AS kembali 
                        FROM
                            rsp_project_live.`t_adjusment_item` ai
                            JOIN rsp_project_live.t_adjusment a ON a.no_adj = ai.no_adj 
                        WHERE
                            a.type = 22 
                            AND LEFT ( a.no_adj, 3 ) = 'AKJ' AND a.id_hr = '$user_id'
                        GROUP BY
                            ai.no_peminjaman,
                            ai.kode_barang 
                        ) aik ON aik.no_peminjaman = ai.no_adj 
                        AND aik.kode_barang = ai.kode_barang 
                    WHERE
                        a.type = 21 
                        AND LEFT ( a.no_adj, 3 ) = 'AMJ' AND a.id_hr = '$user_id'
                        AND (
                        ABS( ai.quantity * 1 ) - COALESCE ( aik.kembali, 0 )) > 0";
        return $this->db->query($query)->result();
    }


    public function get_report_detail($start, $end)
    {
        $query = "SELECT
                        DATE(ec.created_at) AS created_at,
                        ec.id_resignation,
                        COALESCE(atasan_rsp.nama_spv,'') AS nama_spv,
	                    IF(COALESCE(atasan_rsp.nama_mng,'') = 'IT Trusmi Group', '',COALESCE(atasan_rsp.nama_mng,'')) AS nama_mng,
                        ec.karyawan as employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                                        e.date_of_joining,
                                        concat(
                                    timestampdiff(YEAR,`e`.`date_of_joining`,curdate()),' tahun ',(timestampdiff(MONTH,`e`.`date_of_joining`,curdate()) 
                                    - (12 * timestampdiff(YEAR,`e`.`date_of_joining`,curdate()))),' bulan' ) AS masa_kerja,
                                        la.last_attendance,
                                        MAX(to_date) AS habis_kontrak,
                        CONCAT(head.first_name,' ',head.last_name) AS head_employee_name,
                        ds.designation_name,
                        d.department_name,
                        c.name AS company_name,
                        ec.subclearance AS id_subclearance,
                        sc.subclearance,
                        ec.`status` AS id_status_resignation,
                        ec.note,
                        CASE WHEN ec.`status` = 0 THEN 'Waiting' 
                        WHEN ec.`status` = 1 THEN 'Approve' 
                        WHEN ec.`status` = 2 THEN 'Approve' 
                        WHEN ec.`status` = 3 THEN 'Approve'
                        WHEN ec.`status` = 4 THEN 'Reject'
                        ELSE  'Not Approved' END AS status_resignation,
                        ec.id AS id_exit_clearance,
                        ec.pic,
                        COALESCE(SUBSTR(ec.approved_at,1,10),'') AS approved_at,
                        CONCAT(apr.first_name,' ',apr.last_name) AS diperiksa_oleh,
                        er.reason_atasan
                    FROM
                        trusmi_exit_clearance ec
                        LEFT JOIN xin_employees e ON e.user_id = ec.karyawan
                                        LEFT JOIN (SELECT
                    er.employee_id,
                    MAX( attendance_date ) AS last_attendance
                FROM (
                SELECT employee_id FROM xin_employee_resignations er GROUP BY er.employee_id ) er
                JOIN xin_attendance_time ON xin_attendance_time.employee_id = er.employee_id
                GROUP BY xin_attendance_time.employee_id) AS la ON la.employee_id = ec.karyawan
                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                LEFT JOIN xin_employees head ON head.user_id = d.head_id
                LEFT JOIN xin_companies c ON c.company_id = e.company_id
                LEFT JOIN xin_employee_resignations er ON er.resignation_id = ec.id_resignation
                LEFT JOIN xin_employees apr ON apr.user_id = ec.pic
                LEFT JOIN trusmi_subclearance sc ON sc.id = ec.subclearance
                LEFT JOIN xin_employee_contract ON xin_employee_contract.employee_id = e.user_id
                LEFT JOIN (
                            SELECT
                            u.id_hr,
                            u.employee_name,
                            spv.employee_name AS nama_spv,
                            mng.employee_name AS nama_mng 
                        FROM
                            rsp_project_live.`user` u
                            LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                            LEFT JOIN rsp_project_live.`user` mng ON mng.id_user = u.id_manager 
                        WHERE
                            u.id_hr IS NOT NULL AND u.id_user != 1
                    ) AS atasan_rsp ON atasan_rsp.id_hr = e.user_id
                WHERE DATE(ec.created_at) BETWEEN '$start' AND '$end'
                GROUP BY e.user_id, ec.id_resignation, ec.subclearance
                ORDER BY CASE WHEN ec.`status` = 0 THEN 1 
                WHEN ec.`status` = 1 THEN 3 
                WHEN ec.`status` = 2 THEN 4 
                WHEN ec.`status` = 3 THEN 5
                WHEN ec.`status` = 4 THEN 2
                ELSE 1 END ASC";
        return $this->db->query($query)->result();
    }

    function list_inventaris($user) {

        $query = "SELECT
        a.id_aset,
        a.kode_aset,
        a.nomor_aset,
        a.nama_aset,
        j.nama_jenis AS jenis_aset,
        a.qty,
        a.foto_aset,
        un.nama AS satuan,
        a.harga,
        a.tgl_beli,
        l.kode_lokasi,
        l.nama_lokasi,
        CONCAT( e.first_name, ' ', e.last_name ) AS pic_by,
        c.company_id,
        c.`name` AS company_name,
        d.department_id,
        d.department_name,
        a.`status`,
        a.keterangan,
        a.created_at AS tgl_registrasi_aset,
        CONCAT( created.first_name, ' ', created.last_name ) AS registrasi_by,
        pi.purchase_number,
        pi.created_at AS po_at,
        CONCAT( po_user.first_name, ' ', po_user.last_name ) AS po_by,
        po.approved_at AS approved_at,
        CONCAT( po_aprove.first_name, ' ', po_aprove.last_name ) AS po_approved_by,
        ri.receive_number,
        ri.created_at AS receive_at,
        CONCAT( u_rcv.first_name, ' ', u_rcv.last_name ) AS receive_by,
        a.disposal,
        a.disposal_note,
        CONCAT( dis_user.first_name, ' ', dis_user.last_name ) AS disposal_by,
        a.disposal_at 
    FROM
        db_pobox.`m_aset` a
        LEFT JOIN db_pobox.t_receive tr ON tr.receive_number = a.receive_number
        LEFT JOIN db_pobox.t_receive_item ri ON ri.id = a.id_receive_item
        LEFT JOIN db_pobox.t_purchase_item pi ON pi.nama_barang = ri.nama_barang 
        AND pi.purchase_number = ri.purchase_number
        LEFT JOIN db_pobox.t_purchase po ON po.purchase_number = pi.purchase_number
        LEFT JOIN db_pobox.m_lokasi l ON l.id_lokasi = a.id_lokasi
        LEFT JOIN db_pobox.m_jenis_aset j ON j.id_jenis = a.id_jenis_aset
        LEFT JOIN db_pobox.m_unit un ON un.unit = a.satuan
        LEFT JOIN hris.xin_companies c ON c.company_id = a.company
        LEFT JOIN hris.xin_departments d ON d.department_id = a.department
        LEFT JOIN hris.xin_employees e ON e.user_id = a.pic
        LEFT JOIN hris.xin_employees created ON created.user_id = a.created_by
        LEFT JOIN hris.xin_employees u_rcv ON u_rcv.user_id = tr.created_by
        LEFT JOIN hris.xin_employees po_user ON po_user.user_id = po.created_by
        LEFT JOIN hris.xin_employees dis_user ON dis_user.user_id = a.disposal_by
        LEFT JOIN hris.xin_employees po_aprove ON po_aprove.user_id = po.approved_by 
    WHERE
        (
            a.disposal IS NULL 
        OR a.disposal IN ( 1, 2 )) 
        AND a.pic = $user";

        return $this->db->query($query)->result();
    }
}
