<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_birthday_monitoring extends CI_Model
{
    protected $userId;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->userId = $this->session->userdata('user_id');
    }

    function get_birthday_notif_log($startdate, $enddate)
    {
        $sql = "
            SELECT
                l.id,
                l.phone,
                e.user_id AS employee_id,
                l.employee_name,
                l.message,
                l.imageUrl,
                l.`status`,
                l.created_at,
                l.updated_at
            FROM
                (
                    SELECT
                        id,
                        phone,
                        LOWER(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(message, ' selalu', 1), 'Semoga di usia yang baru ini, ', - 1))) AS employee_name,
                        message,
                        imageUrl,
                        `status`,
                        created_at,
                        updated_at
                    FROM
                        wa_notif_hr_log
                    WHERE
                        phone = '6281229044211'
                        AND created_at BETWEEN '{$startdate} 00:00:00'
                        AND '{$enddate} 23:59:59'
                ) l
                JOIN (
                    SELECT
                        LOWER(TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(message, ' selalu', 1), 'Semoga di usia yang baru ini, ', - 1))) AS employee_name,
                        MAX(created_at) AS max_created_at
                    FROM
                        wa_notif_hr_log
                    WHERE
                        phone = '6281229044211'
                        AND created_at BETWEEN '{$startdate} 00:00:00'
                        AND '{$enddate} 23:59:59'
                    GROUP BY
                        employee_name
                ) latest ON l.employee_name = latest.employee_name
                AND l.created_at = latest.max_created_at
                LEFT JOIN xin_employees e ON LOWER(CONCAT(e.first_name, ' ', e.last_name)) = l.employee_name
            ORDER BY
                l.created_at DESC
        ";

        return $this->db->query($sql)->result();
    }
}
