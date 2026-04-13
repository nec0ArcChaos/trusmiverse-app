<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_employees extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function dt_employees()
    {
        $query = "SELECT
                        e.user_id,
                        e.employee_id,
                        CASE WHEN e.profile_picture = '' AND e.gender = 'Male' THEN 'default_male.jpg'
                        WHEN e.profile_picture = '' AND e.gender = 'Female' THEN 'default_female.jpg'
                        ELSE e.profile_picture END AS profile_picture,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        c.`name` AS company_name,
                        d.department_name,
                        ds.designation_name,
                        l.location_name,
                        e.username,
                        e.email,
                        e.contact_no,
                        e.ctm_grade,
                        r.role_name,
                        s.shift_name,
                        e.is_active,
                        COALESCE(e.updated_at,'') AS updated_at,
                        COALESCE(CONCAT(u.first_name,' ',u.last_name),'') AS updated_by,
                        -- COALESCE(CONCAT(head.first_name,' ',head.last_name),'') AS head_name
                        head.username AS head_name
                    FROM
                        xin_employees e
                        LEFT JOIN xin_companies c ON c.company_id = e.company_id
                        LEFT JOIN xin_departments d ON d.department_id = e.department_id
                        LEFT JOIN xin_employees head ON head.user_id = d.head_id
                        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                        LEFT JOIN xin_user_roles r ON r.role_id = e.user_role_id
                        LEFT JOIN xin_office_shift s ON s.office_shift_id = e.office_shift_id
                        LEFT JOIN xin_office_location l ON l.location_id = e.location_id
                        LEFT JOIN xin_employees u ON u.user_id = e.updated_by
                        WHERE e.user_id != 1
                        -- AND SUBSTR( e.created_at, 1, 10 ) > '2024-01'
                        -- AND e.is_active = 1
                        ";
        return $this->db->query($query)->result();
    }

    function reset_password()
    {
        $user_id = $this->input->post('user_id');
        if ($user_id != '') {
            $data = array(
                'password' => '$2y$12$8LhRlAGa9Qp0T.jy1aIK.O0ficmh.DafzR4tM5GnwWkj56U8IYxKq',
                'ctm_password' => '25d55ad283aa400af464c76d713c07ad'
            );
            return $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        }
        return false;
    }
    function detail_employee($user_id, $type)
    {
        if ($type == 1) {
            $query = "SELECT
                emp.first_name,
                emp.last_name,
                emp.user_id AS employee_id,
                emp.username,
                emp.email,
                com.`name` AS company_name,
                loc.location_name AS location,
                dep.department_name AS departement,
                des.designation_name,
                emp.date_of_joining,
                emp.date_of_leaving,
                emp.ctm_offering AS date_offering,
                rol.role_name,
                emp.ctm_posisi as posisi,
                emp.gender,
                emp.marital_status,
                emp.contact_no AS contact,
                CASE emp.is_active
                WHEN 1 THEN 'Active'
                ELSE 'Inactive'
                END AS status_active,
                sh.office_shift_id AS office_shift,
                emp.date_of_birth,
                emp.city,
                emp.zipcode,
                ag.ethnicity_type_id AS agama,
                emp.address,
                emp.ctm_tempat_lahir AS place_birth,
                emp.ctm_ayah AS ayah,
                emp.ctm_ibu AS ibu,
                emp.ctm_nokk AS no_kk,
                emp.ctm_noktp AS no_ktp,
                fc.no_npwp
                FROM
                xin_employees emp
                JOIN xin_companies com ON emp.company_id = com.company_id
                JOIN xin_office_location loc ON loc.location_id = emp.location_id
                JOIN xin_departments dep ON dep.department_id = emp.department_id
                JOIN xin_designations des ON des.designation_id = emp.designation_id
                JOIN xin_user_roles rol ON rol.role_id = emp.user_role_id
                JOIN xin_office_shift sh ON sh.office_shift_id = emp.office_shift_id
                JOIN xin_ethnicity_type ag ON ag.ethnicity_type_id = emp.ethnicity_type
                LEFT JOIN xin_job_applications app ON app.user_id_emp = emp.user_id
                LEFT JOIN fack_personal_details fc ON fc.application_id = app.application_id 
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->row_object();
        } else if ($type == 2) {
            $query = "SELECT 
                fam.application_id,
                fam.`status`,
                fam.nama,
                fam.jenis_kelamin,
                fam.tempat_lahir,
                fam.pendidikan AS id_pendidikan,
                lvl.name AS pendidikan,
                fam.pekerjaan,
                fam.no_hp

                FROM `fack_families` fam
                JOIN xin_job_applications app ON app.application_id = fam.application_id
                JOIN xin_employees emp ON app.user_id_emp = emp.user_id
                JOIN xin_qualification_education_level lvl ON lvl.education_level_id = fam.pendidikan
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->result();
        } else if ($type == 3) {
            $query = "SELECT 
                qualification_id,
                employee_id,
                lv.`name` AS level,
                qu.`name`,
                from_year,
                to_year
                FROM `xin_employee_qualification` qu
                JOIN xin_qualification_education_level lv ON lv.education_level_id = qu.education_level_id
                WHERE employee_id = '$user_id'";
            return $this->db->query($query)->result();
        } else if ($type == 4) {
            $query = "SELECT
                we.nama_perusahaan,
                we.lokasi,
                we.posisi,
                we.tahun_masuk,
                we.tahun_keluar
            FROM
                `fack_work_experience` we
                JOIN xin_job_applications app ON app.application_id = we.application_id
                JOIN xin_employees emp ON app.user_id_emp = emp.user_id 
            WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->result();
        }else{
            $query = "SELECT 
                ct.title,
                ct.from_date,
                ct.to_date,
                ct.description,
                CASE ct.is_active
                WHEN 1 THEN 'Active'
                ELSE 'Inactive'
                END AS status
                FROM `xin_employee_contract` ct 
                JOIN xin_employees emp ON ct.employee_id = emp.user_id
                WHERE
                emp.user_id = '$user_id'";
            return $this->db->query($query)->result();
        }
    }
}
