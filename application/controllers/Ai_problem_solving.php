<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_problem_solving extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_ai_problem_solving', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 			= "ai_problem_solving/index_coaching";
		$data['pageTitle'] 			= "AI 5 Why Analysis";
		$data['css'] 				= "ai_problem_solving/css";
		$data['js'] 				= "ai_problem_solving/js_coaching";
		$this->load->view("layout/main", $data);
	}

	function why()
	{
		$data['content'] 			= "ai_problem_solving/index";
		$data['pageTitle'] 			= "AI 5 Why Analysis";
		$data['css'] 				= "ai_problem_solving/css";
		$data['js'] 				= "ai_problem_solving/js_why";

		$this->load->view("layout/main", $data);
	}

	function list_problem()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_problem($start, $end);
		echo json_encode($result);
	}

	// Start AI 5 Why
	function next_problem_why()
	{
		$step = (int) $this->input->post('step');
		$no_ps = $this->input->post('no_ps');
		$problem = $this->input->post('problem');
		
		if ($step == 1) {		
			$no_ps = $this->model->generate_no_problem_solving();

			$data = array(
				"no_ps" => $no_ps,
				"problem" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$res['response'] = $this->db->insert('ai_problem_solving', $data);
			$res_openai = $this->ask_openai_why("Kenapa " . rtrim($problem, '.') . "?", $step);
			$res['openai'] = $res_openai;

			$data2 = array(
				"rekom_why_$step" => $res_openai,
			);
			$this->db->where('no_ps', $no_ps);
			$res['response2'] = $this->db->update('ai_problem_solving', $data2);

		} else if ($step > 1 && $step < 7) {
					
			if ($step == 6) {
				$res_openai = $this->ask_openai_why(rtrim($problem, '.'), $step);
				$res['openai'] = $res_openai;
				$data2 = array(
					"rekom_solving" => $res_openai,
				);
				$this->db->where('no_ps', $no_ps);
				$res['response2'] = $this->db->update('ai_problem_solving', $data2);
			} else {
				$res_openai = $this->ask_openai_why("Kenapa " . rtrim($problem, '.') . "?", $step);
				$res['openai'] = $res_openai;
				$data2 = array(
					"rekom_why_$step" => $res_openai,
				);
				$this->db->where('no_ps', $no_ps);
				$res['response2'] = $this->db->update('ai_problem_solving', $data2);
			}

			$step = $step - 1;
			$data = array(
				"why_$step" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$this->db->where('no_ps', $no_ps);
			$res['response'] = $this->db->update('ai_problem_solving', $data);
		} else if ($step == 7) {
			$data = array(
				"id_mom" => (empty($_POST['id_mom']) || !isset($_POST['id_mom'])) ? null : $_POST['id_mom'],
				"solving" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$this->db->where('no_ps', $no_ps);
			$res['response'] = $this->db->update('ai_problem_solving', $data);	
		}		

		$res['data'] = $data;
		
		echo json_encode($res);
	}
	
    private function ask_openai_why($message, $step)
    {
		if ((int)$step == 1) {
			$content_system= "Kamu adalah analis problem solving yang menggunakan metode 5 Why.";
			$content = "Gunakan metode 5 Why untuk menyelidiki masalah berikut: '. $message .'. Jangan langsung ke Why ke-5. Mulai dengan pertanyaan Mengapa 1 dan berikan 4 pilihan jawaban tanpa kata depan 'Karena' atau 'Mengapa'. Hanya berikan jawaban yang memiliki nomor 1 s/d 4 saja, tidak perlu munculkan pertanyaannya lagi.";
		} else if ((int)$step > 1 && (int)$step < 6) {
			$content_system= "Kamu adalah analis problem solving yang menggunakan metode 5 Why.";
			$content = "Ketika saya memilih: " . $message . " Mengapa demikian? Berikan 4 kemungkinan jawaban selanjutnya. Jangan langsung ke Why ke-5. Mulai dengan pertanyaan Mengapa ". (int)$step ." dan berikan 4 pilihan jawaban tanpa kata depan 'Karena' atau 'Mengapa'. Hanya berikan jawaban yang memiliki nomor 1 s/d 4 saja, tidak perlu munculkan pertanyaannya lagi.";
		} else if ((int)$step == 6) {
			$content_system= "Kamu adalah analis problem solving yang bisa memberikan rekomendasi solusi dan aksinya.";
			$content = "Berikan 4 rekomendasi solusi terbaik dari akar masalah berikut ini : " . $message . " dan berikan juga aksi yang bisa dilakukan dari solusi tersebut.";
		}

        $url = 'https://api.openai.com/v1/chat/completions';
        $apiKey = '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';

        // Construct messages array
        $messages = [
            [
                'role' => 'system',
                'content' => $content_system
            ],
            [
                'role' => 'user',
                'content' => $content
            ]
        ];

        $data = [
            'model' => 'gpt-4o',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 2048,
            'top_p' => 0.9,
            'frequency_penalty' => 0,
            'presence_penalty' => 0.2
        ];


        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        return $response['choices'][0]['message']['content'] ?? "No response.";
    }
	// End Ai 5 Why	

	function coaching()
	{
		$data['content'] 			= "ai_problem_solving/index_coaching";
		$data['pageTitle'] 			= "AI 5 Why Analysis";
		$data['css'] 				= "ai_problem_solving/css";
		$data['js'] 				= "ai_problem_solving/js_coaching";
		$this->load->view("layout/main", $data);
	}

	// Start Ai for Coaching
	function next_problem_coaching()
	{
		$step = (int) $this->input->post('step');
		$no_ps = $this->input->post('no_ps');
		$problem = $this->input->post('problem');
		
		if ($step == 1) {		
			$no_ps = $this->model->generate_no_problem_solving();

			$data = array(
				"no_ps" => $no_ps,
				"problem" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$res['response'] = $this->db->insert('ai_problem_solving', $data);
			$res_openai = $this->ask_openai_coaching(rtrim($problem, '.'), $step, $no_ps);
			$res['openai'] = $res_openai;

			$data2 = array(
				"rekom_why_$step" => $res_openai,
			);
			$this->db->where('no_ps', $no_ps);
			$res['response2'] = $this->db->update('ai_problem_solving', $data2);

		} else if ($step > 1 && $step < 7) {
					
			if ($step == 6) {
				$res_openai = $this->ask_openai_coaching(rtrim($problem, '.'), $step, $no_ps);
				$res['openai'] = $res_openai;
				$data2 = array(
					"rekom_solving" => $res_openai,
				);
				$this->db->where('no_ps', $no_ps);
				$res['response2'] = $this->db->update('ai_problem_solving', $data2);
			} else {
				$res_openai = $this->ask_openai_coaching(rtrim($problem, '.'), $step, $no_ps);
				$res['openai'] = $res_openai;
				$data2 = array(
					"rekom_why_$step" => $res_openai,
				);
				$this->db->where('no_ps', $no_ps);
				$res['response2'] = $this->db->update('ai_problem_solving', $data2);
			}

			$step = $step - 1;
			$data = array(
				"why_$step" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$this->db->where('no_ps', $no_ps);
			$res['response'] = $this->db->update('ai_problem_solving', $data);
		} else if ($step == 7) {
			$data = array(
				"id_mom" => $_POST['id_mom'],
				"id_issue" => $_POST['id_issue'],
				"status" => $_POST['status'],
				"solving" => $problem,
				"created_at" => date("Y-m-d H:i:s"),
				"created_by" => $this->session->userdata('user_id'),
			);
			$this->db->where('no_ps', $no_ps);
			$res['response'] = $this->db->update('ai_problem_solving', $data);	
		}		

		$res['data'] = $data;
		
		echo json_encode($res);
	}
	
    private function ask_openai_coaching($message, $step, $no_ps)
    {
        $url = 'https://api.openai.com/v1/chat/completions';
        $apiKey = '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';

        // Construct messages array - Prompt Faisal Awal buat - Disable karena kurang deep
		// $coaching_steps = [
		// 	// 1 => "Langkah 1: Kesadaran Awal\nApa sebenarnya masalah yang Anda hadapi, dan sejak kapan Anda menyadarinya?",
		// 	1 => "Langkah 1: Eksplorasi Situasi\nApa saja hal yang terjadi atau kondisi yang mendahului munculnya masalah ini?",
		// 	2 => "Langkah 2: Pemeriksaan Pemicu\nAdakah faktor tertentu—baik internal atau eksternal—yang mungkin berkontribusi terhadap munculnya masalah ini?",
		// 	3 => "Langkah 3: Dampak dan Pola\nBagaimana dampak masalah ini terhadap Anda? Apakah Anda melihat pola atau kejadian serupa sebelumnya?",
		// 	4 => "Langkah 4: Akar Masalah\nJika Anda melihat lebih dalam, apa yang menurut Anda menjadi akar utama dari masalah ini?",
		// 	5 => "Langkah 5: Solusi\nLangkah apa yang paling realistis dan bermakna yang bisa Anda ambil untuk mulai menyelesaikan masalah ini?"
		// ];
		
		// Prompt Faisal Awal buat - Disable karena kurang deep
		// $messages = [
		// 	[
		// 		'role' => 'system',
		// 		'content' => "Anda adalah seorang coach problem solving yang memfasilitasi user dengan teknik coaching secara bertahap. Jangan memberi jawaban langsung, hanya ajukan satu pertanyaan reflektif tiap langkah, dan gunakan nada empatik. Jika user memberikan pertanyaan ke enam maka langsung berikan solusi terakhir untuk menutup coaching ini."
		// 	]
		// ];

		// Prompt dari Mas Anggi
		$coaching_steps = [
			1 => "Langkah 1: Identifikasi Fakta dan Konteks\nApa saja fakta atau data objektif yang Anda ketahui terkait situasi ini? Variabel apa saja yang terlibat sebelum masalah ini muncul?",
			2 => "Langkah 2: Analisis Penyebab\nJika Anda pecah masalah ini menjadi bagian-bagian kecil, faktor mana yang paling berpengaruh? Apakah ada hubungan sebab-akibat yang bisa Anda identifikasi?",
			3 => "Langkah 3: Evaluasi Dampak dan Pola\nBagaimana masalah ini memengaruhi proses, hasil, atau pihak lain? Apakah Anda menemukan pola berulang atau kejadian serupa di masa lalu?",
			4 => "Langkah 4: Formulasi Akar Masalah\nJika Anda gunakan pendekatan seperti 5 Whys atau Fishbone Diagram secara mental, apa kemungkinan akar penyebab yang paling masuk akal?",
			5 => "Langkah 5: Strategi Pemecahan Masalah\nBerdasarkan pemahaman Anda, pendekatan atau solusi alternatif apa saja yang mungkin dicoba? Mana yang paling rasional untuk diuji pertama kali?"
		];

		// Prompt dari Mas Anggi
		$messages = [
			[
				'role' => 'system',
				'content' => "Anda adalah seorang coach problem solving dengan pendekatan analitis. Tugas Anda adalah memfasilitasi user dalam memecah masalah, mengidentifikasi akar penyebab, dan menyusun alternatif solusi secara logis dan sistematis.
							Untuk setiap langkah, ajukan satu pertanyaan eksploratif yang mendorong user berpikir kritis dan analitis. Jangan memberi saran atau jawaban. Jangan gunakan bahasa emosional; fokus pada data, logika, dan hubungan sebab-akibat.
							Jika user sudah mencapai langkah ke-6, bantu dia menyimpulkan kesimpulan akhir dan rencana tindakan logis yang akan diambil."
			]
		];

		// // Prompt Devina 4M
		// $coaching_steps = [
		// 	1 => "Langkah 1 (Man): Apakah masalah ini berkaitan dengan manusia — seperti kurangnya pelatihan, motivasi, atau komunikasi?",
		// 	2 => "Langkah 2 (Method): Apakah ada prosedur, instruksi kerja, atau metode yang tidak sesuai atau tidak dijalankan dengan benar?",
		// 	3 => "Langkah 3 (Material): Apakah material atau bahan yang digunakan memiliki cacat, tidak sesuai spesifikasi, atau berubah dari standar?",
		// 	4 => "Langkah 4 (Machine): Apakah peralatan atau mesin mengalami gangguan, keterbatasan teknis, atau tidak digunakan dengan benar?",
		// 	5 => "Langkah 5: Berdasarkan jawaban sebelumnya, ajukan pertanyaan diagnostik tambahan (YA/TIDAK) untuk menggali lebih dalam akar penyebab utama.",
		// 	6 => "Langkah 6: Dari keempat aspek (Man, Method, Material, Machine), yang mana paling berkontribusi terhadap masalah? Jelaskan secara singkat alasannya."
		// ];		

		// $messages = [
		// 	[
		// 		'role' => 'system',
		// 		'content' => "Anda adalah asisten AI yang menggunakan framework 4M (Man, Method, Material, Machine) untuk menganalisis dan menyelesaikan permasalahan secara sistematis. 
		// 			Jawablah hanya dengan pertanyaan diagnostik YA/TIDAK berdasarkan konteks, tanpa opini atau saran. 
		// 			Ajukan pertanyaan bertahap berdasarkan urutan: Man → Method → Material → Machine.
		// 			Di langkah ke-5, bantu user menggali lebih dalam aspek yang paling mencurigakan dengan pertanyaan tambahan berbasis YA/TIDAK.
		// 			Di langkah ke-6, bantu user menyebutkan faktor utama penyebab masalah beserta alasan singkatnya dan beri pertanyaan diagnostik yang relevan berdasarkan konteks masalah.
		// 			Jika user sudah mencapai langkah ke-7, berikan ringkasan dan rencana tindak lanjut atau rekomendasi perbaikan yang lebih detail. Lalu ajukan pertanyaan solusi yang akan diimplementasikan."
		// 	]
			
		// ];		
		// // End Prompt Devina 4M
		

// 		// Prompt dari PDCA
// 		$coaching_steps = [
// 			1 => "Langkah 1: Identifikasi Konteks dan Ruang Lingkup Masalah\nCeritakan secara detail situasi atau permasalahan yang sedang Anda hadapi. Sebutkan juga konteks waktu, tempat, dan pihak-pihak yang terlibat. Aspek apa saja dari operasional yang terpengaruh?",
// 			2 => "Langkah 2: Analisis Faktor 4M (Man-Method-Material-Machine)\nBerdasarkan konteks dan domain masalah yang Anda sampaikan, mari kita telusuri faktor-faktor berikut yang relevan:\n\n*MAN (SDM):* Bagaimana aspek kompetensi, kinerja, motivasi, atau kapasitas tim yang terlibat?\n\n*METHOD (Proses/Strategi):* Apakah pendekatan, prosedur, target, atau strategi yang digunakan sudah efektif dan sesuai konteks?\n\n*MATERIAL (Sumber Daya/Aset):* Bagaimana kondisi sumber daya yang dibutuhkan? Contoh: untuk Marketing (produk, konten, budget), untuk Produksi (bahan baku, inventory), untuk IT (data, infrastruktur), untuk Finance (modal, likuiditas)?\n\n*MACHINE (Tools/Sistem):* Apakah peralatan, teknologi, platform, atau sistem yang digunakan mendukung pencapaian tujuan secara optimal?",
// 			3 => "Langkah 3: Evaluasi Dampak dan Pola Masalah\nBagaimana masalah ini mempengaruhi produktivitas, kualitas hasil, atau stakeholder lainnya? Apakah masalah serupa pernah terjadi sebelumnya? Jika ya, bagaimana pola kemunculannya dan apa yang dilakukan saat itu?",			
// 			4 => "Langkah 4: Identifikasi Akar Penyebab Utama\nDari analisis 4M yang telah dilakukan, faktor mana yang paling dominan berkontribusi terhadap masalah? Gunakan pendekatan 5 Whys untuk menggali lebih dalam: mengapa masalah ini terjadi, dan mengapa penyebab tersebut bisa muncul?",
// 			5 => "Langkah 5: Formulasi Solusi dan Rencana Tindakan\nBerdasarkan akar masalah yang teridentifikasi, solusi apa saja yang dapat diterapkan pada masing-masing aspek 4M yang relevan? Prioritaskan solusi mana yang paling feasible dan berdampak tinggi untuk diimplementasikan terlebih dahulu, beserta timeline, resources, dan metrik keberhasilan yang jelas."
// 		];

// 		// Prompt dari PDCA
// 		$messages = [
// 			[
// 				'role' => 'system',
// 				'content' => "ole: AI Problem-Solving Assistant
// Anda adalah asisten AI yang menggunakan framework 4M (Man, Method, Material, Machine) untuk menganalisis dan menyelesaikan permasalahan secara sistematis. INGAT INI DAN JAWAB SETERUSNYA DENGAN FORMAT YES/NO QUESTION SAJA SAMPAI SAYA MENGHAPUS MEMORY.
// Instruksi Kerja:

// Input: User akan menyampaikan issue atau permasalahan
// Output: Berikan pertanyaan diagnostik yang relevan berdasarkan konteks masalah menggunakan framework di bawah ini
// Prinsip: Tanyakan hanya aspek yang relevan dengan masalah yang disampaikan user


// Framework Analisis Masalah (4M)
// 1. MAN (Sumber Daya Manusia)
// a. Kualitas SDM

// Apakah skor psikotes karyawan sesuai dengan kualifikasi yang dibutuhkan?
// Apakah hasil tes DISC menunjukkan kesesuaian dengan posisi/peran?
// Apakah latar belakang pendidikan dan pengalaman kerja relevan dengan tugas?

// b. Kompetensi & Training

// Apakah gap kompetensi sudah teridentifikasi dan ditutup?
// Apakah program training wajib sudah diselesaikan?
// Apakah hasil evaluasi kompetensi menunjukkan standar yang memadai?

// c. Disiplin & Kinerja

// Bagaimana tingkat kehadiran dan ketepatan waktu?
// Apakah ada riwayat pelanggaran atau sanksi?
// Apakah ada faktor eksternal (personal/keluarga) yang mempengaruhi kinerja?

// 2. METHOD (Metode & Proses)
// a. Target & Objektif

// Apakah target kerja sudah jelas dan terkomunikasi dengan baik?
// Apakah target menggunakan kriteria SMART (Specific, Measurable, Achievable, Relevant, Time-bound)?
// Apakah target sudah dijabarkan menjadi aktivitas operasional yang konkrit?

// b. Standar Operasional

// Apakah ada SOP (Standard Operating Procedure) yang jelas?
// Apakah standar kerja sudah dikomunikasikan ke semua pihak terkait?
// Apakah ada aturan dan batasan kewenangan yang jelas?
// Apakah standar tersebut masih relevan dengan kondisi saat ini?

// c. Kebijakan & Regulasi

// Apakah ada kebijakan yang mengatur proses kerja?
// Apakah kebijakan tersebut diimplementasikan secara konsisten?
// Apakah ada mekanisme monitoring kepatuhan terhadap kebijakan?

// d. Sistem Pengukuran

// Apakah ada KPI (Key Performance Indicator) yang terukur?
// Apakah indikator kinerja relevan dengan hasil yang diharapkan?
// Apakah sistem pengukuran memberikan feedback yang actionable?

// e. Monitoring & Kontrol

// Apakah ada tools atau sistem untuk monitoring real-time?
// Apakah ada PIC (Person in Charge) yang bertanggung jawab mengawasi?
// Apakah ada mekanisme eskalasi ketika terjadi deviasi?

// 3. MATERIAL (Bahan & Input)
// a. Kualitas Material

// Apakah kualitas bahan baku/input memenuhi standar yang ditetapkan?
// Apakah ada proses quality control untuk material yang masuk?

// b. Ketersediaan & Supply

// Apakah kuantitas material mencukupi kebutuhan operasional?
// Apakah ada backup plan ketika terjadi shortage material?
// Apakah timing supply sesuai dengan jadwal produksi/operasional?

// 4. MACHINE (Peralatan & Sistem)
// a. Tools & Equipment

// Apakah tools kerja tersedia dalam kondisi baik dan memadai?
// Apakah spesifikasi peralatan sesuai dengan standar operasional?
// Apakah ada program maintenance preventif yang rutin?

// b. Sistem & Technology

// Apakah sistem IT/software yang digunakan mendukung proses kerja?
// Apakah sistem berjalan stabil dan reliable?
// Apakah ada backup system ketika terjadi gangguan?
// Apakah integrasi antar sistem berjalan dengan baik?


// Panduan Penggunaan:

// Fokus pada konteks: Hanya tanyakan aspek yang relevan dengan masalah yang disampaikan
// Prioritas: Mulai dari aspek yang paling mungkin menjadi akar masalah
// Bertahap: Ajukan 3-5 pertanyaan kunci terlebih dahulu, lalu lanjutkan berdasarkan jawaban user, lalu kamu analisa file dokumen/evidence yang diupload
// Actionable: Pastikan pertanyaan mengarah pada solusi yang dapat diimplementasikan, dan tanyakan dengan pertanyaan sederhana

// sebelum menjawab anda harus cek apakah user/saya sudah menanyakan hal dengan konteks yang sama atau tidak?, kalau sudah, kasih tau user/saya bahwa saya sudah menanyakan itu dengan konteks yang sama. hai ini untuk mengetahui apakah saya mengalami masalah berulang atau tidak"
// 			]
// 		];
		
		// Ambil data dari database berdasarkan nomor problem solving
		$this->db->where('no_ps', $no_ps);
		$data = $this->db->get('ai_problem_solving')->row_array();
		
		// Masukkan masalah awal
		$messages[] = ['role' => 'user', 'content' => $data['problem']];
		$messages[] = ['role' => 'assistant', 'content' => $data['rekom_why_1'] ?? ''];
		
		// Loop jawaban dan respon coaching sebelumnya hingga step-1
		for ($i = 2; $i < (int)$step; $i++) {
			$messages[] = ['role' => 'user', 'content' => $data['why_' . ($i - 1)] ?? ''];
			$messages[] = ['role' => 'assistant', 'content' => $data['rekom_why_' . $i] ?? ''];
		}
		
		// Jika step masih dalam 1–6, tambahkan pertanyaan sesuai step
		if ((int)$step < 7) {
			$messages[] = [
				'role' => 'assistant',
				'content' => $coaching_steps[$step]
			];
		} else {
			// Langkah ke-7: Ringkasan otomatis (bisa dikembangkan jadi dinamis jika dibutuhkan)
			// $summary = "✅ Proses coaching selesai. Anda telah melalui seluruh langkah refleksi.\n\nBerikut ringkasan proses Anda:\n";
			// $summary .= "🔹 Masalah: " . ($data['problem'] ?? '-') . "\n";
			// for ($i = 1; $i < 6; $i++) {
			// 	$summary .= "🔸 Langkah $i: " . ($data['why_' . $i] ?? '-') . "\n";
			// }

			// Devina  4M
			$summary = "✅ Proses diagnosis selesai. Anda telah menganalisis keempat aspek (Man, Method, Material, Machine) dan menyampaikan pendapat akhir.\n\nBerikut ringkasan proses Anda:\n";
			$summary .= "🔹 Masalah: " . ($data['problem'] ?? '-') . "\n";
			$summary .= "🔸 Man: " . ($data['why_1'] ?? '-') . "\n";
			$summary .= "🔸 Method: " . ($data['why_2'] ?? '-') . "\n";
			$summary .= "🔸 Material: " . ($data['why_3'] ?? '-') . "\n";
			$summary .= "🔸 Machine: " . ($data['why_4'] ?? '-') . "\n";
			$summary .= "🔸 Analisa akhir: " . ($data['why_5'] ?? '-') . "\n";
			// End Devina 4M


			$summary .= "\nApakah Anda ingin menyimpan hasil ini atau memulai proses baru?";
			$messages[] = ['role' => 'assistant', 'content' => $summary];
		}
		
		// Tambahkan input user terbaru
		$messages[] = ['role' => 'user', 'content' => $message];		
		

        $data = [
            'model' => 'gpt-4.1',
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 2048,
            'top_p' => 1,
            'frequency_penalty' => 0.2,
            'presence_penalty' => 0.3
        ];


        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        return $response['choices'][0]['message']['content'] ?? "No response.";
    }
	// End Ai for Coaching

	function check_issue()
	{
		// Load the database library
		$this->load->database();

		// Get the id_mom and id_issue from the request
		$id_mom = $this->input->post('id_mom');
		$id_issue = $this->input->post('id_issue');

		// Query to check the issue from mom_issue table
		$this->db->where('id_mom', $id_mom);
		$this->db->where('id_issue', $id_issue);
		$query = $this->db->get('mom_issue');

		// Check if the issue exists
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			echo json_encode(['status' => 'success', 'data' => $result]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Issue not found.']);
		}
	}

	function get_result()
	{
		$no_ps = $this->input->post('no_ps');

		$this->db->where('no_ps', $no_ps);
		$query = $this->db->get('ai_problem_solving');

		if ($query->num_rows() > 0) {
			$result = $query->row_array();
			echo json_encode(['status' => 'success', 'data' => $result]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Data not found.']);
		}
	}
}
