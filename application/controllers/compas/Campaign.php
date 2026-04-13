<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Campaign extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_campaign', 'model_campaign');
        $this->load->database();
    }

    private function _json_response($status, $message = '', $data = [])
    {
        $response = ['status' => $status, 'message' => $message];
        if (!empty($data)) {
            $response = array_merge($response, (array) $data);
            if (isset($data['data']) && count($data) === 1) {
                $response = array_merge(['status' => $status, 'message' => $message], $data);
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_brands()
    {
        header('Content-Type: application/json');
        $brands = $this->model_campaign->get_brands();
        echo json_encode(['data' => $brands]);
    }

    public function get_employees()
    {
        header('Content-Type: application/json');
        $brand_id = $this->input->post('brand_id');
        $employees = $this->model_campaign->get_employees($brand_id);
        echo json_encode(['data' => $employees]);
    }

    public function get_content_pillars()
    {
        header('Content-Type: application/json');
        $brand_id = $this->input->post('brand_id');
        $content_pillars = $this->model_campaign->get_content_pillars($brand_id);
        echo json_encode(['data' => $content_pillars]);
    }

    public function get_objectives()
    {
        header('Content-Type: application/json');
        $brand_id = $this->input->post('brand_id');
        $objectives = $this->model_campaign->get_objectives($brand_id);
        echo json_encode(['data' => $objectives]);
    }

    public function get_generated_contents()
    {
        header('Content-Type: application/json');
        $brand_id = $this->input->post('brand_id');
        $generated_contents = $this->model_campaign->get_generated_contents($brand_id);
        echo json_encode(['data' => $generated_contents]);
    }

    public function get_content_formats()
    {
        header('Content-Type: application/json');
        $brand_id = $this->input->post('brand_id');
        $content_formats = $this->model_campaign->get_content_formats($brand_id);
        echo json_encode(['data' => $content_formats]);
    }

    public function generate_ai_campaign()
    {
        header('Content-Type: application/json');

        $user_prompt = $this->input->post('user_prompt');

        // 1. Fetch Master Data
        // Brands
        $brands = $this->db->select('brand_id, brand_name, brand_desc')->where('is_active', 1)->get('m_cmp_brand')->result_array();

        // Content Pillars
        $pillars = $this->db->select('cp_id, cp_name, brand_id as brand_ids')->where('is_active', 1)->get('m_cmp_content_pillar')->result_array();

        // Objectives
        $objectives = $this->db->select('objective_id, objective_name, brand_id as brand_ids')->where('is_active', 1)->get('m_cmp_objective')->result_array();

        // Content Generated
        $generated = $this->db->select('cg_id, cg_name, brand_id as brand_ids')->where('is_active', 1)->get('m_cmp_content_generated')->result_array();

        // Content Formats
        $formats = $this->db->select('cf_id, cf_name, brand_id as brand_ids')->where('is_active', 1)->get('m_cmp_content_format')->result_array();

        $master_data = [
            'brands' => $brands,
            'content_pillars' => $pillars,
            'objectives' => $objectives,
            'generated_contents' => $generated,
            'content_formats' => $formats
        ];

        $master_data_str = json_encode($master_data);

        $system_prompt = "Anda adalah Konsultan Strategi Pemasaran Kreatif Senior dengan keahlian mendalam di pasar Indonesia.
Tugas Anda adalah menghasilkan rencana kampanye pemasaran yang komprehensif, realistis, dan berdampak tinggi dalam format JSON berdasarkan input pengguna dan MASTER DATA yang disediakan.

---

🎯 PERAN & KONTEKS:
Anda memiliki pengalaman lebih dari 10 tahun dalam merancang kampanye digital dan offline di Indonesia. Anda memahami perilaku konsumen lokal, tren media sosial Indonesia, musim pemasaran (Ramadan, Lebaran, Harbolnas, dll.), serta karakteristik setiap platform digital yang relevan.

---

📋 INSTRUKSI UTAMA:

1. **Analisis Input Pengguna**
   - Pahami tujuan kampanye, nada komunikasi, dan konteks bisnis dari input yang diberikan.
   - Jika input tidak lengkap, asumsikan konteks yang paling masuk akal dan realistis.
   - Jika input kosong, buat kampanye berdampak tinggi untuk brand yang paling relevan atau menarik dari daftar MASTER DATA.

2. **Pemilihan Brand**
   - Pilih satu `brand_id` yang paling sesuai dari daftar `brands` di MASTER DATA.
   - Keputusan pemilihan harus didasarkan pada relevansi brand terhadap tujuan kampanye.

3. **Pemilihan Elemen Kampanye (Berbasis Brand)**
   Berdasarkan `brand_id` yang dipilih, tentukan elemen-elemen berikut **hanya dari item yang memiliki `brand_id` terpilih di dalam field `brand_ids`-nya** (format comma-separated):
   - `cp_id` → Content Pillars yang relevan
   - `objective_id` → Objektif kampanye yang sesuai
   - `cg_id` → Jenis konten yang akan diproduksi
   - `cf_id` → Format konten yang akan digunakan
   
   ⚠️ Constraint: Semua ID yang dipilih WAJIB memiliki `brand_id` terpilih dalam string `brand_ids`-nya. Kembalikan sebagai Array of Integers/Strings.

4. **Tanggal & Waktu**
   - Tanggal saat ini adalah: " . date('Y-m-d H:i:s') . "
   - Tentukan `start_date` dan `end_date` yang realistis sesuai durasi kampanye yang direkomendasikan.
   - Pertimbangkan momentum kalender pemasaran Indonesia jika relevan.

5. **Standar Kualitas Output**
   - Semua teks WAJIB menggunakan **Bahasa Indonesia** yang natural, profesional, dan persuasif.
   - Semua angka (biaya, target, dll.) WAJIB realistis untuk skala pasar Indonesia.
   - Konten harus koheren, strategis, dan mencerminkan identitas brand yang dipilih.

---

📊 MASTER DATA:
$master_data_str
        
---

📐 PANDUAN PENGISIAN FIELD:

| Field | Panduan |
|---|---|
| `campaign_name` | Nama kampanye yang catchy, mudah diingat, dan relevan dengan brand |
| `campaign_desc` | Deskripsi singkat namun komprehensif (2–4 kalimat) tentang apa, mengapa, dan bagaimana kampanye ini dijalankan |
| `content_angle` | Sudut pandang unik atau hook utama yang membedakan kampanye ini dari kompetitor |
| `target_audience` | Deskripsi spesifik: usia, gender, lokasi, profesi, minat, dan perilaku digital audiens |
| `audience_problem` | Pain point utama yang dirasakan audiens yang ingin diselesaikan kampanye ini |
| `key_message` | Pesan inti yang ingin audiens ingat setelah melihat kampanye (1 kalimat kuat) |
| `reason_to_believe` | Bukti nyata atau alasan logis mengapa audiens harus mempercayai klaim brand |
| `call_to_action` | Ajakan bertindak yang jelas, spesifik, dan mendesak |
| `internal_reference_url` | Contoh: 'Blog/Article - https://example.com/artikel-inspirasi' |
| `external_reference_url` | Contoh: 'Kompetitor/Tren - https://example.com/referensi-eksternal' |
| `production_cost` | Estimasi biaya produksi konten (dalam Rupiah, tanpa titik/koma) |
| `placement_cost` | Estimasi biaya penempatan/iklan (dalam Rupiah, tanpa titik/koma) |

---

🔢 PANDUAN TARGET REALISTIS (Sesuaikan dengan skala brand & budget):

- `internal_content_target`: Jumlah konten yang diproduksi secara internal (misalnya: 8–30 konten)
- `external_content_target`: Jumlah konten dari pihak eksternal/KOL (misalnya: 3–15 konten)
- `target_views`: Total target tayangan/impresi selama kampanye
- `target_leads`: Target prospek/leads yang dikumpulkan
- `target_transactions`: Target transaksi/konversi
- `activation_target`: Jumlah aktivasi/event/touchpoint
- `content_target`: Total konten keseluruhan (internal + eksternal)
- `distribution_target`: Jumlah saluran distribusi yang digunakan
- `optimization_target`: Jumlah iterasi optimasi yang direncanakan

---


📤 FORMAT OUTPUT JSON (Wajib diikuti secara ketat):
        {
            \"brand_id\": \"ID (Integer/String)\",
            \"campaign_name\": \"String\",
            \"campaign_desc\": \"String\",
            \"start_date\": \"YYYY-MM-DD HH:mm:ss\",
            \"end_date\": \"YYYY-MM-DD HH:mm:ss\",
            \"content_angle\": \"String\",
            \"target_audience\": \"String\",
            \"audience_problem\": \"String\",
            \"key_message\": \"String\",
            \"reason_to_believe\": \"String\",
            \"call_to_action\": \"String\",
            \"cp_id\": [Array of IDs],
            \"objective_id\": [Array of IDs],
            \"cg_id\": [Array of IDs],
            \"cf_id\": [Array of IDs],
            \"internal_content_target\": Integer,
            \"internal_reference_url\": \"String (Type Content - URL)\",
            \"external_content_target\": Integer,
            \"external_reference_url\": \"String (Type Content - URL)\",
            \"target_views\": Integer,
            \"target_leads\": Integer,
            \"target_transactions\": Integer,
            \"production_cost\": Integer,
            \"placement_cost\": Integer,
            \"activation_target\": Integer,
            \"content_target\": Integer,
            \"distribution_target\": Integer,
            \"optimization_target\": Integer
        }
            
⚠️ CONSTRAINT AKHIR:
- Output HANYA berupa JSON murni — tanpa penjelasan tambahan, tanpa markdown, tanpa komentar.
- Seluruh nilai string menggunakan Bahasa Indonesia.
- Seluruh nilai numerik dalam satuan yang sesuai dengan pasar Indonesia (Rupiah untuk biaya).
- Pastikan JSON valid dan dapat langsung di-parse.";

        // Payload to send to n8n
        $payload = [
            'system_prompt' => $system_prompt,
            'user_prompt' => $user_prompt ?: "Generate a creative marketing campaign idea"
        ];

        // START: N8N Integration 
        $n8n_url = "https://n8n.trustcore.id/webhook/compas-dynamic-generative-input-c8769381-40ab-46bd-8c9b-7a773f88c162";

        if (!empty($n8n_url)) {
            $ch = curl_init($n8n_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                // Assuming n8n returns the exact JSON structure in 'data' or root
                $result = json_decode($response, true);
                // Adjust based on actual n8n response structure. 
                $data = isset($result['output']) ? $result['output'] : $result;

                // Decode JSON output if it's a string in the response
                if (is_string($data)) {
                    $decoded = json_decode($data, true);
                    if ($decoded)
                        $data = $decoded;
                }

                echo json_encode(['status' => true, 'data' => $data]);
                return;
            }
        }
        // END: N8N Integration

        // Fallback / Simulation Data
        $dummy_data = [
            'campaign_name' => 'AI Concept: ' . ($user_prompt ? substr($user_prompt, 0, 20) . '...' : 'Viral Summer Trend'),
            'campaign_desc' => 'This campaign leverages high-energy visuals. Generated based on: ' . $payload['user_prompt'],
            'start_date' => date('Y-m-d H:i:s'),
            'end_date' => date('Y-m-d H:i:s', strtotime('+30 days')),
            'content_angle' => 'Authenticity and Connection',
            'target_audience' => 'Gen Z and Millennials (18-35)',
            'audience_problem' => 'Finding authentic brand experiences',
            'key_message' => 'Experience the real difference.',
            'reason_to_believe' => 'Rated #1 by Industry Standard.',
            'call_to_action' => 'Join the Movement Now',
            'brand_id' => 1, // Example brand ID
            'cp_id' => [1, 2], // Example content pillar IDs
            'objective_id' => [1], // Example objective IDs
            'cg_id' => [1, 3], // Example content generated IDs
            'cf_id' => [2], // Example content format IDs
            'internal_content_target' => 10,
            'internal_reference_url' => 'https://example.com/concept',
            'external_content_target' => 5,
            'external_reference_url' => 'https://example.com/brief',
            'target_views' => 100000,
            'target_leads' => 500,
            'target_transactions' => 120,
            'production_cost' => 7500000,
            'placement_cost' => 3000000,
            'activation_target' => 3,
            'content_target' => 5,
            'distribution_target' => 5,
            'optimization_target' => 2
        ];

        echo json_encode(['status' => true, 'data' => $dummy_data]);
    }

    public function save_campaign()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $data = [
                'campaign_name' => $this->input->post('campaign_name'),
                'campaign_desc' => $this->input->post('campaign_desc'),
                'brand_id' => $this->input->post('brand_id'),
                'campaign_start_date' => $this->input->post('start_date'),
                'campaign_end_date' => $this->input->post('end_date'),
                'objective_id' => $this->input->post('objective_id') ? implode(',', $this->input->post('objective_id')) : '',
                'cp_id' => $this->input->post('cp_id') ? implode(',', $this->input->post('cp_id')) : '',
                'content_angle' => $this->input->post('angle'),
                'target_audience' => $this->input->post('target_audiens'),
                'audience_problem' => $this->input->post('problem'),
                'key_message' => $this->input->post('key_message'),
                'reason_to_believe' => $this->input->post('reason_to_believe'),
                'call_to_action' => $this->input->post('cta'),
                'cg_id' => $this->input->post('cg_id') ? implode(',', $this->input->post('cg_id')) : '',
                'cf_id' => $this->input->post('cf_id') ? implode(',', $this->input->post('cf_id')) : '',
                'internal_content_target' => $this->input->post('jumlah_konten_internal'),
                'internal_reference_url' => $this->input->post('link_referensi_internal'),
                'external_content_target' => $this->input->post('jumlah_konten_eksternal'),
                'external_reference_url' => $this->input->post('link_referensi_eksternal'),
                'target_views' => str_replace('.', '', $this->input->post('views')),
                'target_leads' => str_replace('.', '', $this->input->post('leads')),
                'target_transactions' => str_replace('.', '', $this->input->post('transaction')),
                'production_cost' => str_replace('.', '', $this->input->post('cost_production')),
                'placement_cost' => str_replace('.', '', $this->input->post('cost_placement')),

                // New Team Fields
                'activation_team' => $this->input->post('activation_team') ? implode(',', $this->input->post('activation_team')) : '',
                'activation_target' => $this->input->post('activation_target'),
                'content_team' => $this->input->post('content_team') ? implode(',', $this->input->post('content_team')) : '',
                'content_target' => $this->input->post('content_target'),
                'talent_team' => $this->input->post('talent_team') ? implode(',', $this->input->post('talent_team')) : '',
                'distribution_team' => $this->input->post('distribution_team') ? implode(',', $this->input->post('distribution_team')) : '',
                'distribution_target' => $this->input->post('distribution_target'),
                'optimization_team' => $this->input->post('optimization_team') ? implode(',', $this->input->post('optimization_team')) : '',
                'optimization_target' => $this->input->post('optimization_target'),

                'campaign_status' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 1,
            ];

            if ($this->model_campaign->insert_campaign($data)) {
                echo json_encode(['status' => 'success', 'message' => 'Campaign saved successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save campaign.']);
            }
        } else {
            show_404();
        }
    }
    public function get_campaign_detail()
    {
        header('Content-Type: application/json');
        $campaign_id = $this->input->post('campaign_id');
        if (!$campaign_id) {
            echo json_encode(['status' => 'error', 'message' => 'Campaign ID is required']);
            return;
        }

        $campaign = $this->model_campaign->get_campaign_by_id($campaign_id);
        $ai_analysis = $this->model_campaign->get_swot_analysis($campaign_id);
        if ($ai_analysis) {
            $ai_analysis['swot_strengths'] = json_decode($ai_analysis['swot_strengths'], true);
            $ai_analysis['swot_weaknesses'] = json_decode($ai_analysis['swot_weaknesses'], true);
            $ai_analysis['swot_opportunities'] = json_decode($ai_analysis['swot_opportunities'], true);
            $ai_analysis['swot_threats'] = json_decode($ai_analysis['swot_threats'], true);
            $ai_analysis['recommendations'] = json_decode($ai_analysis['recommendations'], true);
            $ai_analysis['scoring_breakdown'] = json_decode($ai_analysis['scoring_breakdown'], true);
            $ai_analysis['risk_factors'] = json_decode($ai_analysis['risk_factors'], true);
            $ai_analysis['quick_wins'] = json_decode($ai_analysis['quick_wins'], true);
        }

        if ($campaign) {
            echo json_encode(['status' => 'success', 'data' => $campaign, 'ai_analysis' => $ai_analysis]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Campaign not found']);
        }
    }

    public function swot_analysis()
    {
        header('Content-Type: application/json');
        $campaign_id = $this->input->post('campaign_id');

        if (!$campaign_id) {
            echo json_encode(['status' => 'error', 'message' => 'Campaign ID is required']);
            return;
        }

        // Check if DB has analysis (skip if re-analyze requested)
        $re_analyze = $this->input->post('re_analyze');

        if ($re_analyze !== 'true') {
            $existing = $this->model_campaign->get_swot_analysis($campaign_id);

            if ($existing) {
                $response_data = [
                    'strengths' => json_decode($existing['swot_strengths'], true) ?? [],
                    'weaknesses' => json_decode($existing['swot_weaknesses'], true) ?? [],
                    'opportunities' => json_decode($existing['swot_opportunities'], true) ?? [],
                    'threats' => json_decode($existing['swot_threats'], true) ?? [],
                    'recommendations' => json_decode($existing['recommendations'], true) ?? [],
                    'overall_score' => $existing['overall_score'] ?? 0,
                    'conclusion' => $existing['executive_summary'] ?? '',
                    'scoring_breakdown' => json_decode($existing['scoring_breakdown'], true) ?? [],
                ];
                echo json_encode(['status' => 'success', 'data' => $response_data]);
                return;
            }
        }

        $campaign_data = $this->model_campaign->get_campaign_by_id($campaign_id);

        if ($campaign_data) {
            $strategy_and_concept = [
                'campaign_name' => $campaign_data->campaign_name,
                'campaign_description' => $campaign_data->campaign_desc,
                'brand_name' => $campaign_data->brand_name,
                'brand_desc' => $campaign_data->brand_desc,
                'campaign_start_date' => $campaign_data->campaign_start_date,
                'campaign_end_date' => $campaign_data->campaign_end_date,
                'objectives' => $campaign_data->objectives,
                'content_angle' => $campaign_data->content_angle,
            ];

            $message_and_audience = [
                'target_audience' => $campaign_data->target_audience,
                'audience_problem' => $campaign_data->audience_problem,
                'key_message' => $campaign_data->key_message,
                'reason_to_believe' => $campaign_data->reason_to_believe,
                'call_to_action' => $campaign_data->call_to_action,
            ];

            $creative_and_direction = [
                'content_generated' => $campaign_data->content_generated,
                'content_formats' => $campaign_data->content_formats,
            ];

            $kpi_and_budget = [
                'target_views' => $campaign_data->target_views,
                'target_leads' => $campaign_data->target_leads,
                'target_transactions' => $campaign_data->target_transactions,
                'production_cost' => $campaign_data->production_cost,
                'placement_cost' => $campaign_data->placement_cost,
            ];

            $data = [
                'current_time' => date('Y-m-d H:i:s'),
                'campaign_id' => $campaign_data->campaign_id,
                'strategy_and_concept' => $strategy_and_concept,
                'message_and_audience' => $message_and_audience,
                'creative_and_direction' => $creative_and_direction,
                'kpi_and_budget' => $kpi_and_budget,
            ];

            // curl post to n8n
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://n8n.trustcore.id/webhook/compas-swot-c8769381-40ab-46bd-8c9b-7a773f88c162');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $n8n_data = json_decode($response, true);

            if ($http_code == 200 && $n8n_data) {
                // Handle array wrap
                if (isset($n8n_data[0]) && is_array($n8n_data[0])) {
                    $n8n_result = $n8n_data[0];
                } else {
                    $n8n_result = $n8n_data;
                }

                // Ensure campaign_id is set
                $n8n_result['campaign_id'] = $campaign_id;

                $db_data = [
                    'campaign_id' => $n8n_result['campaign_id'],
                    'analysis_date' => $n8n_result['analysis_date'] ?? date('Y-m-d'),
                    'executive_summary' => $n8n_result['executive_summary'] ?? null,
                    'swot_strengths' => json_encode($n8n_result['swot_analysis']['strengths'] ?? []),
                    'swot_weaknesses' => json_encode($n8n_result['swot_analysis']['weaknesses'] ?? []),
                    'swot_opportunities' => json_encode($n8n_result['swot_analysis']['opportunities'] ?? []),
                    'swot_threats' => json_encode($n8n_result['swot_analysis']['threats'] ?? []),
                    'score_strategy' => $n8n_result['scoring_breakdown']['strategy_and_concept']['score'] ?? 0,
                    'score_message' => $n8n_result['scoring_breakdown']['message_and_audience']['score'] ?? 0,
                    'score_creative' => $n8n_result['scoring_breakdown']['creative_and_execution']['score'] ?? 0,
                    'score_kpi' => $n8n_result['scoring_breakdown']['kpi_and_budget']['score'] ?? 0,
                    'overall_score' => $n8n_result['overall_score'] ?? 0,
                    'scoring_breakdown' => json_encode($n8n_result['scoring_breakdown'] ?? []),
                    'performance_category' => $n8n_result['performance_category'] ?? null,
                    'risk_level' => $n8n_result['risk_level'] ?? null,
                    'risk_factors' => json_encode($n8n_result['risk_factors'] ?? []),
                    'recommendations' => json_encode($n8n_result['recommendations'] ?? []),
                    'conclusion' => $n8n_result['conclusion'] ?? null,
                    'analyst_confidence' => $n8n_result['metadata']['analyst_confidence'] ?? null,
                    'data_completeness' => $n8n_result['metadata']['data_completeness'] ?? null,
                    'analysis_version' => $n8n_result['metadata']['analysis_version'] ?? null,
                    'quick_wins' => json_encode($n8n_result['quick_wins'] ?? []),
                ];

                $this->model_campaign->save_swot_analysis($db_data);

                // Prepare response for frontend
                $frontend_response = [
                    'strengths' => $n8n_result['swot_analysis']['strengths'] ?? [],
                    'weaknesses' => $n8n_result['swot_analysis']['weaknesses'] ?? [],
                    'opportunities' => $n8n_result['swot_analysis']['opportunities'] ?? [],
                    'threats' => $n8n_result['swot_analysis']['threats'] ?? [],
                    'recommendations' => $n8n_result['recommendations'] ?? [],
                    'overall_score' => $n8n_result['overall_score'] ?? 0,
                    'conclusion' => $n8n_result['executive_summary'] ?? $n8n_result['conclusion'] ?? '',
                    'scoring_breakdown' => $n8n_result['scoring_breakdown'] ?? [],
                ];

                echo json_encode(['status' => 'success', 'data' => $frontend_response]);

            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to retrieve analysis from AI service.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Campaign not found']);
        }
    }

    public function update_campaign()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $campaign_id = $this->input->post('campaign_id');

            if (!$campaign_id) {
                echo json_encode(['status' => 'error', 'message' => 'Campaign ID is required']);
                return;
            }

            $data = [
                'campaign_name' => $this->input->post('campaign_name'),
                'campaign_desc' => $this->input->post('campaign_desc'),
                'brand_id' => $this->input->post('brand_id'),
                'campaign_start_date' => $this->input->post('start_date'),
                'campaign_end_date' => $this->input->post('end_date'),
                'objective_id' => $this->input->post('objective_id') ? implode(',', $this->input->post('objective_id')) : '',
                'cp_id' => $this->input->post('cp_id') ? implode(',', $this->input->post('cp_id')) : '',
                'content_angle' => $this->input->post('angle'),
                'target_audience' => $this->input->post('target_audiens'),
                'audience_problem' => $this->input->post('problem'),
                'key_message' => $this->input->post('key_message'),
                'reason_to_believe' => $this->input->post('reason_to_believe'),
                'call_to_action' => $this->input->post('cta'),
                'cg_id' => $this->input->post('cg_id') ? implode(',', $this->input->post('cg_id')) : '',
                'cf_id' => $this->input->post('cf_id') ? implode(',', $this->input->post('cf_id')) : '',
                'internal_content_target' => $this->input->post('jumlah_konten_internal'),
                'internal_reference_url' => $this->input->post('link_referensi_internal'),
                'external_content_target' => $this->input->post('jumlah_konten_eksternal'),
                'external_reference_url' => $this->input->post('link_referensi_eksternal'),
                'target_views' => str_replace('.', '', $this->input->post('views')),
                'target_leads' => str_replace('.', '', $this->input->post('leads')),
                'target_transactions' => str_replace('.', '', $this->input->post('transaction')),
                'production_cost' => str_replace('.', '', $this->input->post('cost_production')),
                'placement_cost' => str_replace('.', '', $this->input->post('cost_placement')),

                // Team Fields
                'activation_team' => $this->input->post('activation_team') ? implode(',', $this->input->post('activation_team')) : '',
                'activation_target' => $this->input->post('activation_target'),
                'content_team' => $this->input->post('content_team') ? implode(',', $this->input->post('content_team')) : '',
                'content_target' => $this->input->post('content_target'),
                'talent_team' => $this->input->post('talent_team') ? implode(',', $this->input->post('talent_team')) : '',
                'distribution_team' => $this->input->post('distribution_team') ? implode(',', $this->input->post('distribution_team')) : '',
                'distribution_target' => $this->input->post('distribution_target'),
                'optimization_team' => $this->input->post('optimization_team') ? implode(',', $this->input->post('optimization_team')) : '',
                'optimization_target' => $this->input->post('optimization_target'),

                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->model_campaign->update_campaign($campaign_id, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Campaign updated successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update campaign.']);
            }
        } else {
            show_404();
        }
    }

    public function approve_campaign()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $campaign_id = $this->input->post('campaign_id');
            $activation_team = $this->input->post('activation_team') ? implode(',', $this->input->post('activation_team')) : '';
            $activation_target = $this->input->post('activation_target');
            // $content_team = $this->input->post('content_team') ? implode(',', $this->input->post('content_team')) : '';
            // $content_target = $this->input->post('content_target');
            // $talent_team = $this->input->post('talent_team') ? implode(',', $this->input->post('talent_team')) : '';
            // $distribution_team = $this->input->post('distribution_team') ? implode(',', $this->input->post('distribution_team')) : '';
            // $distribution_target = $this->input->post('distribution_target');
            // $optimization_team = $this->input->post('optimization_team') ? implode(',', $this->input->post('optimization_team')) : '';
            // $optimization_target = $this->input->post('optimization_target');

            if (!$campaign_id || !$activation_team) {
                echo json_encode(['status' => 'error', 'message' => 'Campaign ID and Activation Team are required.']);
                return;
            }

            $data = [
                'campaign_status' => '2',
                'activation_status' => '1',
                'activation_team' => $activation_team,
                'activation_target' => $activation_target,
                // 'content_team' => $content_team,
                // 'content_target' => $content_target,
                // 'talent_team' => $talent_team,
                // 'distribution_team' => $distribution_team,
                // 'distribution_target' => $distribution_target,
                // 'optimization_team' => $optimization_team,
                // 'optimization_target' => $optimization_target,
                'activation_deadline' => date('Y-m-d 23:59:59', strtotime('+1 days')),
                'campaign_approved_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->model_campaign->update_campaign($campaign_id, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Campaign approved successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to approve campaign.']);
            }
        } else {
            show_404();
        }
    }

    public function approve_done_campaign()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $campaign_id = $this->input->post('campaign_id');

            if (!$campaign_id) {
                echo json_encode(['status' => 'error', 'message' => 'Campaign ID is required.']);
                return;
            }

            $data = [
                'campaign_status' => '4',
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->model_campaign->update_campaign($campaign_id, $data)) {
                echo json_encode(['status' => 'success', 'message' => 'Campaign marked as Done successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update campaign.']);
            }
        } else {
            show_404();
        }
    }

    public function save_swot_analysis()
    {
        // accept input post from n8n php input all $raw_input = file_get_contents('php://input');
        $raw_input = file_get_contents('php://input');
        $input_data = json_decode($raw_input, true);

        // Handle if input is wrapped in array
        if (isset($input_data['results'][0]['json']) && is_array($input_data['results'][0]['json'])) {
            $data = $input_data['results'][0]['json'];
        } else {
            $data = $input_data;
        }

        if (!$data || !isset($data['campaign_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data format or missing campaign_id']);
            return;
        }

        $db_data = [
            'campaign_id' => $data['campaign_id'],
            'analysis_date' => $data['analysis_date'] ?? date('Y-m-d'),
            'executive_summary' => $data['executive_summary'] ?? null,
            'swot_strengths' => json_encode($data['swot_analysis']['strengths'] ?? []),
            'swot_weaknesses' => json_encode($data['swot_analysis']['weaknesses'] ?? []),
            'swot_opportunities' => json_encode($data['swot_analysis']['opportunities'] ?? []),
            'swot_threats' => json_encode($data['swot_analysis']['threats'] ?? []),
            'score_strategy' => $data['scoring_breakdown']['strategy_and_concept']['score'] ?? 0,
            'score_message' => $data['scoring_breakdown']['message_and_audience']['score'] ?? 0,
            'score_creative' => $data['scoring_breakdown']['creative_and_execution']['score'] ?? 0,
            'score_kpi' => $data['scoring_breakdown']['kpi_and_budget']['score'] ?? 0,
            'overall_score' => $data['overall_score'] ?? 0,
            'scoring_breakdown' => json_encode($data['scoring_breakdown'] ?? []),
            'performance_category' => $data['performance_category'] ?? null,
            'risk_level' => $data['risk_level'] ?? null,
            'risk_factors' => json_encode($data['risk_factors'] ?? []),
            'recommendations' => json_encode($data['recommendations'] ?? []),
            'conclusion' => $data['conclusion'] ?? null,
            'analyst_confidence' => $data['metadata']['analyst_confidence'] ?? null,
            'data_completeness' => $data['metadata']['data_completeness'] ?? null,
            'analysis_version' => $data['metadata']['analysis_version'] ?? null,
            'quick_wins' => json_encode($data['quick_wins'] ?? []),
        ];

        $insert = $this->model_campaign->save_swot_analysis($db_data);

        if ($insert) {
            echo json_encode(['status' => 'success', 'message' => 'SWOT analysis saved successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save analysis to database.']);
        }
    }

    public function get_campaign_stats()
    {
        $stats = $this->model_campaign->getCampaignStats();

        // Format avg_sla_days → "Xd Yh"
        $avg_days = (int) ($stats['avg_sla_days'] ?? 0);
        $sla_display = ($avg_days > 0)
            ? floor($avg_days / 1) . 'd 0h'
            : '0d';

        return $this->_json_response(true, 'OK', [
            'data' => [
                'total_submissions' => (int) ($stats['total_submissions'] ?? 0),
                'avg_sla_days' => $avg_days,
                'avg_sla_display' => $sla_display,
                'avg_ai_score' => (int) ($stats['avg_ai_score'] ?? 0),
                'approved_plans' => (int) ($stats['approved_plans'] ?? 0),
            ]
        ]);
    }
}