<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_birthday_employees_tkb extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getBirthdayByDate()
    {
        $sql = "
            SELECT
                employees.user_id,
                employees.first_name,
                employees.last_name,
                CONCAT(employees.first_name, ' ', employees.last_name) AS fullname,
                designations.designation_name AS designation,
                employees.date_of_birth,
                TIMESTAMPDIFF(YEAR, employees.date_of_birth, CURDATE()) AS age,
                employees.contact_no AS phone,
                employees.profile_picture AS photo,
                employees.gender,
                employees.date_of_joining
            FROM xin_employees AS employees
            JOIN xin_designations AS designations ON employees.designation_id = designations.designation_id
            WHERE DATE_FORMAT(employees.date_of_birth, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d')
            AND employees.company_id = 3
            AND employees.is_active = 1
        ";

        return $this->db->query($sql)->result();
    }

    function getBirthdayByUserId($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = 11219;
        }

        $sql = "
            SELECT
                employees.user_id,
                employees.first_name,
                employees.last_name,
                CONCAT(employees.first_name, ' ', employees.last_name) AS fullname,
                designations.designation_name AS designation,
                employees.date_of_birth,
                TIMESTAMPDIFF(YEAR, employees.date_of_birth, CURDATE()) AS age,
                employees.contact_no AS phone,
                employees.profile_picture AS photo,
                employees.gender,
                employees.date_of_joining
            FROM xin_employees AS employees
            JOIN xin_designations AS designations ON employees.designation_id = designations.designation_id
            WHERE employees.user_id = {$user_id};
        ";

        return $this->db->query($sql)->row();
    }
}