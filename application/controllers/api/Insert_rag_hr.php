<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert_rag_hr extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_insert_rag_hr', 'model');
    }

    public function insert_rag_hr()
    {
        $data = json_decode($_POST['content'], true);
        // var_dump($data);

        // $document_id = $data['document_id'] ?? null;
        // $content     = $data['content'] ?? null;
        // $embedding   = $data['embedding'] ?? null;
        // $source      = $data['source'] ?? null;

        $save = $this->model->simpan_rag_hr($data);

        // $response['document_id'] = $document_id;
        $response['data']        = $save;

        echo json_encode($response);

    }

    

}