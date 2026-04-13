<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_wajs_notif_tkb_customer extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database('pos_batik');
    }

    function check_number($phone)
    {
        $query = "SELECT cs.customer_id, cs.`name` AS nama_customer, COALESCE(cs.log_register, 0) AS registered
                    FROM m_customer cs
                  AND REGEXP_REPLACE(REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(cs.contact, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(cs.contact, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(cs.contact, '-',''),'+','') END
                        ), ' ',''), '[^0-9]', '') = '$phone' 
                        LIMIT 1";
        $result = $this->db->query($query);
        return $result->row();
    }

    // notif internal
    function check_mpm() //message per minute
    {
        $query = "SELECT COUNT(id) AS total
            FROM wa_notif_log
            WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00')
            AND created_at < DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:00'), INTERVAL 1 MINUTE)";
        $result = $this->db->query($query);
        return $result->row();
    }

    function insert_log($data)
    {
        $this->db->insert('wa_notif_log', $data);
        return $this->db->insert_id();
    }



    
}
