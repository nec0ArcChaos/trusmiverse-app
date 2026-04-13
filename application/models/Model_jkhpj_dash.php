<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jkhpj_dash extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_data_dashboard($periode, $department_id = null)
    {
        $user_id = $this->session->userdata("user_id");
        $role = $this->session->userdata("user_role_id");
        $nama = $this->session->userdata("nama");

        $superUser = [1];
        $roleAccess = [1, 2, 3, 10];

        if ($department_id != 0) {
            $kondisi = "m_jkhpj.department_id = '$department_id'";
        } else {
            $kondisi = "1 = 1";
        }

        if (in_array($user_id, $superUser) || in_array($role, $roleAccess)) {
            $kondisi .= "";
        } else {
            $kondisi .= " AND u.user_id = '$user_id'";
        }

        $sql = "SELECT
            m_jkhpj.*,
            u.nama,
            u.user_id,
            u.department_name,
            u.designation_name,
            COALESCE(task.tgl1, 0) AS tgl1,
            COALESCE(task.tgl2, 0) AS tgl2,
            COALESCE(task.tgl3, 0) AS tgl3,
            COALESCE(task.tgl4, 0) AS tgl4,
            COALESCE(task.tgl5, 0) AS tgl5,
            COALESCE(task.tgl6, 0) AS tgl6,
            COALESCE(task.tgl7, 0) AS tgl7,
            COALESCE(task.tgl8, 0) AS tgl8,
            COALESCE(task.tgl9, 0) AS tgl9,
            COALESCE(task.tgl10, 0) AS tgl10,
            COALESCE(task.tgl11, 0) AS tgl11,
            COALESCE(task.tgl12, 0) AS tgl12,
            COALESCE(task.tgl13, 0) AS tgl13,
            COALESCE(task.tgl14, 0) AS tgl14,
            COALESCE(task.tgl15, 0) AS tgl15,
            COALESCE(task.tgl16, 0) AS tgl16,
            COALESCE(task.tgl17, 0) AS tgl17,
            COALESCE(task.tgl18, 0) AS tgl18,
            COALESCE(task.tgl19, 0) AS tgl19,
            COALESCE(task.tgl20, 0) AS tgl20,
            COALESCE(task.tgl21, 0) AS tgl21,
            COALESCE(task.tgl22, 0) AS tgl22,
            COALESCE(task.tgl23, 0) AS tgl23,
            COALESCE(task.tgl24, 0) AS tgl24,
            COALESCE(task.tgl25, 0) AS tgl25,
            COALESCE(task.tgl26, 0) AS tgl26,
            COALESCE(task.tgl27, 0) AS tgl27,
            COALESCE(task.tgl28, 0) AS tgl28,
            COALESCE(task.tgl29, 0) AS tgl29,
            COALESCE(task.tgl30, 0) AS tgl30,
            COALESCE(task.tgl31, 0) AS tgl31,
            task.tgl1_fb,
            task.tgl2_fb,
            task.tgl3_fb,
            task.tgl4_fb,
            task.tgl5_fb,
            task.tgl6_fb,
            task.tgl7_fb,
            task.tgl8_fb,
            task.tgl9_fb,
            task.tgl10_fb,
            task.tgl11_fb,
            task.tgl12_fb,
            task.tgl13_fb,
            task.tgl14_fb,
            task.tgl15_fb,
            task.tgl16_fb,
            task.tgl17_fb,
            task.tgl18_fb,
            task.tgl19_fb,
            task.tgl20_fb,
            task.tgl21_fb,
            task.tgl22_fb,
            task.tgl23_fb,
            task.tgl24_fb,
            task.tgl25_fb,
            task.tgl26_fb,
            task.tgl27_fb,
            task.tgl28_fb,
            task.tgl29_fb,
            task.tgl30_fb,
            task.tgl31_fb
            FROM
            (
                SELECT
                m.designation_id,
                dep.department_id,
                dep.head_id
                FROM
                `jkhpj_m_item` m
                LEFT JOIN xin_designations ds ON ds.designation_id = m.designation_id
                JOIN xin_departments dep ON dep.department_id = ds.department_id
                GROUP BY
                designation_id
            ) AS m_jkhpj
            JOIN (SELECT
                CONCAT(first_name, ' ', last_name) AS nama,
                user_id,
                emp.department_id,
                emp.designation_id,
                dep.department_name,
                ds.designation_name
                FROM
                xin_employees emp
                LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                LEFT JOIN xin_designations ds ON ds.designation_id = emp.designation_id
                WHERE
                is_active = 1) AS u ON u.designation_id = m_jkhpj.designation_id
            LEFT JOIN (
                SELECT
                task.created_by AS id_user,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 1 THEN task.achievement END), 0)) AS tgl1,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 2 THEN task.achievement END), 0)) AS tgl2,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 3 THEN task.achievement END), 0)) AS tgl3,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 4 THEN task.achievement END), 0)) AS tgl4,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 5 THEN task.achievement END), 0)) AS tgl5,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 6 THEN task.achievement END), 0)) AS tgl6,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 7 THEN task.achievement END), 0)) AS tgl7,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 8 THEN task.achievement END), 0)) AS tgl8,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 9 THEN task.achievement END), 0)) AS tgl9,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 10 THEN task.achievement END), 0)) AS tgl10,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 11 THEN task.achievement END), 0)) AS tgl11,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 12 THEN task.achievement END), 0)) AS tgl12,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 13 THEN task.achievement END), 0)) AS tgl13,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 14 THEN task.achievement END), 0)) AS tgl14,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 15 THEN task.achievement END), 0)) AS tgl15,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 16 THEN task.achievement END), 0)) AS tgl16,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 17 THEN task.achievement END), 0)) AS tgl17,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 18 THEN task.achievement END), 0)) AS tgl18,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 19 THEN task.achievement END), 0)) AS tgl19,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 20 THEN task.achievement END), 0)) AS tgl20,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 21 THEN task.achievement END), 0)) AS tgl21,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 22 THEN task.achievement END), 0)) AS tgl22,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 23 THEN task.achievement END), 0)) AS tgl23,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 24 THEN task.achievement END), 0)) AS tgl24,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 25 THEN task.achievement END), 0)) AS tgl25,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 26 THEN task.achievement END), 0)) AS tgl26,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 27 THEN task.achievement END), 0)) AS tgl27,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 28 THEN task.achievement END), 0)) AS tgl28,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 29 THEN task.achievement END), 0)) AS tgl29,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 30 THEN task.achievement END), 0)) AS tgl30,
                ROUND(COALESCE(MAX(CASE WHEN DAY(task.created_at) = 31 THEN task.achievement END), 0)) AS tgl31,
                
                MAX(CASE WHEN DAY(task.created_at) = 1 THEN task.status_feedback END) AS tgl1_fb,
                MAX(CASE WHEN DAY(task.created_at) = 2 THEN task.status_feedback END) AS tgl2_fb,
                MAX(CASE WHEN DAY(task.created_at) = 3 THEN task.status_feedback END) AS tgl3_fb,
                MAX(CASE WHEN DAY(task.created_at) = 4 THEN task.status_feedback END) AS tgl4_fb,
                MAX(CASE WHEN DAY(task.created_at) = 5 THEN task.status_feedback END) AS tgl5_fb,
                MAX(CASE WHEN DAY(task.created_at) = 6 THEN task.status_feedback END) AS tgl6_fb,
                MAX(CASE WHEN DAY(task.created_at) = 7 THEN task.status_feedback END) AS tgl7_fb,
                MAX(CASE WHEN DAY(task.created_at) = 8 THEN task.status_feedback END) AS tgl8_fb,
                MAX(CASE WHEN DAY(task.created_at) = 9 THEN task.status_feedback END) AS tgl9_fb,
                MAX(CASE WHEN DAY(task.created_at) = 10 THEN task.status_feedback END) AS tgl10_fb,
                MAX(CASE WHEN DAY(task.created_at) = 11 THEN task.status_feedback END) AS tgl11_fb,
                MAX(CASE WHEN DAY(task.created_at) = 12 THEN task.status_feedback END) AS tgl12_fb,
                MAX(CASE WHEN DAY(task.created_at) = 13 THEN task.status_feedback END) AS tgl13_fb,
                MAX(CASE WHEN DAY(task.created_at) = 14 THEN task.status_feedback END) AS tgl14_fb,
                MAX(CASE WHEN DAY(task.created_at) = 15 THEN task.status_feedback END) AS tgl15_fb,
                MAX(CASE WHEN DAY(task.created_at) = 16 THEN task.status_feedback END) AS tgl16_fb,
                MAX(CASE WHEN DAY(task.created_at) = 17 THEN task.status_feedback END) AS tgl17_fb,
                MAX(CASE WHEN DAY(task.created_at) = 18 THEN task.status_feedback END) AS tgl18_fb,
                MAX(CASE WHEN DAY(task.created_at) = 19 THEN task.status_feedback END) AS tgl19_fb,
                MAX(CASE WHEN DAY(task.created_at) = 20 THEN task.status_feedback END) AS tgl20_fb,
                MAX(CASE WHEN DAY(task.created_at) = 21 THEN task.status_feedback END) AS tgl21_fb,
                MAX(CASE WHEN DAY(task.created_at) = 22 THEN task.status_feedback END) AS tgl22_fb,
                MAX(CASE WHEN DAY(task.created_at) = 23 THEN task.status_feedback END) AS tgl23_fb,
                MAX(CASE WHEN DAY(task.created_at) = 24 THEN task.status_feedback END) AS tgl24_fb,
                MAX(CASE WHEN DAY(task.created_at) = 25 THEN task.status_feedback END) AS tgl25_fb,
                MAX(CASE WHEN DAY(task.created_at) = 26 THEN task.status_feedback END) AS tgl26_fb,
                MAX(CASE WHEN DAY(task.created_at) = 27 THEN task.status_feedback END) AS tgl27_fb,
                MAX(CASE WHEN DAY(task.created_at) = 28 THEN task.status_feedback END) AS tgl28_fb,
                MAX(CASE WHEN DAY(task.created_at) = 29 THEN task.status_feedback END) AS tgl29_fb,
                MAX(CASE WHEN DAY(task.created_at) = 30 THEN task.status_feedback END) AS tgl30_fb,
                MAX(CASE WHEN DAY(task.created_at) = 31 THEN task.status_feedback END) AS tgl31_fb
                FROM
                jkhpj_t_task AS task
                WHERE
                SUBSTR(task.created_at, 1, 7) = '$periode'
                GROUP BY
                task.created_by
            ) AS task ON task.id_user = u.user_id
            WHERE
            $kondisi
            GROUP BY
            u.user_id";

        return $this->db->query($sql)->result();
    }

    function getDepartments()
    {
        $user_id = $this->session->userdata("user_id");
        $department_id = $this->session->userdata("department_id");
        $role = $this->session->userdata("user_role_id");
        $nama = $this->session->userdata("nama");

        $superUser = [1];
        $roleAccess = [1, 2, 3, 10];

        if (in_array($user_id, $superUser) || in_array($role, $roleAccess)) {
            $sql = "SELECT
                    CONCAT(first_name, ' ', last_name) AS nama,
                    user_id,
                    dep.department_id,
                    ds.designation_id,
                    dep.department_name,
                    ds.designation_name
                    FROM
                    jkhpj_m_item m
                    LEFT JOIN xin_designations ds ON ds.designation_id = m.designation_id
                    LEFT JOIN xin_departments dep ON dep.department_id = ds.department_id
                    LEFT JOIN xin_employees emp ON emp.user_id = dep.head_id
                    WHERE
                    emp.is_active = 1
                    GROUP BY
                    dep.head_id";
        } else {
            $sql = "SELECT 
                    '$nama' AS nama,
                    $user_id AS user_id,
                    $department_id AS department_id,
                    emp.designation_id,
                    dep.department_name,
                    ds.designation_name
                    FROM
                    jkhpj_m_item m
                    LEFT JOIN xin_designations ds ON ds.designation_id = m.designation_id
                    LEFT JOIN xin_departments dep ON dep.department_id = ds.department_id
                    JOIN xin_employees emp ON emp.user_id = dep.head_id AND emp.user_id = $user_id
                    WHERE
                    emp.is_active = 1
                    GROUP BY
                    dep.head_id";
        }

        return $this->db->query($sql)->result();
    }
}
