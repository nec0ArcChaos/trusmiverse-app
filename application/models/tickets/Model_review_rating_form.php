<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_review_rating_form extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_detail_feedback($id)
    {
        $query = "SELECT
                    uat.id_task,
                    uat.`status`,
                    uat.note,
                    uat.files,
                    uat.created_at,
                    CONCAT(em.first_name,' ',em.last_name) AS created_by,
                    com.`name` AS company,
                    dp.department_name AS department,
                    dg.designation_name AS designation,
                    IF(rv.id_task IS NOT NULL,'Done','Waiting') AS status_review,
                    IF(rv.id_task IS NOT NULL,'green','orange') AS color_review
                FROM
                    ticket_uat AS uat
                    LEFT JOIN xin_employees AS em ON em.user_id = uat.created_by
                    LEFT JOIN xin_companies AS com ON com.company_id = em.company_id
                    LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
                    LEFT JOIN xin_designations AS dg ON dg.designation_id = em.designation_id
                    LEFT JOIN ticket_review AS rv ON rv.id_task = uat.id_task
                WHERE
                    MD5(uat.id_task) = '$id'";
        return $this->db->query($query)->row_array();
    }
    public function get_impact()
    {
        $query = "SELECT id, impact FROM ticket_impact";
        return $this->db->query($query)->result();
    }

    function get_reminder_review()
    {
        return $this->db->query("SELECT
                                    tsk.id_task AS id,
                                    tsk.task,
                                    tsk.description,
                                    em.employee_name AS `name`,
                                    REPLACE ( REPLACE ( REPLACE ( em.kontak, ' ', '' ), '+', '' ), '-', '' ) AS kontak,
                                    IF ( ut.`status` = 1, 'Sesuai', 'Tidak Sesuai' ) AS status_uat,
                                    ut.note AS note_uat,
                                    ut.created_at AS tgl_uat,
                                    CONCAT(
                                        'https://trusmiverse.com/apps/rr-frm/',
                                    MD5( tsk.id_task )) AS link 
                                FROM
                                    ticket_task AS tsk
                                    LEFT JOIN ticket_uat AS ut ON ut.id_task = tsk.id_task
                                    LEFT JOIN ticket_review AS rv ON rv.id_task = tsk.id_task
                                    LEFT JOIN (
                                    SELECT
                                        user_id,
                                        CONCAT( first_name, ' ', last_name ) AS employee_name,
                                    IF
                                        ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS kontak 
                                    FROM
                                        xin_employees 
                                    ) AS em ON em.user_id = tsk.created_by 
                                WHERE
                                    tsk.`status` = 16 
                                    AND ut.`status` = 1
                                    -- AND tsk.id_task = 'T240810016'
                                    AND DATE_ADD( ut.created_at, INTERVAL 7 DAY ) = CURDATE()")->result();
    }
}
