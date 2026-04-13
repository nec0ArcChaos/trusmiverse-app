<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jkhpj_dev extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_jkhpj_task()
    {
        $task = $this->db->query("SELECT * FROM jkhpj_t_task WHERE SUBSTR(created_at,1,10) = SUBSTR(CURDATE(),1,10) ORDER BY id_task DESC LIMIT 1")->row_array();
        if ($task == null) {
            $date = substr(date("Ymd"), 2);
            $id = "JKHPJ" . $date . "001";
        } else {
            $latest = substr($task['id_task'], 11);
            $current = sprintf("%03d", (int)$latest + 1);
            $date = substr(date("Ymd"), 2);
            $id = "JKHPJ" . $date . $current;
        }
        return $id;
    }

    function dt_resume_tasklist($datestart = null, $dateend = null, $status = null)
    {
        $user_id = $this->session->userdata('user_id');
        $kondisi = "";
        $kondisi2 = "";
        if ($datestart != null) {
            $kondisi = "SUBSTR(task.created_at, 1, 10) BETWEEN '$datestart' AND '$dateend'";
        }

        if (in_array($user_id, [1, 2, 6466, 4498])) {
            $kondisi .= "";
        } else {
            $check_head = $this->db->query("SELECT * FROM xin_departments WHERE head_id = '$user_id'");
            if ($check_head->num_rows() > 0) {
                $depa = $check_head->row();
                $depa_id = $depa->department_id;
                $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
                if ($get_emp->num_rows() > 0) {
                    $list_id = array();
                    foreach ($get_emp->result() as $value) {
                        $list_id[] = $value->user_id;
                    }

                    $list_id = "(" . implode(",", $list_id) . ")";

                    if ($kondisi == "") {
                        $kondisi .= " task.created_by IN $list_id";
                    } else {
                        $kondisi .= " AND task.created_by IN $list_id";
                    }
                } else {
                    if ($kondisi == "") {
                        $kondisi .= " task.created_by = '$user_id'";
                    } else {
                        $kondisi .= " AND task.created_by = '$user_id'";
                    }
                }
            } else {
                $check_manager = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$user_id' AND is_active = 1 AND user_role_id = 3");
                if ($check_manager->num_rows() > 0) {
                    $manager = $check_manager->row();
                    $depa_id = $manager->department_id;
                    $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
                    if ($get_emp->num_rows() > 0) {
                        $list_id = array();
                        foreach ($get_emp->result() as $value) {
                            $list_id[] = $value->user_id;
                        }

                        $list_id = "(" . implode(",", $list_id) . ")";

                        if ($kondisi == "") {
                            $kondisi .= " task.created_by IN $list_id";
                        } else {
                            $kondisi .= " AND task.created_by IN $list_id";
                        }
                    } else {
                        if ($kondisi == "") {
                            $kondisi .= " task.created_by = '$user_id'";
                        } else {
                            $kondisi .= " AND task.created_by = '$user_id'";
                        }
                    }
                } else {
                    $kondisi .= " AND task.created_by = '$user_id'";
                }
            }
        }

        if ($status == 'feedback') {
            if ($kondisi == "") {
                $kondisi2 = "task.feedback_at is NULL";
            } else {
                $kondisi2 = "AND task.feedback_at is NULL";
            }
        }

        $sql = "SELECT
                    task.id_task,
                    task.designation_id,
                    designation.designation_name,
                    ROUND(task.achievement, 2) AS achievement,
                    task.average_rating,
                    task.created_at,
                    task.created_by AS id_created_by,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by,
                    task.feedback,
                    task.file_feedback,
                    task.link_feedback,
                    task.status_feedback
                FROM
                    `jkhpj_t_task` AS task
                    JOIN xin_designations designation ON task.designation_id = designation.designation_id
                    JOIN xin_employees emp ON task.created_by = emp.user_id
                WHERE
                    $kondisi $kondisi2
                ";

        return $this->db->query($sql);
    }

    function dt_resume_tasklist_feedback($datestart = null, $dateend = null, $status = null)
    {
        $user_id = $this->session->userdata('user_id');
        $kondisi = "";
        $kondisi2 = "";
        if ($datestart != null) {
            $kondisi = "SUBSTR(task.created_at, 1, 10) BETWEEN '$datestart' AND '$dateend'";
        }

        // if (in_array($user_id, [1,2,6466])) {
        //     $kondisi .= "";
        // } else {
        //     $check_head = $this->db->query("SELECT * FROM xin_departments WHERE head_id = '$user_id'");
        //     if ($check_head->num_rows() > 0) {
        //         $depa = $check_head->row();
        //         $depa_id = $depa->department_id;
        //         $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
        //         if ($get_emp->num_rows() > 0) {
        //             $list_id = array();
        //             foreach ($get_emp->result() as $value) {
        //                 $list_id[] = $value->user_id;
        //             }

        //             $list_id = "(" . implode(",", $list_id) . ")";

        //             if ($kondisi == "") {
        //                 $kondisi .= " task.created_by IN $list_id";
        //             } else {
        //                 $kondisi .= " AND task.created_by IN $list_id";
        //             }

        //         } else {
        //             if ($kondisi == "") {
        //                 $kondisi .= " task.created_by = '$user_id'";
        //             } else {
        //                 $kondisi .= " AND task.created_by = '$user_id'";
        //             }
        //         }
        //     } else {
        //         $check_manager = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$user_id' AND is_active = 1 AND user_role_id = 3");
        //         if ($check_manager->num_rows() > 0) {
        //             $manager = $check_manager->row();
        //             $depa_id = $manager->department_id;
        //             $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
        //             if ($get_emp->num_rows() > 0) {
        //                 $list_id = array();
        //                 foreach ($get_emp->result() as $value) {
        //                     $list_id[] = $value->user_id;
        //                 }

        //                 $list_id = "(" . implode(",", $list_id) . ")";

        //                 if ($kondisi == "") {
        //                     $kondisi .= " task.created_by IN $list_id";
        //                 } else {
        //                     $kondisi .= " AND task.created_by IN $list_id";
        //                 }

        //             } else {
        //                 if ($kondisi == "") {
        //                     $kondisi .= " task.created_by = '$user_id'";
        //                 } else {
        //                     $kondisi .= " AND task.created_by = '$user_id'";
        //                 }
        //             }
        //         } else {
        //             $kondisi .= " AND task.created_by = '$user_id'";
        //         }
        //     }
        // }

        if ($status == 'feedback') {
            if ($kondisi == "") {
                $kondisi2 = "task.feedback_at is NULL";
            } else {
                $kondisi2 = "AND task.feedback_at is NULL";
            }
        }

        $sql = "SELECT
                    task.id_task,
                    task.designation_id,
                    designation.designation_name,
                    ROUND(task.achievement, 2) AS achievement,
                    task.average_rating,
                    task.created_at,
                    task.created_by AS id_created_by,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by,
                    task.feedback,
                    task.file_feedback,
                    task.link_feedback,
                    task.status_feedback
                FROM
                    `jkhpj_t_task` AS task
                    JOIN xin_designations designation ON task.designation_id = designation.designation_id
                    JOIN xin_employees emp ON task.created_by = emp.user_id
                WHERE
                    $kondisi $kondisi2
                ";

        return $this->db->query($sql);
    }

    function dt_list_detail_task($id_task)
    {
        $user_id = $this->session->userdata('user_id');
        $kondisi = "item.id_task = '$id_task'";
        if (in_array($user_id, [1, 2, 6466, 4498])) {
            $kondisi = "item.id_task = '$id_task'";
        } else {
            $check_head = $this->db->query("SELECT * FROM xin_departments WHERE head_id = '$user_id'");
            if ($check_head->num_rows() > 0) {
                $depa = $check_head->row();
                $depa_id = $depa->department_id;
                $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
                if ($get_emp->num_rows() > 0) {
                    $list_id = array();
                    foreach ($get_emp->result() as $value) {
                        $list_id[] = $value->user_id;
                    }

                    $list_id = "(" . implode(",", $list_id) . ")";

                    $kondisi .= " AND task.created_by IN $list_id";
                } else {
                    $kondisi .= " AND task.created_by = '$user_id'";
                }
            } else {
                $check_manager = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$user_id' AND is_active = 1 AND user_role_id = 3");
                if ($check_manager->num_rows() > 0) {
                    $manager = $check_manager->row();
                    $depa_id = $manager->department_id;
                    $get_emp = $this->db->query("SELECT user_id FROM xin_employees WHERE department_id = '$depa_id' AND is_active = 1");
                    if ($get_emp->num_rows() > 0) {
                        $list_id = array();
                        foreach ($get_emp->result() as $value) {
                            $list_id[] = $value->user_id;
                        }

                        $list_id = "(" . implode(",", $list_id) . ")";

                        if ($kondisi == "") {
                            $kondisi .= " AND task.created_by IN $list_id";
                        } else {
                            $kondisi .= " AND task.created_by IN $list_id";
                        }
                    } else {
                        if ($kondisi == "") {
                            $kondisi .= " AND task.created_by = '$user_id'";
                        } else {
                            $kondisi .= " AND task.created_by = '$user_id'";
                        }
                    }
                } else {
                    $kondisi .= " AND task.created_by = '$user_id'";
                }
            }
        }

        $sql = "SELECT
                    item.id,
                    item.id_task,
                    task.designation_id,
                    designation.designation_name,
                    item.tasklist,
                    item.time_start,
                    item.time_end,
                    item.time_actual,
                    item.`status`,
                    item.file,
                    item.link,
                    jkhpj_m_item.description,
                    item.note,
                    item.created_at,
                    item.created_by AS id_created_by,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by
                FROM
                    jkhpj_t_task_item AS item
                    JOIN jkhpj_t_task task ON item.id_task = task.id_task
                    JOIN jkhpj_m_item ON jkhpj_m_item.id_jkhpj_item = item.id_jkhpj_item
                    JOIN xin_designations designation ON task.designation_id = designation.designation_id
                    JOIN xin_employees emp ON task.created_by = emp.user_id
                WHERE
                    $kondisi
                ORDER BY item.`status` ASC";

        return $this->db->query($sql);
    }

    function detail_task_item($id)
    {
        $sql = "SELECT
                    item.*,
                    m_item.description,
                    SUBSTR(item.time_start, 1, 5) AS timestart, 
                    SUBSTR(item.time_end, 1, 5) AS timeend,
                    task.created_at AS task_created_at 
                FROM
                    `jkhpj_t_task_item` AS item
                JOIN jkhpj_m_item AS m_item ON m_item.id_jkhpj_item = item.id_jkhpj_item
                JOIN jkhpj_t_task AS task ON item.id_task = task.id_task
                WHERE
                    item.id = '$id'";

        return $this->db->query($sql);
    }

    function check_task($designation_id, $user_id)
    {
        $sql = "SELECT
                    *
                FROM
                    jkhpj_t_task 
                WHERE
                    designation_id = '$designation_id' 
                    AND DATE( created_at ) = CURDATE()
                    AND created_by = $user_id";

        return $this->db->query($sql);
    }
}
