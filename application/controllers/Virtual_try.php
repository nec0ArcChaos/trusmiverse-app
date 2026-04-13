<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Virtual_try extends CI_Controller
{
    private $max_tryon_limit = 2; // Limit try-on per user
    // KREDENSIAL KLING AI (Ganti dengan milik Anda)
    private $kling_access_key = 'ATn3YyHkGpN4Bky4D8RQM3NJCQ8paH4p';
    private $kling_secret_key = 'LPm39hKPKMbH4MfdD44A4gLPfpffCHry';
    private $api_key = 'sk_live_f4z8SFERrVgaV1ot1rGJSwRAXSMFeHXT1-CTtWaTfWk'; // Ganti dengan API key Miragic

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->database();

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['user_limit_info'] = $this->get_user_limit_info();
        $this->load->view('virtual_try/index', $data);
    }

    // Method untuk cek limit user
    private function check_user_limit($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'completed');
        $count = $this->db->count_all_results('t_tryon');

        return [
            'is_limit_reached' => $count >= $this->max_tryon_limit,
            'current_count' => $count,
            'max_limit' => $this->max_tryon_limit,
            'remaining' => max(0, $this->max_tryon_limit - $count)
        ];
    }

    // Method untuk mendapatkan info limit user (untuk tampilan)
    public function get_user_limit_info()
    {
        $user_id = $this->session->userdata('user_id');
        return $this->check_user_limit($user_id);
    }

    // API endpoint untuk cek limit (dipanggil via AJAX)
    public function check_limit()
    {
        header('Content-Type: application/json');
        $user_id = $this->session->userdata('user_id');
        $limit_info = $this->check_user_limit($user_id);
        echo json_encode($limit_info);
    }

    public function process()
    {
        header('Content-Type: application/json');

        try {
            $user_id = $this->session->userdata('user_id');

            // CEK LIMIT TERLEBIH DAHULU
            $limit_info = $this->check_user_limit($user_id);

            if ($limit_info['is_limit_reached']) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Anda telah mencapai batas maksimal ' . $this->max_tryon_limit . 'x virtual try-on. Silakan hapus riwayat try-on sebelumnya jika ingin mencoba lagi.',
                    'limit_reached' => true,
                    'limit_info' => $limit_info
                ]);
                return;
            }

            // Validasi input
            if (empty($_FILES['model_image']['name'])) {
                throw new Exception('Foto model harus diupload');
            }

            if (empty($this->input->post('garment_image_url'))) {
                throw new Exception('Pakaian harus dipilih');
            }

            $garment_url = $this->input->post('garment_image_url');
            $garment_type = $this->input->post('garment_type') ?? 'full_body';
            $product_id = $this->input->post('product_id') ?? null;

            // Generate unique filename
            $timestamp = date('YmdHis');
            $random = substr(md5(uniqid()), 0, 8);

            // Konfigurasi upload untuk model image
            $model_filename = 'model_' . $user_id . '_' . $timestamp . '_' . $random;
            $upload_config = [
                'upload_path'   => './assets/uploads/tryon/',
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 2048,
                'file_name'     => $model_filename
            ];

            // Buat direktori jika belum ada
            if (!is_dir($upload_config['upload_path'])) {
                mkdir($upload_config['upload_path'], 0777, true);
            }

            if (!is_dir('./assets/uploads/tryon_results/')) {
                mkdir('./assets/uploads/tryon_results/', 0777, true);
            }

            $this->upload->initialize($upload_config);

            if (!$this->upload->do_upload('model_image')) {
                throw new Exception('Upload gagal: ' . strip_tags($this->upload->display_errors()));
            }

            $upload_data = $this->upload->data();
            $model_image_path = $upload_data['full_path'];
            $model_image_filename = $upload_data['file_name'];

            // Download dan simpan garment image dengan nama custom
            $garment_filename = 'garment_' . $user_id . '_' . $timestamp . '_' . $random . '.jpg';
            $garment_image_path = $this->download_and_save_image(
                $garment_url,
                './assets/uploads/tryon/' . $garment_filename
            );

            if (!$garment_image_path) {
                throw new Exception('Gagal mengunduh gambar pakaian');
            }

            // Insert data awal ke database
            $tryon_data = [
                'user_id' => $user_id,
                'model_image' => $model_image_filename,
                'garment_image' => $garment_filename,
                'garment_url' => $garment_url,
                'product_id' => $product_id,
                'garment_type' => $garment_type,
                'status' => 'processing',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('t_tryon', $tryon_data);
            $tryon_id = $this->db->insert_id();

            // Kirim request ke Miragic
            $api_result = $this->call_miragic_api($model_image_path, $garment_image_path, $garment_type);

            // Ambil jobId
            $jobId = $api_result['jobId'];

            $this->db->where('id', $tryon_id);
            $this->db->update('t_tryon', [
                'job_id' => $jobId,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // START POLLING (CEK STATUS)
            $attempt = 0;
            $max_attempts = 15;
            $final_result = null;

            while ($attempt < $max_attempts) {
                $attempt++;
                sleep(3);

                $status = $this->check_miragic_status($jobId);

                if ($status['success']) {
                    if ($status['data']['status'] === 'COMPLETED') {
                        $final_result = $status;
                        break;
                    }
                }
            }

            // Jika tetap tidak selesai
            if (!$final_result) {
                // Update status ke failed
                $this->db->where('id', $tryon_id);
                $this->db->update('t_tryon', [
                    'status' => 'failed',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                echo json_encode([
                    'success' => false,
                    'error' => 'Proses memakan waktu lebih lama dari batas maksimal.'
                ]);
                return;
            }

            // Download result image dari Miragic
            $result_image_url = $final_result['data']['resultImagePath'];
            $result_filename = 'result_' . $user_id . '_' . $timestamp . '_' . $random . '.jpg';
            $result_image_path = $this->download_and_save_image(
                $result_image_url,
                './assets/uploads/tryon_results/' . $result_filename
            );

            if (!$result_image_path) {
                throw new Exception('Gagal mengunduh gambar hasil');
            }

            // Update database dengan hasil
            $this->db->where('id', $tryon_id);
            $this->db->update('t_tryon', [
                'result_image' => $result_filename,
                'status' => 'completed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Dapatkan info limit terbaru
            $updated_limit_info = $this->check_user_limit($user_id);

            // Kirim response final ke frontend
            echo json_encode([
                'success' => true,
                'message' => 'Virtual try-on selesai',
                'tryon_id' => $tryon_id,
                'result_image_url' => base_url('assets/uploads/tryon_results/' . $result_filename),
                'original_model_url' => base_url('assets/uploads/tryon/' . $model_image_filename),
                'garment_image_url' => base_url('assets/uploads/tryon/' . $garment_filename),
                'limit_info' => $updated_limit_info,
                'data' => $final_result['data']
            ]);
        } catch (Exception $e) {
            // Update status ke failed jika ada error
            if (isset($tryon_id)) {
                $this->db->where('id', $tryon_id);
                $this->db->update('t_tryon', [
                    'status' => 'failed',
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function call_miragic_api($model_image_path, $garment_image_path, $garment_type = 'full_body')
    {
        $api_url = 'https://backend.miragic.ai/api/v1/virtual-try-on';
        $api_key = $this->api_key;

        $ch = curl_init();

        $cfile = new CURLFile($model_image_path, 'image/jpeg', 'humanImage');
        $gfile = new CURLFile($garment_image_path, 'image/jpeg', 'clothImage');

        $post_data = [
            'garmentType' => $garment_type,
            'humanImage' => $cfile,
            'clothImage' => $gfile
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-API-Key: ' . $api_key,
                'User-Agent: CodeIgniter-VTO-App/1.0'
            ],
            CURLOPT_TIMEOUT => 120,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($http_code !== 200 && $http_code !== 201 && $http_code !== 202) {
            throw new Exception('Miragic API Error (HTTP ' . $http_code . '): ' . $response . ' - ' . $error);
        }

        $response_data = json_decode($response, true);

        if (!isset($response_data['data']['jobId'])) {
            throw new Exception('Invalid response from Miragic API: ' . $response);
        }

        return [
            'jobId' => $response_data['data']['jobId'],
            'status' => $response_data['data']['status'] ?? null,
            'mode' => $response_data['data']['mode'] ?? null,
            'createdAt' => $response_data['data']['createdAt'] ?? null,
            'message' => $response_data['message'] ?? null
        ];
    }

    private function check_miragic_status($jobId)
    {
        $api_url = 'https://backend.miragic.ai/api/v1/virtual-try-on/' . $jobId;
        $api_key = $this->api_key;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-API-Key: ' . $api_key
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 60
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            return [
                'success' => false,
                'error' => 'Status check failed'
            ];
        }

        $data = json_decode($response, true);

        return [
            'success' => true,
            'data' => $data['data']
        ];
    }

    private function download_and_save_image($image_url, $save_path)
    {
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $image_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true
            ]);

            $image_data = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code !== 200 || empty($image_data)) {
                return false;
            }

            // Simpan ke file
            file_put_contents($save_path, $image_data);

            return $save_path;
        } catch (Exception $e) {
            return false;
        }
    }

    // Method untuk download hasil try-on
    public function download($tryon_id)
    {
        $user_id = $this->session->userdata('user_id');

        // Ambil data dari database
        $this->db->where('id', $tryon_id);
        $this->db->where('user_id', $user_id);
        $tryon = $this->db->get('t_tryon')->row();

        if (!$tryon) {
            show_error('Data tidak ditemukan atau Anda tidak memiliki akses');
            return;
        }

        if (empty($tryon->result_image)) {
            show_error('Hasil gambar tidak tersedia');
            return;
        }

        $file_path = './assets/uploads/tryon_results/' . $tryon->result_image;

        if (!file_exists($file_path)) {
            show_error('File tidak ditemukan');
            return;
        }

        // Force download
        $this->load->helper('download');
        force_download($file_path, NULL);
    }

    // Method untuk melihat history try-on user
    public function history()
    {
        $user_id = $this->session->userdata('user_id');

        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'completed');
        $this->db->order_by('created_at', 'DESC');
        $data['history'] = $this->db->get('t_tryon')->result();
        $data['user_limit_info'] = $this->get_user_limit_info();

        $this->load->view('virtual_try/history', $data);
    }

    // Method untuk hapus history
    public function delete($tryon_id)
    {
        header('Content-Type: application/json');

        $user_id = $this->session->userdata('user_id');

        // Ambil data
        $this->db->where('id', $tryon_id);
        $this->db->where('user_id', $user_id);
        $tryon = $this->db->get('t_tryon')->row();

        if (!$tryon) {
            echo json_encode(['success' => false, 'error' => 'Data tidak ditemukan']);
            return;
        }

        // Hapus file fisik
        $files = [
            './assets/uploads/tryon/' . $tryon->model_image,
            './assets/uploads/tryon/' . $tryon->garment_image,
            './assets/uploads/tryon_results/' . $tryon->result_image
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        // Hapus dari database
        $this->db->where('id', $tryon_id);
        $this->db->where('user_id', $user_id);
        $this->db->delete('t_tryon');

        // Dapatkan info limit terbaru setelah delete
        $updated_limit_info = $this->check_user_limit($user_id);

        echo json_encode([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'limit_info' => $updated_limit_info
        ]);
    }

    public function get_products()
    {
        // Contoh data produk - bisa diganti dengan query database
        $products = [
            [
                'id' => 1,
                'name' => 'Kemeja Putih Casual',
                'image' => base_url('assets/images/products/shirt1.jpg'),
                'price' => 'Rp 199.000',
                'category' => 'Atasan'
            ],
        ];

        echo json_encode($products);
    }

    public function get_result()
    {
        header('Content-Type: application/json');
        $jobId = $this->input->get('jobId');
        if (empty($jobId)) {
            echo json_encode(['success' => false, 'error' => 'Job ID tidak ditemukan']);
            return;
        }
        $api_url = 'https://backend.miragic.ai/api/v1/virtual-try-on/' . $jobId;
        $api_key = $this->api_key;
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-API-Key: ' . $api_key,
                'User-Agent: CodeIgniter-VTO-App/1.0'
            ],
            CURLOPT_TIMEOUT => 60,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if ($http_code !== 200) {
            echo json_encode(['success' => false, 'error' => 'Miragic API Error: ' . $response . ' - ' . $error]);
            return;
        }
        $response_data = json_decode($response, true);
        if (!isset($response_data['data']['resultImagePath'])) {
            echo json_encode(['success' => false, 'error' => 'Result image belum tersedia']);
            return;
        }
        echo json_encode([
            'success' => true,
            'status' => $response_data['data']['status'],
            'result_image_url' => $response_data['data']['resultImagePath'],
            'original_model_url' => $response_data['data']['humanImagePath'],
            'garment_image_url' => $response_data['data']['clothImagePath'],
            'data' => $response_data['data']
        ]);
    }

    private function generate_kling_jwt()
    {
        // Header
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);

        // Payload
        $payload = json_encode([
            'iss' => $this->kling_access_key,
            'exp' => time() + 1800, // Expire in 30 mins
            'nbf' => time() - 5
        ]);

        // Encode
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Sign
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->kling_secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    private function call_klingai_api($model_image_path, $garment_image_path, $garment_type = 'upper_body')
    {
        // Endpoint Kling AI (Kolors Virtual Try-On)
        // Pastikan endpoint ini sesuai dokumentasi terbaru, biasanya di v1/images/kolors-virtual-try-on
        $api_url = 'https://api.klingai.com/v1/images/kolors-virtual-try-on';

        $token = $this->generate_kling_jwt();

        // Konversi gambar ke Base64 karena API Kling biasanya meminta JSON body, bukan Multipart file
        $model_base64 = base64_encode(file_get_contents($model_image_path));
        $garment_base64 = base64_encode(file_get_contents($garment_image_path));

        // Mapping kategori garment codeigniter ke Kling API
        // CodeIgniter: full_body, tops, bottoms
        // Kling mungkin butuh: 'upper_body', 'lower_body', 'dresses'
        $category_map = [
            'full_body' => 'dresses',
            'tops' => 'upper_body',
            'bottoms' => 'lower_body'
        ];
        $kling_category = isset($category_map[$garment_type]) ? $category_map[$garment_type] : 'dresses';

        $post_data = json_encode([
            'model_name' => 'kolors-virtual-try-on-v1',
            'human_image' => $model_base64,
            'cloth_image' => $garment_base64,
            'category' => $kling_category
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ],
            CURLOPT_TIMEOUT => 120
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($http_code !== 200 && $http_code !== 201) {
            throw new Exception('Kling AI Error (' . $http_code . '): ' . $response);
        }

        $response_data = json_decode($response, true);

        // Sesuaikan dengan format response Kling AI (biasanya mengembalikan task_id atau data.task_id)
        // Jika response strukturnya: { "code": 0, "message": "success", "data": { "task_id": "..." } }
        if (!isset($response_data['data']['task_id'])) {
            // Fallback check jika structure beda
            if (isset($response_data['task_id'])) {
                return ['jobId' => $response_data['task_id']];
            }
            throw new Exception('Invalid response from Kling AI: ' . $response);
        }

        return [
            'jobId' => $response_data['data']['task_id'],
            'message' => $response_data['message'] ?? 'Task created'
        ];
    }

    private function check_klingai_status($task_id)
    {
        // Endpoint Get Task Status
        $api_url = 'https://api.klingai.com/v1/images/kolors-virtual-try-on/' . $task_id;
        $token = $this->generate_kling_jwt();

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ],
            CURLOPT_TIMEOUT => 60
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code !== 200) {
            return ['success' => false, 'error' => 'Status check failed'];
        }

        $data = json_decode($response, true);

        // Mapping status Kling ke format aplikasi kita
        // Kling statuses: SUBMITTED, PROCESSING, SUCCEED, FAILED
        $kling_status = $data['data']['task_status'] ?? $data['data']['status'] ?? 'PROCESSING';

        $mapped_data = $data['data'];

        // Normalize status key
        if (!isset($mapped_data['status'])) {
            $mapped_data['status'] = $kling_status;
        }

        // Normalized result image path
        if (isset($data['data']['task_result']['images'][0]['url'])) {
            $mapped_data['resultImagePath'] = $data['data']['task_result']['images'][0]['url'];
            $mapped_data['url'] = $data['data']['task_result']['images'][0]['url'];
        }

        return [
            'success' => true,
            'data' => $mapped_data
        ];
    }


    public function processModelKling()
    {
        header('Content-Type: application/json');

        try {
            $user_id = $this->session->userdata('user_id');

            // CEK LIMIT
            $limit_info = $this->check_user_limit($user_id);
            if ($limit_info['is_limit_reached']) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Anda telah mencapai batas maksimal try-on.',
                    'limit_reached' => true
                ]);
                return;
            }

            // Validasi input
            if (empty($_FILES['model_image']['name'])) {
                throw new Exception('Foto model harus diupload');
            }
            if (empty($this->input->post('garment_image_url'))) {
                throw new Exception('Pakaian harus dipilih');
            }

            $garment_url = $this->input->post('garment_image_url');
            $garment_type = $this->input->post('garment_type') ?? 'full_body'; // tops, bottoms, full_body
            $product_id = $this->input->post('product_id') ?? null;

            // Generate filename
            $timestamp = date('YmdHis');
            $random = substr(md5(uniqid()), 0, 8);

            // 1. Upload Model Image
            $model_filename = 'model_' . $user_id . '_' . $timestamp . '_' . $random;
            $upload_config = [
                'upload_path'   => './assets/uploads/tryon/',
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 5048, // Kling support higher res
                'file_name'     => $model_filename
            ];

            if (!is_dir($upload_config['upload_path'])) mkdir($upload_config['upload_path'], 0777, true);
            if (!is_dir('./assets/uploads/tryon_results/')) mkdir('./assets/uploads/tryon_results/', 0777, true);

            $this->upload->initialize($upload_config);
            if (!$this->upload->do_upload('model_image')) {
                throw new Exception('Upload gagal: ' . strip_tags($this->upload->display_errors()));
            }
            $upload_data = $this->upload->data();
            $model_image_path = $upload_data['full_path'];
            $model_image_filename = $upload_data['file_name'];

            // 2. Download Garment Image
            $garment_filename = 'garment_' . $user_id . '_' . $timestamp . '_' . $random . '.jpg';
            $garment_image_path = $this->download_and_save_image($garment_url, './assets/uploads/tryon/' . $garment_filename);
            if (!$garment_image_path) throw new Exception('Gagal mengunduh gambar pakaian');

            // 3. Insert Database (Processing)
            $tryon_data = [
                'user_id' => $user_id,
                'model_image' => $model_image_filename,
                'garment_image' => $garment_filename,
                'garment_url' => $garment_url,
                'product_id' => $product_id,
                'garment_type' => $garment_type,
                'status' => 'processing',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('t_tryon', $tryon_data);
            $tryon_id = $this->db->insert_id();

            // ============================================================
            // PILIH PROVIDER: MIRAGIC ATAU KLING AI
            // ============================================================

            // OPSI A: Gunakan Kling AI (Aktifkan ini)
            $api_result = $this->call_klingai_api($model_image_path, $garment_image_path, $garment_type);

            // OPSI B: Gunakan Miragic (Lama)
            // $api_result = $this->call_miragic_api($model_image_path, $garment_image_path, $garment_type);

            $jobId = $api_result['jobId'];

            $this->db->where('id', $tryon_id);
            $this->db->update('t_tryon', ['job_id' => $jobId, 'updated_at' => date('Y-m-d H:i:s')]);

            // 4. Polling Status
            // Note: Kling AI mungkin butuh waktu lebih lama dari Miragic (10-30 detik)
            $attempt = 0;
            $max_attempts = 30; // Perpanjang waktu tunggu
            $final_result = null;

            while ($attempt < $max_attempts) {
                $attempt++;
                sleep(2); // Interval polling

                // Gunakan checker yang sesuai dengan provider
                $status = $this->check_klingai_status($jobId);
                // $status = $this->check_miragic_status($jobId);

                if ($status['success']) {
                    if ($status['data']['status'] === 'SUCCEED' || $status['data']['status'] === 'COMPLETED') {
                        $final_result = $status;
                        break;
                    } elseif ($status['data']['status'] === 'FAILED') {
                        throw new Exception('Proses generate gagal di sisi AI: ' . ($status['data']['message'] ?? 'Unknown error'));
                    }
                }
            }

            if (!$final_result) {
                // Timeout tapi background process mungkin masih jalan
                // Kita bisa return success false tapi tidak mematikan record di DB agar user bisa cek history nanti
                echo json_encode([
                    'success' => false,
                    'error' => 'Proses sedang berjalan di latar belakang, silakan cek menu riwayat nanti.'
                ]);
                return;
            }

            // 5. Download Result
            // Kling AI mengembalikan array results, kita ambil yang pertama
            $result_image_url = isset($final_result['data']['url']) ? $final_result['data']['url'] : $final_result['data']['resultImagePath'];

            // Validasi URL
            if (empty($result_image_url)) {
                // Coba cari struktur lain dari response Kling
                if (isset($final_result['data']['images'][0]['url'])) {
                    $result_image_url = $final_result['data']['images'][0]['url'];
                }
            }

            $result_filename = 'result_' . $user_id . '_' . $timestamp . '_' . $random . '.jpg';
            $result_image_path = $this->download_and_save_image($result_image_url, './assets/uploads/tryon_results/' . $result_filename);

            if (!$result_image_path) throw new Exception('Gagal mengunduh gambar hasil');

            $this->db->where('id', $tryon_id);
            $this->db->update('t_tryon', [
                'result_image' => $result_filename,
                'status' => 'completed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Virtual try-on selesai',
                'result_image_url' => base_url('assets/uploads/tryon_results/' . $result_filename),
                'limit_info' => $this->check_user_limit($user_id)
            ]);
        } catch (Exception $e) {
            if (isset($tryon_id)) {
                $this->db->where('id', $tryon_id);
                $this->db->update('t_tryon', ['status' => 'failed', 'updated_at' => date('Y-m-d H:i:s')]);
            }
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
