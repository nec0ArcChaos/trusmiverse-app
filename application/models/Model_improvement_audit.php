<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_improvement_audit extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_imp()
    {
        $q = $this->db->query("SELECT 
                MAX( RIGHT ( audit_improvement.id_imp, 4 ) ) AS kd_max 
            FROM
                audit_improvement 
            WHERE
                DATE( audit_improvement.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%04s", $tmp);
        }
        } else {
        $kd = "0001";
        }

        return 'IMP' . date('ymd') . $kd;
    }

    function get_plan($plan = null)
    {
        if ($plan != null) {
            $sub_query = "WHERE plan.id_plan = '$plan'";
        } else {
            $sub_query = '';
        }
        $query = "SELECT 
            plan.id_plan,
            plan.subject,
            plan.object,
            plan.pemeriksaan,
            plan.periode,
            plan.company_id,
            company.name as company_name,
            plan.department_id,
            department.department_name,
            plan.designation_id,
            designation.designation_name
        FROM 
            t_audit_plan_monthly plan
        LEFT JOIN xin_companies company ON company.company_id = plan.company_id
        LEFT JOIN xin_departments department ON department.department_id = plan.department_id
        LEFT JOIN xin_designations designation ON designation.designation_id = plan.designation_id
        $sub_query;";
        return $this->db->query($query)->result();
    }

    function get_improvement_audit($start, $end) 
    {
        $query = "SELECT 
            imp.id_imp,
            plan.id_plan,
            plan.subject,
            plan.object,
            plan.pemeriksaan,
            plan.periode,
            plan.company_id,
            company.name as company_name,
            plan.department_id,
            department.department_name,
            plan.designation_id,
            designation.designation_name,
            imp.tindak_lanjut,
            imp.improvement,
            imp.attachment,
            imp.created_at,
            CONCAT( employee.first_name, ' ', employee.last_name ) AS created_by
        FROM 
            audit_improvement imp
        LEFT JOIN t_audit_plan_monthly plan ON plan.id_plan = imp.id_plan
        LEFT JOIN xin_companies company ON company.company_id = plan.company_id
        LEFT JOIN xin_departments department ON department.department_id = plan.department_id
        LEFT JOIN xin_designations designation ON designation.designation_id = plan.designation_id
        LEFT JOIN xin_employees employee ON employee.user_id = imp.created_by
        WHERE DATE( imp.created_at ) BETWEEN '$start' AND '$end';";
        return $this->db->query($query)->result();
    }

    function get_improvement_audit_detail($id_plan) 
    {
        $query = "SELECT 
            imp.id_imp,
            plan.id_plan,
            plan.subject,
            plan.object,
            plan.pemeriksaan,
            plan.periode,
            plan.company_id,
            company.name as company_name,
            plan.department_id,
            department.department_name,
            plan.designation_id,
            designation.designation_name,
            imp.tindak_lanjut,
            imp.improvement,
            imp.attachment,
            imp.created_at,
            CONCAT( employee.first_name, ' ', employee.last_name ) AS created_by
        FROM 
            audit_improvement imp
        LEFT JOIN t_audit_plan_monthly plan ON plan.id_plan = imp.id_plan
        LEFT JOIN xin_companies company ON company.company_id = plan.company_id
        LEFT JOIN xin_departments department ON department.department_id = plan.department_id
        LEFT JOIN xin_designations designation ON designation.designation_id = plan.designation_id
        LEFT JOIN xin_employees employee ON employee.user_id = imp.created_by
        WHERE imp.id_plan = '$id_plan'";
        return $this->db->query($query)->result();
    }
}