<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sharing_leader extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_peserta(){

            $user_id = $this->session->userdata('user_id');
            // kusus bu arari
            if($user_id == 6466){
                $kondisi_role = 'AND emp.user_role_id NOT IN (1,9,10,12,13,14)';
            } else {
                $kondisi_role = 'AND emp.user_role_id NOT IN (1,8,9,10,11,12,13,14)';
            }

        $query = "SELECT
            emp.user_id,
            CONCAT(emp.first_name,' ',emp.last_name, ' | ',des.designation_name) AS nama,
            des.designation_name
            
            FROM
            xin_employees emp
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            WHERE emp.is_active = 1
            -- AND emp.user_role_id NOT IN (1,8,9,10,11,12,13,14)
            $kondisi_role 
            ORDER BY first_name";
        return $this->db->query($query)->result();
    }

    function get_klasifikasi()
    {
        $user_id = $this->session->userdata('user_id');
        $query = "SELECT
                    m.id,
                    m.soft_skill AS klasifikasi,
                    COALESCE ( p.klasifikasi, '' ) AS sudah
                FROM
                    m_soft_skill m
                    LEFT JOIN (
                    SELECT
                        p.id_sl,
                        p.klasifikasi
                    FROM
                        t_sharing_leader p
                    WHERE
                        SUBSTR( p.created_at, 1, 7 ) = DATE_FORMAT( CURRENT_DATE, '%Y-%m' ) 
                        AND p.created_by = '$user_id'
                    ORDER BY
                        p.id_sl DESC 
                        LIMIT 1 
                    ) p ON p.klasifikasi = m.id
                    ORDER BY m.soft_skill ASC";
        return $this->db->query($query)->result();
    }

    function generate_id_sharing_leader()
    {
        $q = $this->db->query("SELECT
                                MAX( RIGHT ( t_sharing_leader.id_sl, 3 ) ) AS kd_max 
                            FROM t_sharing_leader 
                            WHERE SUBSTR( t_sharing_leader.created_at, 1, 10 ) = CURDATE( )");
                            $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'SL' . date('ymd') . $kd;
    }


    function dt_sharing_leader($start, $end)
    {
        $user_id = $_SESSION['user_id'];
        $user_role_id = $_SESSION['user_role_id'];
        $designation_id = $_SESSION['designation_id'];

        if ($user_role_id == 1 || in_array($designation_id, ['1217', '1218', '888', '1187']) == 1 || in_array($user_id, [5385, 2729, 70, 2903, 9645,10214, 4498, 10127, 7731, 10404]) == 1) {
            $cond = "";
        } else if ($user_id == 70) {
            $cond = " AND e.company_id = 5";
        } else if ($user_id == 7838) { // hrbatik
            $cond = " AND e.company_id IN (1,3,5,6)";
        } else {
            $cond = " AND sl.created_by = $user_id";
        }
        
        if ($user_id == 7731) { // Dimas Nurullah
            $cond = " AND (e.department_id IN (106,142,183) OR sl.created_by = $user_id)";
        }
        
        if ($user_id == 2735) { // Siti Cahyati
            $cond = " AND (e.department_id IN (142,204,205,206,207,210,211) OR sl.created_by IN ($user_id,6736))";
        }

        if ($user_id == 11372) { // soniyanto8949
            $cond = " AND (sl.created_by IN (9621, 10176, 10168) OR sl.created_by = $user_id)";
         }

        $query = "SELECT
                    sl.id_sl,
                    CONCAT(e.first_name,' ',e.last_name) AS created_by,
                    d.designation_name AS jabatan,
                    sl.judul,
                    s.soft_skill AS klasifikasi,
                    sl.impact,
                    sl.lampiran,
                    sl.created_at,
                    sl.peserta  AS id_peserta,
                    GROUP_CONCAT(CONCAT(pes.first_name,' ',pes.last_name)) AS peserta,
                    sl.file_materi
                FROM t_sharing_leader sl
                LEFT JOIN xin_employees e ON e.user_id = sl.created_by
                LEFT JOIN xin_employees pes ON FIND_IN_SET(pes.user_id,sl.peserta)
                LEFT JOIN xin_designations d ON d.designation_id = sl.designation
                LEFT JOIN m_soft_skill s ON s.id = sl.klasifikasi
                WHERE DATE(sl.created_at) BETWEEN '$start' AND '$end'
                $cond
                GROUP BY sl.id_sl";
        
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
                        p.id_sl,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM t_sharing_leader p 
                    LEFT JOIN m_soft_skill s ON s.id = p.klasifikasi 
                    WHERE CEIL(DAY(p.created_at) / 7) = 1
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w1 ON w1.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id_sl,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM t_sharing_leader p 
                    LEFT JOIN m_soft_skill s ON s.id = p.klasifikasi 
                    WHERE CEIL(DAY(p.created_at) / 7) = 2
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w2 ON w2.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id_sl,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM t_sharing_leader p 
                    LEFT JOIN m_soft_skill s ON s.id = p.klasifikasi 
                    WHERE CEIL(DAY(p.created_at) / 7) = 3
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w3 ON w3.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id_sl,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM t_sharing_leader p 
                    LEFT JOIN m_soft_skill s ON s.id = p.klasifikasi 
                    WHERE CEIL(DAY(p.created_at) / 7) = 4
                    ORDER BY created_at DESC 
                    -- LIMIT 1
                ) w4 ON w4.created_by = e.user_id
                
                LEFT JOIN (
                    SELECT 
                        p.id_sl,
                        p.title,
                        p.author,
                        p.link,
                        s.soft_skill,
                        p.point,
                        p.impact,
                        p.created_at,
                        p.created_by
                    FROM t_sharing_leader p 
                    LEFT JOIN m_soft_skill s ON s.id = p.klasifikasi 
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
