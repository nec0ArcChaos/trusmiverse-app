<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    protected $PROJECT_TYPES = [
        'plan_infra',
        'plan_housing',
        'project_infra',
        'crm',
        'purchasing',
        'aftersales',
        'qc',
        'perencana'
    ];

    protected $SALES_TYPES = [
        'booking',
        'sp3k',
        'akad',
        'drbm',
        'pemberkasan',
        'proses_bank'
    ];

    protected $PM_HOUSING_TYPES = [
        'project_housing',
        'project_housing_komersil',
    ];

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("agentic/model_main", 'model');
        $this->load->model("agentic/Model_api_crm", 'model_crm');
        $this->load->model("agentic/Model_api_pemberkasan", 'model_pemberkasan');
        $this->load->model("agentic/model_api_akad", 'model_akad');
        $this->load->model("agentic/model_api_booking", 'model_booking');
        $this->load->model("agentic/model_api_sp3k", 'model_sp3k');
        $this->load->model("agentic/model_api_purchasing", 'model_purchasing');
        $this->load->model("agentic/Model_api_drbm", 'model_drbm');
        $this->load->model("agentic/Model_api_plan_infra", 'model_plan_infra');
        $this->load->model("agentic/Model_api_plan_housing", 'model_plan_housing');
        $this->load->model("agentic/Model_api_project_infra", 'model_project_infra');
        $this->load->model("agentic/Model_api_proses_bank", 'model_proses_bank');
        $this->load->model("agentic/Model_api_aftersales", 'model_aftersales');
        $this->load->model("agentic/Model_api_qc", 'model_qc');
        $this->load->model("agentic/Model_api_perencana", 'model_perencana');
        $this->load->model("model_monday", 'monday');
        if ($this->session->userdata('user_id') != "") {
        }
        else {
            redirect('login', 'refresh');
        }
    }


    public function index($tipe_agentic)
    {
        $data['tipe_agentic'] = $tipe_agentic ?? 'project_housing';
        $data['pageTitle'] = "Dashboard Analisa Agentic AI";
        $data['css'] = "agentic/main/css";
        $data['content'] = "agentic/main/index";
        $data['js'] = "agentic/main/js";
        $data['pic'] = $this->model->get_all_pic();
        $data['tipe_agentics'] = ["project_housing", "booking", "sp3k", "purchasing", "akad", "drbm", "plan_infra", "plan_housing", "crm", "pemberkasan", "proses_bank", "aftersales", "qc", "perencana"];

        if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
            // $data['project'] = $this->model->get_project();
            $show_opsi_all = ['perencana', 'qc', 'aftersales'];
            $data_project = $this->model->get_project();
            $additional = [];
            if (in_array($tipe_agentic, $show_opsi_all)) { //menambahkan option all project
                $additional = [
                    (object)[
                        'id_project' => 'all',
                        'project' => 'All Project'
                    ]
                ];
            }
            $data['project'] = array_merge($additional, $data_project);
        }
        elseif (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
            $data['gm'] = $this->model->get_all_rm_akad();
        }
        elseif (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
            $data['pm'] = $this->model->get_all_pm_housing();
        }
        $this->load->view('layout/main_agentic', $data);
    }

    public function header()
    {
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->header($tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function load_id()
    {
        $tipe_agentic = $this->input->post('tipe_agentic');
        $periode = $this->input->post('periode');

        if ($tipe_agentic == 'crm') {
            $data = $this->model_crm->get_project_with_complaint($periode);
        }
        else {
            if (in_array($tipe_agentic, $this->PROJECT_TYPES) == true) {
                $data = $this->model->get_project();
            }
            elseif (in_array($tipe_agentic, $this->SALES_TYPES) == true) {
                $data = $this->model->get_all_rm_akad();
            }
            elseif (in_array($tipe_agentic, $this->PM_HOUSING_TYPES) == true) {
                $data['pm'] = $this->model->get_all_pm_housing();
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_kpi()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_kpi($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_kesehatan_kpi()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_kesehatan_kpi($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_analisa_sistem()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_analisa_sistem($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_governance_leadership()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_governance_leadership($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_4_analisa()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_4_analisa($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_timeline()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $week = $this->input->post('week');
        $status_plan = $this->input->post('p_status');

        $data = $this->model->data_timeline($periode, $tipe_agentic, $id, $week, $status_plan);

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_week()
    {
        $periode = $this->input->post('periode');
        $data = $this->model->data_week($periode);

        echo json_encode([
            'weeks' => [
                ['wk' => 1, 'label' => 'Week 1'],
                ['wk' => 2, 'label' => 'Week 2'],
                ['wk' => 3, 'label' => 'Week 3'],
                ['wk' => 4, 'label' => 'Week 4'],
                ['wk' => 5, 'label' => 'Week 5']
            ]
        ]);

    }


    public function data_rule()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_rule($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_reward()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_reward($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_teknologi()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = $this->model->data_teknologi($periode, $tipe_agentic, $id);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function data_summary()
    {
        $periode = $this->input->post('periode');
        $tipe_agentic = $this->input->post('tipe_agentic');
        $id = $this->input->post('id');
        $data = [
            'kpi' => $this->model->data_summary_kpi($periode, $tipe_agentic, $id),
            'risk' => $this->model->data_summary_risk($periode, $tipe_agentic, $id),
            'focus' => $this->model->data_summary_focus($periode, $tipe_agentic, $id)
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function save_task()
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $pic_arr = $this->input->post('pic');
        $pic = is_array($pic_arr) ? implode(',', $pic_arr) : '';
        $due_date = $this->input->post('due_date');
        $priority = $this->input->post('priority');
        $goal = $this->input->post('goal');
        $result = false;

        if ($action == 1) { //take
            $id_task_ibr = $this->monday->generate_id_task();
            $id_sub_task_ibr = $this->monday->generate_id_sub_task();
            $data_ibr = [
                'id_task' => $id_task_ibr,
                'type' => 1,
                'category' => 1,
                'task' => $goal . ' From Agentic AI',
                'object' => 1,
                'status' => 1,
                'progress' => 0,
                'pic' => $pic,
                'priority' => $priority,
                'due_date' => $due_date,
                'jenis_strategy' => 'Once',
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('user_id'),
            ];
            $this->db->insert('td_task', $data_ibr);

            $data_ibr_sub = [
                'id_sub_task' => $id_sub_task_ibr,
                'id_task' => $id_task_ibr,
                'sub_task' => $goal,
                'type' => 1,
                'start' => date("Y-m-d"),
                'end' => $due_date,
                'actual' => 0,
                'progress' => 0,
                'note' => 'From Agentic AI',
                'jam_notif' => '07:00',
                'created_at' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('user_id'),
            ];
            $this->db->insert('td_sub_task', $data_ibr_sub);

            $data_update = [
                'owner' => '',
                'due_date' => $due_date,
                'status_plan' => 'Take',
                'status_actual' => 'On Progres',
                'id_task' => $id_task_ibr
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.6_timeline_tracking', $data_update);
        }
        else {
            $data_update = [
                'status_plan' => 'Reject',
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.6_timeline_tracking', $data_update);
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // public function save_add_task()
    // {
    //     $kpi_id     = $this->input->post('kpi_id');
    //     $pic_arr    = $this->input->post('pic');
    //     $pic        = is_array($pic_arr) ? implode(',', $pic_arr) : '';
    //     $due_date   = $this->input->post('due_date');
    //     $priority   = $this->input->post('priority');
    //     $goal       = $this->input->post('goal');
    //     $problem    = $this->input->post('problem');
    //     $type       = $this->input->post('type');
    //     $kategori   = $this->input->post('kategori');
    //     $nominal    = $this->input->post('nominal');
    //     $rules      = $this->input->post('rules');
    //     $result     = false;

    //     $id_task_ibr = $this->monday->generate_id_task();
    //     $id_sub_task_ibr = $this->monday->generate_id_sub_task();
    //     $data_ibr = [
    //         'id_task' => $id_task_ibr,
    //         'type' => 1,
    //         'category' => 1,
    //         'task' => $goal . ' From Agentic AI',
    //         'object' => 1,
    //         'status' => 1,
    //         'progress' => 0,
    //         'pic' => $pic,
    //         'priority' => $priority,
    //         'due_date' => $due_date,
    //         'jenis_strategy' => 'Once',
    //         'created_at' => date("Y-m-d H:i:s"),
    //         'created_by' => $this->session->userdata('user_id'),
    //     ];
    //     $this->db->insert('td_task', $data_ibr);

    //     $data_ibr_sub = [
    //         'id_sub_task' => $id_sub_task_ibr,
    //         'id_task' => $id_task_ibr,
    //         'sub_task' => $goal,
    //         'type' => 1,
    //         'start' => date("Y-m-d"),
    //         'end' => $due_date,
    //         'actual' => 0,
    //         'progress' => 0,
    //         'note' => 'From Agentic AI',
    //         'jam_notif' => '07:00',
    //         'created_at' => date("Y-m-d H:i:s"),
    //         'created_by' => $this->session->userdata('user_id'),
    //     ];
    //     $this->db->insert('td_sub_task', $data_ibr_sub);

    //     if($kategori == 1){
    //         $id_analysis = $this->model->generate_kpi_action_plan_id();
    //         $insert_data_timeline_tracking = [
    //             'id' => $id_analysis,
    //             'kpi_id' => $kpi_id,
    //             'description' => $goal,
    //             'reason' => $problem,
    //             'owner' => '',
    //             'due_date' => $due_date,
    //             'status_plan' => 'Take',
    //             'status_actual' => 'On Progres',
    //             'notes' => '',
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'by' => 'Head',
    //             'id_task' => $id_task_ibr
    //         ];
    //         $result = $this->db->insert('agentic.6_timeline_tracking', $insert_data_timeline_tracking);

    //     }else if($kategori == 2){
    //             $id_analysis = $this->model->generate_kpi_rule_consequence_id();
    //             $insert_data_rule_consequence = [
    //                 'id'            => $id_analysis,
    //                 'kpi_id'        => $kpi_id,
    //                 'rule_text'     => $goal,
    //                 'rules'         => $type,
    //                 'status_plan'   => 'Waiting',
    //                 'nominal'       => isset($nominal) ? $nominal : null,
    //                 'duedate'       => isset($due_date) ? $due_date : null,
    //                 'created_at'    => date('Y-m-d H:i:s'),
    //             ];
    //             $result = $this->db->insert('agentic.7_rules_consequence', $insert_data_rule_consequence);
    //             $result = $this->db->insert('agentic.7_rules_consequence_history', $insert_data_rule_consequence);

    //     }else if($kategori == 3){
    //         $id_analysis = $this->model->generate_kpi_reward_id();
    //         $insert_data_reward = [
    //             'id'            => $id_analysis,
    //             'kpi_id'        => $kpi_id,
    //             'reward_text'   => $goal,
    //             'status_plan'   => 'Waiting',
    //             'rules'         => $rules,
    //             'nominal'       => isset($nominal) ? $nominal : null,
    //             'created_at'    => date('Y-m-d H:i:s'),
    //         ];
    //         $result = $this->db->insert('agentic.8_reward', $insert_data_reward);
    //         $result = $this->db->insert('agentic.8_reward_history', $insert_data_reward);

    //     }else if($kategori == 4){
    //         $query_tech_ccp = $this->db->query("SELECT * FROM agentic.9_tech_ccp_accountability WHERE kpi_id = '$kpi_id'");
    //         if ($query_tech_ccp->num_rows() > 0) {
    //             $data_existing_tech_ccp = $query_tech_ccp->result();
    //             // delete all existing
    //             foreach ($data_existing_tech_ccp as $row) {
    //                 $this->db->where('id', $row->id);
    //                 $this->db->delete('agentic.9_tech_ccp_accountability');
    //             }
    //             $id_analysis = $this->model->generate_kpi_tech_ccp_id();
    //             $insert_data_tech_ccp = [
    //                 'id'            => $id_analysis,
    //                 'kpi_id'        => $kpi_id,
    //                 'description'   => $goal,
    //                 'created_at'    => date('Y-m-d H:i:s'),
    //             ];
    //             $result = $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data_tech_ccp);
    //             $result = $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data_tech_ccp);
    //         } else {
    //             $id_analysis = $this->model->generate_kpi_tech_ccp_id();
    //             $insert_data_tech_ccp = [
    //                 'id'            => $id_analysis,
    //                 'kpi_id'        => $kpi_id,
    //                 'description'   => $goal,
    //                 'created_at'    => date('Y-m-d H:i:s'),
    //             ];
    //             $result = $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data_tech_ccp);
    //             $result = $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data_tech_ccp);
    //         }
    //     }

    //     header('Content-Type: application/json');
    //     // echo json_encode($result);
    //     echo json_encode([
    //         'status'    => $result,
    //         'message'   => $result ? 'Berhasil disimpan' : 'Gagal menyimpan data'
    //     ]);

    // }

    public function save_add_task()
    {

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $count_1_kpi_data = 0;
        $count_2_kpi_health = 0;
        $count_2_kpi_health_history = 0;
        $count_6_timeline_tracking = 0;
        $count_7_rules_consequence = 0;
        $count_7_rules_consequence_history = 0;
        $count_8_reward = 0;
        $count_8_reward_history = 0;
        $count_9_tech_ccp_accountability = 0;
        $count_9_tech_ccp_accountability_history = 0;

        // ===============================
        // GET INPUT
        // ===============================
        $kpi_id = $this->input->post('kpi_id');
        $pic_arr = $this->input->post('pic');
        $pic = is_array($pic_arr) ? implode(',', $pic_arr) : '';
        $due_date = $this->input->post('due_date');
        $priority = $this->input->post('priority');
        $goal = $this->input->post('goal');
        $problem = $this->input->post('problem');
        $type = $this->input->post('tipe_rule_consequence');
        $kategori = $this->input->post('kategori');
        $poin_kpi = $this->input->post('poin_kpi');
        $target_corporate = $this->input->post('target_corporate');
        $actual_corporate = $this->input->post('actual_corporate');
        $target_value = $this->input->post('target_value');
        $actual_value = $this->input->post('actual_value');
        $condition_rule = $this->input->post('target_persentase');

        $json = file_get_contents('php://input');
        // Decode ke array
        $data = json_decode($json, true);

        $id_gm = $data['id_gm'];
        $periode = $data['periode'];

        // ❗ missing variable FIX
        $nominal = $this->input->post('nominal') ?? null;
        $rules = $this->input->post('rules') ?? null;

        $result = false;

        // ===============================
        // START TRANSACTION
        // ===============================
        $this->db->trans_begin();

        // ===============================
        // GENERATE ID
        // ===============================
        $id_task_ibr = $this->monday->generate_id_task();
        $id_sub_task_ibr = $this->monday->generate_id_sub_task();

        // ===============================
        // INSERT TASK
        // ===============================
        $data_ibr = [
            'id_task' => $id_task_ibr,
            'type' => 1,
            'category' => 1,
            'task' => $goal . ' From Agentic AI',
            'object' => 1,
            'status' => 1,
            'progress' => 0,
            'pic' => $pic,
            'priority' => $priority,
            'due_date' => $due_date,
            'jenis_strategy' => 'Once',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_task', $data_ibr);

        // ===============================
        // INSERT SUB TASK
        // ===============================
        $data_ibr_sub = [
            'id_sub_task' => $id_sub_task_ibr,
            'id_task' => $id_task_ibr,
            'sub_task' => $goal,
            'type' => 1,
            'start' => date("Y-m-d"),
            'end' => $due_date,
            'actual' => 0,
            'progress' => 0,
            'note' => 'From Agentic AI',
            'jam_notif' => '07:00',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_sub_task', $data_ibr_sub);

        // $query = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'sp3k' AND id_gm = '$id_gm' AND LEFT (created_at,7) = '$periode'");
        // if ($query->num_rows() > 0) {
        //     $data_existing = $query->row_array();
        //     $id_kpi = $data_existing['id'];
        //     // Update
        //     $update_data_kpi = [
        //         'type_agentic'          => 'sp3k',
        //         'corporate_kpi_name'    => $resume['corporate_kpi'],
        //         'id_gm'                 => $id_gm,
        //         'target_corporate'      => $data['data_input']['kpi_corporate']['target'],
        //         'actual_corporate'      => $data['data_input']['kpi_corporate']['actual'],
        //         'target_value'          => $resume['sp3k']['target_persentase'],
        //         'actual_value'          => $resume['sp3k']['achieve_persentase'],
        //         'unit'                  => '%',
        //         'note'                  => $note,
        //         'periode'               => date('Y-m-d', strtotime($data['periode'] . '-01')),
        //         'updated_at'            => date('Y-m-d H:i:s'),
        //     ];
        //     $this->db->where('id', $id_kpi);
        //     $this->db->update('agentic.1_kpi_data', $update_data_kpi);
        //     $count_1_kpi_data++;
        // } else {
        $data_corporate = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE id = '$kpi_id'")->row_array();
        $id_kpi = $this->model->generate_kpi_id();
        // Insert
        $insert_data_kpi = [
            'id' => $id_kpi,
            'type_agentic' => $data_corporate['type_agentic'],
            'corporate_kpi_name' => $poin_kpi,
            'id_gm' => $pic,
            'target_corporate' => $data_corporate['target_corporate'],
            'actual_corporate' => $data_corporate['actual_corporate'],
            'target_value' => $target_value,
            'actual_value' => $actual_value,
            'unit' => '%',
            'periode' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('agentic.1_kpi_data', $insert_data_kpi);
        $count_1_kpi_data++;

        $id_kpi_health = $this->model_sp3k->generate_kpi_health_id();
        if ($actual_value >= $target_value) {
            $status_kpi_health = 'good';
        }
        else if ($actual_value < $target_value && $actual_value >= ($target_value * 0.7)) {
            $status_kpi_health = 'warning';
        }
        else {
            $status_kpi_health = 'bad';
        }

        $note_rule = "(" . $target_value . " / " . $actual_value . " )";

        // Update
        $insert_data_kpi_health = [
            'id' => $id_kpi_health,
            'kpi_id' => $kpi_id,
            'indicator_name' => $poin_kpi,
            // 'condition_rule' => $condition_rule,
            'condition_rule' => 100,
            'target_value' => $target_value,
            'actual_value' => $actual_value,
            'status' => $status_kpi_health,
            'note' => $note_rule,
            'unit' => '%',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('agentic.2_kpi_health', $insert_data_kpi_health);
        $this->db->insert('agentic.2_kpi_health_history', $insert_data_kpi_health);
        $count_2_kpi_health++;
        $count_2_kpi_health_history++;

        // }

        // ===============================
        // CATEGORY HANDLING
        // ===============================
        if ($kategori == 1) {

            // === TIMELINE TRACKING
            $id_analysis = $this->model->generate_kpi_action_plan_id();

            $insert_data = [
                'id' => $id_analysis,
                'kpi_id' => $kpi_id,
                'description' => $goal,
                'reason' => $problem,
                'owner' => '',
                'due_date' => $due_date,
                'status_plan' => 'Take',
                'status_actual' => 'On Progres',
                'notes' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'by' => 'Head',
                'id_task' => $id_task_ibr
            ];

            $this->db->insert('agentic.6_timeline_tracking', $insert_data);
            $count_6_timeline_tracking++;

        }
        elseif ($kategori == 2) {

            // === RULE CONSEQUENCE
            $id_analysis = $this->model_sp3k->generate_kpi_rule_consequence_id();

            $insert_data = [
                'id' => $id_analysis,
                'kpi_id' => $kpi_id,
                'rule_text' => $goal,
                'rules' => $type,
                'status_plan' => 'Waiting',
                'nominal' => $nominal ?: null,
                'duedate' => $due_date ?: null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('agentic.7_rules_consequence', $insert_data);
            $this->db->insert('agentic.7_rules_consequence_history', $insert_data);
            $count_7_rules_consequence++;
            $count_7_rules_consequence_history++;

        }
        elseif ($kategori == 3) {

            // === REWARD
            $id_analysis = $this->model_sp3k->generate_kpi_reward_id();

            $insert_data = [
                'id' => $id_analysis,
                'kpi_id' => $kpi_id,
                'reward_text' => $goal,
                'status_plan' => 'Waiting',
                'rules' => $rules,
                'nominal' => $nominal ?: null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('agentic.8_reward', $insert_data);
            $this->db->insert('agentic.8_reward_history', $insert_data);
            $count_8_reward++;
            $count_8_reward_history++;

        }
        elseif ($kategori == 4) {

            // === TECH CCP
            $this->db->where('kpi_id', $kpi_id);
            $this->db->delete('agentic.9_tech_ccp_accountability');

            $id_analysis = $this->model_sp3k->generate_kpi_tech_ccp_id();

            $insert_data = [
                'id' => $id_analysis,
                'kpi_id' => $kpi_id,
                'description' => $goal,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data);
            $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data);
            $count_9_tech_ccp_accountability++;
            $count_9_tech_ccp_accountability_history++;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback(); // Rollback if any operation failed

            $result['status'] = 'error';
            $result['message'] = 'Data processed failed';
            header('Content-Type: application/json');
            echo json_encode($result);
        }
        else {
            $this->db->trans_commit(); // Commit if all operations succeeded

            $result['status'] = 'success';
            $result['message'] = 'Data processed successfully';
            $result['data'] = [
                '6_timeline_tracking' => $count_6_timeline_tracking,
                '7_rules_consequence' => $count_7_rules_consequence,
                '7_rules_consequence_history' => $count_7_rules_consequence_history,
                '8_reward' => $count_8_reward,
                '8_reward_history' => $count_8_reward_history,
                '9_tech_ccp_accountability' => $count_9_tech_ccp_accountability,
                '9_tech_ccp_accountability_history' => $count_9_tech_ccp_accountability_history,
            ];
            header('Content-Type: application/json');
            echo json_encode($result);
        }


    }

    public function save_add_feedback()
    {
    
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        $count_1_kpi_data = 0;
        $count_2_kpi_health = 0;
        $count_2_kpi_health_history = 0;
        $count_6_timeline_tracking = 0;
        $count_7_rules_consequence = 0;
        $count_7_rules_consequence_history = 0;
        $count_8_reward = 0;
        $count_8_reward_history = 0;
        $count_9_tech_ccp_accountability = 0;
        $count_9_tech_ccp_accountability_history = 0;
    
        // ===============================
        // GET INPUT
        // ===============================
        $kpi_id          = $this->input->post('kpi_id');
        $pic_arr         = $this->input->post('pic');
        $pic             = is_array($pic_arr) ? implode(',', $pic_arr) : '';
        $due_date        = $this->input->post('due_date');
        $priority        = $this->input->post('priority');
        $goal            = $this->input->post('goal');
        $problem         = $this->input->post('problem');
        $type            = $this->input->post('tipe_rule_consequence');
        $kategori        = $this->input->post('kategori');
        $poin_kpi        = $this->input->post('poin_kpi');
        $target_value    = $this->input->post('target_value');
        $actual_value    = $this->input->post('actual_value');
        $condition_rule  = $this->input->post('target_persentase');
        $nominal         = $this->input->post('nominal') ?? null;
        $rules           = $this->input->post('rules')   ?? null;
    
        $json   = file_get_contents('php://input');
        $data   = json_decode($json, true);
        $id_gm  = $data['id_gm']  ?? null;
        $periode = $data['periode'] ?? null;
    
        $result = false;
    
        // ===============================
        // START TRANSACTION
        // ===============================
        $this->db->trans_begin();
    
        // ===============================
        // GENERATE ID
        // ===============================
        $id_task_ibr     = $this->monday->generate_id_task();
        $id_sub_task_ibr = $this->monday->generate_id_sub_task();
    
        // ===============================
        // INSERT TASK
        // ===============================
        $data_ibr = [
            'id_task'        => $id_task_ibr,
            'type'           => 1,
            'category'       => 1,
            'task'           => $goal . ' From Dashboard Sales',
            'object'         => 1,
            'status'         => 1,
            'progress'       => 0,
            'pic'            => $pic,
            'priority'       => $priority,
            'due_date'       => $due_date,
            'jenis_strategy' => 'Once',
            'created_at'     => date("Y-m-d H:i:s"),
            'created_by'     => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_task', $data_ibr);
    
        // ===============================
        // INSERT SUB TASK
        // ===============================
        $data_ibr_sub = [
            'id_sub_task' => $id_sub_task_ibr,
            'id_task'     => $id_task_ibr,
            'sub_task'    => $goal,
            'day_per_week' => 0,
            'type'        => 1,
            'start'       => date("Y-m-d"),
            'end'         => $due_date,
            'actual'      => 0,
            'progress'    => 0,
            'note'        => 'From Dashboard Sales',
            'jam_notif'   => '07:00',
            'created_at'  => date("Y-m-d H:i:s"),
            'created_by'  => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_sub_task', $data_ibr_sub);
    
        // ===============================
        // INSERT 1_KPI_DATA
        // ===============================
        $data_corporate = $this->db->query(
            "SELECT * FROM agentic.1_kpi_data WHERE id = '" . $this->db->escape_str($kpi_id) . "'"
        )->row_array();
    
        $id_kpi = $this->model->generate_kpi_id();
    
        // ── RESOLVE id_gm dari PIC ──────────────────────────────────────────────
        // PIC dipilih dari xin_employees (user_id).
        // Query: xin_employees  →  LEFT JOIN rsp_project_live.user ON user.id_hr = xin_employees.user_id
        // Ambil kolom id_gm dari tabel user.
        // Gunakan pic pertama yang dipilih sebagai acuan GM.
        $id_gm_resolved   = null;
        $first_pic_uid    = is_array($pic_arr) ? ($pic_arr[0] ?? null) : null;
    
        if ($first_pic_uid) {
            $gm_row = $this->db->query("
                SELECT u.id_gm
                FROM hris.xin_employees e
                LEFT JOIN rsp_project_live.`user` u ON u.id_hr = e.user_id
                WHERE e.user_id = '" . $this->db->escape_str($first_pic_uid) . "'
                LIMIT 1
            ")->row_array();
    
            $id_gm_resolved = $gm_row['id_gm'] ?? null;
        }
        // ────────────────────────────────────────────────────────────────────────
    
        $insert_data_kpi = [
            'id'                 => $id_kpi,
            'type_agentic'       => $data_corporate['type_agentic'],
            'corporate_kpi_name' => $poin_kpi,
            'id_gm'              => $id_gm_resolved,          // ← hasil lookup, bukan $pic
            'target_corporate'   => $data_corporate['target_corporate'],
            'actual_corporate'   => $data_corporate['actual_corporate'],
            'target_value'       => $target_value,
            'actual_value'       => $actual_value,
            'unit'               => '%',
            'periode'            => date('Y-m-d H:i:s'),
            'created_at'         => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('agentic.1_kpi_data', $insert_data_kpi);
        $count_1_kpi_data++;
    
        // ===============================
        // INSERT 2_KPI_HEALTH
        // ===============================
        $id_kpi_health = $this->model_sp3k->generate_kpi_health_id();
    
        if ($actual_value >= $target_value) {
            $status_kpi_health = 'good';
        } elseif ($actual_value < $target_value && $actual_value >= ($target_value * 0.7)) {
            $status_kpi_health = 'warning';
        } else {
            $status_kpi_health = 'bad';
        }
    
        $note_rule = "(" . $target_value . " / " . $actual_value . " )";
    
        $insert_data_kpi_health = [
            'id'             => $id_kpi_health,
            'kpi_id'         => $id_kpi,
            'indicator_name' => $poin_kpi,
            'condition_rule' => 100,
            'target_value'   => $target_value,
            'actual_value'   => $actual_value,
            'status'         => $status_kpi_health,
            'note'           => $note_rule,
            'unit'           => '%',
            'created_at'     => date('Y-m-d H:i:s'),
        ];
    
        $this->db->insert('agentic.2_kpi_health', $insert_data_kpi_health);
        $this->db->insert('agentic.2_kpi_health_history', $insert_data_kpi_health);
        $count_2_kpi_health++;
        $count_2_kpi_health_history++;
    
        // ===============================
        // CATEGORY HANDLING
        // ===============================
        if ($kategori == 1) {
    
            $id_analysis = $this->model->generate_kpi_action_plan_id();
            $insert_data = [
                'id'            => $id_analysis,
                'kpi_id'        => $id_kpi,
                'description'   => $goal,
                'reason'        => $problem,
                'owner'         => '',
                'due_date'      => $due_date,
                'status_plan'   => 'Take',
                'status_actual' => 'On Progres',
                'notes'         => '',
                'created_at'    => date('Y-m-d H:i:s'),
                'by'            => 'Head',
                'id_task'       => $id_task_ibr,
            ];
            $this->db->insert('agentic.6_timeline_tracking', $insert_data);
            $count_6_timeline_tracking++;
    
        } elseif ($kategori == 2) {
    
            $id_analysis = $this->model_sp3k->generate_kpi_rule_consequence_id();
            $insert_data = [
                'id'          => $id_analysis,
                'kpi_id'      => $id_kpi,
                'rule_text'   => $goal,
                'rules'       => $type,
                'status_plan' => 'Waiting',
                'nominal'     => $nominal ?: null,
                'duedate'     => $due_date ?: null,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.7_rules_consequence', $insert_data);
            $this->db->insert('agentic.7_rules_consequence_history', $insert_data);
            $count_7_rules_consequence++;
            $count_7_rules_consequence_history++;
    
        } elseif ($kategori == 3) {
    
            $id_analysis = $this->model_sp3k->generate_kpi_reward_id();
            $insert_data = [
                'id'          => $id_analysis,
                'kpi_id'      => $id_kpi,
                'reward_text' => $goal,
                'status_plan' => 'Waiting',
                'rules'       => $rules,
                'nominal'     => $nominal ?: null,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.8_reward', $insert_data);
            $this->db->insert('agentic.8_reward_history', $insert_data);
            $count_8_reward++;
            $count_8_reward_history++;
    
        } elseif ($kategori == 4) {
    
            $this->db->where('kpi_id', $kpi_id);
            $this->db->delete('agentic.9_tech_ccp_accountability');
    
            $id_analysis = $this->model_sp3k->generate_kpi_tech_ccp_id();
            $insert_data = [
                'id'          => $id_analysis,
                'kpi_id'      => $id_kpi,
                'description' => $goal,
                'created_at'  => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data);
            $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data);
            $count_9_tech_ccp_accountability++;
            $count_9_tech_ccp_accountability_history++;
        }
    
        // ===============================
        // COMMIT / ROLLBACK
        // ===============================
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
    
            $result['status']  = 'error';
            $result['message'] = 'Data processed failed';
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            $this->db->trans_commit();
    
            $result['status']  = 'success';
            $result['message'] = 'Data processed successfully';
            $result['data']    = [
                '6_timeline_tracking'              => $count_6_timeline_tracking,
                '7_rules_consequence'              => $count_7_rules_consequence,
                '7_rules_consequence_history'      => $count_7_rules_consequence_history,
                '8_reward'                         => $count_8_reward,
                '8_reward_history'                 => $count_8_reward_history,
                '9_tech_ccp_accountability'        => $count_9_tech_ccp_accountability,
                '9_tech_ccp_accountability_history' => $count_9_tech_ccp_accountability_history,
            ];
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }


    public function save_add_task_sales()
    {
        $kpi_id = $this->model->generate_kpi_id();
        $pic_arr = $this->input->post('pic');
        $pic = is_array($pic_arr) ? implode(',', $pic_arr) : '';
        $due_date = $this->input->post('due_date');
        $priority = $this->input->post('priority');
        $goal = $this->input->post('goal');
        $result = false;

        $id_task_ibr = $this->monday->generate_id_task();
        $id_sub_task_ibr = $this->monday->generate_id_sub_task();
        $data_ibr = [
            'id_task' => $id_task_ibr,
            'type' => 1,
            'category' => 1,
            'task' => $goal . ' From Agentic AI',
            'object' => 1,
            'status' => 1,
            'progress' => 0,
            'pic' => $pic,
            'priority' => $priority,
            'due_date' => $due_date,
            'jenis_strategy' => 'Once',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_task', $data_ibr);

        $data_ibr_sub = [
            'id_sub_task' => $id_sub_task_ibr,
            'id_task' => $id_task_ibr,
            'sub_task' => $goal,
            'type' => 1,
            'start' => date("Y-m-d"),
            'end' => $due_date,
            'actual' => 0,
            'progress' => 0,
            'note' => 'From Agentic AI',
            'jam_notif' => '07:00',
            'created_at' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('td_sub_task', $data_ibr_sub);

        $id_analysis = $this->model->generate_kpi_action_plan_id();
        $insert_data_timeline_tracking = [
            'id' => $id_analysis,
            'kpi_id' => $kpi_id,
            'description' => $goal,
            'owner' => '',
            'due_date' => $due_date,
            'status_plan' => 'Take',
            'status_actual' => 'On Progres',
            'notes' => '',
            'created_at' => date('Y-m-d H:i:s'),
            'by' => 'Head',
            'id_task' => $id_task_ibr
        ];
        $result = $this->db->insert('agentic.6_timeline_tracking', $insert_data_timeline_tracking);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function save_denda_reward()
    {
        $employee = $this->input->post('employee');
        $nominal = $this->input->post('nominal');
        $id = $this->input->post('id');
        $tipe = $this->input->post('tipe');
        $user_locked = $this->session->userdata('nama');
        $deskripsi = $this->input->post('deskripsi');
        $action = $this->input->post('action');
        if ($action == 1) { //take
            $inserted_ids = [];
            foreach ($employee as $value) {
                $data = [
                    'employee_id' => $value,
                    'nominal' => $nominal,
                    'keterangan' => $deskripsi . ' by ' . $user_locked,
                    'periode' => date('Y-m'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id'),
                    'tipe' => $tipe
                ];
                $this->db->insert('trusmi_denda', $data);
                $inserted_ids[] = $this->db->insert_id();
            }
            $id_referensi_string = implode(',', $inserted_ids);
            $data_update = [
                'status_plan' => 'Take',
                'id_referensi' => $id_referensi_string
            ];
            $this->db->where('id', $id);
            if ($tipe == 'Denda') {
                $result = $this->db->update('agentic.7_rules_consequence', $data_update);
            }
            else {
                $result = $this->db->update('agentic.8_reward', $data_update);
            }
        }
        else {
            $data_update = [
                'status_plan' => 'Reject',
            ];
            $this->db->where('id', $id);
            if ($tipe == 'Denda') {
                $result = $this->db->update('agentic.7_rules_consequence', $data_update);
            }
            else {
                $result = $this->db->update('agentic.8_reward', $data_update);
            }
        }
        echo json_encode($result);
    }

    public function save_warning()
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $employee = $this->input->post('employee');
        $company_id = $this->input->post('company_id');
        $warning_date = $this->input->post('warning_date');
        $warning_type = $this->input->post('warning_type');
        $subject = $this->input->post('subject');
        $result_investigation = $this->input->post('result_investigation');
        $corrective = $this->input->post('corrective');
        $another_note = $this->input->post('another_note');
        if ($action == 1) {
            $inserted_ids = [];
            $data = [
                'company_id' => $company_id,
                'warning_to' => $employee,
                'warning_by' => $this->session->userdata('user_id'),
                'warning_date' => $warning_date,
                'warning_type_id' => $warning_type,
                'tindakan_perbaikan' => $corrective,
                'hasil_investigasi' => $result_investigation,
                'catatan_lain' => $another_note,
                'subject' => $subject,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('xin_employee_warnings', $data);
            $id_referensi_string = implode(',', $inserted_ids);
            $data_update = [
                'status_plan' => 'Take',
                'id_referensi' => $id_referensi_string
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.7_rules_consequence', $data_update);
        }
        else {
            $data_update = [
                'status_plan' => 'Reject',
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.7_rules_consequence', $data_update);
        }
        echo json_encode($result);
    }
    public function save_lock()
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $employee = $this->input->post('employee');
        $reason = $this->input->post('reason');
        $user_locked = $this->session->userdata('nama');

        if ($action == 1) {
            $inserted_ids = [];
            foreach ($employee as $value) {
                $data = array(
                    "type_lock" => 'other',
                    "employee_id" => $value,
                    "alasan_lock" => $reason . " - By " . $user_locked,
                    "status" => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    "created_by" => $this->session->userdata('user_id')
                );

                $this->db->insert("trusmi_lock_absen_manual", $data);
                $inserted_ids[] = $this->db->insert_id();
            }
            $id_referensi_string = implode(',', $inserted_ids);
            $data_update = [
                'status_plan' => 'Take',
                'id_referensi' => $id_referensi_string
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.7_rules_consequence', $data_update);
        }
        else {
            $data_update = [
                'status_plan' => 'Reject',
            ];
            $this->db->where('id', $id);
            $result = $this->db->update('agentic.7_rules_consequence', $data_update);
        }
        echo json_encode($result);
    }

    public function cron_kpi()
    {
        $periode = $this->input->post('periode') ?? date('Y-m');
        $id = $this->input->post('id') ?? 42;
        $type_agentic = $this->input->post('tipe_agentic') ?? 'project_housing';


        if ($type_agentic == 'project_infra') {
            $start_date = date('Y-m-01', strtotime($periode));
            $end_date = date('Y-m-t', strtotime($periode));
            $check_spk = $this->model_project_infra->check_spk($id, $start_date, $end_date);

            if ($check_spk > 0) {
                $data_post = [
                    "periode" => $periode,
                    "id" => $id,
                    "type_agentic" => "project_infra"
                ];

                $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
                curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'x-api-key: n8nAgenticProject$123'
                ));
                $response = curl_exec($ch);
                curl_close($ch);

                echo json_encode(true);
                return;
            }

            echo json_encode(false);
            return;
        }

        if ($type_agentic == 'proses_bank') {
            $start_date = date('Y-m-01', strtotime($periode));
            $end_date = date('Y-m-t', strtotime($periode));
            $check_berkas = $this->model_proses_bank->get_leadtime($id, $periode);

            if (count($check_berkas) > 0) {
                $data_post = [
                    "periode" => $periode,
                    "id" => $id,
                    "type_agentic" => "proses_bank"
                ];

                $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
                curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'x-api-key: n8nAgenticProject$123'
                ));
                $response = curl_exec($ch);
                curl_close($ch);

                echo json_encode(true);
                return;
            }

            echo json_encode(false);
            return;
        }


        if ($type_agentic == 'project_housing' || $type_agentic == 'project_housing_komersil') {

            $data = $this->model->cron_kpi_leadtime_housing($periode, $id);
            // print_r($data);die();
            if (empty($data->id_project)) {
                echo json_encode(false);
                return;
            }
            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'project_housing' AND LEFT(periode,7) = LEFT('$data->tgl',7) AND project_id = '$data->id_project'")->result();
            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'project_housing' AND LEFT(periode,7) = LEFT('$data->tgl',7) AND id_pm = '$id'")->result();
            // $data_update = [
            //     'periode' => $data->tgl,
            //     'type_agentic' => 'project_housing',
            //     'corporate_kpi_name' => $data->nama,
            //     'target_corporate' => $data->target_achieve,
            //     'actual_corporate' => $data->achieve,
            //     // 'project_id' => $data->id_project,
            //     'id_pm' => $id,
            //     'project_name' => $data->project,
            //     'target_value' => $data->target_achieve,
            //     'actual_value' => $data->achieve_project,
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'project_housing');
            //     $this->db->where('LEFT(periode, 7) =', $data->periode);
            //     // $this->db->where('project_id', $data->id_project);
            //     $this->db->where('id_pm', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            if ($type_agentic == 'project_housing') {
                $project_tipe = 'subsidi';
            }
            else {
                $project_tipe = 'komersil';
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "project_housing",
                "project_tipe" => $project_tipe
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'sp3k') {
            $kpi_corporate = $this->model_sp3k->kpi_corporate($periode);
            $kpi_rm = $this->model_sp3k->kpi_rm($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'sp3k' AND LEFT(periode,7) = LEFT('$periode',7) AND id_gm = '$id'")->result();
            $data_update = [
                'periode' => $periode,
                'type_agentic' => 'sp3k',
                'corporate_kpi_name' => $kpi_corporate['goal'],
                'target_corporate' => $kpi_corporate['target_persentase'],
                'actual_corporate' => $kpi_corporate['achieve_persentase'],
                'id_gm' => $id,
                'target_value' => $kpi_rm['target_persentase'],
                'actual_value' => $kpi_rm['achieve_persentase'],
                'unit' => '%',
            ];
            if (count($data_agentic) > 0) { // jika sudah ada update
                $data_update['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where('type_agentic', 'sp3k');
                $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
                $this->db->where('id_gm', $id);
                $this->db->update('agentic.1_kpi_data', $data_update);
            }
            else {
                $data_update['id'] = $this->model->generate_kpi_id();
                $data_update['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('agentic.1_kpi_data', $data_update);
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "sp3k"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'purchasing') {
            $kpi_corporate = $this->model_purchasing->kpi_corporate($periode);
            $kpi_project = $this->model_purchasing->kpi_project($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'purchasing' AND LEFT(periode,7) = LEFT('$periode',7) AND id_gm = '$id'")->result();
            $data_update = [
                'periode' => $periode,
                'type_agentic' => 'purchasing',
                'corporate_kpi_name' => $kpi_corporate['goal'],
                'target_corporate' => $kpi_corporate['target_persentase'],
                'actual_corporate' => $kpi_corporate['achieve_persentase'],
                'id_gm' => $id,
                'target_value' => $kpi_project['target_persentase'],
                'actual_value' => $kpi_project['achieve_persentase'],
                'unit' => '%',
            ];
            if (count($data_agentic) > 0) { // jika sudah ada update
                $data_update['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where('type_agentic', 'purchasing');
                $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
                $this->db->where('id_gm', $id);
                $this->db->update('agentic.1_kpi_data', $data_update);
            }
            else {
                $data_update['id'] = $this->model->generate_kpi_id();
                $data_update['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('agentic.1_kpi_data', $data_update);
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "purchasing"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'akad') {
            $kpi_corporate = $this->model_akad->kpi_corporate($periode);
            $kpi_rm = $this->model_akad->kpi_rm($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'akad' AND LEFT(periode,7) = LEFT('$periode',7) AND id_gm = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'akad',
            //     'corporate_kpi_name' => $kpi_corporate['goal'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'id_gm' => $id,
            //     'target_value' => $kpi_rm['target_persentase'],
            //     'actual_value' => $kpi_rm['achieve_persentase'],
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'akad');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('id_gm', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "akad"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'booking') {
            $kpi_corporate = $this->model_booking->kpi_corporate($periode);
            $kpi_rm = $this->model_booking->kpi_rm($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'booking' AND LEFT(periode,7) = LEFT('$periode',7) AND id_gm = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'booking',
            //     'corporate_kpi_name' => $kpi_corporate['goal'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'id_gm' => $id,
            //     'target_value' => $kpi_rm['target_persentase'],
            //     'actual_value' => $kpi_rm['achieve_persentase'],
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'booking');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('id_gm', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "booking"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'pemberkasan') {
            $kpi_corporate = $this->model_pemberkasan->kpi_corporate($periode);
            $kpi_rm = $this->model_pemberkasan->kpi_rm($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'pemberkasan' AND LEFT(periode,7) = LEFT('$periode',7) AND id_gm = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'pemberkasan',
            //     'corporate_kpi_name' => $kpi_corporate['goal'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'id_gm' => $id,
            //     'target_value' => $kpi_rm['target_persentase'],
            //     'actual_value' => $kpi_rm['achieve_persentase'],
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'pemberkasan');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('id_gm', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "pemberkasan"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'drbm') {
            $kpi_corporate = $this->model_drbm->kpi_corporate($periode);
            $kpi_rm = $this->model_drbm->kpi_rm($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "drbm"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'plan_infra') {
            $kpi_corporate = $this->model_plan_infra->kpi_corporate($periode);
            $kpi_project = $this->model_plan_infra->kpi_project($id, $periode);
            $get_project = $this->model_plan_infra->get_project($id);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'plan_infra' AND LEFT(periode,7) = LEFT('$periode',7) AND project_id = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'plan_infra',
            //     'corporate_kpi_name' => $kpi_corporate['corporate_kpi'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'project_id' => $id,
            //     'project_name' => $get_project['project'],
            //     'target_value' => $kpi_project['target_persentase'],
            //     'actual_value' => $kpi_project['achieve_persentase'],
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'plan_infra');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('project_id', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "plan_infra"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }


        if ($type_agentic == 'plan_housing') {
            $kpi_corporate = $this->model_plan_housing->kpi_corporate($periode);
            $kpi_project = $this->model_plan_housing->kpi_project($id, $periode);
            $get_project = $this->model_plan_housing->get_project($id);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'plan_housing' AND LEFT(periode,7) = LEFT('$periode',7) AND project_id = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'plan_housing',
            //     'corporate_kpi_name' => $kpi_corporate['corporate_kpi'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'project_id' => $id,
            //     'project_name' => $get_project['project'],
            //     'target_value' => $kpi_project['target_persentase'],
            //     'actual_value' => $kpi_project['achieve_persentase'],
            //     'unit' => '%',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'plan_housing');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('project_id', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "plan_housing"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'crm') {
            // var_dump($type_agentic);
            $kpi_corporate = $this->model_crm->kpi_corporate($periode);
            $kpi_project = $this->model_crm->kpi_project($id, $periode);
            $get_project = $this->model_crm->get_project($id);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            // $data_agentic = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'crm' AND LEFT(periode,7) = LEFT('$periode',7) AND project_id = '$id'")->result();
            // $data_update = [
            //     'periode' => $periode,
            //     'type_agentic' => 'crm',
            //     'corporate_kpi_name' => $kpi_corporate['corporate_kpi'],
            //     'target_corporate' => $kpi_corporate['target_persentase'],
            //     'actual_corporate' => $kpi_corporate['achieve_persentase'],
            //     'project_id' => $id,
            //     'project_name' => $get_project['project'],
            //     'target_value' => $kpi_project['target_persentase'],
            //     'actual_value' => $kpi_project['achieve_persentase'],
            //     'unit' => '',
            // ];
            // if (count($data_agentic) > 0) { // jika sudah ada update
            //     $data_update['updated_at'] = date('Y-m-d H:i:s');
            //     $this->db->where('type_agentic', 'crm');
            //     $this->db->where('periode', date('Y-m-d', strtotime($periode . '-01')));
            //     $this->db->where('project_id', $id);
            //     $this->db->update('agentic.1_kpi_data', $data_update);
            // } else {
            //     $data_update['id'] = $this->model->generate_kpi_id();
            //     $data_update['created_at'] = date('Y-m-d H:i:s');
            //     $this->db->insert('agentic.1_kpi_data', $data_update);
            // }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "crm"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'aftersales') {
            if ($id == 0) {
                $id = 'all';
            }
            $kpi_corporate = $this->model_aftersales->kpi_corporate($periode);
            $kpi_rm = $this->model_aftersales->kpi_project($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "aftersales"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }

        if ($type_agentic == 'qc') {
            $kpi_corporate = $this->model_qc->kpi_corporate($periode);
            $kpi_rm = $this->model_qc->kpi_project($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "qc"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }
        if ($type_agentic == 'perencana') {
            $kpi_corporate = $this->model_perencana->kpi_corporate($periode);
            $kpi_rm = $this->model_perencana->kpi_project($id, $periode);

            if ($periode) {
                $date = DateTime::createFromFormat('Y-m-d', $periode);
                if ($date) {
                    $periode = $date->format('Y-m');
                }
            }

            $data_post = [
                "periode" => $periode,
                "id" => $id,
                "type_agentic" => "perencana"
            ];


            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook-test/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/agentic-decision-project-housing-335782d5');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_post));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'x-api-key: n8nAgenticProject$123'
            ));
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(true);
        }
    }
}
