<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_purchasing extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("agentic/model_api_purchasing", 'model');
        $this->load->model("agentic/model_main");
    // $this->load->model("model_monday", 'monday');
    // if ($this->session->userdata('user_id') != "") {
    // } else {
    //     redirect('login', 'refresh');
    // }
    }

    function purchasing()
    {
        $api_key = $this->input->get_request_header('x-api-key', TRUE);
        if ($api_key !== 'n8nAgenticPurchasing$123') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        // Ambil raw input JSON
        $json = file_get_contents('php://input');

        // Decode ke array
        $data = json_decode($json, true);

        $id_project = $data['id_project'];
        $periode = $data['periode'];

        if ($periode) {
            $date = DateTime::createFromFormat('Y-m-d', $periode);
            if ($date) {
                $periode = $date->format('Y-m');
            }
        }

        if (!$id_project || !$periode) {
            echo json_encode(['status' => false, 'message' => 'Missing parameters']);
            return;
        }

        $kpi_project = $this->model->kpi_project($id_project, $periode);

        $response['periode'] = $periode;
        $response['project'] = $this->model->get_project($id_project);
        $response['kpi_corporate'] = $this->model->kpi_corporate($periode);
        $response['resume'] = $this->model->kpi_project($id_project, $periode);

        // $response['resume'] = [
        //     'corporate_kpi' => $kpi_project['goal'],
        //     'periode'       => $periode,
        //     'leadtime_plan' => [
        //         'jml_po'                => $kpi_project['jml_po'],
        //         'target'                => $kpi_project['target'],
        //         'actual'                => $kpi_project['jml_rjc'],
        //         'target_persentase'     => $kpi_project['target_persentase'],
        //         'achieve_persentase'    => $kpi_project['achieve_persentase'],
        //         'leadtime' => [
        //             'ontime'            => $kpi_project['jml_acc'],
        //             'persentase_ontime' => $kpi_project['p_jml_acc'],
        //             'late'              => $kpi_project['jml_rjc'],
        //             'persentase_late'   => $kpi_project['p_jml_rjc'],
        //         ],
        //     ]
        // ];

        $response['detail'] = [
            'leadtime_plan_housing' => $this->model->leadtime_plan_housing($id_project, $periode),
            'leadtime_spk_awal' => $this->model->leadtime_spk_awal($id_project, $periode),
            'leadtime_po' => $this->model->leadtime_po($id_project, $periode),
            'jumlah_reject' => $this->model->jumlah_reject($id_project, $periode)
        ];

        $response['date'] = date('Y-m-d H:i:s');

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'data' => $response]);
    }

    function update_data_agentic()
    {
        $api_key = $this->input->get_request_header('x-api-key', TRUE);
        if ($api_key !== 'n8nAgenticPurchasing$123') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        // Ambil raw input JSON
        $json = file_get_contents('php://input');

        // Decode ke array
        $data = json_decode($json, true);

        $count_1_kpi_data = 0;
        $count_2_kpi_health = 0;
        $count_2_kpi_health_history = 0;
        $count_3_system_analysis = 0;
        $count_3_system_analysis_history = 0;
        $count_4_governance_check = 0;
        $count_4_governance_check_history = 0;
        $count_5_four_m_analysis = 0;
        $count_5_four_m_analysis_history = 0;
        $count_6_timeline_tracking = 0;
        $count_7_rules_consequence = 0;
        $count_7_rules_consequence_history = 0;
        $count_8_reward = 0;
        $count_8_reward_history = 0;
        $count_9_tech_ccp_accountability = 0;
        $count_9_tech_ccp_accountability_history = 0;
        $count_10_executive_summary = 0;
        $count_10_executive_summary_history = 0;
        $count_11_executive_risks = 0;
        $count_11_executive_risks_history = 0;
        $count_12_executive_focus = 0;
        $count_12_executive_focus_history = 0;

        $resume = $data['data_input']['resume'];
        $detail = $data['data_input']['detail'];
        $analisa_sistem = $data['result']['analisa_sistem'];
        $governance_check = $data['result']['governance_check'];

        $rekomendasi_4M = ($data['result']['rekomendasi_4M']);


        $action_plan = ($data['result']['action_plan']);

        $rule_consequence = ($data['result']['rule_consequence']);
        $reward = ($data['result']['reward']);

        $tech_ccp_accountability = ($data['result']['tech_ccp_accountability']);
        $ringkasan_esklusif = ($data['result']['ringkasan_esklusif']);


        $id_project = $data['data_input']['project']['id_project'];
        $created_at = date('Y-m-d');
        // $note = "Total Project : ".$resume['actual']."/".$resume['target']."";
        $note = "Total PO : " . $resume['jml_po'] . "<br>Target : " . $resume['target'] . "%" . "<br>Jumlah Reject : " . $resume['jml_rjc'] . "";

        $this->db->trans_begin();

        // 1 KPI Data
        // Cek apakah data dengan id_project sudah ada
        // $query = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'purchasing' AND id_project = '$id_project' AND SUBSTR(created_at,1,7) = SUBSTR('$created_at',1,7)");
        $query = $this->db->query("SELECT * FROM agentic.1_kpi_data WHERE type_agentic = 'purchasing' AND project_id = '$id_project' AND LEFT (created_at,7) = '$data[periode]'");
        if ($query->num_rows() > 0) {
            $data_existing = $query->row_array();
            $id_kpi = $data_existing['id'];
            // Update
            $update_data_kpi = [
                'type_agentic' => 'purchasing',
                'corporate_kpi_name' => $resume['corporate_kpi'],
                'project_id' => $id_project,
                'project_name' => $data['data_input']['project']['project'],
                'target_corporate' => $data['data_input']['kpi_corporate']['target'],
                'actual_corporate' => $data['data_input']['kpi_corporate']['actual'],
                'target_value' => $resume['target_persentase'],
                'actual_value' => $resume['achieve_persentase'],
                'unit' => '%',
                'note' => $note,
                'periode' => date('Y-m-d', strtotime($data['periode'] . '-01')),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id', $id_kpi);
            $this->db->update('agentic.1_kpi_data', $update_data_kpi);
            $count_1_kpi_data++;
        }
        else {
            $id_kpi = $this->model->generate_kpi_id();
            // Insert
            $insert_data_kpi = [
                'id' => $id_kpi,
                'type_agentic' => 'purchasing',
                'corporate_kpi_name' => $resume['corporate_kpi'],
                'project_id' => $id_project,
                'project_name' => $data['data_input']['project']['project'],
                'target_corporate' => $data['data_input']['kpi_corporate']['target'],
                'actual_corporate' => $data['data_input']['kpi_corporate']['actual'],
                'target_value' => $resume['target_persentase'],
                'actual_value' => $resume['achieve_persentase'],
                'unit' => '%',
                'note' => $note,
                'periode' => date('Y-m-d', strtotime($data['periode'] . '-01')),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.1_kpi_data', $insert_data_kpi);
            $count_1_kpi_data++;
        }

        // 2. KPI Health
        // Cek apakah data dengan id_project sudah ada
        $query_kpi_health = $this->db->query("SELECT * FROM agentic.2_kpi_health WHERE kpi_id = '$id_kpi'");
        $indikator_name = [
            'Leadtime plan housing vs tgl spk awal',
            'Leadtime spk awal vs tgl mulai',
            'Leadtime po vs receive',
            'Jumlah reject material'

        ];
        if ($query_kpi_health->num_rows() > 0) {
            $data_existing_kpi_health = $query_kpi_health->result();
            // delete all existing
            foreach ($data_existing_kpi_health as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.2_kpi_health');
            }

            for ($i = 0; $i < COUNT($indikator_name); $i++) {
                $id_kpi_health = $this->model->generate_kpi_health_id();

                if ($indikator_name[$i] == 'Leadtime plan housing vs tgl spk awal') {
                    $target_value = $detail['leadtime_plan_housing']['target_persentase'];
                    $actual_value = $detail['leadtime_plan_housing']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_plan_housing']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_plan_housing']['jml_ontime'] . "/" . $detail['leadtime_plan_housing']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Leadtime spk awal vs tgl mulai') {
                    $target_value = $detail['leadtime_spk_awal']['target_persentase'];
                    $actual_value = $detail['leadtime_spk_awal']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_spk_awal']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_spk_awal']['jml_ontime'] . "/" . $detail['leadtime_spk_awal']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Leadtime po vs receive') {
                    $target_value = $detail['leadtime_po']['target_persentase'];
                    $actual_value = $detail['leadtime_po']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_po']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_po']['jml_ontime'] . "/" . $detail['leadtime_po']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Jumlah reject material') {
                    $target_value = $detail['jumlah_reject']['target_persentase'];
                    $actual_value = $detail['jumlah_reject']['p_jml_rjc'];
                    $condition_rule = '= ' . $detail['jumlah_reject']['target_persentase'];
                    $note_rule = "(" . $detail['jumlah_reject']['jml_rjc'] . "/" . $detail['jumlah_reject']['jml_po'] . ")";

                }


                if ($actual_value >= $target_value) {
                    $status_kpi_health = 'good';
                }
                else if ($actual_value < $target_value && $actual_value >= ($target_value * 0.7)) {
                    $status_kpi_health = 'warning';
                }
                else {
                    $status_kpi_health = 'bad';
                }

                // Update
                $insert_data_kpi_health = [
                    'id' => $id_kpi_health,
                    'kpi_id' => $id_kpi,
                    'indicator_name' => $indikator_name[$i],
                    'condition_rule' => $condition_rule,
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
            }

        }
        else {
            for ($i = 0; $i < COUNT($indikator_name); $i++) {
                $id_kpi_health = $this->model->generate_kpi_health_id();

                if ($indikator_name[$i] == 'Leadtime plan housing vs tgl spk awal') {
                    $target_value = $detail['leadtime_plan_housing']['target_persentase'];
                    $actual_value = $detail['leadtime_plan_housing']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_plan_housing']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_plan_housing']['jml_ontime'] . "/" . $detail['leadtime_plan_housing']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Leadtime spk awal vs tgl mulai') {
                    $target_value = $detail['leadtime_spk_awal']['target_persentase'];
                    $actual_value = $detail['leadtime_spk_awal']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_spk_awal']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_spk_awal']['jml_ontime'] . "/" . $detail['leadtime_spk_awal']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Leadtime po vs receive') {
                    $target_value = $detail['leadtime_po']['target_persentase'];
                    $actual_value = $detail['leadtime_po']['p_jml_ontime'];
                    $condition_rule = '=' . $detail['leadtime_po']['target_persentase'];
                    $note_rule = "(" . $detail['leadtime_po']['jml_ontime'] . "/" . $detail['leadtime_po']['jml_po'] . ")";

                }
                else if ($indikator_name[$i] == 'Jumlah reject material') {
                    $target_value = $detail['jumlah_reject']['target_persentase'];
                    $actual_value = $detail['jumlah_reject']['p_jml_rjc'];
                    $condition_rule = '= ' . $detail['jumlah_reject']['target_persentase'];
                    $note_rule = "(" . $detail['jumlah_reject']['jml_rjc'] . "/" . $detail['jumlah_reject']['jml_po'] . ")";

                }

                if ($actual_value >= $target_value) {
                    $status_kpi_health = 'good';
                }
                else if ($actual_value < $target_value && $actual_value >= ($target_value * 0.7)) {
                    $status_kpi_health = 'warning';
                }
                else {
                    $status_kpi_health = 'bad';
                }
                // Update
                $insert_data_kpi_health = [
                    'id' => $id_kpi_health,
                    'kpi_id' => $id_kpi,
                    'indicator_name' => $indikator_name[$i],
                    'condition_rule' => $condition_rule,
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
            }
        }

        // 3. System Analysis
        // Cek apakah data dengan id_project sudah ada
        $query_system_analysis = $this->db->query("SELECT * FROM agentic.3_system_analysis WHERE kpi_id = '$id_kpi'");
        if ($query_system_analysis->num_rows() > 0) {
            $data_existing_system_analysisi = $query_system_analysis->result();
            // delete all existing
            foreach ($data_existing_system_analysisi as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.3_system_analysis');
            }



            foreach ($analisa_sistem as $key => $value) {
                $analisa_sistem[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_system_analysis_id();
                $insert_data_system_analysis = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'issue_text' => $analisa_sistem[$key]['issue'],
                    'severity' => $analisa_sistem[$key]['severity'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.3_system_analysis', $insert_data_system_analysis);
                $this->db->insert('agentic.3_system_analysis_history', $insert_data_system_analysis);
                $count_3_system_analysis++;
                $count_3_system_analysis_history++;
            }
        }
        else {
            $id_analysis = $this->model->generate_kpi_system_analysis_id();
            foreach ($analisa_sistem as $key => $value) {
                $analisa_sistem[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_system_analysis_id();
                $insert_data_system_analysis = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'issue_text' => $analisa_sistem[$key]['issue'],
                    'severity' => $analisa_sistem[$key]['severity'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.3_system_analysis', $insert_data_system_analysis);
                $this->db->insert('agentic.3_system_analysis_history', $insert_data_system_analysis);
                $count_3_system_analysis++;
                $count_3_system_analysis_history++;
            }
        }

        // 4. Governance Check
        // check if data exists
        $query_governance_check = $this->db->query("SELECT * FROM agentic.4_governance_check WHERE kpi_id = '$id_kpi'");
        if ($query_governance_check->num_rows() > 0) {
            $data_existing_governance_check = $query_governance_check->result();
            // delete all existing
            foreach ($data_existing_governance_check as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.4_governance_check');
            }


            foreach ($governance_check as $key => $value) {
                $governance_check[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_governance_id();
                $insert_data_system_analysis = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'check_item' => $governance_check[$key]['aspek'],
                    'short_note' => $governance_check[$key]['catatan_singkat'],
                    'status_desc' => $governance_check[$key]['tindakan'],
                    'priority' => $governance_check[$key]['level'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.4_governance_check', $insert_data_system_analysis);
                $this->db->insert('agentic.4_governance_check_history', $insert_data_system_analysis);
                $count_4_governance_check++;
                $count_4_governance_check_history++;
            }
        }
        else {
            $id_analysis = $this->model->generate_kpi_governance_id();
            foreach ($governance_check as $key => $value) {
                $governance_check[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_governance_id();
                $insert_data_system_analysis = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'check_item' => $governance_check[$key]['aspek'],
                    'short_note' => $governance_check[$key]['catatan_singkat'],
                    'status_desc' => $governance_check[$key]['tindakan'],
                    'priority' => $governance_check[$key]['level'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.4_governance_check', $insert_data_system_analysis);
                $this->db->insert('agentic.4_governance_check_history', $insert_data_system_analysis);
                $count_4_governance_check++;
                $count_4_governance_check_history++;
            }
        }

        // 5. Recommendation 4M
        // check if data exists
        $query_rekomendasi_4M = $this->db->query("SELECT * FROM agentic.5_four_m_analysis WHERE kpi_id = '$id_kpi'");
        if ($query_rekomendasi_4M->num_rows() > 0) {
            $data_existing_rekomendasi_4M = $query_rekomendasi_4M->result();
            // delete all existing
            foreach ($data_existing_rekomendasi_4M as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.5_four_m_analysis');
            }

            foreach ($rekomendasi_4M as $key => $value) {
                $rekomendasi_4M[$key] = (array)$value;
                foreach ($rekomendasi_4M[$key] as $sub_key => $sub_value) {
                    $id_analysis = $this->model->generate_kpi_4M_id();
                    $insert_data_system_analysis = [
                        'id' => $id_analysis,
                        'kpi_id' => $id_kpi,
                        'category' => $key,
                        'action_text' => $sub_value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.5_four_m_analysis', $insert_data_system_analysis);
                    $this->db->insert('agentic.5_four_m_analysis_history', $insert_data_system_analysis);
                    $count_5_four_m_analysis++;
                    $count_5_four_m_analysis_history++;
                }
            }
        }
        else {
            $id_analysis = $this->model->generate_kpi_4M_id();
            foreach ($rekomendasi_4M as $key => $value) {
                $rekomendasi_4M[$key] = (array)$value;
                foreach ($rekomendasi_4M[$key] as $sub_key => $sub_value) {
                    $id_analysis = $this->model->generate_kpi_4M_id();
                    $insert_data_system_analysis = [
                        'id' => $id_analysis,
                        'kpi_id' => $id_kpi,
                        'category' => $key,
                        'action_text' => $sub_value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.5_four_m_analysis', $insert_data_system_analysis);
                    $this->db->insert('agentic.5_four_m_analysis_history', $insert_data_system_analysis);
                    $count_5_four_m_analysis++;
                    $count_5_four_m_analysis_history++;
                }
            }
        }

        // 6. Action Plan
        // // check if data exists
        // $query_action_plan = $this->db->query("SELECT * FROM agentic.6_action_plan WHERE kpi_id = '$id_kpi'");
        // if ($query_action_plan->num_rows() > 0) {
        //     $data_existing_action_plan = $query_action_plan->result();

        //     foreach ($action_plan as $key => $value) {
        //         $action_plan[$key] = (array)$value;
        //         $id_analysis = $this->model->generate_kpi_action_plan_id();
        //         $insert_data_system_analysis = [
        //             'id' => $id_analysis,
        //             'kpi_id' => $id_kpi,
        //             'action_text' => $action_plan[$key]['rencana_aksi'],
        //             'PIC' => $action_plan[$key]['PIC'],
        //             'due_date' => $action_plan[$key]['due_date'],
        //             'status' => 'pending',
        //             'created_at' => date('Y-m-d H:i:s'),
        //         ];
        //         $this->db->insert('agentic.6_timeline_tracking', $insert_data_system_analysis);
        //         $count_action_insert++;
        //     }
        // } else {
        $id_analysis = $this->model->generate_kpi_action_plan_id();
        foreach ($action_plan as $key => $value) {
            $action_plan[$key] = (array)$value;
            $id_analysis = $this->model->generate_kpi_action_plan_id();
            $insert_data_timeline_tracking = [
                'id' => $id_analysis,
                'kpi_id' => $id_kpi,
                'description' => $action_plan[$key]['aksi'],
                'owner' => $action_plan[$key]['pic'],
                'due_date' => $action_plan[$key]['due_date'],
                'status_plan' => 'Waiting',
                'notes' => $action_plan[$key]['catatan'],
                'reason' => $action_plan[$key]['reason'],
                'issue_id' => $action_plan[$key]['issue_id'],
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.6_timeline_tracking', $insert_data_timeline_tracking);
            $count_6_timeline_tracking++;
        }

        // 7. Rule Consequence
        // // check if data exists
        // $query_rule_consequence = $this->db->query("SELECT * FROM agentic.7_rules_consequence WHERE kpi_id = '$id_kpi'");
        // if ($query_rule_consequence->num_rows() > 0) {
        //     $data_existing_rule_consequence = $query_rule_consequence->result();
        //     // delete all existing
        //     foreach ($data_existing_rule_consequence as $row) {
        //         $this->db->where('id', $row->id);
        //         $this->db->delete('agentic.7_rules_consequence');
        //     }

        //     foreach ($rule_consequence as $key => $value) {
        //         $rule_consequence[$key] = (array)$value;
        //         $id_analysis = $this->model->generate_kpi_rule_consequence_id();
        //         $insert_data_rule_consequence = [
        //             'id' => $id_analysis,
        //             'kpi_id' => $id_kpi,
        //             'rule_text' => $rule_consequence[$key]['rule'],
        //             'rules' => $rule_consequence[$key]['type'],
        //             'created_at' => date('Y-m-d H:i:s'),
        //         ];
        //         $this->db->insert('agentic.7_rules_consequence', $insert_data_rule_consequence);
        //         $this->db->insert('agentic.7_rules_consequence_history', $insert_data_rule_consequence);
        //         $count_action_insert++;
        //     }
        // } else {
        $id_analysis = $this->model->generate_kpi_rule_consequence_id();
        foreach ($rule_consequence as $key => $value) {
            $rule_consequence[$key] = (array)$value;
            $id_analysis = $this->model->generate_kpi_rule_consequence_id();
            $insert_data_rule_consequence = [
                'id' => $id_analysis,
                'kpi_id' => $id_kpi,
                'rule_text' => $rule_consequence[$key]['rule'],
                'rules' => $rule_consequence[$key]['type'],
                'status_plan' => 'Waiting',
                'nominal' => isset($rule_consequence[$key]['nominal']) ? $rule_consequence[$key]['nominal'] : null,
                'duedate' => isset($rule_consequence[$key]['due_date']) ? $rule_consequence[$key]['due_date'] : null,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.7_rules_consequence', $insert_data_rule_consequence);
            $this->db->insert('agentic.7_rules_consequence_history', $insert_data_rule_consequence);
            $count_7_rules_consequence++;
            $count_7_rules_consequence_history++;
        }
        // }
        // }

        // 8. Reward
        // // check if data exists
        // $query_reward = $this->db->query("SELECT * FROM agentic.8_reward WHERE kpi_id = '$id_kpi'");
        // if ($query_reward->num_rows() > 0) {
        //     $data_existing_reward = $query_reward->result();
        //     // delete all existing
        //     foreach ($data_existing_reward as $row) {
        //         $this->db->where('id', $row->id);
        //         $this->db->delete('agentic.8_reward');
        //     }

        //     foreach ($reward as $key => $value) {
        //         $reward[$key] = (array)$value;
        //         $id_analysis = $this->model->generate_kpi_reward_id();
        //         $insert_data_reward = [
        //             'id' => $id_analysis,
        //             'kpi_id' => $id_kpi,
        //             'reward_text' => $reward[$key]['reward'],
        //             'criteria' => $reward[$key]['criteria'],
        //             'created_at' => date('Y-m-d H:i:s'),
        //         ];
        //         $this->db->insert('agentic.8_reward', $insert_data_reward);
        //         $this->db->insert('agentic.8_reward_history', $insert_data_reward);
        //         $count_action_insert++;
        //     }
        // } else {
        $id_analysis = $this->model->generate_kpi_reward_id();
        foreach ($reward as $key => $value) {
            $reward[$key] = (array)$value;
            $id_analysis = $this->model->generate_kpi_reward_id();
            $insert_data_reward = [
                'id' => $id_analysis,
                'kpi_id' => $id_kpi,
                'reward_text' => $reward[$key]['reward_text'],
                'status_plan' => 'Waiting',
                'rules' => $reward[$key]['rules'],
                'nominal' => isset($reward[$key]['nominal']) ? $reward[$key]['nominal'] : null,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('agentic.8_reward', $insert_data_reward);
            $this->db->insert('agentic.8_reward_history', $insert_data_reward);
            $count_8_reward++;
            $count_8_reward_history++;
        }
        // }

        // 9. Tech CCP Accountability
        // // check if data exists
        $query_tech_ccp = $this->db->query("SELECT * FROM agentic.9_tech_ccp_accountability WHERE kpi_id = '$id_kpi'");
        if ($query_tech_ccp->num_rows() > 0) {
            $data_existing_tech_ccp = $query_tech_ccp->result();
            // delete all existing
            foreach ($data_existing_tech_ccp as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.9_tech_ccp_accountability');
            }

            foreach ($tech_ccp_accountability as $key => $value) {
                $tech_ccp_accountability[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_tech_ccp_id();
                $insert_data_tech_ccp = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'description' => $tech_ccp_accountability[$key]['item'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data_tech_ccp);
                $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data_tech_ccp);
                $count_9_tech_ccp_accountability++;
                $count_9_tech_ccp_accountability_history++;
            }
        }
        else {
            $id_analysis = $this->model->generate_kpi_tech_ccp_id();
            foreach ($tech_ccp_accountability as $key => $value) {
                $tech_ccp_accountability[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_tech_ccp_id();
                $insert_data_tech_ccp = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'description' => $tech_ccp_accountability[$key]['item'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.9_tech_ccp_accountability', $insert_data_tech_ccp);
                $this->db->insert('agentic.9_tech_ccp_accountability_history', $insert_data_tech_ccp);
                $count_9_tech_ccp_accountability++;
                $count_9_tech_ccp_accountability_history++;
            }
        }

        // 10. Ringkasan Eksklusif
        // check if data exists
        $query_ringkasan_eks = $this->db->query("SELECT * FROM agentic.10_executive_summary WHERE kpi_id = '$id_kpi'");
        if ($query_ringkasan_eks->num_rows() > 0) {
            $data_existing_ringkasan_eks = $query_ringkasan_eks->result();
            // delete all existing
            foreach ($data_existing_ringkasan_eks as $row) {
                $this->db->where('id', $row->id);
                $this->db->delete('agentic.10_executive_summary');
            }

            foreach ($ringkasan_esklusif as $key => $value) {
                $ringkasan_esklusif[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_ringkasan_eks_id();
                $insert_data_ringkasan_eks = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'status_kpi' => $resume['jml_rjc'] >= $resume['target'] ? 'Ontime' : 'Delay',
                    'status_value' => $resume['jml_rjc'],
                    'status_note' => $ringkasan_esklusif[$key]['note'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.10_executive_summary', $insert_data_ringkasan_eks);
                $this->db->insert('agentic.10_executive_summary_history', $insert_data_ringkasan_eks);
                $count_10_executive_summary++;
                $count_10_executive_summary_history++;

                $resiko_kritis = $ringkasan_esklusif[$key]['resiko_kritis'];
                $fokus_minggu_ini = $ringkasan_esklusif[$key]['fokus_minggu_ini'];

                $data_existing_resiko_kritis = $this->db->query("SELECT * FROM agentic.11_executive_risks WHERE summary_id = '$id_analysis'")->result();
                // delete all existing
                foreach ($data_existing_resiko_kritis as $row) {
                    $this->db->where('id', $row->id);
                    $this->db->delete('agentic.11_executive_risks');
                }

                $data_existing_fokus_minggu_ini = $this->db->query("SELECT * FROM agentic.12_executive_focus WHERE summary_id = '$id_analysis'")->result();
                // delete all existing
                foreach ($data_existing_fokus_minggu_ini as $row) {
                    $this->db->where('id', $row->id);
                    $this->db->delete('agentic.12_executive_focus');
                }

                foreach ($resiko_kritis as $key => $value) {
                    $id_resiko_kritis = $this->model->generate_kpi_resiko_kritis_id();
                    $insert_data_resiko_kritis = [
                        'id' => $id_resiko_kritis,
                        'summary_id' => $id_analysis,
                        'risk_description' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.11_executive_risks', $insert_data_resiko_kritis);
                    $this->db->insert('agentic.11_executive_risks_history', $insert_data_resiko_kritis);
                    $count_11_executive_risks++;
                    $count_11_executive_risks_history++;
                }


                foreach ($fokus_minggu_ini as $key => $value) {
                    $id_fokus_minggu_ini = $this->model->generate_kpi_fokus_minggu_ini_id();
                    $insert_data_fokus_minggu_ini = [
                        'id' => $id_fokus_minggu_ini,
                        'summary_id' => $id_analysis,
                        'focus_description' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.12_executive_focus', $insert_data_fokus_minggu_ini);
                    $this->db->insert('agentic.12_executive_focus_history', $insert_data_fokus_minggu_ini);
                    $count_12_executive_focus++;
                    $count_12_executive_focus_history++;
                }
            }
        }
        else {
            $id_analysis = $this->model->generate_kpi_ringkasan_eks_id();
            foreach ($ringkasan_esklusif as $key => $value) {
                $ringkasan_esklusif[$key] = (array)$value;
                $id_analysis = $this->model->generate_kpi_ringkasan_eks_id();
                $insert_data_ringkasan_eks = [
                    'id' => $id_analysis,
                    'kpi_id' => $id_kpi,
                    'status_kpi' => $resume['jml_rjc'] >= $resume['target'] ? 'Ontime' : 'Delay',
                    'status_value' => $resume['jml_rjc'],
                    'status_note' => $ringkasan_esklusif[$key]['note'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $this->db->insert('agentic.10_executive_summary', $insert_data_ringkasan_eks);
                $this->db->insert('agentic.10_executive_summary_history', $insert_data_ringkasan_eks);
                $count_10_executive_summary++;
                $count_10_executive_summary_history++;

                $resiko_kritis = $ringkasan_esklusif[$key]['resiko_kritis'];
                $fokus_minggu_ini = $ringkasan_esklusif[$key]['fokus_minggu_ini'];

                $data_existing_resiko_kritis = $this->db->query("SELECT * FROM agentic.11_executive_risks WHERE summary_id = '$id_analysis'")->result();
                // delete all existing
                foreach ($data_existing_resiko_kritis as $row) {
                    $this->db->where('id', $row->id);
                    $this->db->delete('agentic.11_executive_risks');
                }
                $data_existing_fokus_minggu_ini = $this->db->query("SELECT * FROM agentic.12_executive_focus WHERE summary_id = '$id_analysis'")->result();
                // delete all existing
                foreach ($data_existing_fokus_minggu_ini as $row) {
                    $this->db->where('id', $row->id);
                    $this->db->delete('agentic.12_executive_focus');
                }

                foreach ($resiko_kritis as $key => $value) {
                    $id_resiko_kritis = $this->model->generate_kpi_resiko_kritis_id();
                    $insert_data_resiko_kritis = [
                        'id' => $id_resiko_kritis,
                        'summary_id' => $id_analysis,
                        'risk_description' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.11_executive_risks', $insert_data_resiko_kritis);
                    $this->db->insert('agentic.11_executive_risks_history', $insert_data_resiko_kritis);
                    $count_11_executive_risks++;
                    $count_11_executive_risks_history++;
                }


                foreach ($fokus_minggu_ini as $key => $value) {
                    $id_fokus_minggu_ini = $this->model->generate_kpi_fokus_minggu_ini_id();
                    $insert_data_fokus_minggu_ini = [
                        'id' => $id_fokus_minggu_ini,
                        'summary_id' => $id_analysis,
                        'focus_description' => $value,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->db->insert('agentic.12_executive_focus', $insert_data_fokus_minggu_ini);
                    $this->db->insert('agentic.12_executive_focus_history', $insert_data_fokus_minggu_ini);
                    $count_12_executive_focus++;
                    $count_12_executive_focus_history++;
                }
            }
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
                '1_kpi_data' => $count_1_kpi_data,
                '2_kpi_health' => $count_2_kpi_health,
                '2_kpi_health_history' => $count_2_kpi_health_history,
                '3_system_analysis' => $count_3_system_analysis,
                '3_system_analysis_history' => $count_3_system_analysis_history,
                '4_governance_check' => $count_4_governance_check,
                '4_governance_check_history' => $count_4_governance_check_history,
                '5_four_m_analysis' => $count_5_four_m_analysis,
                '5_four_m_analysis_history' => $count_5_four_m_analysis_history,
                '6_timeline_tracking' => $count_6_timeline_tracking,
                '7_rules_consequence' => $count_7_rules_consequence,
                '7_rules_consequence_history' => $count_7_rules_consequence_history,
                '8_reward' => $count_8_reward,
                '8_reward_history' => $count_8_reward_history,
                '9_tech_ccp_accountability' => $count_9_tech_ccp_accountability,
                '9_tech_ccp_accountability_history' => $count_9_tech_ccp_accountability_history,
                '10_executive_summary' => $count_10_executive_summary,
                '10_executive_summary_history' => $count_10_executive_summary_history,
                '11_executive_risks' => $count_11_executive_risks,
                '11_executive_risks_history' => $count_11_executive_risks_history,
                '12_executive_focus' => $count_12_executive_focus,
                '12_executive_focus_history' => $count_12_executive_focus_history,
            ];
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }
}