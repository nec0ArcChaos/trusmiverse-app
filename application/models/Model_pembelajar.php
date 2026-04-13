<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pembelajar extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_soft_skill()
    {
        $user_id = $this->session->userdata('user_id');
        return $this->db->query("SELECT
                                    m.id,
                                    m.soft_skill,
                                    COALESCE ( p.soft_skill, '' ) AS sudah
                                FROM
                                    m_soft_skill m
                                    LEFT JOIN (
                                    SELECT
                                        p.id,
                                        p.soft_skill
                                    FROM
                                        pembelajar p
                                    WHERE
                                        SUBSTR( p.created_at, 1, 7 ) = DATE_FORMAT( CURRENT_DATE, '%Y-%m' ) 
                                        AND p.created_by = '$user_id'
                                    ORDER BY
                                        p.id DESC 
                                        -- LIMIT 1 
                                    ) p ON p.soft_skill = m.id")->result();
    }

    function generate_id_pembelajar()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( pembelajar.id, 3 ) ) AS kd_max 
        FROM
        pembelajar 
        WHERE
        SUBSTR( pembelajar.created_at_system, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'P' . date('ymd') . $kd;
    }


    function dt_pembelajar($start, $end)
    {
        $user_id = $_SESSION['user_id'];
        $user_role_id = $_SESSION['user_role_id'];
        $designation_id = $_SESSION['designation_id'];


        if ($user_role_id == 1 || in_array($designation_id, ['1217', '1218', '888', '1187']) == 1 || in_array($user_id, [5385, 2729, 3388, 6466]) == 1) {
            $cond = "";
        } else if ($user_id == 70) {
            $cond = " AND e.company_id IN (1,3,4,5)";
        } else if ($user_id == 7838) { // hrbatik
            $cond = " AND e.company_id IN (1,3,5,6)";
        } else if ($user_id == 11372) { // soniyanto8949
            $cond = " AND p.created_by = $user_id OR p.created_by in (9621, 10176, 10168)";
        } else {
            $cond = " AND p.created_by = $user_id";
        }
        $query = "SELECT
                    p.id,
                    p.title,
                    p.author,
                    p.link,
                    s.id AS id_soft_skill,
                    s.soft_skill,
                    p.point,
                    p.impact,
                    SUBSTR(p.created_at,1,10) AS created_at,
                    p.created_at_system AS created_at_system,
                    c.name AS company_name,
                    d.department_name,
                    CONCAT(e.first_name,' ',e.last_name) AS created_by
                        
                FROM pembelajar p
                LEFT JOIN m_soft_skill s ON s.id = p.soft_skill
                LEFT JOIN xin_employees e ON e.user_id = p.created_by
                LEFT JOIN xin_companies c ON c.company_id = e.company_id
                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                WHERE DATE(p.created_at) BETWEEN '$start' AND '$end' $cond";
        return $this->db->query($query)->result();
    }


    function dt_resume_pembelajar($user_id = null)
    {

        $user_id = $_SESSION['user_id'];
        $user_role_id = $_SESSION['user_role_id'];


        if ($user_role_id == 1) {
            $cond = "";
        } else {
            $cond = " AND e.user_id = $user_id";
        }
        $query = "SELECT 
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                    ds.designation_name AS jabatan,
                    
                    -- w1 	
                    COALESCE(w1.id,'') AS w1_id,
                    -- w1.title AS w1_title,
                    -- w1.author AS w1_author,
                    -- w1.link AS w1_link,
                    -- w1.point AS w1_point,
                    -- w1.impact AS w1_impact,
                    -- w1.created_at AS w1_created_at,
                    
                    -- w2	
                    COALESCE(w2.id,'') AS w2_id,
                    -- w2.title AS w2_title,
                    -- w2.author AS w2_author,
                    -- w2.link AS w2_link,
                    -- w2.point AS w2_point,
                    -- w2.impact AS w2_impact,
                    -- w2.created_at AS w2_created_at,
                    
                    -- w3	
                    COALESCE(w3.id,'') AS w3_id,
                    -- w3.title AS w3_title,
                    -- w3.author AS w3_author,
                    -- w3.link AS w3_link,
                    -- w3.point AS w3_point,
                    -- w3.impact AS w3_impact,
                    -- w3.created_at AS w3_created_at,
                    
                    
                    -- w4	
                    COALESCE(w4.id,'') AS w4_id,
                    -- w4.title AS w4_title,
                    -- w4.author AS w4_author,
                    -- w4.link AS w4_link,
                    -- w4.point AS w4_point,
                    -- w4.impact AS w4_impact,
                    -- w4.created_at AS w4_created_at,
                    
                    -- w5	
                    COALESCE(w5.id,'') AS w5_id
                    -- w5.title AS w5_title,
                    -- w5.author AS w5_author,
                    -- w5.link AS w5_link,
                    -- w5.point AS w5_point,
                    -- w5.impact AS w5_impact,
                    -- w5.created_at AS w5_created_at
                
                    
                    
                FROM xin_employees e
                LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id
                LEFT JOIN xin_departments d ON d.department_id = e.department_id
                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                LEFT JOIN (
                    SELECT 
                        p.id,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM pembelajar p 
                    LEFT JOIN m_soft_skill s ON s.id = p.soft_skill 
                    WHERE CEIL(DAY(p.created_at) / 7) = 1
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w1 ON w1.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM pembelajar p 
                    LEFT JOIN m_soft_skill s ON s.id = p.soft_skill 
                    WHERE CEIL(DAY(p.created_at) / 7) = 2
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w2 ON w2.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM pembelajar p 
                    LEFT JOIN m_soft_skill s ON s.id = p.soft_skill 
                    WHERE CEIL(DAY(p.created_at) / 7) = 3
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w3 ON w3.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM pembelajar p 
                    LEFT JOIN m_soft_skill s ON s.id = p.soft_skill 
                    WHERE CEIL(DAY(p.created_at) / 7) = 4
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w4 ON w4.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM pembelajar p 
                    LEFT JOIN m_soft_skill s ON s.id = p.soft_skill 
                    WHERE CEIL(DAY(p.created_at) / 7) = 5
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w5 ON w5.created_by = e.user_id
                
                WHERE (e.company_id = 2 
                -- AND e.user_role_id IN (2,3,4,5) 
                AND ur.level_sto >= 4 
                AND e.is_active = 1) OR e.user_id IN (1633, 1448, 2987, 1272, 2675, 2525, 2506, 2396, 1426, 1483, 2529, 1568, 2547, 2399, 68, 78, 1139, 1784, 2069, 2521, 476, 116, 118, 454, 573, 637, 638, 998, 1013, 1212, 1294, 1299, 1563, 1721, 1733, 1844, 2108, 3609, 3648, 3961, 4201)
                $cond";
        return $this->db->query($query)->result();
    }






    // OLD

    function list_head()
    {
        $query = "SELECT 
                -- 	dep.department_id,
                -- 	dep.department_name,
                -- 	h.username,
                    h.user_id
                FROM xin_departments dep 
                JOIN xin_employees h ON h.user_id = dep.head_id
                GROUP BY h.department_id";
        $result = $this->db->query($query)->result();

        $heads = [];
        foreach ($result as $row) {
            array_push($heads, $row->user_id);
        }
        return $heads;
    }

    function data_employee($user_id)
    {
        $query = "SELECT user_id, 
                    company_id, 
                    department_id, 
                    designation_id, 
                    user_role_id 
                FROM xin_employees 
                WHERE user_id = '$user_id' 
                LIMIT 1";
        return $this->db->query($query)->row_array();
    }
}
