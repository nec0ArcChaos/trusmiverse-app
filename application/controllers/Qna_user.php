<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qna_user extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("model_memo", 'model');
        $this->load->model("model_qna_user", 'model1');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $data['pageTitle']        = "Qna User";
        $data['css']              = "qna_user/css";
        $data['content']          = "qna_user/index";
        $data['js']               = "qna_user/js";
        $data['user_id'] = $this->session->userdata("user_id");
        $data['companies'] = $this->model->get_companies();
        $data['roles'] = $this->model->get_role();
        $data['kategori'] = $this->model1->get_kategori();
        $data['pilihopsi'] = $this->model1->get_pilihan_opsi();
        

        $id = $this->session->userdata("user_id");
        if ($id == 1 || $id == 2516 || $id == 2729 || $id == 803 || $id == 6466) {
            $this->load->view('layout/main', $data);
        } else {
            redirect('https://trusmiverse.com/apps/dashboard', 'refresh');
        }
        
    }

    public function get_opsi_by_kategori() {
        $kategori = $this->input->post('kategori');
        $data = [];
        $output = [];
    
        if ($kategori == 'Company') {
            $data = $this->db->get('xin_companies')->result();
            $output = [];
            foreach ($data as $d) {
                $output[] = [
                    'id' => $d->company_id,
                    'nama' => $d->name
                ];
            }
          }elseif ($kategori == 'Department') {
            $data = $this->db->get('xin_departments')->result();
            $output = [];
            foreach ($data as $d) {
                $output[] = [
                    'id' => $d->department_id,
                    'nama' => $d->department_name
                ];
            }
         } elseif ($kategori == 'Specific User') {
            $this->db->select("user_id, CONCAT(first_name, ' ', last_name) as nama");
            $this->db->from("xin_employees");
            $this->db->where("is_active", 1);
            $data = $this->db->get()->result();            
            $output = [];
                foreach ($data as $d) {
                $output[] = [
                    'id' => $d->user_id,
                    'nama' => $d->nama
                ];
            }
         }elseif ($kategori == 'Designation') {
            $data = $this->db->get('xin_designations')->result();
            $output = [];
            foreach ($data as $d) {
            $output[] = [
                'id' => $d->designation_id,
                'nama' => $d->designation_name
            ];
        }
        }
    
       
    
        echo json_encode($output);
    }


    public function get_data_select(){
        $data = $this->db->get('qna_m_type')->result();

    $output = [];
    foreach ($data as $row) {
        $output[] = [
            'id' => $row->id_type,
            'label' => "{$row->a_1} - {$row->a_2} - {$row->a_3} - {$row->a_4} - {$row->a_5}"
        ];
    }

    echo json_encode($output);
    }

    function tambah_qna(){
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $kategori_label = $this->input->post('kategori');
        $kategori = $this->input->post('id_category');    
        $periode = $this->input->post('periode');
        $pilihan_kategori = $this->input->post('pilihan_kategori');
        $session = $this->session->userdata('user_id');

        if (!empty($pilihan_kategori)) {
            $pilihan_kategori = implode(',', $pilihan_kategori); 
        } else {
            $pilihan_kategori = null; 
        }
        $data = [
            'judul' => $judul,
            'pengantar' => $deskripsi,
            'periode_lock' => $periode,
            'company_id' => null,
            // 'id_designation' => null,
            'list_user_id' => null,
            'department_id' => null,
            'category_id' => $kategori,
            'created_at' =>  date('Y-m-d H:i:s'),
            'created_by' => $session
        ];
        
        if ($kategori == 2) {
            $data['company_id'] = $pilihan_kategori;
        } elseif ($kategori == 3) {
            $data['department_id'] = $pilihan_kategori;
        } elseif ($kategori == 4) {
            $data['list_user_id'] = $pilihan_kategori;
        }
        // } elseif ($kategori == 5) {
        //     $data['id_designation'] = $pilihan_kategori;
        // }
        
        $this->db->insert('qna_m_question', $data);
        $qna_id = $this->db->insert_id(); 
  
    $list_job1 = $this->input->post('list_job1'); 
    $list_point1 = $this->input->post('list_point1'); 
    $list_tipe1 = $this->input->post('list_type1'); 
    $list_job = $this->input->post('list_job'); 
    $list_point = $this->input->post('list_point'); 
    $list_tipe = $this->input->post('list_type'); 
    $no_urut1 = $this->input->post('no_urut1');
    $no_urut = $this->input->post('no_urut');

    $no_urut2 = $this->input->post('no_urut2');
    $list_tipe2 = $this->input->post('list_type2'); 
    $list_point2 = $this->input->post('list_point2'); 
    $list_job2 = $this->input->post('list_job2'); 
    
    $dt_a = $this->model1->data_a($list_tipe1);
    $map_type = [];
        foreach ($dt_a as $row) {
            $map_type[$row->id_type] = $row;
        }

        
    

    if ($list_job && $list_point && $list_tipe) {
        for ($i = 0; $i < count($list_job); $i++) {
            $data_detail2 = [
                'question_id' => $qna_id,
                'huruf_urut' => $list_job[$i],
                'question' => $list_point[$i],
                'type_id' => $list_tipe[$i],
                'no_urut'     => isset($no_urut[$i]) ? $no_urut[$i] : 0
            ];
             $this->db->insert('qna_m_question_item', $data_detail2); 
            // var_dump($data_detail2);
            
        }
    }

    

    if ($list_job2 && $list_point2 && $list_tipe2) {
        for ($i = 0; $i < count($list_job2); $i++) {
            $type_id = $list_tipe2[$i];

            $a_1 = isset($map_type[$type_id]->a_1) ? $map_type[$type_id]->a_1 : '';
            $a_2 = isset($map_type[$type_id]->a_2) ? $map_type[$type_id]->a_2 : '';
            $a_3 = isset($map_type[$type_id]->a_3) ? $map_type[$type_id]->a_3 : '';
            $a_4 = isset($map_type[$type_id]->a_4) ? $map_type[$type_id]->a_4 : '';
            $a_5 = isset($map_type[$type_id]->a_5) ? $map_type[$type_id]->a_5 : '';
            $b_1 = isset($map_type[$type_id]->b_1) ? $map_type[$type_id]->b_1 : '';
            $b_2 = isset($map_type[$type_id]->b_2) ? $map_type[$type_id]->b_2 : '';
            $b_3 = isset($map_type[$type_id]->b_3) ? $map_type[$type_id]->b_3 : '';
            $b_4 = isset($map_type[$type_id]->b_4) ? $map_type[$type_id]->b_4 : '';
            $b_5 = isset($map_type[$type_id]->b_5) ? $map_type[$type_id]->b_5 : '';

            $data_detail1 = [
                'question_id' => $qna_id,
                'huruf_urut' => $list_job2[$i],
                'question' => $list_point2[$i],
                'type_id' => $list_tipe2[$i],
                'no_urut'     => isset($no_urut2[$i]) ? $no_urut2[$i] : 0,
                'a_1' => $a_1,
                'a_2' => $a_2,
                'a_3' => $a_3,
                'a_4' => $a_4,
                'a_5' => $a_5,
                'b_1' => $b_1,
                'b_2' => $b_2,
                'b_3' => $b_3,
                'b_4' => $b_4,
                'b_5' => $b_5
            ];
             $this->db->insert('qna_m_question_item', $data_detail1); 
            
        }
    }


    // Untuk list_job, list_point, dan list_tipe
    // if ($list_job2 && $list_point2 && $list_tipe2) {
    //     for ($i = 0; $i < count($list_job2); $i++) {
    //         $data_detail2 = [
    //             'question_id' => $qna_id,
    //             'huruf_urut' => $list_job2[$i],
    //             'question' => $list_point2[$i],
    //             'type_id' => $list_tipe2[$i],
    //             'no_urut'     => isset($no_urut[$i]) ? $no_urut[$i] : 0
    //         ];
    //          $this->db->insert('qna_m_question_item', $data_detail2); 
            
            
    //     }
    // }

    $this->session->set_flashdata('simpandata', 'Data berhasil disimpan.');
    redirect('qna_user');
    // echo "Data berhasil disimpan.";
    } 
}