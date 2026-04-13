<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_navigation extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_parent()
    {
        $query = "SELECT menu_id, menu_nm, `level` FROM `trusmi_navigation` WHERE `level` IN (1,2,3,4) AND menu_url IS NULL";
        return $this->db->query($query)->result();
    }

    function get_role()
    {
        $query = "SELECT role_id, `role_name` AS role_nm FROM `xin_user_roles`";
        return $this->db->query($query)->result();
    }

    function get_company()
    {
        $query = "SELECT company_id, `name` AS company_nm FROM `xin_companies`";
        return $this->db->query($query)->result();
    }

    function get_department()
    {
        $query = "SELECT department_id, `department_name` AS department_nm FROM `xin_departments`";
        return $this->db->query($query)->result();
    }

    function get_designation()
    {
        $query = "SELECT designation_id, `designation_name` AS designation_nm FROM `xin_designations`";
        return $this->db->query($query)->result();
    }

    function get_user()
    {
        $query = "SELECT user_id, CONCAT(`first_name`, ' ', last_name, ' (', d.department_name,')') AS user_nm FROM `xin_employees` 
        LEFT JOIN xin_departments d ON d.department_id = xin_employees.department_id WHERE is_active = 1";
        return $this->db->query($query)->result();
    }


   //  function menu($level = null)
   //  {
   //      $group_by = "";
   //      $order_by = "";
   //      if ($level == 1) {
   //          $group_by = "GROUP BY a.menu_nm";
   //          $order_by = "ORDER BY a.no_urut";
   //      } else if ($level == 2) {
   //          $group_by = "GROUP BY b.menu_nm";
   //          $order_by = "ORDER BY b.no_urut";
   //      } else if ($level == 3) {
   //          $order_by = "ORDER BY c.no_urut";
   //          $group_by = "GROUP BY c.menu_nm";
   //      }
   //      $query = "SELECT
   //                  a.menu_id AS a_id,
   //                  a.menu_nm AS a_menu,
   //                  IF(b.menu_nm IS NULL,a.menu_url,'#') AS a_url,
   //                  a.menu_icon AS a_icon,
   //                  a.role_id AS a_role_id,
   //                  a.company_id AS a_company_id,
   //                  a.department_id AS a_department_id,
   //                  a.designation_id AS a_designation_id,
   //                  a.user_id AS a_user_id,
   //                  a.user_id_blocked AS a_user_id_blocked,
   //                  b.menu_id AS b_id,
   //                  b.parent_id AS b_parent_id,
   //                  b.menu_nm AS b_menu,
   //                  IF(c.menu_nm IS NULL,b.menu_url,'#') AS b_url,
   //                  b.menu_icon AS b_icon,
   //                  b.role_id AS b_role_id,
   //                  b.company_id AS b_company_id,
   //                  b.department_id AS b_department_id,
   //                  b.designation_id AS b_designation_id,
   //                  b.user_id AS b_user_id,
   //                  b.user_id_blocked AS b_user_id_blocked,
   //                  c.parent_id AS c_parent_id,
   //                  c.menu_nm AS c_menu,
   //                  c.menu_url AS c_url,
   //                  c.menu_icon AS c_icon,
   //                  c.role_id AS c_role_id,
   //                  c.company_id AS c_company_id,
   //                  c.department_id AS c_department_id,
   //                  c.designation_id AS c_designation_id,
   //                  c.user_id AS c_user_id,
   //                  c.user_id_blocked AS c_user_id_blocked
   //              FROM
   //                  `trusmi_navigation` a
   //                  LEFT JOIN trusmi_navigation b ON b.parent_id = a.menu_id AND b.`level` = 2
   //                  LEFT JOIN trusmi_navigation c ON c.parent_id = b.menu_id AND c.`level` = 3
   //                  WHERE a.parent_id IS NULL
   //          $group_by $order_by";
   //      return $this->db->query($query)->result();
   //  }

   // sampai level 5
   function menu($level = null) {
      $group_by = "";
      $order_by = "";

      if ($level == 1) {
         $group_by = "GROUP BY a.menu_nm";
         $order_by = "ORDER BY a.no_urut";
      } else if ($level == 2) {
         $group_by = "GROUP BY b.menu_nm";
         $order_by = "ORDER BY b.no_urut";
      } else if ($level == 3) {
         $group_by = "GROUP BY c.menu_nm";
         $order_by = "ORDER BY c.no_urut";
      } else if ($level == 4) {
         $group_by = "GROUP BY d.menu_nm";
         $order_by = "ORDER BY d.no_urut";
      } else if ($level == 5) {
         $group_by = "GROUP BY e.menu_nm";
         $order_by = "ORDER BY e.no_urut";
      }

      $query = "
         SELECT 
               
               a.menu_id AS a_id, a.menu_nm AS a_menu, IF(b.menu_nm IS NULL,a.menu_url,'#') AS a_url,
               a.menu_icon AS a_icon, a.role_id AS a_role_id, a.company_id AS a_company_id, 
               a.department_id AS a_department_id, a.designation_id AS a_designation_id,
               a.user_id AS a_user_id, a.user_id_blocked AS a_user_id_blocked,
               a.notes AS a_notes,

               b.menu_id AS b_id, b.parent_id AS b_parent_id, b.menu_nm AS b_menu, 
               IF(c.menu_nm IS NULL,b.menu_url,'#') AS b_url, b.menu_icon AS b_icon,
               b.role_id AS b_role_id, b.company_id AS b_company_id, 
               b.department_id AS b_department_id, b.designation_id AS b_designation_id,
               b.user_id AS b_user_id, b.user_id_blocked AS b_user_id_blocked,
               b.notes AS b_notes,

               c.menu_id AS c_id, c.parent_id AS c_parent_id, c.menu_nm AS c_menu, 
               IF(d.menu_nm IS NULL,c.menu_url,'#') AS c_url, c.menu_icon AS c_icon,
               c.role_id AS c_role_id, c.company_id AS c_company_id, 
               c.department_id AS c_department_id, c.designation_id AS c_designation_id,
               c.user_id AS c_user_id, c.user_id_blocked AS c_user_id_blocked,
               c.notes AS c_notes,

               d.menu_id AS d_id, d.parent_id AS d_parent_id, d.menu_nm AS d_menu, 
               IF(e.menu_nm IS NULL,d.menu_url,'#') AS d_url, d.menu_icon AS d_icon,
               d.role_id AS d_role_id, d.company_id AS d_company_id, 
               d.department_id AS d_department_id, d.designation_id AS d_designation_id,
               d.user_id AS d_user_id, d.user_id_blocked AS d_user_id_blocked,
               d.notes AS d_notes,

               e.menu_id AS e_id, e.parent_id AS e_parent_id, e.menu_nm AS e_menu, 
               e.menu_url AS e_url, e.menu_icon AS e_icon,
               e.role_id AS e_role_id, e.company_id AS e_company_id, 
               e.department_id AS e_department_id, e.designation_id AS e_designation_id,
               e.user_id AS e_user_id, e.user_id_blocked AS e_user_id_blocked,
               e.notes AS e_notes

            FROM trusmi_navigation a
            LEFT JOIN trusmi_navigation b ON b.parent_id = a.menu_id AND b.level = 2
            LEFT JOIN trusmi_navigation c ON c.parent_id = b.menu_id AND c.level = 3
            LEFT JOIN trusmi_navigation d ON d.parent_id = c.menu_id AND d.level = 4
            LEFT JOIN trusmi_navigation e ON e.parent_id = d.menu_id AND e.level = 5
            WHERE a.parent_id IS NULL
            $group_by
            $order_by
         ";

      return $this->db->query($query)->result();
   }

    public function dt_navigation()
    {
        $query = "SELECT
                    a.menu_id,
                    a.no_urut,
                    a.`level`,
                    a.parent_id,
                    COALESCE(b.menu_nm, '-') AS parent_nm,
                    a.menu_nm,
                    a.menu_url,
                    a.menu_icon,
                    a.role_id,
                    COALESCE(GROUP_CONCAT(DISTINCT r.`role_name`), '') AS role_name,
                    COALESCE(a.company_id, '') AS company_id,
                    COALESCE(GROUP_CONCAT(DISTINCT c.`name`), '') AS company_name,
                    COALESCE(a.department_id, '') AS department_id,
                    COALESCE(GROUP_CONCAT(DISTINCT d.`department_name`), '') AS department_name,
                    COALESCE(a.designation_id, '') AS designation_id,
                    COALESCE(GROUP_CONCAT(DISTINCT ds.`designation_name`), '') AS designation_name,
                    COALESCE(a.user_id, '') AS user_id,
                    COALESCE(GROUP_CONCAT(DISTINCT e.employee_name), '') AS user_name,
                    COALESCE(a.user_id_blocked, '') AS user_id_blocked,
                    COALESCE(GROUP_CONCAT(DISTINCT bl.employee_name), '') AS user_blocked 
                    FROM
                    trusmi_navigation a
                    LEFT JOIN (
                        SELECT
                        a.menu_id,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name, ' ', e.last_name)) AS employee_name 
                        FROM
                        trusmi_navigation a
                        JOIN xin_employees e ON FIND_IN_SET(e.user_id, a.user_id) 
                        GROUP BY
                    a.menu_id) e ON FIND_IN_SET(e.menu_id, a.menu_id)
                    LEFT JOIN (
                        SELECT
                        a.menu_id,
                        GROUP_CONCAT(DISTINCT CONCAT(bl.first_name, ' ', bl.last_name)) AS employee_name 
                        FROM
                        trusmi_navigation a
                        JOIN xin_employees bl ON FIND_IN_SET(bl.user_id, a.user_id_blocked) 
                        GROUP BY
                    a.menu_id) bl ON FIND_IN_SET(bl.menu_id, a.menu_id)
                    LEFT JOIN trusmi_navigation b ON b.menu_id = a.parent_id
                    LEFT JOIN xin_user_roles r ON FIND_IN_SET(r.role_id, a.role_id)
                    LEFT JOIN xin_companies c ON FIND_IN_SET(c.company_id, a.company_id)
                    LEFT JOIN xin_departments d ON FIND_IN_SET(d.department_id, a.department_id)
                    LEFT JOIN xin_designations ds ON FIND_IN_SET(ds.designation_id, a.designation_id) 
                    GROUP BY
                    a.menu_id";
        return $this->db->query($query)->result();
    }
}
