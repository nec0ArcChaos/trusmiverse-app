<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whistleblower_api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_trusmi_wb", "model");
        // if ($this->session->userdata('user_id') != "") {
        // } else {
        //     redirect('login', 'refresh');
        // }
    }

    public function test_hit()
    {
        echo json_encode(['message' => 'response test ok']);
    }

    public function index()
    {
        $data['pageTitle']        = "Whistleblower";
        $data['js']               = "whistleblower/js";
        $data['css']              = "whistleblower/css";
        $data['content']          = "whistleblower/index";
        $data['company']          = $this->model->getCompany();
        $data['wb_aktivitas']     = $this->model->getWbAktivitas();
        $data['wb_pertanyaan']    = $this->model->getWbPertanyaan();
        $data['department']       = $this->model->getDepartmentActive();
        $this->load->view('whistleblower/main', $data);
    }

    public function getWbPertanyaan()
    {
        $data = $this->model->getWbPertanyaan();
        $this->output
            ->set_content_type('application/json') // Set header Content-Type
            ->set_output(json_encode($data)); // Encode data ke JSON
    }

    public function getEmployee()
    {
        $id = $this->input->post('department_id');
        $data = $this->model->getEmployee($id);
        echo json_encode($data);
    }

    function generate_id_wb()
    {
        $q = $this->db->query("SELECT
	MAX( RIGHT ( trusmi_t_wb.id_wb, 3 ) ) AS kd_max 
FROM
	trusmi_t_wb 
WHERE
	DATE ( trusmi_t_wb.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return 'WB' . date('ymd') . $kd;
    }

    public function add_wb()
    {
        $id = $this->input->post('id_wb');
        $id_wb = $this->generate_id_wb();
        // var_dump($id);
        // die();
        if ($id == "") {
            $data = array(
                'id_wb' => $id_wb,
                'laporan' => $this->input->post('laporan'),
                'department_id' => $this->input->post('department_id'),
                'employee_id' => $this->input->post('employee_id'),
                'tgl_temuan' => $this->input->post('tgl_temuan'),
                'id_aktivitas' => $this->input->post('id_aktivitas'),
                'note_other' => $this->input->post('note_other'),
                'kronologi' => $this->input->post('kronologi'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id')
            );
            $response['status'] = $this->db->insert('trusmi_t_wb', $data);
            $response['message'] = "Success add data";
            $response['id_wb'] = $id_wb;
        } else {
            $data = array(
                'id_wb' => $id,
                'laporan' => $this->input->post('laporan'),
                'department_id' => $this->input->post('department_id'),
                'employee_id' => $this->input->post('employee_id'),
                'tgl_temuan' => $this->input->post('tgl_temuan'),
                'id_aktivitas' => $this->input->post('id_aktivitas'),
                'note_other' => $this->input->post('note_other'),
                'kronologi' => $this->input->post('kronologi')
            );

            $this->db->where('id_wb', $id);
            $response['status'] = $this->db->update('trusmi_t_wb', $data);
            $response['message'] = "Success add data";
            $response['id_wb'] = $id;
        }
        echo json_encode($response);
    }

    public function add_wb_2()
    {
        $id = $this->input->post('id_wb');
        $hubungan = $this->input->post('hubungan');
        $file_name = "";

        if (!is_dir('./uploads/wb_files/')) {
            mkdir('./uploads/wb_files/', 0775, true);
        }

        // Cek jika ada file yang diunggah
        if (!empty($_FILES['bukti']['name'])) {
            // Konfigurasi unggah file
            $config['upload_path']   = './uploads/wb_files/';
            $config['allowed_types'] = '*'; // Anda dapat membatasi jenis file, contoh: 'gif|jpg|png|jpeg|pdf'
            $config['file_name']     = $id . '_' . time(); // Format nama file
            $config['max_size']      = 2048; // Maksimum ukuran file dalam KB (opsional)

            // Load library upload dengan konfigurasi
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('bukti')) {
                // Jika upload gagal, kembalikan pesan error
                $response = [
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ];
                echo json_encode($response);
                return;
            } else {
                // Jika upload berhasil, ambil nama file
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            }
        }
        if ($hubungan == 1) {
            $data = array(
                'lokasi' => $this->input->post('lokasi'),
                'kota' => $this->input->post('kota'),
                'hubungan' => $hubungan,
                'company_terkait' => $this->input->post('company_terkait'),
                'department_terkait' => $this->input->post('department_terkait'),
                'informasi' => $this->input->post('informasi'),
                'bukti' => $file_name
            );
        } else {
            $data = array(
                'lokasi' => $this->input->post('lokasi'),
                'kota' => $this->input->post('kota'),
                'hubungan' => $hubungan,
                'informasi' => $this->input->post('informasi'),
                'bukti' => $file_name
            );
        }
        $this->db->where('id_wb', $id);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";
    }

    public function getDepartmentByCompany()
    {
        $id = $this->input->post('company_id');
        $data = $this->model->getDepartmentByCompany($id);
        echo json_encode($data);
    }

    public function savePertanyaan()
    {
        // Ambil data dari request
        $data = json_decode(file_get_contents('php://input'), true);

        if (is_array($data)) {
            foreach ($data as $item) {
                // Siapkan data untuk disimpan
                $insertData = array(
                    'id_wb' => $item['id_wb'],
                    'id_pertanyaan' => $item['id_pertanyaan'],
                    'jawaban' => $item['jawaban'],
                    'pertanyaan' => $item['pertanyaan'],
                );

                // Cek apakah data dengan id_wb dan id_pertanyaan sudah ada
                $this->db->where('id_wb', $item['id_wb']);
                $this->db->where('id_pertanyaan', $item['id_pertanyaan']);
                $query = $this->db->get('trusmi_t_wb_pertanyaan');

                if ($query->num_rows() > 0) {
                    // Jika data sudah ada, lakukan update
                    $this->db->where('id_wb', $item['id_wb']);
                    $this->db->where('id_pertanyaan', $item['id_pertanyaan']);
                    $this->db->update('trusmi_t_wb_pertanyaan', $insertData);
                } else {
                    // Jika data belum ada, lakukan insert
                    $this->db->insert('trusmi_t_wb_pertanyaan', $insertData);
                }
            }

            // Beri respons sukses
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success', 'message' => 'Data berhasil disimpan atau diperbarui')));
        } else {
            // Beri respons error
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Data tidak valid')));
        }
    }

    public function finish()
    {
        $id = $this->input->post('id_wb');
        $persetujuan = $this->input->post('persetujuan');
        $data = array(
            'persetujuan' => $persetujuan
        );
        $this->db->where('id_wb', $id);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";
        echo json_encode($response);
    }

    public function getListWb()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $response['data'] = $this->model->getListWb($start, $end);
        echo json_encode($response);
    }
}
