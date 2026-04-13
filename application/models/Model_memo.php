<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_memo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_companies()
    {
        $query = "SELECT * FROM xin_companies";
        return $this->db->query($query)->result();
    }

    function get_department($company_id = null)
    {
        if ($company_id != null) {
            $cond = "WHERE company_id IN (".implode (", ", $company_id).")";
        } else {
            $cond = "";
        }
        $query = "SELECT * FROM xin_departments $cond";
        return $this->db->query($query)->result();
    }

    function get_role()
    {
        $query = "SELECT * FROM xin_user_roles";
        return $this->db->query($query)->result();
    }

    function get_id_memo()
    {
        $memo = $this->db->query("SELECT * FROM trusmi_t_memo WHERE SUBSTR(created_at,1,10) = SUBSTR(CURDATE(),1,10) ORDER BY id_memo DESC LIMIT 1")->row_array();
        if ($memo == null) {
            $date = substr(date("Ymd"), 2);
            $id = "MEMO" . $date . "001";
        } else {
            $latest = substr($memo['id_memo'], 10);
            $current = sprintf("%03d", (int)$latest + 1);
            $date = substr(date("Ymd"), 2);
            $id = "MEMO" . $date . $current;
        }
        return $id;
    }

    function dt_memo($start, $end, $department, $role_id, $status_memo, $id)
    {
        if ($department == 0 || $id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466 ) {
            $sub_query1 = "";
        } 
        else {
            $sub_query1 = "FIND_IN_SET('$department',memo.department_id)";
        }
        
        if ($role_id == 1 || $id == 1 || $id == 2516 || $id == 2729 || $id == 803 ) {
            $sub_query2 = "";
        } else {
            $sub_query2 = "AND FIND_IN_SET('$role_id',memo.role_id)";
        }

        if ($start == null) {
            if ($status_memo != 'feedback') {
                if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466 ) {
                    $sub = 'WHERE memo.status_memo = ' . $status_memo;
                } else {
                    $sub = 'WHERE memo.created_by = ' . $id . ' AND memo.status_memo = ' . $status_memo;
                }
            } else {
                $sub = 'WHERE SUBSTR(memo.start_feedback_at,1,10) <= CURDATE() AND memo.status_memo = 1';
            }
        } else {
            if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466 ) {
                $sub = "WHERE SUBSTR(memo.created_at,1,10) BETWEEN SUBSTR('" . $start . "',1,10) AND SUBSTR('" . $end . "',1,10) AND memo.status_memo = " . $status_memo;
            } else {
                $sub = "WHERE SUBSTR(memo.created_at,1,10) BETWEEN SUBSTR('" . $start . "',1,10) AND SUBSTR('" . $end . "',1,10) AND ((" . $sub_query1 . " " . $sub_query2 . ") OR memo.created_by = " . $id . ") AND memo.status_memo = " . $status_memo;
            }
        }

        $query = "SELECT
                    memo.id_memo,
                    IF(memo.id_approval IS NOT NULL, 1, NULL) AS id_approval,
                    memo.tipe_memo,
                    memo.note,
                    memo.created_at,
                    memo.files_memo,
                    memo.status_memo,
                    CONCAT(emp.first_name,' ',emp.last_name) as created_by,
                    GROUP_CONCAT(DISTINCT com.name) as company,
                    GROUP_CONCAT(DISTINCT depa.department_name) as department,
	                GROUP_CONCAT(DISTINCT `role`.role_name) AS role,
                    CONCAT(upd.first_name,' ',upd.last_name) as updated_by,
                    memo.note_update  
                FROM
                    trusmi_t_memo memo
                    JOIN `xin_employees` emp ON emp.user_id = memo.created_by
                    LEFT JOIN `xin_employees` upd ON upd.user_id = memo.updated_by
                    JOIN xin_companies com ON FIND_IN_SET(com.company_id, memo.company_id)
                    JOIN xin_departments depa ON FIND_IN_SET(depa.department_id, memo.department_id)
	                JOIN xin_user_roles `role` ON FIND_IN_SET(`role`.role_id, memo.role_id)
                    $sub
                GROUP BY memo.id_memo;";
        return $this->db->query($query)->result();
    }

    function feedback_memo_history($id)
    {
        $query = "SELECT 
            history.*,
            CONCAT(emp.first_name,' ',emp.last_name) as feedback_by
        FROM trusmi_t_memo_history history
        JOIN `xin_employees` emp ON emp.user_id = history.feedback_by
        WHERE 
            history.id_memo = '$id' 
        ORDER BY id DESC";
        return $this->db->query($query)->result();
    }
}
