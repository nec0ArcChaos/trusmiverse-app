<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_whatsapp_message extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_exist($id)
    {
        $query = $this->db->query("SELECT * FROM whatsapp_messages WHERE message_id = '$id'");
        return $query->row();
    }

    public function insert_message($data)
    {
        return $this->db->insert('whatsapp_messages', $data);
    }
}
