<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_kanban extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function kanban_data($id_task = null, $user_id = null, $type, $pic, $start, $end)
    {

        if(strtolower($type) == "all"){
            $kondisi_type = "";
        }else{
            $kondisi_type = "AND ticket_task.type = $type";
        }

        if(strtolower($pic) == "all"){
            $kondisi_pic = "";
        }else{
            $kondisi_pic = "AND (FIND_IN_SET($pic, ticket_task.pic) OR ticket_task.created_by = $pic)";
        }

        $user_role_id = $_SESSION['user_role_id'];
        if($user_id == null){
            $user_id = $this->session->userdata('user_id');
        }

        if ($id_task != null) {
            if($user_role_id=="1"){
                if($user_id == null || $user_id == ""){
                    $kondisi = "AND ticket_task.id_task = '$id_task' $kondisi_type $kondisi_pic";
                }else{
                    $kondisi = "AND ticket_task.id_task = '$id_task'
                        $kondisi_type $kondisi_pic";
                }
            }else{
                $kondisi = "AND ticket_task.id_task = '$id_task'
                        $kondisi_type $kondisi_pic";
            }
            
        } else {
            if($user_role_id=="1"){

                $kondisi = "";
                if($user_id == null || $user_id == ""){
                    $kondisi = "$kondisi_type $kondisi_pic";
                }else{
                    // $kondisi = "WHERE FIND_IN_SET($user_id, ticket_task.pic)";
                    $kondisi = "$kondisi_type $kondisi_pic";
                }
            }else{
                $kondisi = "$kondisi_type $kondisi_pic";
            }
        }

        

        $query = "SELECT 
                    ticket_task.id_task,
                    ticket_type.id AS id_type,
                    ticket_type.type,
                    ticket_category.id AS id_category,
                    ticket_category.category,
                    ticket_object.id AS id_object,
                    ticket_object.object,
                    ticket_task.task,
                    ticket_task.description,
                    ticket_task.pic AS id_pic,
                    ticket_task.level,
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
                    ticket_status.id AS id_status,
                    ticket_status.status,
                    ticket_status.color AS status_color,
                    ticket_task.progress,
                    ticket_priority.id AS id_priority,
                    ticket_priority.priority,
                    COALESCE(ticket_task.start,'') AS start,
                    COALESCE(ticket_task.end,'') AS end,
                    COALESCE(ticket_task.done_date,'') AS done_date,
                    ticket_task.due_date,
                    COALESCE(ticket_task.note,'') AS note,
                    ticket_task.created_at,
                    CONCAT(created_by.first_name, ' ', created_by.last_name) AS created_by,
                    -- COALESCE(ticket_task.indicator,'') AS indicator,
                    -- COALESCE(ticket_task.strategy,'') AS strategy,
                    -- COALESCE(ticket_task.jenis_strategy,'') AS jenis_strategy,
                    -- COALESCE(ticket_task.evaluation,'') AS evaluation,
                    COALESCE(ticket_task_attach.attachment,'') AS attachment
                    
                FROM ticket_task
                LEFT JOIN ticket_type ON ticket_type.id = ticket_task.type
                LEFT JOIN ticket_category ON ticket_category.id = ticket_task.category
                LEFT JOIN ticket_object ON ticket_object.id = ticket_task.object
                LEFT JOIN xin_employees ON FIND_IN_SET(xin_employees.user_id, ticket_task.pic)
                LEFT JOIN ticket_status ON ticket_status.id = ticket_task.status
                LEFT JOIN ticket_priority ON ticket_priority.id = ticket_task.priority
                LEFT JOIN xin_employees created_by ON created_by.user_id = ticket_task.created_by
                LEFT JOIN ticket_task_attach ON ticket_task_attach.id_task = ticket_task.id_task
                WHERE DATE(ticket_task.created_at) BETWEEN '$start' AND '$end' 
                $kondisi
                GROUP BY ticket_task.id_task";
        return $this->db->query($query)->result();
    }
}
