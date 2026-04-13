<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ai_counseling extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_coaching()
    {
        $q = $this->db->query("SELECT 
                                MAX( RIGHT ( coaching.id_coaching, 4 ) ) AS kd_max 
                              FROM
                                coaching 
                              WHERE
                                DATE( coaching.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return 'CC' . date('ymd') . $kd;
    }

    function start_session($review)
    {
        $id_coaching = $this->generate_id_coaching();
        $head_id = $this->get_atasan_department()['head_id'] ?? 1;
        $data = [
            'id_coaching' => $id_coaching,
            'karyawan' => $_SESSION['user_id'],
            'tempat' => 'AI Counseling',
            'tanggal' => date('Y-m-d'),
            'review' => $review,
            'atasan' => $head_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['user_id'],
            'company_id' => $_SESSION['company_id'] ?? 0,
            'department_id' => $_SESSION['department_id'] ?? 0,
            'designation_id' => $_SESSION['designation_id'] ?? 0,
            'role_id' => $_SESSION['user_role_id'] ?? 0,
        ];
        $store = $this->db->insert('coaching', $data);
        if ($store) {
            return $id_coaching;
        }

        return false;
    }

    function detail_counselling($id_counselling)
    {
        $query = "SELECT
                              coaching.id_coaching,
                              CONCAT(kary.first_name,' ',kary.last_name) AS karyawan,
                              TIMESTAMPDIFF(YEAR,kary.date_of_birth,CURRENT_DATE) AS umur,
                              kary.gender,
                              kary.profile_picture,
                              coaching.tempat,
                                CASE
                                    WHEN TIMESTAMPDIFF(YEAR,kary.date_of_joining,CURRENT_DATE) >= 1
                                    THEN CONCAT(
                                        TIMESTAMPDIFF(YEAR,kary.date_of_joining,CURRENT_DATE), ' tahun ',
                                        MOD(TIMESTAMPDIFF(MONTH,kary.date_of_joining,CURRENT_DATE), 12), ' bulan ',
                                        TIMESTAMPDIFF(DAY,kary.date_of_joining,CURRENT_DATE) % (TIMESTAMPDIFF(MONTH,kary.date_of_joining,CURRENT_DATE) % 12 * 30), ' hari')
                                    WHEN TIMESTAMPDIFF(MONTH,kary.date_of_joining,CURRENT_DATE) % 12 >= 1
                                    THEN CONCAT(TIMESTAMPDIFF(MONTH,kary.date_of_joining,CURRENT_DATE) % 12, ' bulan')
                                    ELSE CONCAT(TIMESTAMPDIFF(DAY,kary.date_of_joining,CURRENT_DATE) % (TIMESTAMPDIFF(MONTH,kary.date_of_joining,CURRENT_DATE) % 12 * 30), ' hari')
                                END AS masa_kerja,
                              DATE_FORMAT(coaching.tanggal,'%d %b %Y') AS tanggal,
                              CONCAT(atas.first_name,' ',atas.last_name) AS atasan,
                              coaching.review,
                              coaching.goals,
                              coaching.reality,
                              coaching.option,
                              coaching.will,
                              coaching.komitmen,
                              COALESCE(coaching.foto,'') AS foto,
                              coaching.company_id,
                              comp.name AS company_name,
                              coaching.department_id,
                              dp.department_name,
                              coaching.designation_id,
                              dg.designation_name,
                              coaching.role_id,
                              role.role_name,
                              coaching.created_at,
                              CONCAT(usr.first_name,' ',usr.last_name) AS created_by,
                              coaching.status,
                              COALESCE(coaching.end_session_at,'') AS end_session_at,
                              COALESCE(coaching.review_problem,'') AS review_problem,
                              COALESCE(coaching.key_takeaways,'') AS key_takeaways,
                              COALESCE(coaching.main_issue_highlight,'') AS main_issue_highlight,
                              COALESCE(coaching.percentage_burnout,'') AS percentage_burnout,
                              COALESCE(coaching.reasoning_burnout,'') AS reasoning_burnout,
                              COALESCE(coaching.root_cause_hypothesis,'') AS root_cause_hypothesis,
                              TIMESTAMPDIFF(MINUTE,coaching.created_at,coaching.end_session_at) AS duration
                            FROM
                              coaching 
                              JOIN xin_employees AS kary ON kary.user_id = coaching.karyawan
                              JOIN xin_employees AS atas ON atas.user_id = coaching.atasan
                              JOIN xin_employees AS usr ON usr.user_id = coaching.created_by
                              LEFT JOIN xin_companies AS comp ON comp.company_id = coaching.company_id
                              LEFT JOIN xin_departments AS dp ON dp.department_id = coaching.department_id
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = coaching.designation_id
                              LEFT JOIN xin_user_roles AS role ON role.role_id = coaching.role_id
                            WHERE coaching.id_coaching = '$id_counselling'";

        return $this->db->query($query)->row_array();
    }

    function get_atasan_department()
    {
        $department_id = $_SESSION['department_id'];
        $query = $this->db->query("SELECT head_id FROM xin_departments d WHERE d.department_id = '$department_id'");
        return $query->row_array();
    }
    function get_last_activity($start, $end)
    {
        $user_id = $_SESSION['user_id'];
        $query = $this->db->query("SELECT * FROM coaching WHERE tanggal BETWEEN '$start' AND '$end' AND karyawan = '$user_id' AND tempat = 'Ai Counseling' ORDER BY tanggal,id_coaching DESC");
        return $query->result_array();
    }
    function get_sesi_konsultasi()
    {
        $user_id = $_SESSION['user_id'];
        $query = $this->db->query("SELECT coaching.*, CONCAT(xin_employees.first_name,' ',xin_employees.last_name) AS created_by_name FROM coaching
        LEFT JOIN xin_employees ON xin_employees.user_id = coaching.created_by
         WHERE karyawan = '$user_id' AND tempat = 'Ai Counseling' AND status = '0' ORDER BY tanggal,id_coaching DESC");
        return $query->result_array();
    }

    function get_kpi($periode, $user_id)
    {
        $query = "SELECT kpi.periode, kpi.tipe_kpi, kpi.user_id, kpi.nilai, kpi.persen 
                    FROM ( SELECT
                            periode,
                            'SPV' AS tipe_kpi,
                            user_id,
                            nilai,
                            persen,
                            created_at,
                            updated_at
                            FROM
                            perf_grd_supervisor 
                            WHERE
                            periode = '$periode' AND user_id = '$user_id' UNION
                            SELECT
                            periode,
                            'STAFF' AS tipe_kpi,
                            user_id,
                            nilai,
                            persen,
                            created_at,
                            updated_at
                            FROM
                            perf_grd_staff 
                            WHERE
                            periode = '$periode' AND user_id = '$user_id' UNION
                            SELECT
                            periode,
                            'MANAGER' AS tipe_kpi,
                            user_id,
                            nilai,
                            persen,
                            created_at,
                            updated_at
                            FROM
                            perf_grd_manager 
                            WHERE
                            periode = '$periode' AND user_id = '$user_id') AS kpi";
        return $this->db->query($query)->result_array();
    }

    function get_session_counselling($id_counselling)
    {
        $query = "SELECT * FROM coaching_session WHERE id_coaching = '$id_counselling'";
        return $this->db->query($query)->row_array();
    }

    function insert_session_coaching($id_counselling, $session_metadata)
    {
        // check if there is already a session
        $query = "SELECT id_coaching FROM coaching_session WHERE id_coaching = '$id_counselling'";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            // session already exists
            // update the session
            $data = [
                'session_metadata' => json_encode($session_metadata),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['user_id']
            ];
            $this->db->where('id_coaching', $id_counselling);
            $update = $this->db->update('coaching_session', $data);
            if ($update) {
                return true;
            }
            return false;
        } else {
            // session doesn't exist
            // create a new session
            $data = [
                'id_coaching' => $id_counselling,
                'session_metadata' => json_encode($session_metadata),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $_SESSION['user_id']
            ];
            $store = $this->db->insert('coaching_session', $data);
            if ($store) {
                return true;
            }
            return false;
        }
    }

    function insert_session_coaching_evaluation($id_counselling, $grow_summary, $analysis)
    {
        // check if there is already a session
        $query = "SELECT id_coaching FROM coaching_session WHERE id_coaching = '$id_counselling'";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            // session already exists
            // update the session
            $data = [
                'grow_summary' => json_encode($grow_summary),
                'analysis' => json_encode($analysis),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['user_id'] ?? 0
            ];
            $this->db->where('id_coaching', $id_counselling);
            $update = $this->db->update('coaching_session', $data);
            if ($update) {
                return true;
            }
            return false;
        } else {
            // session doesn't exist
            // create a new session
            $data = [
                'id_coaching' => $id_counselling,
                'grow_summary' => json_encode($grow_summary),
                'analysis' => json_encode($analysis),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $_SESSION['user_id'] ?? 0
            ];
            $store = $this->db->insert('coaching_session', $data);
            if ($store) {
                return true;
            }
            return false;
        }
    }
    function insert_session_coaching_advisor($id_counselling, $strategic_recommendations, $action_plan, $recommended_resources, $disclaimer)
    {
        // check if there is already a session
        $query = "SELECT id_coaching FROM coaching_session WHERE id_coaching = '$id_counselling'";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            // session already exists
            // update the session
            $data = [
                'strategic_recommendations' => json_encode($strategic_recommendations),
                'action_plan' => json_encode($action_plan),
                'recommended_resources' => json_encode($recommended_resources),
                'disclaimer' => $disclaimer,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $_SESSION['user_id'] ?? 0
            ];
            $this->db->where('id_coaching', $id_counselling);
            $update = $this->db->update('coaching_session', $data);
            if ($update) {
                return true;
            }
            return false;
        } else {
            // session doesn't exist
            // create a new session
            $data = [
                'id_coaching' => $id_counselling,
                'strategic_recommendations' => json_encode($strategic_recommendations),
                'action_plan' => json_encode($action_plan),
                'recommended_resources' => json_encode($recommended_resources),
                'disclaimer' => json_encode($disclaimer),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $_SESSION['user_id'] ?? 0
            ];
            $store = $this->db->insert('coaching_session', $data);
            if ($store) {
                return true;
            }
            return false;
        }
    }

    function insert_ai_response($data_ai_response)
    {
        $store = $this->db->insert('coaching_chat', $data_ai_response);
        if ($store) {
            return true;
        }
        return false;
    }
    function insert_conversation($message_from_user)
    {
        $store = $this->db->insert('coaching_chat', $message_from_user);
        if ($store) {
            return true;
        }
        return false;
    }

    function get_conversation($id_counselling)
    {
        $query = "SELECT * FROM coaching_chat where id_coaching = '$id_counselling' ORDER BY created_at ASC";
        return $this->db->query($query)->result_array();
    }

    function akhiri_sesi($id_counselling)
    {
        $data = [
            'status' => 1,
            'end_session_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $_SESSION['user_id']
        ];
        $this->db->where('id_coaching', $id_counselling);
        $update = $this->db->update('coaching', $data);
        if ($update) {
            return true;
        }
        return false;
    }

    function update_counselling($session_id, $data_update)
    {
        if (!$session_id) {
            return false;
        }
        $this->db->where('id_coaching', $session_id);
        $update = $this->db->update('coaching', $data_update);
        if ($update) {
            return true;
        }
        return false;
    }
}
