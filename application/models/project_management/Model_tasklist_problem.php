<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tasklist_problem extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_tasklist_problem($periode, $user_id)
    {
        $query = "SELECT
                    t.project_code,
                    t.project_name,
                    t.id,
                    t.project_id,
                    t.task_code,
                    t.task_name,
                    t.category,
                    t.pic,
                    GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic_name,
                    t.`start_date`,
                    t.progress,
                    t.STATUS,
                    DATE_FORMAT(t.deadline, '%d %M') AS deadline_req,
                    CASE WHEN t.end_date IS NOT NULL OR t.`status` IN ('Done', 'Cancelled') THEN 'DONE' 
                    WHEN CURRENT_DATE > DATE(t.deadline) THEN CONCAT('OVERDUE ', DATEDIFF(CURRENT_DATE, DATE(t.deadline)), ' DAYS') 
                    WHEN CURRENT_DATE = DATE(t.deadline) THEN 'DUE TODAY' 
                    WHEN DATEDIFF(DATE(t.deadline), CURRENT_DATE) = 1 THEN 'DUE TOMORROW' 
                    WHEN DATEDIFF(DATE(t.deadline), CURRENT_DATE) BETWEEN 2 AND 3 THEN 'DUE SOON' ELSE 'ON_TRACK' 
                    END AS deadline_hint,
                    COALESCE(prob.id, '') AS problem_id,
                    COALESCE(prob.problem_desc, '') AS problem_desc,
                    COALESCE(prob.created_at, '') AS problem_created_at,
                    COALESCE(prob.problem_note, '') AS problem_note,
                    COALESCE(CONCAT(prob_e.first_name, ' ', prob_e.last_name), 'System') AS problem_reporter,
                    t.is_late,
                    t.is_potential_late,
                    CASE WHEN prob.id IS NULL THEN 1 ELSE 0 END AS need_input_problem,
                    CASE WHEN prob.id IS NOT NULL THEN 1 ELSE 0 END AS has_problem,
                    prob.`status` AS status_problem,
                    COALESCE(prob.est_date, 'Not Estimated') AS est_date,
                    COALESCE(CASE WHEN CURRENT_DATE > DATE(prob.est_date) THEN CONCAT('OVERDUE ', DATEDIFF(CURRENT_DATE, DATE(prob.est_date)), ' DAYS') 
                    WHEN CURRENT_DATE = DATE(prob.est_date) THEN 'DUE TODAY' 
                    WHEN DATEDIFF(DATE(prob.est_date), CURRENT_DATE) = 1 THEN 'DUE TOMORROW' 
                    WHEN DATEDIFF(DATE(prob.est_date), CURRENT_DATE) BETWEEN 2 AND 3 THEN 'DUE SOON' ELSE CONCAT('DUE IN ', DATEDIFF(DATE(prob.est_date), CURRENT_DATE), ' DAYS') 
                    END, '') AS est_hint 
                FROM
                    (
                        SELECT
                            task.pic,
                            p.project_code,
                            p.project_name,
                            task.id,
                            task.project_id,
                            task.task_code,
                            task.task_name,
                            task.category,
                            task.`start_date`,
                            task.deadline,
                            task.end_date,
                            task.progress,
                            task.`status`,
                            task.created_at,
                            CASE WHEN task.`status` IN ('In Progress', 'To Do') AND CURRENT_DATE >= DATE(task.deadline) THEN 1 ELSE 0 END AS is_late,
                            t1.unfinished_task AS is_potential_late 
                        FROM
                            t_pm_tasklist task
                            LEFT JOIN t_pm_projects p ON p.id = task.project_id
                            LEFT JOIN 
                                (
                                    SELECT
                                        project_id,
                                        COUNT(DISTINCT id) AS unfinished_task 
                                    FROM
                                        t_pm_tasklist task1 
                                    WHERE
                                        SUBSTR(task1.`start_date`, 1, 7) = '$periode' 
                                        AND task1.`status` IN ('In Progress', 'To Do') 
                                        AND task1.pic = '$user_id' 
                                        AND DATE(task1.`start_date`) < CURRENT_DATE 
                                    GROUP BY
                                        project_id
                                ) AS t1 ON t1.project_id = task.project_id 
                        WHERE
                            SUBSTR(task.`start_date`, 1, 7) = '$periode'
                    ) t
                LEFT JOIN t_pm_tasklist_problem prob ON prob.task_id = t.id
                LEFT JOIN xin_employees prob_e ON prob_e.user_id = prob.created_by
                LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id,t.pic)
                WHERE
                    t.is_late = 1 
                    OR t.is_potential_late = 1 
                GROUP BY
                    t.id,
                    prob.id";
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function add_problem($data)
    {
        $this->db->insert('t_pm_tasklist_problem', $data);
        return $this->db->insert_id();
    }

    public function add_problem_history($data)
    {
        $this->db->insert('t_pm_tasklist_problem_history', $data);
    }

    public function update_problem($task_id, $data)
    {
        $this->db->where('task_id', $task_id);
        $this->db->update('t_pm_tasklist_problem', $data);
        return $this->db->affected_rows();
    }

    public function get_problem_by_task($task_id)
    {
        $this->db->where('task_id', $task_id);
        return $this->db->get('t_pm_tasklist_problem')->row();
    }

    public function delete_problem($task_id)
    {
        $this->db->where('task_id', $task_id);
        $this->db->delete('t_pm_tasklist_problem');
    }
}
