<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_kanban extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function kanban_data($id_task = null, $user_id = null, $category, $pic, $start, $end)
    {

        if (strtolower($category) == "all") {
            $kondisi_category = "";
        } else {
            $kondisi_category = "AND cm_task.id_category = $category";
        }

        if (strtolower($pic) == "all") {
            $kondisi_pic = "";
        } else {
            $kondisi_pic = "AND (FIND_IN_SET($pic, cm_task.pic) OR cm_task.created_by = $pic)";
        }

        $user_role_id = $_SESSION['user_role_id'];
        if ($user_id == null) {
            $user_id = $this->session->userdata('user_id');
        }

        if ($id_task != null) {
            if ($user_role_id == "1") {
                if ($user_id == null || $user_id == "") {
                    $kondisi = "AND cm_task.id_task = '$id_task' $kondisi_category $kondisi_pic";
                } else {
                    $kondisi = "AND cm_task.id_task = '$id_task'
                        $kondisi_category $kondisi_pic";
                }
            } else {
                $kondisi = "AND cm_task.id_task = '$id_task'
                        $kondisi_category $kondisi_pic";
            }
        } else {
            if ($user_role_id == "1") {

                $kondisi = "";
                if ($user_id == null || $user_id == "") {
                    $kondisi = "$kondisi_category $kondisi_pic";
                } else {
                    // $kondisi = "WHERE FIND_IN_SET($user_id, cm_task.pic)";
                    $kondisi = "$kondisi_category $kondisi_pic";
                }
            } else {
                $kondisi = "$kondisi_category $kondisi_pic";
            }
        }



        $query = "SELECT 
                    cm_task.id_task,
                    cm_category.id AS id_category,
                    cm_category.category,
                    cm_task.task,
                    cm_task.description,
                    cm_task.pic AS id_pic,
                    cm_task.level,
                    GROUP_CONCAT(CONCAT(xin_employees.first_name, ' ', xin_employees.last_name)) AS pic,
                    GROUP_CONCAT(
                        CASE 
                            WHEN xin_employees.profile_picture IS NULL OR xin_employees.profile_picture='' OR xin_employees.profile_picture='no file' 
                                THEN 
                                    CASE 
                                        WHEN xin_employees.gender = 'Male' 
                                            THEN 'default_male.jpg'
                                        ELSE 'default_female.jpg'
                                    END
                            ELSE COALESCE(xin_employees.profile_picture,'')
                        END
                    ) AS profile_picture,
                    
					-- END AS profile_picture,
                    cm_status.id AS id_status,
                    cm_status.status,
                    cm_status.color AS status_color,
                    cm_task.progress,
                    cm_priority.id AS id_priority,
                    cm_priority.priority,
                    COALESCE(cm_task.start,'') AS start,
                    COALESCE(cm_task.end,'') AS end,
                    COALESCE(cm_task.done_date,'') AS done_date,
                    cm_task.due_date,
                    COALESCE(cm_task.pic_note,'') AS note,
                    cm_task.created_at,
                    CONCAT(created_by.first_name, ' ', created_by.last_name) AS created_by,
                    -- COALESCE(cm_task.indicator,'') AS indicator,
                    -- COALESCE(cm_task.strategy,'') AS strategy,
                    -- COALESCE(cm_task.jenis_strategy,'') AS jenis_strategy,
                    -- COALESCE(cm_task.evaluation,'') AS evaluation,
                    COALESCE(cm_task_attach.attachment,'') AS attachment
                    
                FROM cm_task
                LEFT JOIN cm_category ON cm_category.id = cm_task.id_category
                LEFT JOIN xin_employees ON FIND_IN_SET(xin_employees.user_id, cm_task.pic)
                LEFT JOIN cm_status ON cm_status.id = cm_task.status
                LEFT JOIN cm_priority ON cm_priority.id = cm_task.priority
                LEFT JOIN xin_employees created_by ON created_by.user_id = cm_task.created_by
                LEFT JOIN cm_task_attach ON cm_task_attach.id_task = cm_task.id_task
                WHERE DATE(cm_task.created_at) BETWEEN '$start' AND '$end' 
                $kondisi
                GROUP BY cm_task.id_task";
        return $this->db->query($query)->result();
    }
}
