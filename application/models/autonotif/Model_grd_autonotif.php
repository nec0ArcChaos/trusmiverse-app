<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_grd_autonotif extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_resume_task()
    {
        $query = "SELECT
        emp.user_id,
        CONCAT( emp.first_name, ' ', emp.last_name ) AS nama,
        CASE WHEN LEFT(REPLACE(REPLACE(emp.contact_no, '-',''),'+',''),1) = 0 THEN
        CONCAT('62',SUBSTR(REPLACE(REPLACE(emp.contact_no, '-',''),'+',''),2)) 
        ELSE REPLACE(REPLACE(emp.contact_no, '-',''),'+','') END AS contact_no,
        COUNT( DISTINCT daily.si ) AS total_daily,
        GROUP_CONCAT( DISTINCT daily.si SEPARATOR '|') AS daily,
        COUNT( DISTINCT weekly.si ) AS total_weekly,
        GROUP_CONCAT( DISTINCT weekly.si SEPARATOR '|') AS weekly,
        COUNT( DISTINCT monthly.si ) AS total_monthly,
        GROUP_CONCAT( DISTINCT monthly.si SEPARATOR '|') AS monthly 
    FROM
        xin_employees emp
        LEFT JOIN (
            SELECT
                task.pic,
                task.id_tasklist,
                task.jenis_tasklist,
                si.si,
                task.`start`,
                task.`end`,
                task.`status` 
        FROM
            grd_t_tasklist task
            LEFT JOIN grd_t_si si ON si.id_si = task.id_si 
        WHERE
            task.jenis_tasklist = 'Daily' 
            AND (
                task.`start` BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY ) 
                AND CURDATE() 
                OR task.`end` BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY ) 
            AND CURDATE()) 
            AND NOT EXISTS ( SELECT 1 FROM grd_t_tasklist_history AS hs WHERE hs.id_tasklist = task.id_tasklist AND DATE ( hs.created_at ) = DATE_SUB( CURDATE(), INTERVAL 1 DAY ) )
        ) daily ON FIND_IN_SET( emp.user_id, daily.pic )
        LEFT JOIN (
            SELECT
                task.pic,
                task.jenis_tasklist,
                si.si,
                task.`start`,
                task.`end`,
                task.`status` 
            FROM
                grd_t_tasklist task
                LEFT JOIN grd_t_si si ON si.id_si = task.id_si 
            WHERE
                task.jenis_tasklist = 'Weekly' 
                AND task.`status` < 3 
                AND (
                    task.`start` BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY ) 
                    AND CURDATE() 
                    OR task.`end` BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY ) 
                AND CURDATE()) 
                AND NOT EXISTS (
                SELECT
                    1 
                FROM
                    grd_t_tasklist_history hs 
                WHERE
                    hs.id_tasklist = task.id_tasklist 
                    AND DATE ( hs.created_at ) BETWEEN SUBDATE(
                        CURDATE(),
                        WEEKDAY(
                        CURDATE())) 
                    AND SUBDATE(
                        CURDATE(),
                        WEEKDAY(
                        CURDATE())) + INTERVAL 6 DAY 
                )
        ) weekly ON FIND_IN_SET( emp.user_id, weekly.pic )
        LEFT JOIN (
        SELECT
            task.pic,
            task.jenis_tasklist,
            si.si,
            task.`start`,
            task.`end`,
            task.`status` 
        FROM
            grd_t_tasklist task
            LEFT JOIN grd_t_si si ON si.id_si = task.id_si 
        WHERE
            task.jenis_tasklist = 'Monthly' 
            AND task.`status` < 3 
            AND task.`end` BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 DAY ) 
            AND CURDATE() 
        ) monthly ON FIND_IN_SET( emp.user_id, monthly.pic ) 
    GROUP BY
        emp.user_id 
    HAVING
        total_daily > 0 
        OR total_weekly > 0 
        OR total_monthly > 0";

        return $this->db->query($query)->result();
    }
}
