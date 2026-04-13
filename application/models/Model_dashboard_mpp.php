<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_mpp extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function dt_karyawan($contract_type, $kategori_level, $level, $company_id = 0, $department_id = 0)
    {
        if ($company_id == 0) {
            $kondisi = "";
        } else {
            if ($department_id == 0) {
                $kondisi = "AND e.company_id = $company_id";
            } else {
                $kondisi = "AND e.company_id = $company_id AND e.department_id = $department_id";
            }
        }

        if ($kategori_level == 'below') {

            if ($contract_type == 1) {
                $kondisi2 = "AND e.ctm_posisi IN('Staff', 'Officer')";
            } else {
                $kondisi2 = "AND e.ctm_posisi IN('Helper', 'Staff', 'Officer')";
            }
        } elseif ($kategori_level == 'up') {
            $kondisi2 = "AND e.ctm_posisi IN('Supervisor', 'Manager', 'Head', 'Direktur')";
        } else {
            $kondisi2 = "";
        }

        if ($level == '') {
            $kondisi3 = "";
        } else {
            $kondisi3 = "AND e.ctm_posisi = '$level'";
        }

        // $posisi = '';
        // if ($kategori_level == 'below') {
        //     $posisi = $leader_below;
        // } else {
        //     $posisi = $leader_up;
        // }

        $query = "SELECT DISTINCT
                    e.user_id,
                    com.name AS company,
                    CONCAT( e.first_name, ' ', e.last_name ) AS full_name,
                    dg.designation_name,
                    e.gender,
                    e.marital_status,
                    e.date_of_joining 
                FROM
                    xin_employees e
                    JOIN (
                    SELECT
                        ec1.employee_id,
                        ec1.contract_type_id 
                    FROM
                        xin_employee_contract ec1
                        INNER JOIN ( SELECT employee_id, MAX( created_at ) AS max_created_at FROM xin_employee_contract WHERE is_active = 1 GROUP BY employee_id ) ec2 ON ec1.employee_id = ec2.employee_id 
                        AND ec1.created_at = ec2.max_created_at 
                    WHERE
                        ec1.is_active = 1 
                    ) latest_contracts ON e.user_id = latest_contracts.employee_id
                    JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id
                    LEFT JOIN xin_companies com ON e.company_id = com.company_id
                    LEFT JOIN xin_designations dg ON e.designation_id = dg.designation_id 
                WHERE
                    e.is_active = 1 
                    AND ct.contract_type_id = $contract_type
                    $kondisi
                    $kondisi2
                    $kondisi3
                ORDER BY
                    e.user_id";
        return $this->db->query($query);
    }

    public function dt_jumlah_karyawan_by_status($company_id = 0, $department_id = 0)
    {
        if ($company_id == 0) {
            $kondisi = "";
        } else {
            if ($department_id == 0) {
                $kondisi = "AND e.company_id = $company_id";
            } else {
                $kondisi = "AND e.company_id = $company_id AND e.department_id = $department_id";
            }
        }

        $query = "SELECT ct.name, COUNT(DISTINCT e.user_id) AS active_employees
                FROM xin_employees e
                JOIN (
                    SELECT ec1.employee_id, ec1.contract_type_id
                    FROM xin_employee_contract ec1
                    INNER JOIN (
                        SELECT employee_id, MAX(created_at) AS max_created_at
                        FROM xin_employee_contract
                        WHERE is_active = 1
                        GROUP BY employee_id
                    ) ec2 ON ec1.employee_id = ec2.employee_id AND ec1.created_at = ec2.max_created_at
                    WHERE ec1.is_active = 1
                ) latest_contracts ON e.user_id = latest_contracts.employee_id
                JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id
                WHERE e.is_active = 1
                $kondisi
                GROUP BY ct.contract_type_id";
        return $this->db->query($query);
    }

    public function dt_jumlah_karyawan_by_kategori_level($company_id = 0, $department_id = 0, $contract_type, $jenis, $kategori_level)
    {
        if ($company_id == 0) {
            $kondisi = "";
        } else {
            if ($department_id == 0) {
                $kondisi = "AND e.company_id = $company_id";
            } else {
                $kondisi = "AND e.company_id = $company_id AND e.department_id = $department_id";
            }
        }

        $leader_below = "";
        $leader_up = "'Supervisor', 'Manager', 'Head', 'Direktur'";

        if ($contract_type == 1) {
            $leader_below = "'Staff', 'Officer'";
        } elseif ($contract_type == 2) {
            if ($jenis == 'reguler') {
                $leader_below = "'Helper', 'Staff', 'Officer'";
            } else {
                $leader_below = "'Daily Worker', 'Magang', 'PKL'";
            }
        } else {
            $leader_below = "'Helper', 'Staff', 'Officer'";
        }

        $posisi = '';
        if ($kategori_level == 'below') {
            $posisi = $leader_below;
        } else {
            $posisi = $leader_up;
        }

        $query = "SELECT
                    ct.NAME,
                    COUNT( DISTINCT e.user_id ) AS active_employees 
                FROM
                    xin_employees e
                    JOIN (
                    SELECT
                        ec1.employee_id,
                        ec1.contract_type_id 
                    FROM
                        xin_employee_contract ec1
                        INNER JOIN ( SELECT employee_id, MAX( created_at ) AS max_created_at FROM xin_employee_contract WHERE is_active = 1 GROUP BY employee_id ) ec2 ON ec1.employee_id = ec2.employee_id 
                        AND ec1.created_at = ec2.max_created_at 
                    WHERE
                        ec1.is_active = 1 
                    ) latest_contracts ON e.user_id = latest_contracts.employee_id
                    JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id 
                WHERE
                    e.is_active = 1 
                    $kondisi
                    AND latest_contracts.contract_type_id = '$contract_type'
                    AND e.ctm_posisi IN ($posisi)
                GROUP BY
                    ct.contract_type_id";

        if ($this->db->query($query)->num_rows() > 0) {
            return $this->db->query($query)->row()->active_employees;
        } else {
            return '0';
        }
    }

    public function dt_jumlah_karyawan_by_level($contract_type, $posisi, $company_id = 0, $department_id = 0)
    {
        if ($company_id == 0) {
            $kondisi = "";
        } else {
            if ($department_id == 0) {
                $kondisi = "AND e.company_id = $company_id";
            } else {
                $kondisi = "AND e.company_id = $company_id AND e.department_id = $department_id";
            }
        }

        $query = "SELECT
                    ct.NAME,
                    COUNT( DISTINCT e.user_id ) AS active_employees 
                FROM
                    xin_employees e
                    JOIN (
                    SELECT
                        ec1.employee_id,
                        ec1.contract_type_id 
                    FROM
                        xin_employee_contract ec1
                        INNER JOIN ( SELECT employee_id, MAX( created_at ) AS max_created_at FROM xin_employee_contract WHERE is_active = 1 GROUP BY employee_id ) ec2 ON ec1.employee_id = ec2.employee_id 
                        AND ec1.created_at = ec2.max_created_at 
                    WHERE
                        ec1.is_active = 1 
                    ) latest_contracts ON e.user_id = latest_contracts.employee_id
                    JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id 
                WHERE
                    e.is_active = 1 
                    AND latest_contracts.contract_type_id = '$contract_type'
                    AND e.ctm_posisi = '$posisi'
                    $kondisi
                GROUP BY
                    ct.contract_type_id";
        if ($this->db->query($query)->num_rows() > 0) {
            return $this->db->query($query)->row()->active_employees;
        } else {
            return '0';
        }
    }

    public function dt_jumlah_karyawan_by_level2($contract_type, $company_id = 0, $department_id = 0)
    {
        $query = "SELECT
                    e.ctm_posisi,
                    COUNT( DISTINCT e.user_id ) AS active_employees 
                FROM
                    xin_employees e
                    JOIN (
                    SELECT
                        ec1.employee_id,
                        ec1.contract_type_id 
                    FROM
                        xin_employee_contract ec1
                        INNER JOIN ( SELECT employee_id, MAX( created_at ) AS max_created_at FROM xin_employee_contract WHERE is_active = 1 GROUP BY employee_id ) ec2 ON ec1.employee_id = ec2.employee_id 
                        AND ec1.created_at = ec2.max_created_at 
                    WHERE
                        ec1.is_active = 1 
                    ) latest_contracts ON e.user_id = latest_contracts.employee_id
                    JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id 
                WHERE
                    e.is_active = 1
                AND latest_contracts.contract_type_id = $contract_type
                -- 	AND e.company_id = 1
                -- 	AND e.department_id = 68
                GROUP BY
                    e.ctm_posisi";
        return $this->db->query($query);
    }

    // public function dt_jumlah_karyawan_filter($company_id, $department_id)
    // {
    //     $query = "SELECT
    //                 ct.NAME,
    //                 COUNT( DISTINCT e.user_id ) AS active_employees 
    //             FROM
    //                 xin_employees e
    //                 JOIN (
    //                 SELECT
    //                     ec1.employee_id,
    //                     ec1.contract_type_id 
    //                 FROM
    //                     xin_employee_contract ec1
    //                     INNER JOIN ( SELECT employee_id, MAX( created_at ) AS max_created_at FROM xin_employee_contract WHERE is_active = 1 GROUP BY employee_id ) ec2 ON ec1.employee_id = ec2.employee_id 
    //                     AND ec1.created_at = ec2.max_created_at 
    //                 WHERE
    //                     ec1.is_active = 1 
    //                 ) latest_contracts ON e.user_id = latest_contracts.employee_id
    //                 JOIN xin_contract_type ct ON latest_contracts.contract_type_id = ct.contract_type_id 
    //             WHERE
    //                 e.is_active = 1 
    //                 AND e.company_id = '$company_id'
    //                 AND e.department_id = '$department_id'
    //                 AND e.ctm_posisi IN ('Staff', 'Officer', 'Supervisor', 'Manager', 'Head', 'Direktur')
    //             GROUP BY
    //                 ct.contract_type_id";
    //     return $this->db->query($query);
    // }

    // public function dt_jumlah_karyawan_by_status2()
    // {
    //     $query = "SELECT
    //                 COUNT( DISTINCT emp.user_id ) AS jumlah_semua,
    //                 COUNT(
    //                 IF
    //                 ( con.contract_type_id = 1, 1, NULL )) AS jumlah_kartap,
    //                 COUNT(
    //                 IF
    //                 ( con.contract_type_id = 2, 1, NULL )) AS jumlah_k_kontrak,
    //                 COUNT(
    //                 IF
    //                 ( con.contract_type_id = 3, 1, NULL )) AS jumlah_k_nonkontrak,
    //                 COUNT(
    //                 IF
    //                 ( con.contract_type_id = 4, 1, NULL )) AS jumlah_k_perjanjian
    //             FROM
    //                 `xin_employees` AS emp
    //                 JOIN xin_employee_contract AS con ON emp.user_id = con.employee_id 
    //             WHERE
    //                 emp.is_active = 1 
    //                 AND con.is_active = 1";
    //     return $this->db->query($query);
    // }

    public function get_company()
    {
        $id_user = $this->session->userdata('user_id');
        if ($id_user == 5840) {
            $kondisi = "WHERE xin_companies.company_id IN(1,3,4,5,6)";
        } else {
            $kondisi = "";
        }

        $query = "SELECT
            xin_companies.company_id,
            xin_companies.`name` AS company 
        FROM
            xin_companies
            $kondisi";

        return $this->db->query($query);
    }

    public function get_department($company_id)
    {
        $union = "UNION SELECT
            xin_departments.department_id AS `value`,
            CONCAT(xin_departments.department_name, ' (Bali)') AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.department_id IN (175, 177, 180)";

        $query = "SELECT
            0 AS `value`,
            'All Departments' AS `text` UNION
        SELECT
            xin_departments.department_id AS `value`,
            xin_departments.department_name AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.company_id != 0 AND xin_departments.company_id = $company_id AND xin_departments.hide = 0
        $union";

        return $this->db->query($query);
    }
}
