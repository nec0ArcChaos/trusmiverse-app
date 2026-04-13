<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_review_sistem extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data($start, $end)
    {
        $user = $this->session->userdata('user_id');
        $cek_user = $this->db->query("SELECT user_id, first_name FROM xin_employees emp JOIN xin_user_roles role ON role.role_id = emp.user_role_id WHERE emp.user_id = $user AND emp.user_id IN (6806,6466,1,10127,11065,4498,10127)")->num_rows();
        if ($cek_user > 0) {
            $kondisi = "";
        } else {
            $kondisi = "AND rtmi.pic = '$user'";
        }
        $query = "SELECT
        rtm.id_review,
        rtmi.id AS id_item,
        rtm.deadline_head,
        rtm.head_at,
        xc.`name` AS company,
        xd.department_name AS department,
        CONCAT( head.first_name,' ', head.last_name ) AS head_name,
        GROUP_CONCAT(DISTINCT CONCAT( pic.first_name,' ', pic.last_name )) AS pic_name,
        rtmi.deadline_pic,
		GROUP_CONCAT(
        CONCAT(
            rmn.menu, 
            IF(rmn.sub_menu IS NOT NULL, CONCAT('->', rmn.sub_menu), ''),
            IF(rmn.sub_sub_menu IS NOT NULL, CONCAT('->', rmn.sub_sub_menu), ''),
            IF(rmn.sub_sub_sub_menu IS NOT NULL, CONCAT('->', rmn.sub_sub_sub_menu), '')
        ) 
        SEPARATOR ', '
    ) AS navigation,
		GROUP_CONCAT(DISTINCT rma.aplikasi) AS aplikasi,
        DATE(rtm.created_at) AS created_at,
        CONCAT( created.first_name,' ', created.last_name ) AS created_name  
    FROM
        `review_t_menu` rtm
				LEFT JOIN review_t_menu_item rtmi ON rtmi.id_review = rtm.id_review
				LEFT JOIN review_m_navigation rmn ON rmn.id = rtmi.id_navigation
				LEFT JOIN review_m_aplikasi rma ON rma.id = rmn.id_aplikasi
        LEFT JOIN xin_companies xc ON xc.company_id = rtm.company_id
        LEFT JOIN xin_departments xd ON xd.department_id = rtm.department_id
        LEFT JOIN xin_employees head ON head.user_id = rtm.head_id
        LEFT JOIN xin_employees pic ON pic.user_id = rtmi.pic
        LEFT JOIN xin_employees created ON created.user_id = rtm.created_by
        WHERE SUBSTR(rtm.created_at,1,10) BETWEEN '$start' AND '$end' 
        $kondisi
        GROUP BY rtmi.id_review";
        return $this->db->query($query)->result();
    }

    function get_list_detail($start, $end)
    {

        $user = $this->session->userdata('user_id');
        $cek_user = $this->db->query("SELECT user_id, first_name FROM xin_employees emp JOIN xin_user_roles role ON role.role_id = emp.user_role_id WHERE emp.user_id = $user AND emp.user_id IN (6806,6466,1,10127,11065,4498,10127)")->num_rows();
        if ($cek_user > 0) {
            $kondisi = "";
        } else {
            $kondisi = "AND rtmi.pic = '$user'";
        }
        $query = "SELECT
        rtm.id_review,
        rtmi.id,
        rma.aplikasi,
        rmn.link,
        rmn.menu,
        rmn.sub_menu,
        rmn.sub_sub_menu,
        rmn.sub_sub_sub_menu,
        rtm.deadline_head,
        rtm.head_at,
        xc.`name` AS company,
        xd.department_name AS department,
        CONCAT(head.first_name, ' ', head.last_name) AS head_name,
        CONCAT(pic.first_name, ' ', pic.last_name) AS pic_name,
        rtmi.deadline_pic,
        rtmi.attachment,
        rtmi.impact,
        GROUP_CONCAT(ti.impact SEPARATOR ', ') AS category_impact,
        rtmi.kepuasan_aplikasi,
        rtmi.improvement,
        rtmi.kesesuaian_uiux,
        rtmi.impact_system,
        rtmi.improve_ui,
        rtmi.improve_ux,
        rtmi.note,
        rms.`status`,
        rtmi.kesesuaian_aplikasi 
    FROM
        review_t_menu_item rtmi
    LEFT JOIN review_m_status rms ON rtmi.`status` = rms.id
    LEFT JOIN (
        SELECT 
            ti.id, 
            ti.impact 
        FROM 
            ticket_impact ti
        WHERE 
            FIND_IN_SET(ti.id, (SELECT GROUP_CONCAT(rtmi_impact.impact_category) 
                                FROM review_t_menu_item rtmi_impact))
    ) ti ON FIND_IN_SET(ti.id, rtmi.impact_category) > 0
    LEFT JOIN review_t_menu rtm ON rtm.id_review = rtmi.id_review
    LEFT JOIN review_m_navigation rmn ON rmn.id = rtmi.id_navigation
    LEFT JOIN review_m_aplikasi rma ON rma.id = rmn.id_aplikasi
    LEFT JOIN xin_companies xc ON xc.company_id = rtm.company_id
    LEFT JOIN xin_departments xd ON xd.department_id = rtm.department_id
    LEFT JOIN xin_employees head ON head.user_id = rtm.head_id
    LEFT JOIN xin_employees pic ON pic.user_id = rtmi.pic
    LEFT JOIN xin_employees created ON created.user_id = rtm.created_by
    WHERE SUBSTR(rtm.created_at,1,10) BETWEEN '$start' AND '$end' 
		$kondisi
    GROUP BY 
        rtmi.id";
        return $this->db->query($query)->result();
    }

    function get_detail($id)
    {
        $query = "SELECT
        rtm.id_review,
        rtmi.id,
        rtm.deadline_head,
        rtm.head_at,
        xc.`name` AS company,
        xd.department_name AS department,
        CONCAT(head.first_name, ' ', head.last_name) AS head_name,
        CONCAT(pic.first_name, ' ', pic.last_name) AS pic_name,
        rtmi.deadline_pic,
        rtmi.attachment,
        rtmi.impact,
        GROUP_CONCAT(ti.impact SEPARATOR ', ') AS category_impact, -- Grouped impacts
        rtmi.kepuasan_aplikasi,
        rtmi.improvement,
        rtmi.note,
        rms.`status`,
        rtmi.kesesuaian_aplikasi 
    FROM
        review_t_menu_item rtmi
    LEFT JOIN review_m_status rms ON rtmi.`status` = rms.id
    LEFT JOIN (
        SELECT 
            ti.id, 
            ti.impact 
        FROM 
            ticket_impact ti
        WHERE 
            FIND_IN_SET(ti.id, (SELECT GROUP_CONCAT(rtmi_impact.impact_category) 
                                FROM review_t_menu_item rtmi_impact))
    ) ti ON FIND_IN_SET(ti.id, rtmi.impact_category) > 0 -- Match impact_category with ticket_impact.id
    LEFT JOIN review_t_menu rtm ON rtm.id_review = rtmi.id_review
    LEFT JOIN review_m_navigation rmn ON rmn.id = rtmi.id_navigation
    LEFT JOIN review_m_aplikasi rma ON rma.id = rmn.id_aplikasi
    LEFT JOIN xin_companies xc ON xc.company_id = rtm.company_id
    LEFT JOIN xin_departments xd ON xd.department_id = rtm.department_id
    LEFT JOIN xin_employees head ON head.user_id = rtm.head_id
    LEFT JOIN xin_employees pic ON pic.user_id = rtmi.pic
    LEFT JOIN xin_employees created ON created.user_id = rtm.created_by
    WHERE rtmi.id = '$id'
    GROUP BY 
        rtmi.id";

        return $this->db->query($query)->result();
    }

    function get_company()
    {
        return $this->db->select('company_id, name AS company_name')->from('xin_companies')->get()->result();
    }

    function get_department($id)
    {
        return $this->db->select('department_id, department_name')->from('xin_departments')->where('company_id', $id)->get()->result();
    }

    function get_head($department)
    {
        //     $query = "SELECT
        //     xd.head_id AS user_id,
        //     CONCAT( xe.first_name, ' ', xe.last_name ) AS nama_karyawan 
        // FROM
        //     `xin_departments` xd
        //     LEFT JOIN xin_employees xe ON xe.user_id = xd.head_id 
        // WHERE
        //     xe.is_active = '1' 
        //     AND xd.department_id = '$department' 
        // ORDER BY
        //     nama_karyawan ASC
        //     ";

        $query = "SELECT
    xe.user_id,
    CONCAT( xe.first_name, ' ', xe.last_name ) AS nama_karyawan,
    xds.designation_name 
    FROM
        `xin_employees` xe
        LEFT JOIN xin_departments xd ON xe.department_id = xd.department_id
        LEFT JOIN xin_designations xds ON xds.designation_id = xe.designation_id
    WHERE
        xe.is_active = 1
        AND xd.department_id = '$department'
    ORDER BY
        nama_karyawan ASC";

        return $this->db->query($query)->result();
    }

    function get_aplikasi()
    {
        return $this->db->select('id, aplikasi')->from('review_m_aplikasi')->get()->result();
    }

    function get_navigation($id)
    {
        $query = "SELECT
        rma.aplikasi,rmn.* 
    FROM
        `review_m_navigation` rmn
        LEFT JOIN review_m_aplikasi rma ON rmn.id_aplikasi = rma.id
        WHERE rmn.id_aplikasi = '$id'";
        return $this->db->query($query)->result();
    }

    function get_navigation_temp()
    {
        $user = $this->session->userdata('user_id');
        $query = "SELECT
        rt.*,
        rma.aplikasi,
        rmn.link,
        rmn.menu,
        rmn.sub_menu,
        rmn.sub_sub_menu,
        rmn.sub_sub_sub_menu 
    FROM
        `review_temp` rt
        LEFT JOIN review_m_navigation rmn ON rmn.id = rt.id_navigation
        LEFT JOIN review_m_aplikasi rma ON rmn.id_aplikasi = rma.id
        WHERE rt.created_by = '$user'";

        return $this->db->query($query)->result();
    }

    function get_karyawan()
    {
        $user = $this->session->userdata('user_id');
        $query = "SELECT xin_employees.user_id, xin_employees.username, designation_name, xin_companies.name AS company, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS nama_karyawan, xin_departments.department_name,xin_departments.department_id
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
        WHERE xin_employees.is_active = 1 AND xin_employees.user_id != '$user'
        ORDER BY nama_karyawan ASC
        ";
        return $this->db->query($query)->result();
    }

    function get_pic($id)
    {
        $query = "SELECT xin_employees.user_id, xin_employees.username, designation_name, xin_companies.name AS company, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS nama_karyawan, xin_departments.department_name,xin_departments.department_id
        
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
        LEFT JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        LEFT JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
        WHERE xin_employees.is_active = 1 AND xin_departments.department_id = $id
        ORDER BY nama_karyawan ASC
        ";
        return $this->db->query($query)->result();
    }

    function generate_id_review()
    {
        $q = $this->db->query("SELECT 
                                  MAX( RIGHT ( review_t_menu.id_review, 4 ) ) AS kd_max 
                                FROM
                                review_t_menu 
                                WHERE
                                  DATE( review_t_menu.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return 'REV' . date('ymd') . $kd;
    }

    function jumlah_temp($id)
    {

        $query = "SELECT
                count(review_temp.id) AS jumlah
            FROM
                review_temp
            WHERE review_temp.created_by = $id LIMIT 1";

        return $this->db->query($query)->result();;
    }

    function jumlah_pic($id)
    {

        $query = "SELECT
        count( rmi.id_review ) AS jumlah 
    FROM
        review_t_menu_item rmi 
    WHERE
        rmi.id_review = '$id' 
        AND rmi.pic IS NOT NULL";

        return $this->db->query($query)->result();;
    }

    function list_review_head()
    {
        $user = $this->session->userdata('user_id');
        $kondisi = "";
        if (!in_array($user, [1, 4498,10127])){
            $kondisi = "AND rtm.head_id = $user";
        }
        $query = "SELECT
        xc.`name` AS company,
        xd.department_name AS department,
        CONCAT( head.first_name,' ', head.last_name ) AS head_name,
        rtm.* 
    FROM
        `review_t_menu` rtm
        LEFT JOIN xin_companies xc ON xc.company_id = rtm.company_id
        LEFT JOIN xin_departments xd ON xd.department_id = rtm.department_id
        LEFT JOIN xin_employees head ON head.user_id = rtm.head_id
        WHERE rtm.head_at IS NULL
        $kondisi";

        return $this->db->query($query)->result();
    }

    function list_review_head_item($id)
    {
        $query = "SELECT
        rmi.id AS id_item,
        rmi.id_review,
        rmi.pic,
        CONCAT( pic.first_name,' ', pic.last_name ) AS pic_name,
        xc.`name` AS company,
        xd.department_name AS department,
        xd.department_id,
        CONCAT( xe.first_name,' ', xe.last_name ) AS head_name,
        rma.aplikasi,
        rmn.menu,
        rmn.link,
        rmn.sub_menu,
        rmn.sub_sub_menu,
        rmn.sub_sub_sub_menu,
        rmn.deskripsi,
        rmi.attachment 
    FROM
        review_t_menu_item rmi
        LEFT JOIN review_t_menu rm ON rm.id_review = rmi.id_review
        LEFT JOIN review_m_navigation rmn ON rmn.id = rmi.id_navigation
        LEFT JOIN review_m_aplikasi rma ON rma.id = rmn.id_aplikasi
        LEFT JOIN xin_companies xc ON xc.company_id = rm.company_id
        LEFT JOIN xin_departments xd ON xd.department_id = rm.department_id
        LEFT JOIN xin_employees xe ON xe.user_id = rm.head_id
        LEFT JOIN xin_employees pic ON pic.user_id = rmi.pic
        WHERE rmi.id_review = '$id'";

        return $this->db->query($query)->result();
    }

    function get_list_pic()
    {
        $user = $this->session->userdata('user_id');
        if (in_array($user, [1, 4498,10127])) {
            $kondisi = "WHERE rmi.pic_at IS NULL";
        } else {
            $kondisi = "WHERE rmi.pic = $user
            AND rmi.pic_at IS NULL";
        }

        $query = "SELECT
        rmi.id AS id_item,
        rmi.id_review,
        rmi.pic,
        rmi.deadline_pic,
        CONCAT( pic.first_name,' ', pic.last_name ) AS pic_name,
        rmi.pic_at,
        xc.`name` AS company,
        xd.department_name AS department,
        xd.department_id,
        CONCAT( xe.first_name,' ', xe.last_name ) AS head_name,
        rma.aplikasi,
        rmn.menu,
        rmn.link,
        rmn.sub_menu,
        rmn.sub_sub_menu,
        rmn.sub_sub_sub_menu,
        rmn.deskripsi,
        rmi.attachment 
    FROM
        review_t_menu_item rmi
        LEFT JOIN review_t_menu rm ON rm.id_review = rmi.id_review
        LEFT JOIN review_m_navigation rmn ON rmn.id = rmi.id_navigation
        LEFT JOIN review_m_aplikasi rma ON rma.id = rmn.id_aplikasi
        LEFT JOIN xin_companies xc ON xc.company_id = rm.company_id
        LEFT JOIN xin_departments xd ON xd.department_id = rm.department_id
        LEFT JOIN xin_employees xe ON xe.user_id = rm.head_id
        LEFT JOIN xin_employees pic ON pic.user_id = rmi.pic
        $kondisi";

        return $this->db->query($query)->result();
    }

    function get_status()
    {
        return $this->db->get('review_m_status')->result();
    }

    function get_sesuai()
    {
        return $this->db->get('review_m_sesuai')->result();
    }

    function get_impact_category()
    {
        return $this->db->get('ticket_impact')->result();
    }
}
