<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_push_notif extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function list_employees(){

        $query = "SELECT 
                    user_id,
                    CONCAT(first_name, ' ', last_name) AS name,
                    fcm_token
                FROM xin_employees 
                WHERE department_id = 68 
                AND is_active = 1 
                -- AND COALESCE(fcm_token,'') != ''
                ORDER BY CONCAT(first_name, ' ', last_name) ASC";

        return $this->db->query($query)->result();
    }
    
    
    function list_departments(){

        $query = "SELECT 
                    department_id,
                    department_name
                FROM xin_departments 
                ORDER BY department_name ASC";

        return $this->db->query($query)->result();
    }


}
