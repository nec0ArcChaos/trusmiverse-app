<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_sistem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_review_sistem', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Review Sistem";
        $data['css']              = "review_sistem/css";
        $data['js']               = "review_sistem/js";
        $data['content']          = "review_sistem/index";
        $data['company']         = $this->model->get_company();
        $data['aplikasi']         = $this->model->get_aplikasi();
        $this->load->view('layout/main', $data);
    }
    function get_data()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_data($start, $end);
        echo json_encode($data);
    }

    function get_list_detail()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->get_list_detail($start, $end);
        echo json_encode($data);
    }

    function get_detail()
    {
        $id = $_POST['id'];
        $data['data'] = $this->model->get_detail($id);
        echo json_encode($data);
    }

    function get_company()
    {
        $data = $this->model->get_company();
        echo json_encode($data);
    }

    function get_department($id)
    {
        $data = $this->model->get_department($id);
        echo json_encode($data);
    }

    function get_head($department)
    {
        $data = $this->model->get_head($department);
        echo json_encode($data);
    }

    function get_aplikasi()
    {
        $data = $this->model->get_aplikasi();
        echo json_encode($data);
    }

    function get_navigation($id)
    {
        $data['data'] = $this->model->get_navigation($id);
        echo json_encode($data);
    }

    function get_navigation_temp()
    {
        $data['data'] = $this->model->get_navigation_temp();
        echo json_encode($data);
    }

    function simpan_temp()
    {
        // Generate ID untuk review
        $id = $this->model->generate_id_review();
        $file_name = "";

        if (!is_dir('./uploads/review_file/')) {
            mkdir('./uploads/review_file/', 0775, true);
        }

        // Cek jika ada file yang diunggah
        if (!empty($_FILES['attachment']['name'])) {
            // Konfigurasi unggah file
            $config['upload_path']   = './uploads/review_file/';
            $config['allowed_types'] = '*'; // Anda dapat membatasi jenis file, contoh: 'gif|jpg|png|jpeg|pdf'
            $config['file_name']     = $id . '_' . time(); // Format nama file
            $config['max_size']      = 2048; // Maksimum ukuran file dalam KB (opsional)

            // Load library upload dengan konfigurasi
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('attachment')) {
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

        // Data yang akan disimpan
        $item = [
            'id_navigation' => $this->input->post('id_navigation'),
            'attachment'    => $file_name,
            'created_by'    => $this->session->userdata('user_id'),
        ];

        // Insert ke database
        $insert = $this->db->insert('review_temp', $item);

        if ($insert) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.'
            ];
        }

        echo json_encode($response);
    }

    function hapus_temp()
    {
        $id = $_POST['id'];
        $file_data = $this->db->get_where('review_temp', ['id' => $id])->row();

        if ($file_data) {
            $file_name = $file_data->attachment;
            $delete = $this->db->delete('review_temp', ['id' => $id]);

            if ($delete) {

                if (!empty($file_name) && file_exists('./uploads/review_file/' . $file_name)) {
                    unlink('./uploads/review_file/' . $file_name);
                }

                $response = [
                    'status' => 'success',
                    'message' => 'Data berhasil dihapus.'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Data gagal dihapus.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ];
        }

        echo json_encode($response);
    }

    function jumlah_temp()
    {
        $user = $this->session->userdata('user_id');
        $data  = $this->model->jumlah_temp($user);
        echo json_encode($data);
    }

    function jumlah_pic()
    {
        $id = $_POST['id'];
        $data = $this->model->jumlah_pic($id);
        echo json_encode($data);
    }

    function simpan_review()
    {
        $id_review = $this->model->generate_id_review();
        $review = array(
            'id_review' => $id_review,
            'company_id' => $_POST['company'],
            'department_id' => $_POST['department'],
            'head_id' => $_POST['head'],
            'deadline_head' => $_POST['deadline_head'],
            'created_by' => $this->session->userdata('user_id'),
            'created_at' => date("Y-m-d H:i:s")
        );
        $data['insert_review_menu'] =  $this->db->insert('review_t_menu', $review);

        // Insert into t_distribusi_item
        foreach ($this->input->post('id_navigation') as $key => $value) {
            $item = array(
                'id_review'      => $id_review,
                'id_navigation' => $_POST['id_navigation'][$key],
                'attachment' => $_POST['attachment'][$key],
                'created_by'    => $this->session->userdata('user_id'),
                'created_at'      => date("Y-m-d H:i:s")
            );
            $data['insert_review_menu_item'] = $this->db->insert('review_t_menu_item', $item);
        }
        // Delete temp
        $data['delete_temp'] = $this->db->where('created_by', $this->session->userdata('user_id'))->delete('review_temp');

        if ($data['insert_review_menu'] && $data['insert_review_menu_item'] && $data['delete_temp']) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data gagal disimpan!'
            ];
        }

        echo json_encode($response);
    }

    function list_review_head()
    {
        $data['data'] = $this->model->list_review_head();
        echo json_encode($data);
    }

    function list_review_head_item($id)
    {
        $data['data'] = $this->model->list_review_head_item($id);
        echo json_encode($data);
    }

    function get_pic($id)
    {
        $data = $this->model->get_pic($id);
        echo json_encode($data);
    }

    // function simpan_pic()
    // {
    //     $id = $_POST['id_item'];
    //     $deadline = $_POST['deadline_pic'];
    //     $today = date("Y-m-d");
    //     $deadline_pic = date("Y-m-d", strtotime("+$deadline days", strtotime($today)));
    //     $review_item = array(
    //         'pic' => $_POST['pic'],
    //         'deadline_pic' => $deadline_pic
    //     );
    //     $data['insert_pic'] =  $this->db->where('id', $id)->update('review_t_menu_item', $review_item);

    //     if ($data['insert_pic']) {
    //         $response = [
    //             'status' => 'success',
    //             'message' => 'Data berhasil disimpan!'
    //         ];
    //     } else {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Data gagal disimpan!'
    //         ];
    //     }

    //     echo json_encode($response);
    // }

    // function simpan_head()
    // {
    //     $id_review = $_POST['id_review'];

    //     $review_t_menu = array(
    //         'head_by' => $this->session->userdata('user_id'),
    //         'head_at' => date("Y-m-d H:i:s")
    //     );
    //     $data['add_head'] =  $this->db->where('id_review', $id_review)->update('review_t_menu', $review_t_menu);
    //     echo json_encode($data);
    // }

    public function simpan_head()
    {
        $id_review = $this->input->post('id_review');
        $pic_data = json_decode($this->input->post('pic_data'), true);

        // var_dump($pic_data);
        // die();
        // Update 'head_by' and 'head_at' in 'review_t_menu'
        $review_t_menu = array(
            'head_by' => $this->session->userdata('user_id'),
            'head_at' => date("Y-m-d H:i:s")
        );
        $update_head = $this->db->where('id_review', $id_review)->update('review_t_menu', $review_t_menu);

        // Process each PIC and Deadline PIC for related items
        $pic_results = [];
        foreach ($pic_data as $item) {
            $id_item = $item['id_item'];
            $pic = $item['pic'];
            $deadline = $item['deadline_pic'];

            $today = date("Y-m-d");
            $deadline_pic = date("Y-m-d", strtotime("+$deadline days", strtotime($today)));

            $review_item = array(
                'pic' => $pic,
                'deadline_pic' => $deadline_pic
            );

            $pic_results[] = $this->db->where('id', $id_item)->update('review_t_menu_item', $review_item);
        }

        // Prepare response
        $all_success = $update_head && !in_array(false, $pic_results, true);

        if ($all_success) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data gagal disimpan!'
            ];
        }

        echo json_encode($response);
    }


    function get_list_pic()
    {
        $data['data'] = $this->model->get_list_pic();
        echo json_encode($data);
    }

    function get_status()
    {
        $data = $this->model->get_status();
        echo json_encode($data);
    }

    function get_sesuai()
    {
        $data = $this->model->get_sesuai();
        echo json_encode($data);
    }

    function get_impact_category()
    {
        $data = $this->model->get_impact_category();
        echo json_encode($data);
    }

    public function simpan_pic_check()
    {

        $id = $this->input->post('id_item_check');


        $pic_by = $this->session->userdata('user_id');



        $impact_category = $this->input->post('impact_category');


        if (is_array($impact_category)) {
            $impact_category = implode(',', $impact_category);
        } else {
            $impact_category = '';
        }


        $review_item = array(
            'status' => $this->input->post('status'),
            'impact' => $this->input->post('impact'),
            'impact_category' => $impact_category,
            'note' => $this->input->post('note'),
            'improvement' => $this->input->post('improvement'),
            'kepuasan_aplikasi' => $this->input->post('kepuasan_aplikasi'),
            'kesesuaian_aplikasi' => $this->input->post('kesesuaian_aplikasi'),
            'impact_system' => $this->input->post('status_sistem'),
            'kesesuaian_uiux' => $this->input->post('kesesuaian_uiux'),
            'improve_ui' => $this->input->post('ui'),
            'improve_ux' => $this->input->post('ux'),
            'pic_by' => $pic_by,
            'pic_at' => date("Y-m-d H:i:s"),
        );


        $this->db->where('id', $id);
        $data['insert_pic_check'] = $this->db->update('review_t_menu_item', $review_item);


        if ($data['insert_pic_check']) {
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data gagal disimpan!'
            ];
        }


        echo json_encode($response);
    }
}
