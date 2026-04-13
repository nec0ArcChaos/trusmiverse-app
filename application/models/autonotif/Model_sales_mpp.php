<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sales_mpp extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_resume_mpp()
    {
        $query = "SELECT
        total,
        mpp,
        mpp - total AS selisih,
        ROUND( total / mpp * 100 ) AS persentase_all,
        sales,
        ROUND( sales / total * 100 ) AS persentase_sales,
        sc,
        ROUND( sc / total * 100 ) AS persentase_sc,
        se,
        ROUND( se / total * 100 ) AS persentase_se,
        `lock`.total_lock,
        COALESCE(`lock`.sales_lock,0) AS sales_lock,
        COALESCE(`lock`.sc_lock,0) AS sc_lock,
        COALESCE(`lock`.se_lock ,0) AS se_lock,
        rsp_sales.sales_aktif,
        total - rsp_sales.sales_aktif AS sales_existing
    FROM
        (
        SELECT
            COUNT(DISTINCT em.user_id) AS total,
            mpp,
            SUM( CASE WHEN em.designation_id = 731 THEN 1 ELSE 0 END ) sales,
            SUM( CASE WHEN em.designation_id = 926 THEN 1 ELSE 0 END ) sc,
            SUM( CASE WHEN em.designation_id = 1690 THEN 1 ELSE 0 END ) se 
        FROM
            xin_employees em
            LEFT JOIN ( SELECT SUM( standar_mpp ) AS mpp FROM xin_designations xds WHERE standar_mpp IS NOT NULL AND designation_id IN ( 731, 1690, 926 ) ) mpp ON TRUE 
        WHERE
            designation_id IN ( 731, 1690, 926 ) 
            AND is_active = 1 
        ) emp_sales
        LEFT JOIN (
        SELECT
            COUNT(*) total_lock,
            SUM( CASE WHEN designation_id = 731 THEN 1 ELSE 0 END ) AS sales_lock,
            SUM( CASE WHEN designation_id = 926 THEN 1 ELSE 0 END ) AS sc_lock,
            SUM( CASE WHEN designation_id = 1690 THEN 1 ELSE 0 END ) AS se_lock 
        FROM
        `view_lock_sales_monthly_target` 
        ) `lock` ON TRUE
        
				LEFT JOIN (
				SELECT
	user_id,
	u.id_user,
	u.employee_name,
	em.department_id,
	em.designation_id,
	xds.designation_name,
	SUM( sales.total ) AS sales_aktif 
FROM
	rsp_project_live.`user` u
	LEFT JOIN xin_employees em ON u.id_hr = em.user_id 
	OR u.join_hr = em.user_id
	LEFT JOIN xin_designations xds ON xds.designation_id = em.designation_id
	JOIN ( SELECT COUNT( id_user ) AS total, id_manager FROM rsp_project_live.`user` JOIN xin_employees em ON em.user_id = `user`.id_hr WHERE id_user != spv AND isActive = 1 AND id_divisi IN (2,20) AND em.designation_id IN (731, 1690, 926) GROUP BY id_manager ) sales ON sales.id_manager = u.id_user 
WHERE
 u.isActive = 1 
				)rsp_sales ON TRUE";

        return $this->db->query($query)->row();
    }

    public function get_resume_sales_per_manager()
    {
        return $this->db->query("SELECT
        user_id,
        u.id_user AS id_rsp,
        u.employee_name,
        em.department_id,
        em.designation_id,
        xds.designation_name,
        SUM( sales.total ) AS sales_aktif 
    FROM
        rsp_project_live.`user` u
        LEFT JOIN xin_employees em ON u.id_hr = em.user_id 
        OR u.join_hr = em.user_id
        LEFT JOIN xin_designations xds ON xds.designation_id = em.designation_id
        JOIN ( SELECT
	COUNT(DISTINCT user_id ) AS total,
	id_manager 
FROM
	rsp_project_live.`user`
	LEFT JOIN xin_employees em ON em.user_id = `user`.id_hr 
WHERE
	id_user != spv 
	AND em.is_active = 1 
	AND em.designation_id IN ( 731, 1690, 926 ) 
GROUP BY
	id_manager) sales ON sales.id_manager = u.id_user 
    WHERE
        u.id_user <> 1 
        AND u.isActive = 1 
    GROUP BY
        user_id")->result();
    }

    public function sales_aktif()
    {
        return $this->db->query("SELECT user_id FROM sales_aktif_65_hari")->result_array();
    }

    public function sales_locked()
    {
        return $this->db->query("SELECT * FROM `view_lock_sales_target_monthly_16`")->result();
    }

    public function check_double_resignation($employee_id)
    {
        return $this->db
            ->where('employee_id', $employee_id)
            ->get('xin_employee_resignations')
            ->row(); // return false/null jika belum ada
    }

    function update_date_of_leaving($employee_id, $resignation_date)
    {
        $this->update_user_rsp($employee_id);
        $data = [
            'date_of_leaving' => $resignation_date,
            'is_active' => 0,
        ];
        return $this->db->where("user_id", $employee_id)->update("xin_employees", $data);
    }

    public function update_user_rsp($user_id)
    {
        $data = [
            'isActive' => 0,
        ];
        return $this->db->where("id_hr", $user_id)->update("rsp_project_live.user", $data);
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

    public function get_atasan($user_id)
    {
        // $department_id = $this->session->userdata('department_id');
        $query = "	SELECT
        department_name,
        head_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS atasan_name,
        CASE
                    WHEN LEFT ( e.contact_no, 1 ) = 0 THEN
                        CONCAT( 62, SUBSTR( e.contact_no, 2, LENGTH( e.contact_no ) ) ) 
                    ELSE e.contact_no 
                END AS no_hp
    FROM
				xin_employees 
        LEFT JOIN xin_departments d ON d.department_id = xin_employees.department_id
        JOIN xin_employees e ON e.user_id = d.head_id
    WHERE xin_employees.user_id = '$user_id' GROUP BY head_id";
        return $this->db->query($query)->row();
    }

    function get_atasan_rsp($user_id)
    {
        $query = "SELECT
                        u.employee_name,
                        spv.id_user AS id_user_spv,
                        spv.employee_name AS nama_spv,
                        mng.id_user AS id_user_mng,
                        mng.employee_name AS nama_mng,
                        mng.join_hr AS head_id,
		                gm.employee_name AS nama_gm
                    FROM
                        rsp_project_live.`user` u 
                        LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                        LEFT JOIN rsp_project_live.`user` mng ON mng.id_user = u.id_manager
                        LEFT JOIN rsp_project_live.`user` gm ON gm.id_user = u.id_gm
                    WHERE u.join_hr = '$user_id'";
        return $this->db->query($query);
    }
}
