<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_autonotif extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_tickets($id)
    {
        $query = "SELECT
                    t.id_task,
                    TRIM(t.task) as task,
                    TRIM(CONCAT( xe.first_name, ' ', xe.last_name )) AS requester,
                    TRIM(CONCAT( xe_head.first_name, ' ', xe_head.last_name )) AS head,
                    xe_head.user_id AS head_id,
                    xd.department_name,
                    ts.`status`,
                    t.created_at 
                FROM
                    ticket_task t
                    LEFT JOIN xin_employees xe ON xe.user_id = t.created_by
                    LEFT JOIN xin_departments xd ON xd.department_id = xe.department_id
                    LEFT JOIN xin_employees xe_head ON xe_head.user_id = xd.head_id 
                    LEFT JOIN ticket_status ts ON ts.id = t.`status`
                WHERE
                    t.`status` IN ( 1, 2, 6, 7, 8, 9, 10 ) 
                    AND t.type = 1 
                    AND t.category NOT IN (1,5,17)
                    AND xe_head.user_id = $id
                GROUP BY
                    t.id_task;";
        return $this->db->query($query)->result();
    }
    public function get_head()
    {
        $query = "SELECT
                        TRIM(
                        CONCAT( xe.first_name, ' ', xe.last_name )) AS head,
                        xe.user_id AS head_id,
                    IF
                        (
                            LEFT ( xe.contact_no, 2 ) = '08',
                            CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 2 ) ),
                            CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 3 ) ) 
                        ) AS contact_no 
                    FROM
                        xin_departments xd
                        LEFT JOIN xin_employees xe ON xe.user_id = xd.head_id 
                    WHERE xe.is_active = 1
                    AND xd.head_id != 323
                    GROUP BY
                        head_id";
        return $this->db->query($query)->result();
    }
}
