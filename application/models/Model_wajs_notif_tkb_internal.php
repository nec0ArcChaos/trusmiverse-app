<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_wajs_notif_tkb_internal extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function check_number($phone)
    {
        $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name, COALESCE(wa_notif_retail, 0) AS registered
                  FROM xin_employees r
                  WHERE r.is_active = 1 
                  AND REGEXP_REPLACE(REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END
                        ), ' ',''), '[^0-9]', '') = '$phone' 
                        LIMIT 1";
        $result = $this->db->query($query);
        return $result->row();
    }

    // notif internal
    function check_mpm() //message per minute
    {
        $query = "SELECT COUNT(id) AS total
            FROM wa_notif_tkb_log
            WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00')
            AND created_at < DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00'), INTERVAL 1 MINUTE)";
        $result = $this->db->query($query);
        return $result->row();
    }

    function insert_log($data)
    {
        $this->db->insert('wa_notif_tkb_log', $data);
        return $this->db->insert_id();
    }



    
}
