<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_main extends CI_Model
{
    protected  $PROJECT_TYPES = [
        'plan_infra',
        'plan_housing',
        'project_infra',
        'crm',
        'purchasing',
        'aftersales',
        'qc',
        'perencana'
    ];

    protected  $SALES_TYPES = [
        'booking',
        'sp3k',
        'akad',
        'drbm',
        'pemberkasan',
        'proses_bank'
    ];

    protected  $PM_HOUSING_TYPES = [
        'project_housing',
        'project_housing_komersil',
    ];

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("agentic/model_api_akad", 'model_akad');
        $this->load->model("agentic/model_api_booking", 'model_booking');
        $this->load->model("agentic/model_api_sp3k", 'model_sp3k');
        $this->load->model("agentic/model_api_purchasing", 'model_purchasing');
        $this->load->model("agentic/model_api_drbm", 'model_drbm');
        $this->load->model("agentic/model_api_proses_bank", 'model_proses_bank');
        $this->load->model("agentic/model_api_project_pm", 'model_project_pm');
    }
    public function generate_kpi_id()
    {
        $prefix = 'AC' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.1_kpi_data');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_action_plan_id()
    {
        $prefix = 'TL' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.6_timeline_tracking');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    function get_all_pic()
    {
        $query = "SELECT
            emp.user_id,
            emp.company_id,
            CONCAT(emp.first_name,' ',emp.last_name, ' | ',des.designation_name) AS nama,
            des.designation_name
            
            FROM
            xin_employees emp
            LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
            WHERE emp.is_active = 1
            AND emp.user_role_id NOT IN (1,8,9,10,11,12,13,14)
            ORDER BY first_name";
        return $this->db->query($query)->result();
    }

    function get_project()
    {
        $query = "SELECT
                pr.id_project,
                pr.project
                
                FROM
                rsp_project_live.m_project pr
                WHERE status IS NULL AND active = 1
                ";
        return $this->db->query($query)->result();
    }

    function get_all_rm_akad()
    {
        return $this->model_akad->get_all_rm();
    }

    function get_all_rm_sp3k()
    {
        return $this->model_sp3k->get_all_rm();
    }

    function get_all_pm_housing()
    {
        $query = "SELECT
  pr.pm_housing as id_user,
  CONCAT(emp.first_name,' ',emp.last_name) AS name
FROM
  rsp_project_live.m_project pr
  LEFT JOIN rsp_project_live.user pm ON pm.id_user = pr.pm_housing
  LEFT JOIN hris.xin_employees emp ON emp.user_id = pm.join_hr
WHERE
  `status` IS NULL
  AND pm_housing IS NOT NULL
  AND active = 1
GROUP BY pm_housing";
        return $this->db->query($query)->result();
    }

    public function header($tipe_agentic, $id)
    {
        if (in_array($tipe_agentic, ['plan_housing']) == true) {
            $query = "SELECT
                pr.id_project,
                pr.project,
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS name
                FROM
                rsp_project_live.m_project pr
                LEFT JOIN rsp_project_live.user pm ON pm.id_user = pr.pm_housing
                LEFT JOIN hris.xin_employees emp ON emp.user_id = pm.join_hr
                WHERE pr.id_project = $id";
            return $this->db->query($query)->row_object();
        }

        if ($tipe_agentic == 'project_housing') {
            return $this->model_project_pm->get_pm($id);
        }

        if (in_array($tipe_agentic, ['project_infra']) == true) {
            $query = "SELECT
                pr.id_project,
                pr.project,
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS name
                FROM
                rsp_project_live.m_project pr
                LEFT JOIN rsp_project_live.user pm ON pm.id_user = pr.pm_infra
                LEFT JOIN hris.xin_employees emp ON emp.user_id = pm.join_hr
                WHERE pr.id_project = $id";
            return $this->db->query($query)->row_object();
        }

        if ($tipe_agentic == 'akad') {
            return $this->model_akad->get_rm($id);
        }

        if ($tipe_agentic == 'booking') {
            return $this->model_booking->get_rm($id);
        }

        if ($tipe_agentic == 'sp3k') {
            return $this->model_sp3k->get_rm($id);
        }

        if ($tipe_agentic == 'purchasing' || $tipe_agentic == 'aftersales' || $tipe_agentic == 'qc') {
            return $this->model_purchasing->get_project($id);
        }

        if ($tipe_agentic == 'drbm') {
            return $this->model_drbm->get_rm($id);
        }
        if ($tipe_agentic == 'pemberkasan') {
            return $this->model_pemberkasan->get_rm($id);
        }

        if ($tipe_agentic == 'proses_bank') {
            return $this->model_proses_bank->get_rm($id);
        }

        if ($tipe_agentic == 'plan_infra') {
            $query = "SELECT
                pr.id_project,
                pr.project,
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS name
                FROM
                rsp_project_live.m_project pr
                LEFT JOIN rsp_project_live.user pm ON pm.id_user = pr.pm_infra
                LEFT JOIN hris.xin_employees emp ON emp.user_id = pm.join_hr
                WHERE pr.id_project = $id";
            return $this->db->query($query)->row_object();
        }

        if ($tipe_agentic == 'crm') {
            $query = "SELECT
                pr.id_project,
                pr.project,
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS name
                FROM
                rsp_project_live.m_project pr
                LEFT JOIN rsp_project_live.user pm ON pm.id_user = 554
                LEFT JOIN hris.xin_employees emp ON emp.user_id = pm.join_hr
                WHERE pr.id_project = $id";
            return $this->db->query($query)->row_object();
        }
    }

    public function data_kpi($periode, $tipe_agentic, $id)
    {
        $condition = "";

        $target_value = ($tipe_agentic == 'crm' ? 100 : "kpi.target_value");
        $actual_value = ($tipe_agentic == 'crm' ? "round(kpi.actual_value/kpi.target_value*100, 2)" : "kpi.actual_value");
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
        kpi.id,
        kpi.corporate_kpi_name,
        CASE WHEN COALESCE(kpi.unit_corporate,'') = '' || COALESCE(kpi.unit_corporate,'') = ' berkas' THEN ROUND(kpi.target_corporate) ELSE kpi.target_corporate END AS target_corporate,
        CASE WHEN COALESCE(kpi.unit_corporate,'') = '' || COALESCE(kpi.unit_corporate,'') = ' berkas' THEN ROUND(kpi.actual_corporate) ELSE kpi.actual_corporate END AS actual_corporate,
        kpi.project_id,
        COALESCE(kpi.project_name, COALESCE(gm.employee_name,'')) AS project_name,
        $target_value as target_value,
        $actual_value as actual_value,
        COALESCE(kpi.unit_corporate,'') AS unit_corporate,
        kpi.unit,
        kpi.periode,
        kpi.status,
        COALESCE(kpi.note,'') AS note,
        kpi.created_at,
        kpi.updated_at
        FROM
        agentic.1_kpi_data kpi
        LEFT JOIN rsp_project_live.user gm ON gm.id_user = kpi.id_gm
        WHERE LEFT(kpi.periode,7) = '$periode'
        $condition
            ";
        return $this->db->query($query)->result();
    }

    public function data_kesehatan_kpi($periode, $tipe_agentic, $id)
    {
        $condition = "";
        $target_value = ($tipe_agentic == 'crm' ? "if(hel.indicator_name = 'CRM Rating',100,hel.target_value)" : "hel.target_value");
        $actual_value = ($tipe_agentic == 'crm' ? "if(hel.indicator_name = 'CRM Rating',round(hel.actual_value/hel.target_value*100, 2),hel.actual_value)" : "hel.actual_value");
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
            hel.id,
            hel.kpi_id,
            hel.indicator_name,
            hel.condition_rule,
            $target_value as target_value,
            $actual_value as actual_value,
            hel.unit,
            hel.`status`,
            hel.created_at,
            COALESCE(hel.note,'') AS note
            FROM
            agentic.2_kpi_health hel
            LEFT JOIN agentic.1_kpi_data kpi ON kpi.id = hel.kpi_id
   WHERE LEFT(kpi.periode,7) = '$periode'
   $condition";
        return $this->db->query($query)->result();
    }

    public function data_analisa_sistem($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
            sis.id,
            sis.kpi_id,
            sis.issue_text,
            sis.severity,
            sis.created_at
            FROM
            agentic.3_system_analysis sis
            LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =sis.kpi_id
            WHERE LEFT(kpi.periode,7) = '$periode'
            $condition";
        return $this->db->query($query)->result();
    }

    public function data_governance_leadership($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                gov.id,
                gov.kpi_id,
                gov.check_item,
                gov.status_desc,
                gov.priority,
                gov.created_at
                FROM
                agentic.4_governance_check gov
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =gov.kpi_id
                    WHERE LEFT(kpi.periode,7) = '$periode'
                    $condition";
        return $this->db->query($query)->result();
    }

    public function data_4_analisa($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                fm.id,
                fm.kpi_id,
                fm.category,
                fm.action_text,
                fm.created_at
                FROM
                agentic.5_four_m_analysis fm
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =fm.kpi_id
                            WHERE LEFT(kpi.periode,7) = '$periode'
                            $condition";
        return $this->db->query($query)->result();
    }

    public function data_timeline($periode, $tipe_agentic, $id, $week, $status_plan)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $conditioner2 = "";

        if (!empty($week) && !empty($status_plan)) {
                $conditioner2 = "WHERE x.wk = '$week' AND x.status_plan = '$status_plan'";
        } else if (!empty($week)) {
                $conditioner2 = "WHERE x.wk = '$week'";
        } else if (!empty($status_plan)) {
                $conditioner2 = "WHERE x.status_plan = '$status_plan'";
        } else {
                $conditioner2 = "";
        }

        $query = "SELECT
                    x.id,
                    x.kpi_id,
                    x.description,
                    x.`owner`,
                    x.due_date,
                    x.status_plan,
                    x.status,
                    x.status_actual,
                    x.status_color,
                    x.tambahan_info,
                    x.pic,
                    x.notes,
                    x.created_at,
                    x.wk,
                    x.id_task,
                    x.id_sub_task,
                    x.by,
                    x.rm,
                    x.reason
                FROM
                    (
                        SELECT
                            tm.id,
                            tm.kpi_id,
                            tm.description,
                            tm.`owner` AS owner_asli,
                            tm.due_date,
                            tm.status_plan,
                            task.status,
                            s.status AS status_actual,
                            REPLACE(s.label, 'outline-', '') AS status_color,
                            tm.tambahan_info,
                            GROUP_CONCAT(DISTINCT CONCAT(pic.first_name,' ',pic.last_name)) AS pic,
                            tm.notes,
                            tm.created_at,
                            WEEK(tm.created_at, 1) - WEEK(DATE_SUB(tm.created_at, INTERVAL DAY(tm.created_at)-1 DAY), 1) + 1 AS wk,
                            tm.id_task,
                            sub.id_sub_task,
                            COALESCE(GROUP_CONCAT(DISTINCT dep.department_name),'') AS `owner`,
                            tm.by,
                            CASE 
                                WHEN tm.reason IS NOT NULL THEN tm.reason
                            ELSE ''
                            END AS reason,
                            CASE 
                                WHEN kpi.id_gm IS NOT NULL THEN CONCAT(rm.first_name,' ',rm.last_name)
                            ELSE ''
                            END AS rm_nama,
                            CASE 
                                WHEN kpi.id_gm IS NOT NULL THEN CONCAT(us.employee_name)
                            ELSE ''
                            END AS rm
                        
                        FROM agentic.6_timeline_tracking tm
                        LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =tm.kpi_id
                        LEFT JOIN td_sub_task sub ON sub.id_task = tm.id_task
                        LEFT JOIN td_task task ON tm.id_task = task.id_task
                        LEFT JOIN td_status s ON s.id = task.`status`
                        LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id,task.pic)
                        LEFT JOIN xin_departments dep ON dep.department_id = pic.department_id
                        LEFT JOIN rsp_project_live.`user` AS us ON us.id_user = kpi.id_gm
                        LEFT JOIN hris.xin_employees AS rm ON rm.user_id = us.id_hr

                        WHERE LEFT(kpi.periode,7) = '$periode'
                        $condition
                        GROUP BY tm.id
                    ) AS x
                $conditioner2
                ";

        return $this->db->query($query)->result();

    }

    public function data_week($periode)
    {

        $query = "SELECT
                    DISTINCT(x.wk) AS wk
                FROM
                    (
                        SELECT
                        tm.id,
                        tm.kpi_id,
                        tm.description,
                        tm.created_at,
                        WEEK(tm.created_at, 1) - WEEK(DATE_SUB(tm.created_at, INTERVAL DAY(tm.created_at)-1 DAY), 1) + 1 AS wk
                        
                        FROM agentic.6_timeline_tracking tm
                        LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =tm.kpi_id
                        WHERE LEFT(kpi.periode,7) = '$periode'
                        GROUP BY tm.id
                    ) AS x
                ";

        return $this->db->query($query)->result();

    }
    

    public function data_rule($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                    rul.id,
                    rul.kpi_id,
                    rul.rule_text,
                    rul.rules,
                    CASE 
                        WHEN rul.rules = 'surat_teguran' THEN 'ST'
                        WHEN rul.rules = 'lock_absen' THEN 'Lock Absen'
                        WHEN rul.rules = 'denda' THEN 'Denda'
                    ELSE ''
                    END AS kategori,
                    COALESCE(rul.status_plan,'Waiting') AS status_plan,
                    rul.created_at,
                    rul.nominal
                    FROM
                        agentic.7_rules_consequence rul
                    LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =rul.kpi_id
                    WHERE LEFT(kpi.periode,7) = '$periode'
                    $condition";
        return $this->db->query($query)->result();
    }

    public function data_reward($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                rew.id,
                rew.kpi_id,
                rew.reward_text,
                rew.status,
                rew.created_at,
                COALESCE(rew.status_plan,'Waiting') AS status_plan,
                rew.nominal
                FROM
                agentic.8_reward rew
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =rew.kpi_id
                            WHERE LEFT(kpi.periode,7) = '$periode'
                            $condition";
        return $this->db->query($query)->result();
    }
    public function data_teknologi($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                tec.id,
                tec.kpi_id,
                tec.description,
                tec.created_at
                FROM
                agentic.9_tech_ccp_accountability tec
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =tec.kpi_id
            WHERE LEFT(kpi.periode,7) = '$periode'
            $condition";
        return $this->db->query($query)->result();
    }

    public function data_summary_kpi($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                sum.id,
                sum.kpi_id,
                sum.status_kpi,
                sum.status_value,
                sum.status_note,
                sum.created_at
                FROM
                agentic.`10_executive_summary` sum
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id =sum.kpi_id
            WHERE LEFT(kpi.periode,7) = '$periode'
            $condition
                ";
        return $this->db->query($query)->result();
    }

    public function data_summary_risk($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                rs.id,
                sum.kpi_id,
                rs.summary_id,
                rs.risk_description,
                rs.created_at
                FROM
                agentic.11_executive_risks rs
                LEFT JOIN agentic.10_executive_summary sum ON sum.id = rs.summary_id
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id = sum.kpi_id
                WHERE LEFT(kpi.periode,7) = '$periode'
                $condition
   ";
        return $this->db->query($query)->result();
    }

    public function data_summary_focus($periode, $tipe_agentic, $id)
    {
        $condition = "";
        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            $condition = " AND kpi.project_id = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $condition = " AND kpi.id_gm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        if (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $condition = " AND kpi.id_pm = '$id' AND kpi.type_agentic = '$tipe_agentic' ";
        }

        $query = "SELECT
                fc.id,
                fc.summary_id,
                fc.focus_description,
                fc.created_at
                FROM
                agentic.`12_executive_focus` fc
                LEFT JOIN agentic.10_executive_summary sum ON sum.id = fc.summary_id
                LEFT JOIN agentic.1_kpi_data kpi ON kpi.id = sum.kpi_id
                WHERE
                LEFT(kpi.periode,7) = '$periode'
                $condition";
        return $this->db->query($query)->result();
    }

    public function cron_kpi_leadtime_housing($periode, $id_pm)
    {

        $query = "SELECT
            CURDATE() AS tgl,
            LEFT(CURDATE(),7) AS periode,
            'Lead Time Pekerjaan Housing' AS nama,
            'Pembangunan housing on time' AS goal,
            COUNT(unit.blok) AS target,
            COUNT(
                IF(
                    DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir, INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)),
                    1,
                    NULL
                )
            ) AS actual,
            95 AS target_achieve,
            ROUND(
                COUNT(
                    IF(
                        DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir, INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)),
                        1,
                        NULL
                    )
                ) / COUNT(unit.blok) * 100,
                0
            ) AS achieve,
            
            project.id_project,
            project.project,
            project.achieve AS achieve_project
            FROM
            rsp_project_live.m_project_unit unit
            LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON spk_detail.id_project = unit.id_project
            AND spk_detail.blok = unit.blok
            LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = unit.id_project
            LEFT JOIN rsp_project_live.t_project_bangun spk ON spk_detail.id_rencana = spk.id_rencana
            JOIN rsp_project_live.m_standar_rumah AS standar ON standar.id = spk.standar
            LEFT JOIN (
                SELECT
                    t_peringatan_vendor.status,
                    t_peringatan_vendor.id_rencana,
                    t_peringatan_vendor.project,
                    m_project_unit.blok,
                    SUM(t_peringatan_vendor.tambahan_waktu) AS tambahan_waktu
                FROM
                    rsp_project_live.t_peringatan_vendor
                    JOIN rsp_project_live.m_project_unit ON (m_project_unit.id_project = t_peringatan_vendor.project AND FIND_IN_SET(m_project_unit.blok, t_peringatan_vendor.blok))
                WHERE
                    t_peringatan_vendor.`status` IN (4, 8)
                GROUP BY
                    m_project_unit.blok,
                    m_project_unit.id_project
            ) t_peringatan_vendor ON t_peringatan_vendor.project = unit.id_project
            AND t_peringatan_vendor.blok = unit.blok
            LEFT JOIN (
            SELECT
            unit.id_project,
            pr.project,
                    ROUND(
                        COUNT(
                        IF(
                            DATE(unit.tgl_pelaksana) <= COALESCE(DATE_ADD(spk_detail.tgl_spk_akhir, INTERVAL t_peringatan_vendor.tambahan_waktu DAY), DATE(spk_detail.tgl_spk_akhir)),
                            1,
                            NULL
                        )
                        ) / COUNT(unit.blok) * 100,
                        0
                    ) AS achieve
                FROM
                    rsp_project_live.m_project_unit unit
                    LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON spk_detail.id_project = unit.id_project
                    AND spk_detail.blok = unit.blok
                    LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = unit.id_project
                    LEFT JOIN rsp_project_live.t_project_bangun spk ON spk_detail.id_rencana = spk.id_rencana
                    JOIN rsp_project_live.m_standar_rumah AS standar ON standar.id = spk.standar
                    LEFT JOIN (
                        SELECT
                        t_peringatan_vendor.status,
                        t_peringatan_vendor.id_rencana,
                        t_peringatan_vendor.project,
                        m_project_unit.blok,
                        SUM(t_peringatan_vendor.tambahan_waktu) AS tambahan_waktu
                        FROM
                        rsp_project_live.t_peringatan_vendor
                        JOIN rsp_project_live.m_project_unit ON (m_project_unit.id_project = t_peringatan_vendor.project AND FIND_IN_SET(m_project_unit.blok, t_peringatan_vendor.blok))
                        WHERE
                        t_peringatan_vendor.`status` IN (4, 8)
                        GROUP BY
                        m_project_unit.blok,
                        m_project_unit.id_project
                    ) t_peringatan_vendor ON t_peringatan_vendor.project = unit.id_project
                    AND t_peringatan_vendor.blok = unit.blok
                WHERE
                    MONTH(spk_detail.tgl_spk_akhir) = MONTH(CURDATE())
                    AND YEAR(spk_detail.tgl_spk_akhir) = YEAR(CURDATE())
                    AND pr.pm_housing = $id_pm
            ) project ON 1=1
            WHERE
            MONTH(spk_detail.tgl_spk_akhir) = MONTH(CURDATE())
            AND YEAR(spk_detail.tgl_spk_akhir) = YEAR(CURDATE())";
        return $this->db->query($query)->row_object();
    }
}
