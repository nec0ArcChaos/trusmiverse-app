<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_candidates extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_job_candidates', 'model');
        $this->load->model("model_profile");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index($job_id = null)
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Auto Screening - Job Candidates";
        $data['css'] = "recruitment/job_candidates/css_ai";
        $data['js'] = "recruitment/job_candidates/js_ai";
        $data['content'] = "recruitment/job_candidates/index_ai";
        $data['assessment'] = $this->model->get_list_test();


        $data['alasan'] = $this->model->get_alasan('database');

        if ($job_id != null) {
            $data['job_id'] = $job_id;
        }

        $this->load->view('layout/main', $data);
    }
    // new development
    function index_ai($job_id = null)
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Auto Screening - Job Candidates";
        $data['css'] = "recruitment/job_candidates/css_ai";
        $data['js'] = "recruitment/job_candidates/js_ai";
        $data['content'] = "recruitment/job_candidates/index_ai";
        $data['assessment'] = $this->model->get_list_test();

        $data['alasan'] = $this->model->get_alasan('database');

        if ($job_id != null) {
            $data['job_id'] = $job_id;
        }

        $this->load->view('layout/main', $data);
    }
    // end new development
    function get_candidates()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        if (isset($_POST['id'])) {
            $data['data'] = $this->model->get_candidates($start, $end, $_POST['id']);
        } else {
            $data['data'] = $this->model->get_candidates($start, $end);
        }
        echo json_encode($data);
    }
    function get_candidates_by_job()
    {
        $id = $this->uri->segment(4);
        $this->index($id);
    }
    function cover_letter()
    {
        $id = $_POST['id'];
        $data['cover_letter'] = $this->model->cover_letter($id);
        echo json_encode($data);
    }
    function save_status()
    {
        $user_id = $this->session->userdata('user_id');

        $job_id = $_POST['id'];
        $status = $_POST['status'];

        if ($status == 2) {
            $alasan = $_POST['alasan'];
        } else {
            $alasan = null;
        }

        $update = [
            'application_status' => $status,
            'alasan_gagal_join' => $alasan,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id,
            // addnew
            'manual_screening_at' => date('Y-m-d H:i:s'),
            'manual_screening_by' => $user_id,
        ];

        // Tambahan field interview HR jika status = 10 (Interview HR)
        if ($status == 10) {
            $date_interview = $_POST['date_interview_hr'];
            $time_interview = $_POST['time_interview_hr'];
            $update['date_interview_hr'] = $date_interview . ' ' . $time_interview . ':00';
            $update['time_interview_hr'] = $time_interview;
            $update['zoom_link'] = $_POST['zoom_link'];
        }

        
        $this->db->where('application_id', $job_id);
        $data['update'] = $this->db->update('xin_job_applications', $update);

        if ($status == 10 && $data['update']) {
            $job_data = $this->model->get_sla_interview_hr($job_id);
            if ($job_data && $job_data['position_id'] != 8) {
                $data['wa_sent_pic'] = $this->send_wa_interviewhr_pic($job_id);
                $data['wa_sent_kandidat'] = $this->send_wa_interviewhr_kandidat($job_id);
            } else {
                $data['wa_skipped'] = 'position_id = 8, notifikasi tidak dikirim';
            }
        }

        echo json_encode($data);
    }

    function send_wa_interviewhr_pic($id)
    {
        $data_msg = $this->model->get_sla_interview_hr($id);
        if (!$data_msg) return false;

        $tgl = !empty($data_msg['tgl']) ? $data_msg['tgl'] : '-';
        $pengalaman = !empty($data_msg['masa_kerja_terakhir']) ? $data_msg['masa_kerja_terakhir'] : '-';
        $date_interview = !empty($data_msg['date_interview_hr']) ? date('d M Y', strtotime($data_msg['date_interview_hr'])) : '-';
        $time_interview = !empty($data_msg['time_interview_hr']) ? $data_msg['time_interview_hr'] : '-';
        $zoom_link = !empty($data_msg['zoom_link']) ? $data_msg['zoom_link'] : '-';
        $sla_days = !empty($data_msg['sla_days']) ? $data_msg['sla_days'] : '1';

        // Format pesan WA
        $msg = "👤Alert!!! 

        *Konfirmasi Interview HR*

        📍Posisi : *" . $data_msg['job_title'] . "*
        👤Kandidat : " . $data_msg['full_name'] . "
        📆Jadwal Interview : " . $date_interview . " | " . $time_interview . "
        🔗Zoom Link : " . $zoom_link . "
        📝Detail Kandidat : https://trusmiverse.com/apps/recruitment/interview/detail/" . $data_msg['application_id'] . "#step-1

        

        *Note : Wajib melakukan feedback H+" . $sla_days . " dari notifikasi ini, jika tidak maka akan ter lock absen*";

        // $phone = $data_msg['contact_no_pic']; 
        $phone = "62859106840999"; 
        $tipe  = 'text';
        $url   = '';

        $this->load->library('WAJS_hr');
        $wa_status = $this->wajs_hr->send_wajs_notif_hr($phone, $msg, $tipe, 'trusmiverse', $url);

        log_message('info', 'WA Interview HR [app_id=' . $id . '] status: ' . json_encode($wa_status));

        return $wa_status;
    }

    function send_wa_interviewhr_kandidat($id)
    {
        $data_msg = $this->model->get_sla_interview_hr($id);
        if (!$data_msg) return false;

        $date_interview = !empty($data_msg['date_interview_hr']) ? date('d M Y', strtotime($data_msg['date_interview_hr'])) : '-';
        $time_interview = !empty($data_msg['time_interview_hr']) ? $data_msg['time_interview_hr'] : '-';
        $zoom_link = !empty($data_msg['zoom_link']) ? $data_msg['zoom_link'] : '-';

        $msg = "Halo *" . $data_msg['full_name'] . "*,\n\n"
             . "Terima kasih atas ketertarikan Anda untuk bergabung bersama kami.\n\n"
             . "Kami dengan senang hati mengundang Anda untuk mengikuti *Interview HR* untuk posisi:\n\n"
             . "📍Posisi : *" . $data_msg['job_title'] . "* (" . $data_msg['role_name'] . ")\n"
             . "📆Tanggal : *" . $date_interview . "*\n"
             . "🕐Waktu : *" . $time_interview . " WIB*\n"
             . "🔗Zoom Link : " . $zoom_link . "\n\n"
             . "Mohon hadir tepat waktu dan mempersiapkan diri dengan baik.\n"
             . "Jika ada kendala, silakan hubungi kami melalui nomor ini.\n\n"
             . "Semoga sukses! 🙏";

        // $phone = $data_msg['contact'];
        $phone = "62859106840999";
        $tipe  = 'text';
        $url_image = '';

        $this->load->library('WAJS_eksternal');
        $wa_status = $this->wajs_eksternal->send_wajs_notif_eksternal($phone, $msg, $tipe, 'trusmiverse', $url_image);

        log_message('info', 'WA Interview Kandidat [app_id=' . $id . '] phone=' . $phone . ' status: ' . json_encode($wa_status));

        return $wa_status;
    }

    function get_sla_interview_hr()
    {
        $application_id = $_POST['application_id'];

        $row = $this->model->get_sla_interview_hr($application_id);

        if (!$row) {
            echo json_encode(['error' => 'Data not found']);
            return;
        }

        $sla_days = (int) $row['sla_days'];
        $base_date = date('Y-m-d', strtotime($row['updated_at']));
        $min_date = $base_date;
        $max_date = date('Y-m-d', strtotime($base_date . ' + ' . $sla_days . ' days'));

        echo json_encode([
            'min_date'  => $min_date,
            'max_date'  => $max_date,
            'sla_days'  => $sla_days,
            'role_id'   => $row['role_id'],
            'role_name' => $row['role_name']
        ]);
    }

    function delete_jc()
    {
        $id = $_POST['id'];
        $this->db->where('application_id', $id);
        $data['delete'] = $this->db->delete('xin_job_applications');
        echo json_encode($data);
    }

    function detail_screener()
    {
        $application_id = $this->input->post('application_id');
        $candidate = $this->model->get_detail_screener($application_id);
        $data['candidate'] = $candidate;
        $data['radar'] = $this->model->get_detail_radar($candidate['id_user_talent']);
        $data['radar_cv'] = $this->model->get_detail_radar_cv($application_id);
        $data['matched_profile'] = $this->model->get_profile_match($application_id, 'matched_profile');
        $data['missing_profile'] = $this->model->get_profile_match($application_id, 'missing_profile');
        $data['matched_skills'] = $this->model->get_profile_match($application_id, 'matched_skill');
        $data['missing_skills'] = $this->model->get_profile_match($application_id, 'missing_skill');
        $data['score_detail'] = $this->model->get_score_detail($application_id);
        echo json_encode($data);
    }

    function summary_ella()
    {
        $data['summary'] = $this->model->get_summary_ella();
        $data['top_candidate'] = $this->model->get_top_candidate_this_month();
        echo json_encode($data);
    }
    function akses_test()
    {
        $id_user = $this->input->post('id_user');
        $email = $this->input->post('email');
        $access_array = $this->input->post('access');

        $access_string = '';
        if (!empty($access_array) && is_array($access_array)) {
            $access_string = implode(',', $access_array);
        }
        $this->db->from('talent_pool.t_test_assessment');
        $this->db->where('id_user', $id_user);
        // Jika Anda ingin mengecek berdasarkan id_user ATAU email, gunakan or_where
        $this->db->or_where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $update_data = [
                'access' => $access_string,
                'updated_at' => date('Y-m-d H:i:s') // Tambahkan timestamp update
            ];

            $this->db->where('id_user', $id_user);
            $result = $this->db->update('talent_pool.t_test_assessment', $update_data);
        } else {
            $insert_data = [
                'id_user' => $id_user,
                'email' => $email,
                'access' => $access_string,
                'created_at' => date('Y-m-d H:i:s'), // Tambahkan timestamp create
                'created_by' => $this->session->userdata('user_id'),
            ];
            $result = $this->db->insert('talent_pool.t_test_assessment', $insert_data);
        }

        echo json_encode($result);
    }
    function get_all_test()
    {
        $data = $this->model->get_all_test();

        // 2. Jika tidak ada data, hentikan proses
        if (empty($data)) {
            // Anda bisa menampilkan pesan atau redirect,
            // tapi untuk download, lebih baik hentikan saja.
            echo "Tidak ada data untuk diunduh.";
            return;
        }

        // 3. Tentukan nama file yang akan diunduh
        $filename = 'laporan_test_' . date('Y-m-d') . '.csv';

        // 4. Atur HTTP Headers untuk memicu download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // 5. Buka output stream PHP untuk menulis data
        $output = fopen('php://output', 'w');

        // 6. Tulis baris header CSV (mengambil dari key array pertama)
        // Menggunakan (array) untuk memastikan bekerja baik untuk object maupun array
        fputcsv($output, array_keys((array) $data[0]));

        // 7. Loop dan tulis setiap baris data ke file CSV
        foreach ($data as $row) {
            // Menggunakan (array) untuk mengubah object menjadi array jika perlu
            fputcsv($output, (array) $row);
        }

        // 8. Tutup stream
        fclose($output);

        // 9. Hentikan eksekusi script lebih lanjut
        exit;
    }
}
