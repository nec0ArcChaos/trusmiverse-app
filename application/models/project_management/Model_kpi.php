<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_kpi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_employees()
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as employee_name");
        $this->db->from('xin_employees');
        $this->db->where('department_id', 68);
        $query = $this->db->get();
        return $query ? $query->result_array() : [];
    }

    public function get_kpi_by_week($user_id)
    {
        $query = $this->db->query("SELECT
            k.id AS kpi_id,
            k.position as kpi_name,
            i.id AS kpi_item_id,
            k.position,
            k.role,
            i.kpi_name AS kpi_item_name,
            i.source,
            i.type,
            i.target AS target_percent,
            i.weight,
            i.unit,
            i.categories,
            COALESCE(k.team_ids, '') AS team_ids,
            COALESCE(k.team_rsp_ids, '') AS team_rsp_ids,
            COALESCE(k.team_bt_ids, '') AS team_bt_ids,
            COALESCE(k.company_ids, '') AS company_ids
            FROM
            m_pm_kpi k
            LEFT JOIN m_pm_kpi_item i ON i.kpi_id = k.id 
            WHERE
            FIND_IN_SET('$user_id', k.user_ids) 
            AND k.is_active = 1 
            AND i.is_active = 1");
        return $query ? $query->result_array() : [];
    }

    public function get_kpi_reviews_weekly_scores($employee_id, $periode, $week, $kpi_id)
    {
        $this->db->from("t_pm_kpi_reviews_weekly_scores");
        $this->db->where('employee_id', $employee_id);
        $this->db->where('periode', $periode);
        $this->db->where('week', $week);
        $this->db->where('kpi_id', $kpi_id);
        $query = $this->db->get();
        return $query ? $query->result_array() : [];
    }

    public function get_kpi_reviews_weekly_feedback($employee_id, $periode, $week, $kpi_id)
    {
        $this->db->select("f.*, COALESCE(e.ttd_digital, '') AS signature_img, CONCAT(e.first_name, ' ', e.last_name) AS reviewer_name, d.designation_name AS reviewer_designation");
        $this->db->from("t_pm_kpi_reviews_weekly_feedback f");
        $this->db->join("xin_employees e", "e.user_id = f.reviewer_id");
        $this->db->join("xin_designations d", "d.designation_id = e.designation_id");
        $this->db->where('f.employee_id', $employee_id);
        $this->db->where('f.periode', $periode);
        $this->db->where('f.week', $week);
        $this->db->where('f.kpi_id', $kpi_id);
        $query = $this->db->get();
        return $query ? $query->row_array() : [];
    }

    public function get_employee_profile($employee_id)
    {
        $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as employee_name, profile_picture, xin_employees.designation_id, xin_employees.department_id, xin_designations.designation_name, xin_departments.department_name");
        $this->db->from('xin_employees');
        $this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
        $this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
        $this->db->where('user_id', $employee_id);
        $query = $this->db->get();
        return $query ? $query->row_array() : [];
    }

    public function get_employee_masa_kerja($employee_id)
    {
        $query = $this->db->query("SELECT
                                    CONCAT(
                                        IF(y > 0, CONCAT(y, ' tahun '), ''),
                                        IF(m > 0, CONCAT(m, ' bulan '), ''),
                                        IF(d > 0, CONCAT(d, ' hari'), '')
                                    ) AS masa_kerja
                                    FROM (
                                    SELECT
                                        TIMESTAMPDIFF(YEAR, date_of_joining, CURDATE()) AS y,
                                        
                                        TIMESTAMPDIFF(
                                        MONTH,
                                        DATE_ADD(date_of_joining, INTERVAL TIMESTAMPDIFF(YEAR, date_of_joining, CURDATE()) YEAR),
                                        CURDATE()
                                        ) AS m,
                                        
                                        DATEDIFF(
                                        CURDATE(),
                                        DATE_ADD(
                                            DATE_ADD(date_of_joining, INTERVAL TIMESTAMPDIFF(YEAR, date_of_joining, CURDATE()) YEAR),
                                            INTERVAL TIMESTAMPDIFF(
                                            MONTH,
                                            DATE_ADD(date_of_joining, INTERVAL TIMESTAMPDIFF(YEAR, date_of_joining, CURDATE()) YEAR),
                                            CURDATE()
                                            ) MONTH
                                        )
                                        ) AS d
                                    FROM xin_employees
                                    WHERE user_id = $employee_id
                                    ) t");
        return $query ? $query->row_array()['masa_kerja'] : "";
    }

    public function get_tasklist_problems($employee_id, $periode, $week)
    {
        $sql = "SELECT
                    p.problem_desc
                FROM
                    t_pm_tasklist_problem p
                JOIN
                    t_pm_tasklist t ON p.task_id = t.id
                WHERE
                    FIND_IN_SET(?, t.pic)
                    AND SUBSTR(t.`start_date`,1,7) = ?
                    AND t.week = ?";

        $query = $this->db->query($sql, array($employee_id, $periode, $week));
        if (!$query) return "";

        $problems = [];
        foreach ($query->result() as $row) {
            if (!empty($row->problem_desc)) {
                $problems[] = "- " . $row->problem_desc;
            }
        }

        return implode("\n", $problems);
    }

    public function save_kpi_review($data)
    {
        // check if data already exists
        $this->db->where('employee_id', $data['employee_id']);
        $this->db->where('kpi_id', $data['kpi_id']);
        $this->db->where('periode', $data['periode']);
        $this->db->where('week', $data['week']);
        $query = $this->db->get('t_pm_kpi_reviews_weekly');
        if ($query->num_rows() > 0) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->where('kpi_id', $data['kpi_id']);
            $this->db->where('periode', $data['periode']);
            $this->db->where('week', $data['week']);
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $this->db->update('t_pm_kpi_reviews_weekly', $data);
        } else {
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('t_pm_kpi_reviews_weekly', $data);
        }
        return $this->db->affected_rows() > 0;
    }

    function upsert_kpi_scores($data)
    {
        // check if duplicat by employee_id, kpi_id, kpi_item_id, periode, week
        foreach ($data as $key => $value) {

            $this->db->where('employee_id', $value['employee_id']);
            $this->db->where('kpi_id', $value['kpi_id']);
            $this->db->where('kpi_item_id', $value['kpi_item_id']);
            $this->db->where('periode', $value['periode']);
            $this->db->where('week', $value['week']);

            $query = $this->db->get('t_pm_kpi_reviews_weekly_scores');

            if ($query->num_rows() > 0) {

                $this->db->where('employee_id', $value['employee_id']);
                $this->db->where('kpi_id', $value['kpi_id']);
                $this->db->where('kpi_item_id', $value['kpi_item_id']);
                $this->db->where('periode', $value['periode']);
                $this->db->where('week', $value['week']);

                $this->db->update('t_pm_kpi_reviews_weekly_scores', $value);
            } else {

                $this->db->insert('t_pm_kpi_reviews_weekly_scores', $value);
            }
        }
        return $this->db->affected_rows() > 0;
    }

    function upsert_kpi_feedback($data)
    {
        // check if duplicat by employee_id, kpi_id, periode, week
        $this->db->where('employee_id', $data['employee_id']);
        $this->db->where('kpi_id', $data['kpi_id']);
        $this->db->where('periode', $data['periode']);
        $this->db->where('week', $data['week']);
        $query = $this->db->get('t_pm_kpi_reviews_weekly_feedback');
        if ($query->num_rows() > 0) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->where('kpi_id', $data['kpi_id']);
            $this->db->where('periode', $data['periode']);
            $this->db->where('week', $data['week']);
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $this->db->update('t_pm_kpi_reviews_weekly_feedback', $data);
        } else {
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('t_pm_kpi_reviews_weekly_feedback', $data);
        }
        return $this->db->affected_rows() > 0;
    }

    function upsert_kpi_monthly($data)
    {
        // check if duplicat by employee_id, kpi_id, periode
        $this->db->where('employee_id', $data['employee_id']);
        $this->db->where('kpi_id', $data['kpi_id']);
        $this->db->where('periode', $data['periode']);
        $query = $this->db->get('t_pm_kpi_reviews_monthly');
        if ($query->num_rows() > 0) {
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->where('kpi_id', $data['kpi_id']);
            $this->db->where('periode', $data['periode']);
            $this->db->update('t_pm_kpi_reviews_monthly', $data);
        } else {
            $data['reviewed_at'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('t_pm_kpi_reviews_monthly', $data);
        }
        return $this->db->affected_rows() > 0;
    }

    function get_kpi_feedback_periode($employee_id, $kpi_id, $periode)
    {
        $this->db->select('SUM(snapshot_achievement) as snapshot_achievement, SUM(snapshot_final_score) as snapshot_final_score, AVG(rating) as rating');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('kpi_id', $kpi_id);
        $this->db->where('periode', $periode);
        $query = $this->db->get('t_pm_kpi_reviews_weekly_feedback');
        return $query->row_array();
    }

    function get_kpi_scores_periode($employee_id, $kpi_id, $periode)
    {
        $this->db->select('SUM(snapshot_kpi_met) as snapshot_kpi_met, COUNT(snapshot_kpi_met) as snapshot_kpi_count');
        $this->db->where('employee_id', $employee_id);
        $this->db->where('kpi_id', $kpi_id);
        $this->db->where('periode', $periode);
        $query = $this->db->get('t_pm_kpi_reviews_weekly_scores');
        return $query->row_array();
    }
}
