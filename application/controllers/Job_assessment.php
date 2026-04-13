<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_assessment extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('Model_job_assessment', 'model');
        $this->load->model("model_profile");
        // if ($this->session->userdata('user_id') != "") {
        //     $user_id = $this->session->userdata('user_id');
        //     $check_hak_akses = $this->auth->check_hak_akses('employees', $user_id);
        //     if ($check_hak_akses != 'allowed') {
        //         redirect('dashboard', 'refresh');
        //     }
        // } else {
        //     redirect('login', 'refresh');
        // }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Job Assessment";
        $data['css']              = "job_assessment/css";
        $data['js']               = "job_assessment/js";
        $data['content']          = "job_assessment/index";
        $data['karyawan'] = $this->model->get_karyawan();
        $data['level'] = $this->model->get_level();
        $data['m_assessment'] = $this->model->get_m_assessment();
        $data['is_spv_up'] = $this->model->get_spv_up($user);
        // var_dump($data['is_spv_up']);die();
        // var_dump($data['is_spv_up']);die();
        $this->load->view('layout/main', $data);
    }
    function get_data()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_data($start, $end);
        echo json_encode($data);
    }
    function get_approval($start, $end)
    {
        $user = $this->session->userdata('user_id');
        $data['data'] = $this->model->get_approval($user, $start, $end);
        echo json_encode($data);
    }
    public function no_asm()
    {
        $q = $this->db->query("SELECT
			MAX( RIGHT ( trusmi_assessment.id_assessment, 2 ) ) AS as_max 
			FROM
			trusmi_assessment 
			WHERE
			SUBSTR( trusmi_assessment.created_at, 1, 7 ) = LEFT(CURDATE(),7)");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->as_max) + 1;
                $kd = sprintf("%02s", $tmp);
            }
        } else {
            $kd = "01";
        }
        return 'AS' . date('ymd') . $kd;
    }
    function get_karyawan()
    {
        $data = $this->model->get_karyawan();
        echo json_encode($data);
    }
    function save()
    {
        $no_asm = $this->no_asm();
        $user_id = $this->input->post('karyawan');
        $data_1 = [
            'id_assessment' => $no_asm,
            'user_id' => $user_id,
            'from' => $this->input->post('level_from'),
            'to' => $this->input->post('level_to'),
            'due_date' => $this->input->post('due_date'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $this->model->save('trusmi_assessment', $data_1);

        $data_2 = [
            'id' => '',
            'id_assessment' => $no_asm,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
        ];
        $hasil = $this->model->save('trusmi_assessment_hr', $data_2);

        $panelis = $this->input->post('panelis'); // Mengambil array panelis
        $poin_kompetensi = $this->input->post('poin_kompetensi');
        foreach ($panelis as $panelis_id) {
            foreach ($poin_kompetensi as $poin) {
                // Cek apakah poin_kompetensi tidak kosong atau null
                if (!empty($poin)) {
                    $data_3 = [
                        'id' => '',
                        'id_assessment' => $no_asm,
                        'panelis_id' => $panelis_id, // Set panelis_id untuk setiap panelis
                        'poin_kompetensi' => $poin, // Set poin_kompetensi untuk setiap poin
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                    ];
                    $this->db->insert('trusmi_assessment_panelis', $data_3);
                }
            }
        }
        echo json_encode($hasil);
    }
    public function update_psikotest()
    {
        $id = $this->input->post('id_assessment');

        $data = [
            'army_alpha' => $this->input->post('army_alpha'),
            'cfit' => $this->input->post('cfit'),
            'iq' => $this->input->post('iq'),
            'tiu' => ($this->input->post('tiu') == 'Tidak Ada Data') ? null : $this->input->post('tiu'),
            'disc' => ($this->input->post('disc') == 'Tidak Ada Data') ? null : $this->input->post('disc'),
            'mbti' => ($this->input->post('mbti') == 'Tidak Ada Data') ? null : $this->input->post('mbti'),
            'keterangan' => $this->input->post('keterangan'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('user_id'),
        ];
        $hasil = $this->model->update_psikotest($data, $id, $this->input->post('keterangan'));
        echo json_encode($hasil);
    }
    function data_for_panelis()
    {
        $data['data'] = $this->model->data_for_panelis();
        echo json_encode($data);
    }
    function get_data_panelis()
    {
        $id = $this->input->post('id_assessment');
        $panelis = $this->model->get_data_panelis($id);
        $panelis_data = [];
        $kompetensi = [];

        // Loop through the panelis data
        foreach ($panelis as $row) {
            if (!isset($panelis_data[$row->panelis_id])) {
                $panelis_data[$row->panelis_id] = [
                    'id' => $row->id,
                    'id_assessment' => $row->id_assessment,
                    'panelis_id' => $row->panelis_id,
                    'nama_panelis' => $row->nama_panelis,
                    'status_user' => $row->status_user,
                    'total_nilai' => $row->total_nilai,
                    'status_poin' => $row->status_poin,
                    'rata_rata' => $row->rata_rata,
                    'kompetensi' => []
                ];
            }

            // Add competency point and its value
            $panelis_data[$row->panelis_id]['kompetensi'][$row->poin_kompetensi] = $row->nilai;

            // Track unique competency points
            if (!in_array($row->poin_kompetensi, $kompetensi)) {
                $kompetensi[] = $row->poin_kompetensi;
            }
        }

        // Begin rendering the HTML table
        $html = '<table class="table table-bordered" id="dt_panelis">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>No</th>';
        $html .= '<th>Nama Panelis</th>';
        $html .= '<th>Status</th>';

        // Generate headers dynamically for each competency
        foreach ($kompetensi as $kpt) {
            $html .= '<th>' . $kpt . '</th>';
        }

        $html .= '<th>Total Nilai</th>';
        $html .= '<th>Rata-Rata</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Render panelis data into rows
        $no = 1;
        foreach ($panelis_data as $panelis) {
            if($panelis['status_poin'] == 'Submitted'){
                $status_poin = '<span class="badge bg-light-green text-black"><i class="bi bi-check2-all"></i> '.$panelis['status_poin'].'</span>';
            }else{
                $status_poin = '<span class="badge bg-light-yellow text-black"><i class="bi bi-hourglass-split"></i> '.$panelis['status_poin'].'</span>';
            }
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . $panelis['nama_panelis'] . '</td>';
            $html .= '<td>' . $status_poin . '</td>';

            // Loop through competencies and their respective values
            foreach ($kompetensi as $kpt) {
                $nilai = isset($panelis['kompetensi'][$kpt]) ? $panelis['kompetensi'][$kpt] : '-';
                $html .= '<td>' . $nilai . '</td>';
            }

            $html .= '<td>' . $panelis['total_nilai'] . '</td>';
            $html .= '<td>' . $panelis['rata_rata'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Output JSON response
        echo json_encode($html);
    }
    function get_item_poin()
    {
        $id_assessment = $this->input->post('id_assessment');
        $panelis_id = $this->input->post('panelis_id');
        $data = $this->model->get_item_poin($id_assessment, $panelis_id);
        echo json_encode($data);
    }

    function update_panelis()
    {
        $id = $this->input->post('id_poin');
        $nilai = $this->input->post('nilai');

        foreach ($id as $key => $value) {
            $data = [
                'nilai' => $nilai[$key],
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id', $value);
            $hasil = $this->db->update('trusmi_assessment_panelis', $data);
        }
        echo json_encode($hasil);
    }
    function review_panelis()
    {
        $data = [
            'avg_panelis' => $this->input->post('avg_panelis'),
            'spesifikasi_teknis' => $this->input->post('spesifikasi_teknis'),
            'hasil_panelis' => $this->input->post('hasil_panelis'),
            'updated_by' => $this->session->userdata('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_assessment', $this->input->post('id_assessment'));
        $hasil = $this->db->update('trusmi_assessment', $data);
        echo json_encode($hasil);
    }
    function get_detail($id)
    {
        // Get panelis data
        $panelis = $this->model->get_data_panelis($id);
        $panelis_data = [];
        $kompetensi = [];

        // Loop through the panelis data
        foreach ($panelis as $row) {
            if (!isset($panelis_data[$row->panelis_id])) {
                $panelis_data[$row->panelis_id] = [
                    'id' => $row->id,
                    'id_assessment' => $row->id_assessment,
                    'panelis_id' => $row->panelis_id,
                    'nama_panelis' => $row->nama_panelis,
                    'status_user' => $row->status_user,
                    'total_nilai' => $row->total_nilai,
                    'status_poin' => $row->status_poin,
                    'rata_rata' => $row->rata_rata,
                    'kompetensi' => []
                ];
            }

            // Add competency point and its value
            $panelis_data[$row->panelis_id]['kompetensi'][$row->poin_kompetensi] = $row->nilai;

            // Track unique competency points
            if (!in_array($row->poin_kompetensi, $kompetensi)) {
                $kompetensi[] = $row->poin_kompetensi;
            }
        }

        // Begin rendering the HTML table
        $html = '<table class="table table-bordered" id="tabel_panelis">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>No</th>';
        $html .= '<th>Nama Panelis</th>';
        $html .= '<th>Status</th>';

        // Generate headers dynamically for each competency
        foreach ($kompetensi as $kpt) {
            $html .= '<th>' . $kpt . '</th>';
        }

        $html .= '<th>Total Nilai</th>';
        $html .= '<th>Rata-Rata</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Render panelis data into rows
        $no = 1;
        foreach ($panelis_data as $panelis) {
            if($panelis['status_poin'] == 'Submitted'){
                $status_poin = '<span class="badge bg-light-green text-black"><i class="bi bi-check2-all"></i> '.$panelis['status_poin'].'</span>';
            }else{
                $status_poin = '<span class="badge bg-light-yellow text-black"><i class="bi bi-hourglass-split"></i> '.$panelis['status_poin'].'</span>';
            }
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . $panelis['nama_panelis'] . '</td>';
            $html .= '<td>' . $status_poin . '</td>';

            // Loop through competencies and their respective values
            foreach ($kompetensi as $kpt) {
                $nilai = isset($panelis['kompetensi'][$kpt]) ? $panelis['kompetensi'][$kpt] : '-';
                $html .= '<td>' . $nilai . '</td>';
            }

            $html .= '<td>' . $panelis['total_nilai'] . '</td>';
            $html .= '<td>' . $panelis['rata_rata'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Create final data array
        $data = [
            'detail' => $this->model->get_detail($id),
            'psikotest' => $this->model->hasil_psikotest($id),
            'panelis' => $html
        ];

        // Output the HTML as part of JSON response
        echo json_encode($data);
    }

    public function update_kesimpulan()
    {
        $data = [
            'kesimpulan' => $this->input->post('keterangan'),
            'actual_date' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_assessment', $this->input->post('id_assessment'));
        $hasil = $this->db->update('trusmi_assessment', $data);
        echo json_encode($hasil);
    }
    function get_tiu_disc_mbti()
    {
        $data =  $this->model->get_tiu_disc_mbti($this->input->post('user_id'));
        echo json_encode($data);
    }
}
