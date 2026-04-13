<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ai_burnout extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function load_history($user_id = 'default')
    {
        $condition = '';
        if($user_id != 'default'){
            $condition .= "AND se.user_id = '$user_id'";
        }
        $query = "SELECT se.*, d.*, 
            CONCAT(e.first_name,' ',e.last_name) as full_name,
            de.department_name
            FROM
            bo_session se
            LEFT JOIN bo_diagnose d ON se.diagnose_id = d.diagnose_id
            LEFT JOIN xin_employees e ON se.user_id = e. user_id
            LEFT JOIN xin_departments de ON e.department_id = de.department_id
            WHERE se.status = 'completed'
            $condition";
        return $this->db->query($query)->result_array();
        // return $new_id;
    }

    public function get_user($user_id)
    {
        $query = "SELECT 
            CONCAT(e.first_name,' ',e.last_name) as full_name,
            d.department_name
            FROM
            xin_employees e
            LEFT JOIN xin_departments d ON e.department_id = d.department_id
            WHERE e.user_id = '$user_id'";
        return $this->db->query($query)->row_array();
    }
    
    public function get_employee_id()
    {
        $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS employee_name FROM xin_employees WHERE is_active = 1";
        return $this->db->query($query)->result();
    }
    
    public function get_ids($tbl, $col= 'id')
    {
        $query = "SELECT $col FROM $tbl";
        $result = $this->db->query($query)->result_array();
        $posts_id = [];
        foreach ($result as $key => $row) {
            $posts_id[] = $row[$col];
        }
        return $posts_id;
    }

    public function exists_row($table, $colval)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function exists_row_with_data($table, $colval)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->get($table);
        return ['exist' => $query->num_rows() > 0, 'data' => $query->result_array()];
    }

    public function get_data_by($table, $colval)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->get($table);
        return $query;
    }

    public function countRows($table, $colval = [])
    {
        // var_dump($colval);
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->count_all_results($table);
        return $query;
    }

    public function update_where($table,$colval,$data)
    {
        foreach ($colval as $column => $value){
            $this->db->where($column, $value);
        }
        $query = $this->db->update($table,$data);
        return $query;
    }

    public function get_symptoms(){
        $query = "SELECT symptom_id as id, symptom as name, cf_pakar as cfPakar FROM bo_symptom";
        return $this->db->query($query)->result();
    }

    public function get_diagnoses(){
        $query = "SELECT diagnose_id as id, name, description FROM bo_diagnose";
        return $this->db->query($query)->result();
    }

    public function get_solutions(){
        $query = "SELECT diagnose_id as id, solution FROM bo_solution";
        return $this->db->query($query)->result_array();
    }

    public function get_rules(){
        $query = "SELECT diagnose_id as id, rules FROM bo_diagnose";
        return $this->db->query($query)->result_array();
    }
    
    public function get_ratings(){
        $query = "SELECT 
            rating, testimoni, 
            CONCAT(e.first_name,' ',e.last_name) as full_name,
            d.department_name
            FROM
            bo_rating r
            LEFT JOIN
            bo_session s
            ON r.session_id = s.id
            LEFT JOIN
            xin_employees e 
            ON r.user_id = e.user_id
            LEFT JOIN
            xin_departments d
            ON e.department_id = d.department_id
            order by rating DESC, s.completed_at DESC
            LIMIT 3
            ";
        return $this->db->query($query)->result_array();
    }

    public function load_diagnoses(){
        $query = "SELECT d.*, se.*, 
            CONCAT(e.first_name,' ',e.last_name) as full_name,
            de.department_name
            FROM bo_session se
            LEFT JOIN bo_diagnose d ON se.diagnose_id = d.diagnose_id
            LEFT JOIN xin_employees e ON se.user_id = e. user_id
            LEFT JOIN xin_departments de ON e.department_id = de.department_id
            WHERE se.status = 'completed'
            ";
        return $this->db->query($query)->result_array();
    }

    public function load_answers(){
        $query = "SELECT *
            FROM bo_answers a
            LEFT JOIN bo_session se ON a.session_id = se.id
            WHERE se.status = 'completed'
            ";
        return $this->db->query($query)->result_array();
    }
}
