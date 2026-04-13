<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_approval_dev extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dt_trusmi_approval($id_status, $start, $end)
    {
        $department_id = $this->session->userdata('department_id');
        $user_id = $this->session->userdata('user_id');
        $user_role_id = $this->session->userdata('user_role_id');
        if ($id_status == 'all') {
            // 323 Pak Hendra
            // 68 Busines Improvement
            $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end' AND (trusmi_approval.created_by = '$user_id' OR trusmi_approval.approve_to = '$user_id')";
            if (in_array($department_id, ['68', '1'])) {
                $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            }
            if (in_array($user_id, ['323', '1139', '6486'])) {
                $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            }
            if ($user_role_id == 1) {
                $where = "WHERE SUBSTR(trusmi_approval.created_at,1,10) BETWEEN '$start' AND '$end'";
            }
        } else {
            $where = "WHERE trusmi_approval.status IN ('1','4','5','6') AND (trusmi_approval.created_by = '$user_id' OR trusmi_approval.approve_to = '$user_id')";
            if (in_array($department_id, ['68', '1'])) {
                $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            }
            if (in_array($user_id, ['323', '1139', '6486'])) {
                $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            }
            if ($user_role_id == 1) {
                $where = "WHERE trusmi_approval.status IN ('1','4','5','6')";
            }
        }
        return $this->db->query("SELECT
        no_app,
        `subject`,
        `description`,
        file_1,
        file_2,
        trusmi_approval.approve_by AS id_approve_by,
        CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
        pic_approve_to.profile_picture AS approve_to_pic,
        trusmi_approval.created_at AS created_at_hour,
        SUBSTR( trusmi_approval.created_at, 1, 10 ) AS created_at,
        SUBSTR( trusmi_approval.created_at, 12, 5 ) AS created_hour,
        CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS created_by,
        pic_request.profile_picture AS created_by_pic,
        trusmi_approval.`status` AS id_status,
        trusmi_m_status.`status`,
        SUBSTR( approve_at, 1, 10 ) AS approve_at,
        SUBSTR( approve_at, 12, 5 ) AS approve_hour,
        CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
        pic_approve_by.profile_picture AS approve_by_pic,
        approve_note,
        IF( TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) > 12 , 12 , TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) )  AS leadtime,
        if(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) > 9,'Late','Ontime') AS keterangan,
        trusmi_approval.old_no_app
        FROM
        trusmi_approval
        LEFT JOIN xin_employees pic_request ON pic_request.user_id = trusmi_approval.created_by
        LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
        LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
        LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.status
        $where ORDER BY trusmi_approval.created_at DESC
        ");
    }


    function get_trusmi_approval_by_no_app($no_app)
    {
        return $this->db->query("SELECT
        no_app,
        `subject`,
        `description`,
        file_1,
        file_2,
        pic_approve_to.user_id AS user_id_approve_to,
        CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
        pic_approve_to.profile_picture AS approve_to_pic,
        SUBSTR( trusmi_approval.created_at, 1, 10 ) AS created_at,
        SUBSTR( trusmi_approval.created_at, 12, 5 ) AS created_hour,
        CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS created_by,
        pic_request.profile_picture AS created_by_pic,
        pic_request.contact_no AS created_by_contact,
        pic_approve_to.contact_no AS approve_to_contact,
        pic_approve_to.username AS approve_to_username,
        pic_approve_to.user_id AS approve_to_user_id,
        trusmi_approval.`status` AS id_status,
        trusmi_m_status.`status`,
        SUBSTR( approve_at, 1, 10 ) AS approve_at,
        CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
        pic_approve_by.profile_picture AS approve_by_pic,
        approve_note,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_DATE(),trusmi_approval.approve_at)) AS leadtime,
        if(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_DATE(),trusmi_approval.approve_at)) > 9,'Late','Ontime') AS keterangan
        FROM
        trusmi_approval
        LEFT JOIN xin_employees pic_request ON pic_request.user_id = trusmi_approval.created_by
        LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
        LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
        LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.status
        WHERE trusmi_approval.no_app = '$no_app'
        ");
    }

    function no_app()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( trusmi_approval.no_app, 3 ) ) AS kd_max 
        FROM
        trusmi_approval 
        WHERE
        SUBSTR( trusmi_approval.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'AP' . date('ymd') . $kd;
    }

    public function save($data)
    {
        return $this->db->insert('trusmi_approval', $data);
    }
}
