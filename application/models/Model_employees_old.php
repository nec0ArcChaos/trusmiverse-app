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
                        r.role_name,
                        s.shift_name,
                        e.is_active,
                        COALESCE(e.updated_at,'') AS updated_at,
                        COALESCE(CONCAT(u.first_name,' ',u.last_name),'') AS updated_by
                    FROM
                        xin_employees e
                        LEFT JOIN xin_companies c ON c.company_id = e.company_id
                        LEFT JOIN xin_departments d ON d.department_id = e.department_id
                        LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                        LEFT JOIN xin_user_roles r ON r.role_id = e.user_role_id
                        LEFT JOIN xin_office_shift s ON s.office_shift_id = e.office_shift_id
                        LEFT JOIN xin_office_location l ON l.location_id = e.location_id
                        LEFT JOIN xin_employees u ON u.user_id = e.updated_by
                        WHERE e.user_id != 1";
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
}
