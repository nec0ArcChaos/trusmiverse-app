<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_capaian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_employees($search = "")
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as employee_name");
        $this->db->from('xin_employees');
        $this->db->where('is_active', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->group_end();
        }

        $query = $this->db->get();
        return $query ? $query->result_array() : [];
    }

    function get_total_tasklist($periode, $user_id)
    {
        $this->db->select("COUNT(*) as total_tasklist");
        $this->db->from('t_pm_tasklist');
        $this->db->where('SUBSTR(start_date, 1, 7) =', $periode);
        $this->db->where('FIND_IN_SET(' . $user_id . ', pic)');
        $query = $this->db->get();
        return $query ? $query->row()->total_tasklist : 0;
    }

    function get_capaian_progress($user_id, $periode)
    {
        return $this->db->query("SELECT
                            e.user_id AS employee_id,
                            CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                            ti.project_id,
                            ti.id AS task_id,
                            ti.task_name,
                            SUBSTR(ti.`start_date`, 1, 7) AS periode,
                            ti.`start_date`,
                            ti.deadline,
                            ti.`status`,
                            ti.progress,
                            ti.end_date,
                            TIMESTAMPDIFF(DAY, ti.`start_date`, ti.`deadline`) AS work_day,
                            TIMESTAMPDIFF(DAY, ti.`deadline`, COALESCE(ti.`end_date`, CURRENT_TIME)) AS late_day,
                            IF
                            (TIMESTAMPDIFF(DAY, ti.`deadline`, COALESCE(ti.`end_date`, CURRENT_TIME)) > 0, 'late', 'ontime') AS status_leadtime 
                            FROM
                            `t_pm_tasklist` ti
                            LEFT JOIN t_pm_projects t ON t.id = ti.project_id
                            LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, ti.pic) 
                            WHERE
                            e.user_id = '$user_id' 
                            AND SUBSTR(ti.`start_date`, 1, 7) = '$periode' 
                            AND FIND_IN_SET(ti.category, '1')")->row_array();
    }

    function get_ticket_progress($user_id, $periode)
    {
        return $this->db->query("SELECT
                            COUNT(*) as total_ticket,
                            SUM(IF(status IN (3,4), 1, 0)) as done_ticket
                            FROM
                            `ticket_task` ti
                            LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, ti.pic) 
                            WHERE
                            e.user_id = '$user_id' 
                            AND SUBSTR(ti.`start`, 1, 7) = '$periode'")->row_array();
    }
}
