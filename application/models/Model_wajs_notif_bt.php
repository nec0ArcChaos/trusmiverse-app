<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_wajs_notif_bt extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    // notif bt
    function check_mpm() //message per minute
    {
        $query = "SELECT COUNT(id) AS total
            FROM wa_notif_bt_log
            WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00')
            AND created_at < DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00'), INTERVAL 1 MINUTE)";
        $result = $this->db->query($query);
        return $result->row();
    }

    function insert_log($data)
    {
        $this->db->insert('wa_notif_bt_log', $data);
        return $this->db->insert_id();
    }


    
}
